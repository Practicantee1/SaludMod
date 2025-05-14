document.addEventListener('DOMContentLoaded', function() {
    let filaActual; // Variable para almacenar la referencia de la fila actual

    // Manejar el clic en los botones "Agregar" y "Eliminar" para ambos formularios
    document.getElementById('firmas-container').addEventListener('click', function(event) {
        handleRowActions(event, 'entrada');
    });

    document.getElementById('firmas-container-salida').addEventListener('click', function(event) {
        handleRowActions(event, 'salida');
    });

    function handleRowActions(event, tipo) {
        // Manejar el clic en los botones "Agregar"
        if (event.target.classList.contains('add-row')) {
            // Selecciona la fila a clonar
            const filaParaClonar = document.querySelector(tipo === 'entrada' ? '.row.firma-item' : '.row.firmaSalida-item');

            if (filaParaClonar) {
                const nuevaFila = filaParaClonar.cloneNode(true);

                // Limpiar los campos de la nueva fila
                nuevaFila.querySelectorAll('input').forEach(input => {
                    input.value = '';        // Limpiar el valor del input
                });

                 const validarBtn = nuevaFila.querySelector('.validarBtn');
                 if (validarBtn) {
                     validarBtn.disabled = false; // Deshabilitar el botón
                 }

                // Agregar la nueva fila al contenedor específico
                const contenedor = document.getElementById(tipo === 'entrada' ? 'firmas-container' : 'firmas-container-salida');
                contenedor.appendChild(nuevaFila);
            }
        }

        // Manejar el clic en los botones "Eliminar"
        if (event.target.classList.contains('remove-row')) {
            const fila = event.target.closest('.row.firma-item') || event.target.closest('.row.firmaSalida-item');
            const container = document.getElementById(tipo === 'entrada' ? 'firmas-container' : 'firmas-container-salida');

            // Verifica si hay más de una fila antes de eliminar
            if (container.querySelectorAll('.row.firma-item').length > 1 || container.querySelectorAll('.row.firmaSalida-item').length > 1) {
                fila.remove(); // Eliminar la fila actual
            } else {
                // alert('Debes añadir al menos una persona a cargo de la cirugía.'); // Mensaje de advertencia
            }
        }

        // Manejar el clic en los botones "VALIDAR"
        if (event.target.classList.contains('validarBtn')) {
            filaActual = event.target.closest('.row.firma-item') || event.target.closest('.row.firmaSalida-item'); // Almacenar la fila actual
            $('#Modal').modal('show'); // Abrir el modal
        }
    }

    // Evento para el botón "Confirmar" en el modal
    document.getElementById('confirmarBtn').addEventListener('click', function() {
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;

        // Validar que los campos no estén vacíos
        if (username === '' || password === '') {
            mostrarMensaje('Por favor, complete todos los campos', 'error');
            return;
        }

        // Enviar la solicitud Ajax
        $.ajax({
            type: 'POST',
            url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/Cirugia_RH/logica/verificarUsuario.php',
            data: { login: username, clave: password },
            success: function(response) {
		console.log("Respuesta del servidor:", response);
                // Intentar analizar la respuesta JSON
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        mostrarMensaje('Credenciales correctas', 'success');

                        // Llenar los campos de la fila actual
                        if (filaActual.closest('#firmas-container')) {
                            // Si está en el contenedor de firmas de entrada
                            filaActual.querySelector('[name="idNombreFirmaEntrada[]"]').value = jsonResponse.nombre;
                            filaActual.querySelector('[name="idDocumentoFirmaEntrada[]"]').value = jsonResponse.num_documento;
                            filaActual.querySelector('[name="idCargoEntrada[]"]').value = jsonResponse.cargo;
                        } else if (filaActual.closest('#firmas-container-salida')) {
                            // Si está en el contenedor de firmas de salida
                            filaActual.querySelector('[name="idNombreFirmaSalida[]"]').value = jsonResponse.nombre;
                            filaActual.querySelector('[name="idDocumentoFirmaSalida[]"]').value = jsonResponse.num_documento;
                            filaActual.querySelector('[name="idCargoSalida[]"]').value = jsonResponse.cargo;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Firmado Exitosamente',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        /// bloquea boton!!
                        const firmarBtn = filaActual.querySelector('.validarBtn');
                        if (firmarBtn) {
                            firmarBtn.disabled = true; // O firmarBtn.style.display = 'none'; para hacerlo invisible
                        }

                        // Cerrar el modal
                        $('#Modal').modal('hide');
                    } else {
                        mostrarMensaje(jsonResponse.message, 'error');
                    }
                } catch (e) {
                    mostrarMensaje('Error en la respuesta del servidor', 'error');
                }
            },
            error: function(xhr, status, error) {
                mostrarMensaje('Ocurrió un error al validar las credenciales', 'error');
            }
        });
    });

    function mostrarMensaje(mensaje, tipo) {
        let mensajeDiv = document.getElementById('mensaje');
        mensajeDiv.style.display = 'block';
        mensajeDiv.innerText = mensaje;

        // Cambiar la clase según el tipo de mensaje
        if (tipo === 'success') {
            mensajeDiv.classList.remove('alert-danger');
            mensajeDiv.classList.add('alert-success');
        } else {
            mensajeDiv.classList.remove('alert-success');
            mensajeDiv.classList.add('alert-danger');
        }

        // Ocultar el mensaje después de 3 segundos
        setTimeout(function() {
            mensajeDiv.style.display = 'none';
        }, 3000);
    }
});


