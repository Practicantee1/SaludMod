$(document).ready(function() {
  $('#formulario_implantes').on('keypress',function(e) {
    if(e.which === 13){ //Código para el ENTER
      e.preventDefault();
      implantes(this);
    }
  });
});

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


/*Oculto la tabla con la única condición de que tiene que aparecer cuando doy click en el botón "Buscar Paciente", ahora si en dado caso
el usuario da click en el botón y no ingresó ningún documento, la tabla va a seguir siendo oculta y este le mostrará una advertencia para que
ingrese el número de documento. */

/*$(document).ready(function() {
// Asignar evento de clic al botón que carga el modal
$('#btnBuscar').click(function() {
  var numeroEpisodio = $('#idNumeroEpisodio').val();
  if (numeroEpisodio) {
      // Aquí puedes añadir la lógica para buscar los datos del episodio
      console.log("Buscando episodio:", numeroEpisodio);
  } else {
      $('#alertContainer').removeClass('alert-success').addClass('alert-danger').text('Por favor, ingrese un número de episodio').show();
  }
});

// Evento para manejar dinámicamente elementos añadidos
$('#btnAgregarLinea').click(function() {
var container = $('#lineas-container');
var nuevaLinea = `
<div class="row form-section" style="border-bottom: 3px solid #306A42; margin: 5px 0;">
<div class="row">
  <div class="col-md-4">
    <label>Tipo de implante</label>
    <select class="form-select" name="infTipoImplante" onchange="evaluarSeleccion(this)">
      <option value="">Seleccione una opción</option>
      <!-- Opciones dinámicas -->
    </select>
  </div>
  <div class="col-md-4">
    <label>Casa comercial</label>
    <select class="form-select" name="infCasaComercial" onchange="evaluarSeleccion(this)">
      <option value="">Seleccione una opción</option>
      <!-- Opciones dinámicas -->
    </select>
  </div>
  <div class="col-md-4">
    <label>Entrenamiento del soporte</label>
    <select class="form-select" name="infEntrenamiento">
      <option value="">Seleccione una opción</option>
      <option value="Alto">Alto</option>
      <option value="Medio">Medio</option>
      <option value="Bajo">Bajo</option>
    </select>
  </div>
  <div class="col-md-4">
    <label>Personalización del producto</label>
    <select class="form-select" name="infPersonalizacion">
      <option value="">Seleccione una opción</option>
      <option value="Alto">Alto</option>
      <option value="Medio">Medio</option>
      <option value="Bajo">Bajo</option>
    </select>
  </div>
</div>
</div>
`;
container.append(nuevaLinea);
});
});*/

function evaluarSeleccion(elemento) {
console.log("Elemento seleccionado:", elemento.value);
}
