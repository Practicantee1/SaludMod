$(document).ready(function() {
    $("#formVerificarAcceso").submit(function(e) {
      e.preventDefault();
      var documento = $("#documento").val().trim();
      if (documento === "") {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Debe ingresar un número de documento.'
        });
        return;
      }
      $.ajax({
        type: "POST",
        url: "../Control/verificarAcceso.php",
        data: {
          documento: documento
        },
        dataType: "html",
        beforeSend: function() {
          Swal.fire({
            title: 'Verificando...',
            text: 'Por favor, espere.',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
        },
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Resultado',
            html: response
          });
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error en la solicitud.'
          });
        }
      });
    });
  });