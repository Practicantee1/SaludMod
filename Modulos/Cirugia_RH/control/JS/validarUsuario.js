document.addEventListener('DOMContentLoaded', function() {

    
    const urlParams = new URLSearchParams(window.location.search);
    let paciente = urlParams.get("id_paciente"); 
    

    let filaActual; // Variable para almacenar la referencia de la fila actual

    // Manejar el clic en los botones "Agregar" y "Eliminar" para ambos formularios
    document.getElementById('firmas-container').addEventListener('click', function(event) {
        handleRowActions(event, 'entrada');
    });

    document.getElementById('firmas-container-salida').addEventListener('click', function(event) {
        handleRowActions(event, 'salida');
    });

    async function eliminarFirmar(event){
        let confirmado = false;
        let tipo = event.target.getAttribute("data-tipo");
        console.log(tipo)
        let fila;
        if(tipo === "INICIO"){
            fila = await event.target.closest(".firma-item").querySelector(".documento").dataset.id;
        }else{
            console.log("llego aqui", $(event.target).data("tipo"))
            fila = await event.target.closest(".firmaSalida-item").querySelector(".documento").dataset.id;
        }
        
    
        let resultado = await Swal.fire({
            icon: "info",
            title: "¿Estás seguro de realizar esta acción?",
            text: "La firma seleccionada será eliminada",
            showCancelButton: true,
            confirmButtonColor: "#006941",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "No, cancelar"
        });
        let response
        if(resultado.isConfirmed){
            response = new Promise(resolve => {
                $.ajax({
                    type: "POST",
                    url: "../logica/eliminarFirmaUsuario.php",
                    data: { usuario_id: fila, tipo_Firma: tipo, paciente: paciente },
                    success: function(response) {
                        resolve(JSON.parse(response));
                    },
                });
            });
        }
        confirmado = await response;
        console.log(confirmado)
        Swal.fire({
            icon: confirmado.success ? "success" : "error",
            text: confirmado.success ? "Firma eliminada correctamente" : confirmado.message,
            toast: true,
            timer: 3000,
            confirmButtonColor: "#006941",
            position: "bottom-start",
        });

        

        return confirmado;
    }

    async function handleRowActions(event, tipo) {
        
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
                nuevaFila.querySelector(".validarBtn").dataset.firmado = "No";
                // Agregar la nueva fila al contenedor específico
                const contenedor = document.getElementById(tipo === 'entrada' ? 'firmas-container' : 'firmas-container-salida');
                contenedor.appendChild(nuevaFila);
            }
        }

        // Manejar el clic en los botones "Eliminar"
        if (event.target.classList.contains('remove-row')) {
            let confirmado;
            let tipo;
            let evento;
            if($(event.target).data("tipo") == "INICIO"){
                tipo = event.target.closest(".firma-item").querySelector(".nombre").value;
                evento = ".firma-item";
            }else{
                tipo = event.target.closest(".firmaSalida-item").querySelector(".nombre").value
                evento = ".firmaSalida-item";
            }

            if(tipo === ""){
                confirmado = true;
            }else{
                confirmado  = await eliminarFirmar(event, tipo);
            }
            
            if(confirmado){

                const fila = event.target.closest('.row.firma-item') || event.target.closest('.row.firmaSalida-item');
                
                const container = document.getElementById($(event.target).data("tipo") === 'INICIO' ? 'firmas-container' : 'firmas-container-salida');
                // Verifica si hay más de una fila antes de eliminar
                if (container.querySelectorAll('.row.firma-item').length > 1 || container.querySelectorAll('.row.firmaSalida-item').length > 1) {
                    fila.remove(); // Eliminar la fila actual
                } else {
                    event.target.closest(evento).querySelector(".cargo").value = "";
                    event.target.closest(evento).querySelector(".nombre").value = "";
                    event.target.closest(evento).querySelector(".documento").value = "";

                    const firmarBtn = event.target.closest(evento).querySelector('.validarBtn');
                    if (firmarBtn) {
                        firmarBtn.disabled = false; // O firmarBtn.style.display = 'none'; para hacerlo invisible
                    }
                }
            }
               
        }

        // Manejar el clic en los botones "VALIDAR"
        if (event.target.classList.contains('validarBtn')) {
            filaActual = event.target.closest('.row.firma-item') || event.target.closest('.row.firmaSalida-item'); // Almacenar la fila actual
            $('#Modal').modal('show'); // Abrir el modal
        }
    }

    async function verificarFirma(usuario, ciruPaciente, tipo){
        let firma;
        firma = await new Promise(resolve => {
            $.ajax({
                type: "POST",
                url: "../logica/buscarFirmaUsuario.php",
                data: {usuario: usuario, ciruPaciente: ciruPaciente, tipo: tipo },
                success: function(response){
                    response = JSON.parse(response);
                    resolve(response.success);
                }
            });
        });
        return firma
    }

    async function ingresarFirmar(usuario, ciruPaciente, tipo){
        let dato;
        dato = await new Promise(resolve => {
            $.ajax({
                type: "POST",
                url: "../logica/firmarPausas.php",
                data: {usuario_id: usuario, paciente_id: ciruPaciente, tipo: tipo},
                success: function(response){
                    try{
                        response = JSON.parse(response);
                        console.log(response.message);
                        resolve(response);
                    }catch(e){
                        console.log(e)
                    }
                },
                error: function(xhr, status, error){
                    console.error('Error AJAX:', error);
                    console.error('Detalles:', xhr.responseText);
                }
            });
        });

        return dato;
    }


    // Evento para el botón "Confirmar" en el modal
    document.getElementById('confirmarBtn').addEventListener('click', function(e) {
        let tipo = e.target.getAttribute("data-firma");
        if(paciente == null){
            paciente = window.paciente;
        }
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
        let boleano = true;
        let firmaInicio = false;

        // Validar que los campos no estén vacíos
        if (username === '' || password === '') {
            mostrarMensaje('Por favor, complete todos los campos', 'error');
            return;
        }
        // Enviar la solicitud Ajax
        $.ajax({
            type: 'POST',
            //url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/Cirugia_RH/logica/verificarUsuario.php',
            url: 'http://localhost/SaludModDev/Modulos/Cirugia_RH/logica/verificarUsuario.php',
            data: { login: username, clave: password},
            success: async function(response) {
                // Intentar analizar la respuesta JSON
                try {
                    var jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        boleano = await verificarFirma(jsonResponse.id_usuario, paciente, tipo);
                        if(!boleano){
                            mostrarMensaje('Credenciales correctas', 'success');
                            // Llenar los campos de la fila actual
                            if (filaActual.closest('#firmas-container')) {
                                firmaInicio = await confirmarFirmas();
                                if(!firmaInicio) return;
                                actualizarFirma(paciente, jsonResponse.id_usuario);

                                // Si está en el contenedor de firmas de entrada
                                filaActual.querySelector('[name="idNombreFirmaEntrada[]"]').value = jsonResponse.nombre;
                                filaActual.querySelector('[name="idDocumentoFirmaEntrada[]"]').value = jsonResponse.num_documento;
                                filaActual.querySelector('[name="idCargoEntrada[]"]').value = jsonResponse.cargo;
                                const inputEntrada = filaActual.querySelector('.documento');

                                inputEntrada.setAttribute("data-id", jsonResponse.id_usuario);
                                
                                
                            } else if (filaActual.closest('#firmas-container-salida')) {

                                // Si está en el contenedor de firmas de salida
                                filaActual.querySelector('[name="idNombreFirmaSalida[]"]').value = jsonResponse.nombre;
                                filaActual.querySelector('[name="idDocumentoFirmaSalida[]"]').value = jsonResponse.num_documento;
                                filaActual.querySelector('[name="idCargoSalida[]"]').value = jsonResponse.cargo;
                                const inputEntrada = filaActual.querySelector('.documento');
                                filaActual.querySelector(".validarBtn").dataset.firmado = "Si";
                                datos = await ingresarFirmar(jsonResponse.id_usuario, paciente, tipo);           
                                inputEntrada.setAttribute("data-id", jsonResponse.id_usuario);
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
                        }else{
                            Swal.fire({
                                icon: 'info',
                                title: 'No se puede guarda esta firma',
                                text: "El usuario ya se encuentra registrado en las firmas",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    } else {
                        mostrarMensaje(jsonResponse.message, 'error');
                    }
                } catch (e) {
                    mostrarMensaje('Error en la respuesta del servidor', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
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

async function confirmarFirmas(){
    let resultado = await Swal.fire({
        icon: "info",
        title: "¿Estás seguro que quieres completar las firmas de esta pausa?",
        text: "Esta acción no se puede revertir",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#006941",
        confirmButtonText: "Confirmar"
    });

    return resultado.isConfirmed;
}

async function actualizarFirma(paciente, usuario){
    $.ajax({
        type: "POST",
        data: {paciente: paciente, usuario: usuario},
        url: '../logica/guardarFirmaInicio.php',
        success: function(response){
            response = JSON.parse(response);

            if(response.succes){
                Swal.fire({
                    icon: response.success ? "success" : "error",
                    title: response.success ? "Proceso éxitoso" : "Error en el proceso",
                    text: response.message,
                    confirmButtonColor: "#006941",
                    confirmButtonText: "Finalizar"
                });    
            }
            
        }
    });
    console.log("Devuelve la respuesta");
    //$('#guardarFirmaEntrada').prop("disabled", true);
    //$('.add-row').prop("disabled", true);
    //$(".remove-row ").prop("disabled", true);
	// $('#guardarFirmaEntrada').prop("disabled", true);
    $('#agregarInicio').prop("disabled", true);
    // $(".firma-item .remove-row ").prop("disabled", true);
}


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

