// Creación: 22/09/2021 10:00 am
$(document).ready(function () {
  $("#episodioPaciente").on('keypress', function (e) {
    if (e.which === 13) { // Código para el ENTER
      e.preventDefault();
      let episodio = $("#episodioPaciente").val();
      verificacionPaciente(episodio); // Llamar la funcion para consultar en la api por EPISODIO
    }

  });
  $("#episodioPacienteRiesgos").on('keypress', function (e) {
    if (e.which === 13) { // Código para el ENTER
      e.preventDefault();
      let episodio = $("#episodioPacienteRiesgos").val();
      verificacionPaciente(episodio); // Llamar la funcion para consultar en la api por EPISODIO
    }
  });


  //jQuery para guardar restricciones

  $('#btn-guardar-rs').click(function (e) {
    e.preventDefault();
    let episodioPaciente = $("#episodioPaciente").val()
    let tipoDocumento = $("#tipoDocumentoAcomp").val()
    let numeroDocumentoAcompanate = $("#numeroDocumentoAcompanate").val()
    let nombresCompletosAcomp = $("#nombresCompletosAcomp").val()
    let tipoRestriccion = $("#tipoRestriccion").val()

    if (!episodioPaciente || !tipoDocumento || !numeroDocumentoAcompanate || !nombresCompletosAcomp || !tipoRestriccion) {
      Swal.fire({
        icon: 'warning',
        title: 'Campos incompletos',
        text: 'Por favor, completa todos los campos antes de continuar.',
        timer: 3000,
      });
      return;
    }

    $.ajax({
      type: 'POST',
      url: '../Control/enviarRestriccion.php',
      data: {
        episodioPaciente: episodioPaciente,
        tipoDocumento: tipoDocumento,
        numeroDocumentoAcompanate: numeroDocumentoAcompanate,
        nombresCompletosAcomp: nombresCompletosAcomp,
        tipoRestriccion: tipoRestriccion
      },
      success: function () {
        Swal.fire({
          icon: 'success',
          title: 'Restricción guardada exitosamente',
          text: 'La restricción se guardó correctamente.',
          showConfirmButton: false,
          timer: 1500
        });
        $('#modalRestricciones').modal('hide');
        window.location.href = "agregarRestriccionesRiesgos.php";



        Swal.fire({
          icon: 'success',
          title: 'Restricción guardada exitosamente',
          text: 'La restricción se guardó correctamente.',
          showConfirmButton: true
        }).then((result) => {
          if (result.isConfirmed) {
            $('#modalRestricciones').modal('hide');
          }
        });
      },

      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un error al guardar la restricción.',
          timer: 3000
        });
      }
    }).fail(function () {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Hubo un error al guardar la restricción.',
        timer: 3000
      });
    });
  });
  // Limpiar modales al cerrarlos sin importar si se completaron los campos
  $('#modalRestricciones').on('hidden.bs.modal', function () {
    $(this).find('input').val('').attr('readonly', false);
    $(this).find('select').val('');
  });


  // Guardar riesgo
  //jQuery para guardar riesgos

  $('#btn-guardar-rg').click(function (e) {
    e.preventDefault();
    let episodioPaciente = $("#episodioPacienteRiesgos").val();
    let numeroDocumentoRiesgos = $("#numeroDocumentoRiesgos").val();
    let tipoRiesgo = $("#tipoRiesgo").val();
    let observacionRiesgo = $("#observacionRiesgo").val();

    if (!episodioPaciente  || !numeroDocumentoRiesgos || !tipoRiesgo || !observacionRiesgo) {
      Swal.fire({
        icon: 'warning',
        title: 'Campos incompletos',
        text: 'Por favor, completa todos los campos antes de continuar.',
      timer: 2500
      });
      console.log({
        episodioPaciente: episodioPaciente,
        numeroDocumentoRiesgos: numeroDocumentoRiesgos,
        tipoRiesgo: tipoRiesgo,
        observacionRiesgo: observacionRiesgo
      });
      return;
    };
    Swal.fire({
      icon: 'success',
      title: 'Riesgo guardado exitosamente',
      text: 'El riesgo se guardó correctamente.',
      showConfirmButton: false,
      timer: 2500
    }).then(() => {
      // Limpiar todos los campos del formulario
      $("#formRiesgos")[0].reset();
      // Ocultar el modal
      $('#modalRiesgos').modal('hide');
    });
     $('#modalRiesgos').modal('hide');
      window.location.href = "agregarRestriccionesRiesgos.php";

    $.ajax({
      type: 'POST',
      url: '../Control/enviarRiesgo.php',
      data: {
        episodioPaciente: episodioPaciente,
        numeroDocumentoRiesgos: numeroDocumentoRiesgos,
        tipoRiesgo: tipoRiesgo,
        observacionRiesgo: observacionRiesgo,
      },
      success: function () {
        Swal.fire({
          icon: 'success',
          title: 'Riesgo guardado exitosamente',
          text: 'El riesgo se guardó correctamente.',
          showConfirmButton: false,
          timer: 2500
        });

      },
      error: function () {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un error al guardar el riesgo.',
        });
      },
    });
  });
  // Limpiar modales al cerrarlos sin importar si se completaron los campos
  $('#modalRiesgos').on('hidden.bs.modal', function () {
    $(this).find('input').val('').attr('readonly', false);
    $(this).find('select').val('');
  });

  // Limpiar campos al borrar el episodio
  $('#episodioPaciente, #episodioPacienteRiesgos').on('input', function () {
    if ($(this).val().trim() === '') {
      $('#nombresCompletos, #tipoDocumento, #nombresCompletosRiesgos, #numeroDocumentoRiesgos, #tipoDocumentoRiesgos').val('');
    }
  });

});