// //  BLOQUEO DE BOTON FIRMA ARREGLAR
//   // Función para habilitar el botón FIRMAR cuando se selecciona un cargo
//   $(document).ready(function() {
//     // Manejar el cambio en el select
//     $('#firmas-container-salida').on('change', 'select[name="idCargoSalida[]"]', function() {
//         // Verificar si hay una opción seleccionada
//         const $select = $(this);
//         const $validarBtn = $select.closest('.firmaSalida-item').find('.validarBtn');
        
//         if ($select.val()) {
//             // Si hay una opción seleccionada, habilitar el botón
//             $validarBtn.prop('disabled', false);
//         } else {
//             // Si no hay opción seleccionada, deshabilitar el botón
//             $validarBtn.prop('disabled', true);
//         }
//     });
// });


// $(document).ready(function() {
//     // Manejar el cambio en el select
//     $('#firmas-container').on('change', 'select[name="idCargoEntrada[]"]', function() {
//         // Verificar si hay una opción seleccionada
//         const $select = $(this);
//         const $validarBtn = $select.closest('.firma-item').find('.validarBtn');
        
//         if ($select.val()) {
//             // Si hay una opción seleccionada, habilitar el botón
//             $validarBtn.prop('disabled', false);
//         } else {
//             // Si no hay opción seleccionada, deshabilitar el botón
//             $validarBtn.prop('disabled', true);
//         }
//     });
// });

$(document).ready(function() {
    // Ocultar la fila de marcación al cargar la página
    $('#filaMarcacion').hide();

    // Detectar cambio en el campo de selección "Marcacion"
    $('#Marcacion').on('change', function() {
        const seleccion = $(this).val();
        
        if (seleccion === 'si') {
            $('#filaMarcacion').show();  // Mostrar fila si se selecciona "Sí"
        } else if (seleccion === 'no') { // Validar cuando se selecciona "No"
            $('#filaMarcacion').hide();  // Ocultar fila si se selecciona "No"
            $('#idSeleccione').val('').change(); // Esto selecciona la opción deshabilitada por defecto
        } else {
            $('#filaMarcacion').hide(); // Ocultar fila si se selecciona cualquier otra opción
            $('#idSeleccione').val('').change(); // Reiniciar el valor del select
        }
    });
});
