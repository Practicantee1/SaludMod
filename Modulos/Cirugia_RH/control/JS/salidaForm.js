$(document).ready(function() {
    $('#guardarSalida').on('click', function(event) {
        event.preventDefault();

  
        // Datos de FORM Salida 
        var episodio = $("#episodio").val();       
        var programada = $("#id_programada").val();
        var complicaciones = $("#id_complicaciones").val();
        var conteo = $("#id_Conteo").val();
        var camilla = $("#id_Camilla").val();
        var muestra = $("#id_Muestra").val();
        var posopetario = $("#id_posopetario").val();
        var problemas = $("#id_problemas").val();
        var observaciones = $("#idObservacionesSalida").val();

        // console.log("Episodio:", episodio);
        // console.log("Programada:", programada);
        // console.log("Complicaciones:", complicaciones);
        // console.log("Conteo:", conteo);
        // console.log("Camilla:", camilla);
        // console.log("Muestra:", muestra);
        // console.log("Posoperatorio:", posopetario);
        // console.log("Problemas:", problemas);
        // console.log("Observaciones:", observaciones);

        if (
            episodio === null || programada === null || complicaciones === null || conteo === null ||
            camilla === null || muestra === null || posopetario === null || problemas === null 
        ) {
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar el registro',
                text: 'Uno o más campos faltan. Por favor, verifica los datos.',
                showConfirmButton: true
            });
            return; // Salir de la función si se detecta un valor nulo
        }

        // Envía los datos combinados usando AJAX
        $.ajax({
            type: 'POST',
            url: '../logica/formSalidaSQL.php',
            data: {
                episodio: episodio,
                programada: programada,
                complicaciones: complicaciones,
                conteo: conteo,
                camilla: camilla,
                muestra: muestra,
                posopetario: posopetario,
                problemas: problemas,
                observaciones: observaciones
            },
            success: function(response) {
                console.log('Datos enviados con éxito:', response);
                
                // Suponiendo que la respuesta es un JSON, conviértela si es necesario
                var jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            
                if (jsonResponse.error) {
                    Swal.fire({
                        icon: 'error', // Cambiado a error
                        title: jsonResponse.error, // Muestra el mensaje de error devuelto por el servidor
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Habilitar los formularios de pausa
                    // $('#salida-tab').prop('disabled', false).removeClass('disabled');
                    $('#idFormSalida input, #idFormSalida select, #idFormSalida textarea').prop('disabled', true); 
                    document.getElementById('guardarFirmaSalida').removeAttribute('disabled');


                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Se guardó el registro correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al enviar los datos:', error);
                console.error('Detalles del error:', xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar el registro',
                    text: 'Hubo un problema al procesar la solicitud.',
                    showConfirmButton: true
                });
            }
        });
    });
});