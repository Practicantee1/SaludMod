let fecha;
let esRenovacion = false;

document.addEventListener('DOMContentLoaded', function() {

  $("#FechaInicial").on("change", function(){
    if(esRenovacion){
      $("#FechaInicial").val(fecha);
      $("#FechaInicial").attr("min", fecha);
      $("#FechaInicial").attr("max", fecha);
    }
  });

  $("input[name='Prorroga']").on("change", function(e){
    if(esRenovacion){
      $("input[name='Prorroga'][value='Si']").prop("checked", true);
    }else{
      $("input[name='Prorroga'][value='No']").prop("checked", true);
    }
  });

  // Get the form element
  var form = document.getElementById('AgregarIncapacidad');

  // Add event listener for keydown event
  form.addEventListener('keydown', function(event) {
      // Check if the pressed key is Enter (key code 13)
      if (event.keyCode === 13) {
          event.preventDefault(); // Prevent default form submission behavior
      }
  });
});


//Verificar si la persona tiene incapacidades activas y cuantas de estas tienen
$(document).ready(function(){
  IDPaciente = document.getElementById("IDNumberPaciente").value;
  console.log(fecha)
  if(IDPaciente !== ""){
    $.ajax({
      type: "POST",
      url: '../Logica/VerificarIncapacidadActiva.php',
      data: {"IDPaciente" : IDPaciente},
      success: async function(response){
        response = JSON.parse(response);
        if(response.success){
          fecha = await obtenerFechaIncapacidad();
          if(response.message["registros"] == 1){  //Si hay incapacidad entonces se hace una renovación
            Swal.fire({
              icon: "info",
              title: "Hay una incapacidad activa",
              text: `Actualmente el paciente cuenta con una incapacidad activa hasta el ${fecha}. Por tal motivo, solo se podrá gestionar una prórroga adicional.`,
              confirmButtonText: "¡Entendido!",
              confirmButtonColor: "#066E45"
            });
            cambiarDatosIniciales();
            return;
          }
          if(response.message["registros"] >= 2){  //Si hay incapacidad y renovación se debe esperar a la fecha de finalización
            Swal.fire({
              icon: "info",
              title: "Acción no permitida",
              text: "El paciente ya cuenta con una incapacidad y una prórroga activas. Para generar una nueva, primero debes anular la existente.",
              allowOutsideClick: false, 
              allowEscapeKey: false,    
              allowEnterKey: false,    
              confirmButtonText: "Ir a consultar la incapacidad",
              confirmButtonColor: "#066E45"
            }).then(result => {
              if(result.isConfirmed){
                window.location.href = 'ConsolidadoIncapacidad.php';
              }else{
                window.close();
              }
            });
          }
        }   
      }
    })
  }
});


//Mëtodo que cambia datos iniciales con base a si hay o no renovación de incapacidad
function cambiarDatosIniciales(){
  let dia = fecha.split("-");  //Separar la fecha en un array de año - mes - día
  fecha = `${dia[0]}-${dia[1]}-${parseInt(dia[2])+1}`;   //Se le asigna a la fecha el día siguiente para la renovación de la incapacidad
  $("#FechaInicial").val(fecha);
  $("#FechaInicial").attr("min", fecha);
  $("#FechaInicial").attr("max", fecha);
  $("#FechaFinal").attr("min", fecha);
  $("input[name='Prorroga'][value='Si'").attr("checked", true);
  esRenovacion = true;
}


function obtenerFechaIncapacidad(){
  let fech;
  fech = new Promise(resolve => {
    $.ajax({
      type: "POST",
      url: '../Logica/ObtenerFechaIncapacidad.php',
      data: {"IDPaciente" : IDPaciente},
      success: function(response){
        response = JSON.parse(response);
        console.log(JSON.parse(response.message["Datos_Incapacidad"])["FechaFinal"]);
        // var quickScript = new Function($(response).text());
        // quickScript();
        resolve(JSON.parse(response.message["Datos_Incapacidad"])["FechaFinal"]);
      }
  
    });
  });
  return fech;
}