function verificacionPaciente(episodio) {
  $.ajax({
    url: "/SaludMod/Modulos/UbicacionCitasPacientes/Control/obtenerEpisodio.php",
    type: "POST",
    data: { episodio: episodio },
    success: function (response) {
      if (response.trim() === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Paciente no encontrado',
          text: 'No se encontró ningún paciente con el episodio ingresado.',
          timer: 3000,
        });
      } else {
        console.log(response);
      }
    },
    error: function () {
      Swal.fire({
        icon: 'error',
        title: 'Error en la solicitud',
        text: 'No se pudo procesar la solicitud.',
      });
    },
  });
}


function verificacionPaciente(episodio) {
  $.ajax({
    url: "/SaludMod/Modulos/UbicacionCitasPacientes/Control/obtenerEpisodio.php",
    type: "POST",
    data: { episodio: episodio },
    success: function (response) {
      console.log(response);
    },
    error: function () {
      Swal.fire({
        icon: 'error',
        title: 'Error en la solicitud',
        text: 'No se pudo procesar la solicitud.',
      });
    },
  });
}


//limpia los campos de que se traen por medio del episodio de la api
// cuando se borra el episodio

document.getElementById('episodioPacienteRiesgos').addEventListener('input', function () {
  if (this.value.trim() === '') { // Si el campo está vacío, limpiar los otros campos

    document.getElementById('nombresCompletosRiesgos').value = '';
    document.getElementById('numeroDocumentoRiesgos').value = '';
    document.getElementById('tipoDocumentoRiesgos').value = '';
  }
});


$('#episodioPacienteRiesgos').on('input', function () {
  if ($(this).val().trim() === '') {
    $(' #nombresCompletosRiesgos, #numeroDocumentoRiesgos, #tipoDocumentoRiesgos').val('');
  }
});


document.getElementById('episodioPaciente').addEventListener('input', function () {
  if (this.value.trim() === '') { // Si el campo está vacío, limpiar los otros campos
    document.getElementById('nombresCompletos').value = '';
    document.getElementById('tipoDocumento').value = '';
    document.getElementById('numeroDocumento').value = '';

  }
});


