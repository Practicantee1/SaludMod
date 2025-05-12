$(document).ready(function() {
    $('#ConsultaUbicacionForm').submit(function(e) {
      e.preventDefault();
      llenarUbicacion(this);
      
    });
  });


  function llenarUbicacion(form) {
    $("#Search-acompanante").hide();
  
    Swal.fire({
      text: "¿Estas seguro de que este sea el número de identificación del paciente?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#006941",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: '../Control/LlenarUbicacion.php',
          data: $(form).serialize(),
          success: function(response) {
            var quickScript = new Function($(response).text());
            quickScript();
          },
          error: function(response) {
            var txt = "ERROR";
            console.log(txt);
            console.log(response); 
          }
        });
        $("#Search-acompanante").show();
      }
    });
  }

  $(document).ready(function() {
    $('#ConsultaUbicacionForm').submit(function(e) {
      e.preventDefault();
      llenarUbicacion(this);
      
    });
  });



  $("#btn-Documento").click(function(){
    $("#consulta-Documento").removeAttr("hidden");
    $("#consulta-nombres").attr("hidden",true);
    $("#tabla-pacientes_wrapper").attr("hidden",true);
  })
  $("#btn-Nombre").click(function(){
    $("#consulta-Documento").attr("hidden", true);
    $("#consulta-nombres").removeAttr("hidden");
    $("#tabla-pacientes_wrapper").removeAttr("hidden");
  })


  $("#buscar-nombre").click(function () {
    let primerNombre = $("#nombre").val();
    primerNombre = "*"+primerNombre+"*"
    let primerApellido = $("#primerApellido").val();
    primerApellido = "*"+primerApellido+"*"
    let segundoApellido = $("#segundoApellido").val();
    console.log(primerNombre +" "+ primerApellido);
  

    $.ajax({
      type: "POST",
      url: "../Control/ConsultaNombre.php",
      data: {
        primerNombre: primerNombre,
        primerApellido: primerApellido,
        segundoApellido: segundoApellido,
      },
      success: function (response) {
         console.log(response);
        try {
          // Intenta convertir la respuesta en un objeto JSON
          const datosPaciente = JSON.parse(response);
  
          if (datosPaciente.length > 0) {
            // Llama a la funci�n para construir la tabla con los datos
            crearTabla(datosPaciente);
          } else {
            // Si no hay datos, muestra un mensaje
            $("#tabla-container").html("No se encontraron datos de pacientes.");
          }
        } catch (error) {
          console.error("Error procesando los datos:", error);
          console.log(response); // Para depurar
        }
      },
      error: function (response) {
        console.error("Error en la solicitud:", response);
      },
    });
  });
  
  // Funci�n para crear la tabla con DataTables
  function crearTabla(datos) {
    // Limpiar el contenedor de la tabla
    $("#tabla-container").empty();
  
    // Crear la estructura de la tabla
    const tabla = $("<table>").addClass("display").attr("id", "tabla-pacientes");
  
    // Crear cabecera
    const cabecera = $("<thead>").append(
      $("<tr>").append(
        $("<th style='width:80px'>").text("Nombre Completo"),
        $("<th style='width:80px'>").text("Descripcion Documento"),
        $("<th style='width:80px'>").text("Numero de Documento"),
        $("<th style='width:80px'>").text("Numero Paciente").addClass("hidden-column"), // Ocultar esta columna
        $("<th style='width:80px'>").text("Edad"),
        $("<th style='width:80px'>").text("Sexo"),
        $("<th style='width:80px'>").text("Direccion")
      )
    );
  
    // Crear cuerpo de la tabla
    const cuerpo = $("<tbody>");
    datos.forEach((paciente) => {
      let direccionSinCodigo = "";
      if (paciente.Direccion) {
        direccionSinCodigo = paciente.Direccion.replace(/^\d+\s/, ""); // Elimina el c�digo num�rico al inicio
      }
    
      const fila = $("<tr>").append(
        $("<td style='width:80px'>").text(paciente.Nombre_completo),
        $("<td style='width:80px'>").text(paciente.Desc_documento),
        $("<td style='width:80px'>").text(paciente.Numero_documento),
        $("<td style='width:80px'>").text(paciente.Numero_paciente).addClass("hidden-column"), // Ocultar esta columna
        $("<td style='width:80px'>").text(paciente.Edad),
        $("<td style='width:80px'>").text(paciente.Sexo),
        $("<td style='width:80px'>").text(direccionSinCodigo) // Agregar la direcci�n procesada
      );
      cuerpo.append(fila);
    });
  
    // Agregar cabecera y cuerpo a la tabla
    tabla.append(cabecera).append(cuerpo);
  
    // Insertar la tabla en el contenedor dentro del modal
    $("#tabla-conter").empty().append(tabla);
  
    // Inicializar DataTable para la tabla reci�n creada
      const dataTable = new DataTable("#tabla-pacientes", {
      paging: true,           // Activar paginaci�n
      pageLength: 5,          // N�mero de filas por p�gina
      searching: false,       // Desactivar la b�squeda por escrito
      language: {
        url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json", // Cargar traducci�n en espa�ol
      },
      columnDefs: [
        {
          targets: [2],       // �ndice de la columna "N�mero Paciente"
          visible: false,     // Ocultar la columna
        },
      ],
    });
  
    // Mostrar el modal despu�s de que la tabla se haya creado
 
    $("#modal-tabla").removeAttr("hidden");

    // Evento para seleccionar una fila
    $('#tabla-pacientes tbody').on('click', 'tr', function () {
      // Obtener los datos de la fila seleccionada
      const data = dataTable.row(this).data();
      $("#Search-acompanante").show();
      // Aqu� puedes realizar lo que necesites con los datos obtenidos
      let IDNumber = data[2];
      
  
      $.ajax({
        type: "POST",
        url: '../Control/LlenarUbicacion.php',
        data: { IDNumber: IDNumber },
        success: function(response) {
          var quickScript = new Function($(response).text());
          quickScript();
          $("#modal-tabla").attr("hidden", true);
          let documento = $("#documento").val(); 
          $("#IDNumber").val(documento); 
          let INumber = $("#documento").val(); 
          console.log("documento: " + documento);
          console.log("inumber: " + INumber);
        },
        error: function(response) {
          console.log("ERROR");
          console.log(response); 
        }
      });
    });
  }
  
  $("#cerrar").click(function(e){
    e.preventDefault();
    $("#modal-tabla").attr("hidden", true);

  })