$(document).ready(function() {
  $('#FechaInicial').change(function(e) {
    $("#FechaInicial").removeAttr("disabled");
    IDPaciente = document.getElementById("IDNumberPaciente").value;
    FechaExpedicion = document.getElementById("FechaExpedicion").value;
    FechaIni = this.value;
    DateMin = new Date(FechaIni);
    DateMax = new Date(FechaIni);
    DateMax.setDate(DateMax.getDate() + 30);
    FechaFinal = document.getElementById("FechaFinal");
    FechaFinal.value = "";
    FechaFinal.min = DateMin.toISOString().split('T')[0];
    FechaFinal.max = DateMax.toISOString().split('T')[0];
    $.ajax({
      type: "POST",
      url: '../Logica/VerificarIncapacidad.php',
      data: {"IDPaciente" : IDPaciente, "FechaIni" : FechaIni, "FechaExpedicion" : FechaExpedicion},
      success: function(response){
        console.log(response)
        // var quickScript = new Function($(response).text());
        // quickScript();
      },
      error: function(response) {
      } 

    });

    verifyCorrectTimePeriod();
  });
});

$(document).ready(function() {
  $('#FechaFinal').change(function(e) {
    verifyCorrectTimePeriod();
  });
});


$(document).ready(function() {
    $('#AgregarIncapacidad').submit(function(e) {
      e.preventDefault();

      var formData = new FormData($('#AgregarIncapacidad')[0]);

      var OrigenIncapacidadElements = document.getElementsByName("OrigenIncapacidad");
      var OrigenIncapacidad = getSelectedRadio(OrigenIncapacidadElements);

      var ProrrogaElements = document.getElementsByName("Prorroga");
      var Prorroga = getSelectedRadio(ProrrogaElements);

      formData.append("OrigenIncapacidad", OrigenIncapacidad);
      formData.append("Prorroga", Prorroga);
  
      $.ajax({
        type: "POST",
        url: '../Logica/GuardarIncapacidad.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response){
          console.log(response)
          var quickScript = new Function($(response).text());
          quickScript();
          
        },
        error: function(response) {
          var txt = "ERROR";
          console.log(txt);
          console.log(response);
        } 
  
      });
    });
  });

  function getSelectedRadio(Elements){
    var selectedOption;
    for (var i = 0; i < Elements.length; i++) {
      if (Elements[i].checked) {
        selectedOption = Elements[i].value;
        return selectedOption;
      }
    }
    return null;
  }

  function verifyCorrectTimePeriod(){
    FechaIni = document.getElementById("FechaInicial").value;
    FechaFin = document.getElementById("FechaFinal").value;

    if(FechaIni !== "" && FechaFin !== ""){
      if(FechaFin < FechaIni){
        Swal.fire({
          icon: 'info',
          title: 'La fecha de finalizacion debe ser posterior a la fecha de inicio',
        });

        document.getElementById("FechaFinal").value = "";
      }
      else{
        var TotalDias = document.getElementById("TotalDias");
        Inicio = new Date(FechaIni);
        Fin = new Date(FechaFin);

        var differenceMs = Fin - Inicio;
        var differenceDays = Math.floor(differenceMs / (1000 * 60 * 60 * 24)) + 1;

        if( differenceDays == 1){
          days = "dia";
        }
        else if( differenceDays > 1){
          days = "dias";
        }
        TotalDias.value = differenceDays + ' ' + days;

      }
    }

  }






// $(document).ready(function(){
//   IDPaciente = document.getElementById("IDNumberPaciente").value;
//   if(IDPaciente !== ""){
//     $.ajax({
//       type: "POST",
//       url: '../Logica/VerificarIncapacidadActiva.php',
//       data: {"IDPaciente" : IDPaciente},
//       success: function(response){
//         console.log(response)
//         response = JSON.parse(response);
//         if(response.success){
//           console.log("si");
//           Swal.fire({
//             icon: "error",
//             title: "No es posible ingresar",
//             text: "El paciente tiene una incapacidad activa, para generar una nueva debes anular la existente",
//             allowOutsideClick: false, // desactiva clic fuera del modal
//             allowEscapeKey: false,    // desactiva tecla Escape
//             allowEnterKey: false,    //Desactiva el teclado Enter,
//             confirmButtonText: "Ir a consultar la incapacidad",
//             confirmButtonColor: "#066E45"
//           }).then(result => {
//             if(result.isConfirmed){
//               window.location.href = 'ConsolidadoIncapacidad.php';
//             }else{
//               window.close();
//             }
//           });
//         }
        
//       }
  
//     })
    
//   }
// });