$('#episodioPaciente').on('input', function () {
  if ($(this).val().trim() === '') {
    $('#nombresCompletos, #tipoDocumento, #numeroDocumento').val('');
  }
});


$(document).ready(function () {
  $("#episodioPaciente").on("change", function () {
    let valor = $(this).val();

    if (valor.trim() === "" || isNaN(valor)) { // Si está vacío o no es un número
      $(this).addClass("error-input");

      Swal.fire({
        title: "Error",
        text: "El episodio ingresado no es válido. Debe ser un número.",
        icon: "error",
        confirmButtonText: "Aceptar"
      });

      setTimeout(() => {
        $(this).removeClass("error-input");
        $(this).val(""); // Limpia el campo después de la alerta
      }, 1500); // Elimina la clase después de 1.5 segundos
    }
  });
});


$(document).ready(function () {
  // Función para validar los inputs
  function validarInputs() {
    $("input, select").each(function () {
      let valor = $(this).val().trim();
      let icono = $(this).next(".valid-icon");

      // Si el campo está lleno, muestra el check verde
      if (valor !== "") {
        if (icono.length === 0) {
          $(this).after('<i class="valid-icon bi bi-check-circle text-success ms-2"></i>');
        } else {
          icono.show();
        }
        $(this).removeClass("border-danger").addClass("border-success");
      } else {
        icono.hide();
        $(this).removeClass("border-success").addClass("border-danger");
      }
    });
  }

  $(document).ready(function () {
    function validarInputs() {
      $("input[required], select[required], textarea[required]").each(function () {
        let inputGroup = $(this).closest(".input-group");
        if ($(this).val().trim() === "") {
          $(this).addClass("border-danger").removeClass("border-success");
          inputGroup.removeClass("valid-input"); // Quita el chulo si está vacío
        } else {
          $(this).removeClass("border-danger").addClass("border-success");
          inputGroup.addClass("valid-input"); // Muestra el chulo si está lleno
        }
      });
    }

    // Validar en tiempo real los inputs
    $("input, select, textarea").on("input change", function () {
      validarInputs();
    });



    // Solo permitir números en los campos que deben ser numéricos
    $("#episodioPaciente, #numeroDocumentoAcompanate").on("input", function () {
      this.value = this.value.replace(/[^0-9]/g, ''); // Solo números
    });
  });



  //riesgossssssssssssssssssssssssss


  $(document).ready(function () {
    // Función para validar si todos los campos están llenos
    function validarCampos() {
      let todosLlenos = true;

      $("#formRiesgos input, #formRiesgos select, #formRiesgos textarea").each(function () {
        let inputGroup = $(this).closest(".input-group");
        if ($(this).prop("required") && $(this).val().trim() === "") {
          todosLlenos = false;
          inputGroup.removeClass("valid-input"); // Quita el chulo verde si está vacío
        } else {
          inputGroup.addClass("valid-input"); // Agrega el chulo verde si está lleno
        }
      });
      //AUN NO FUNCIONA LO DE LOS CHULOS VERDES LO TENGO DESHABILIDATO NO ME GUSTO LUEGO CONFIGURARLO
      //PARA ESTO HAYQ UE MODIFICAR LOS INPUTS Y PONERLOS COMO INPUT GROUPy
      return todosLlenos;
    }

    // Validar campos en tiempo real
    $("#formRiesgos input, #formRiesgos select, #formRiesgos textarea").on("input change", function () {
      validarCampos();
    });

    // Restringir los inputs de número solo a dígitos
    $("#episodioPacienteRiesgos, #numeroDocumentoRiesgos, #numeroDocumentoRiesgosAcomp").on("input", function () {
      this.value = this.value.replace(/[^0-9]/g, ""); // Solo permite números
    });


  });

});
