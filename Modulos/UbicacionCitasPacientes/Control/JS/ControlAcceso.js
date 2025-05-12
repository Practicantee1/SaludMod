$(document).ready(function() {
    $("#Search-acompanante ").click(function(e) {
      e.preventDefault();
  
      let bedCode = $("#Bedcode").val().trim();
      let idPaciente = $("#IDNumber").val().trim();
      let btnAbrirModal = $("#abrirModal"); // Botón de abrir modal
      let Searchacompanante = $("#Search-acompanante"); 
      if (!bedCode || !idPaciente) {
        Swal.fire({
        icon: "info",
        title: "Paciente dado de alta",
        text: " ℹ️ El paciente ha sido dado de alta y no se encuentra su ubicación de cama.📆",
        confirmButtonColor: "#0d9b62"
        });
        
        btnAbrirModal.prop("disabled", true); // Deshabilita el botón
        Searchacompanante.prop("disabled", true); // Deshabilita el botón
        return;
      }
  
      $.ajax({
        type: "POST",
        url: "../Control/validar_cama.php",
        data: { 
          Bedcode: bedCode,
          IDNumber: idPaciente
        },
        dataType: "json", 
        success: function(response) {
          if (response.error) {
            Swal.fire({
              icon: "warning",
              title: "Acceso Denegado",
              text: response.error + 
                   "\nHorario permitido: " + response.horaInicio + " - " + response.horaFin +
                   "\nHora actual: " + response.horaActual,
              confirmButtonColor: "#0d9b62"
            });
            btnAbrirModal.prop("disabled", true); // Deshabilita el botón si hay error
            return;
          }
  
          let canRegisterAcompanante = response.canRegisterAcompanante;
          let canRegisterVisitante = response.canRegisterVisitante;
  
          // Deshabilitar opciones en el select si no hay cupos
          $("#compania option[value='Visitante']").prop("disabled", !canRegisterVisitante);
          $("#compania option[value='Acompañante']").prop("disabled", !canRegisterAcompanante);
  
          // Deshabilitar botón de abrir modal si no hay cupos o si hay un error en el horario
          let disableButton = !canRegisterAcompanante && !canRegisterVisitante;
          btnAbrirModal.prop("disabled", disableButton);
  
          if (!disableButton) {
            $('#exampleModalToggle').modal('show'); // Abre el modal si hay cupos
          } else {
            Swal.fire({
              icon: "warning",
              title: "Cupos llenos",
              text: "No hay cupos disponibles ni para visitantes ni para acompañantes. 📌",
              confirmButtonColor: "#0d9b62",
              confirmButtonText: "Aceptar"
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo verificar el estado.",
            confirmButtonColor: "#0d9b62"
          });
          btnAbrirModal.prop("disabled", true); // Deshabilita el botón si hay error
        }
      });
    });
  
    // Reactivar el botón cuando se modifiquen los campos de entrada
    $("#Bedcode, #IDNumber").on("input", function () {
      $("#abrirModal").prop("disabled", false);
    });
  
    // Evitar que el modal se abra si el botón está deshabilitado
    $("#abrirModal").click(function(e) {
      if ($(this).prop("disabled")) {
        e.preventDefault();
        Swal.fire({
          icon: "warning",  
          title: "Acción no permitida",
          text: "No puedes abrir el registro hasta que los datos sean válidos.",
          confirmButtonColor: "#0d9b62"
        });
      }
    });
  
    
  });



  $(document).ready(function () {
    function validarRegistroAcompanante() {
        let bedCode = $("#Bedcode").val(); // Obtener el valor de la cama

        if (bedCode.trim() !== "") {
            $("#Searchacompanante").prop("disabled", false); // Habilita el botón
        } else {
            $("#btnRegistrarAcompanante").prop("disabled", true); // Deshabilita el botón
        }
    }

    // Ejecutar la validación al cargar la página
    validarRegistroAcompanante();

    // También ejecutarla si el valor de la cama cambia (por ejemplo, si se actualiza mediante AJAX)
    $("#Bedcode").on("input", function () {
        validarRegistroAcompanante();
    });
});

  
  
  