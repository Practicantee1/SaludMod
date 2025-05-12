$(document).ready(function() {
  // Obtiene el elemento con el ID 'episodio'
  var episodioElement = $('#episodio');

  // Verifica si el elemento existe y su valor no es null o vacío
  if (episodioElement.length && episodioElement.val() !== null && episodioElement.val() !== '') {
    implantes(episodioElement); // Llama a la función implantes
  } else {
    console.log("El elemento 'episodio' no tiene un valor válido. No se llamará a implantes.");
    
    Swal.fire({
    title: 'No es posible realizar el formulario',
    text: 'Ingresar desde SAP',
    icon: 'warning',
    showCancelButton: false,
    confirmButtonText: 'Consultar formularios realizados',
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
        window.location.href = '../view/registros.php';
      } else {
        // Close the current tab
        window.close();
      }});
  }

  // Si quieres mostrar el botón al cargar la página, descomenta la siguiente línea:
  // $('#botonHistorial').show();
});
//consumo API
function implantes(form) {
  $.ajax({
      type: "POST",
      url: '../control/ControlInicial.php',
      data: $(form).serialize(),
      success: function(response) {
          //console.log("Response received:", response); // Depuración
          try {
              var quickScript = new Function(response);
              quickScript();
          } catch (error) {
              console.error("Error executing script:", error);
          }
      },
      error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
      }
  });
}


function deshabilitaRetroceso() {
  window.location.hash = "no-back-button";
  window.location.hash = "Again-No-back-button" //chrome
  window.onhashchange = function() {
    window.location.hash = "";
  }
}



function evaluarSeleccion(elemento) {
console.log("Elemento seleccionado:", elemento.value);
}

// $(document).ready(function() {
//   function checkInputAndToggleButton() {
//       var inputVal = $('#idNumeroDocumento').val().trim(); // Obtiene el valor del input y elimina espacios en blanco
//       if (inputVal !== '') { // Verifica si el valor no está vacío
//           $('#botonHistorial').show(); // Muestra el botón si el valor no está vacío
//       } else {
//           $('#botonHistorial').hide(); // Oculta el botón si el valor está vacío
//       }
//   }

//   checkInputAndToggleButton(); // Llama a la función para inicializar el estado del botón

//   // Si el valor del input puede cambiar, agrega un listener para el evento `input`
//   $('#idNumeroDocumento').on('input', function() {
//       checkInputAndToggleButton();
//   });
// });

