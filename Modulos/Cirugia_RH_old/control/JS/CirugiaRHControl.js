
// Consumo API
$(document).ready( function() {
//   if (event.key === 'Enter') {
      var episodio = $("#episodio").val();

      // Validar si el valor de #episodio está vacío o nulo
      if (!episodio) {
        Swal.fire({
            title: 'No es posible realizar el formulario',
            text: 'Ingresar desde SAP',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Consultar formularios pendientes',
            allowOutsideClick: false,
            allowEscapeKey: false,
            iconColor: '#006941',
            customClass: {
                title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
                popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
                content: 'custom-swal-Incapacidad-Content',
                confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
            }
          }).then((result) => {
              // Check if the user clicked the "Confirm" button
              if (result.isConfirmed) {
                // Redirect to another page
                window.location.href = '../view/continuarForm.php';
              } else {
                // Close the current tab
                window.close();
              }});
          return; // Salir de la función si el valor es nulo o vacío
      }

      // Si el valor no es nulo o vacío, procede con la solicitud AJAX
      $.ajax({
          type: "POST",
          url: '../control/ControlInicialCirugia.php',
          data: { Episodio: episodio },
          success: function(response) {
              try {
                  // Si la respuesta contiene un mensaje o indicador de que el episodio no existe
                  if (response === "Episodio no encontrado" || response.success === false) {
                      Swal.fire({
                          icon: 'warning',
                          title: 'Episodio no encontrado',
                          text: 'El episodio ingresado no fue encontrado en el sistema.',
                          showConfirmButton: true
                      });
                  } else {
                      // Ejecutar el script recibido si el episodio existe
                      var quickScript = new Function(response);
                      quickScript();
                  }
              } catch (error) {
                  console.error("Error executing script:", error);
              }
          },
          error: function(xhr, status, error) {
              console.error("AJAX Error:", status, error);
          }
      });
//   }
});


  
  
 