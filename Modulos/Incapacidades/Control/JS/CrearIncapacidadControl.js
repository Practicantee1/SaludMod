document.addEventListener('DOMContentLoaded', function() {
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



$(document).ready(function() {
  $('#FechaInicial').change(function(e) {
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
        var quickScript = new Function($(response).text());
        quickScript();
        
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