$(document).ready(function() {
    $('#guardarFirmaSalida').on('click', function(event) {
        event.preventDefault();

        // Datos del formulario 'firmaSalida'
        let firmaData = [];
        let hasNullFields = false;

        // Recorre cada fila del formulario para obtener los datos
        $('#firmas-container-salida .firmaSalida-item').each(function(index) {
            var episodio = $("#episodio").val(); 
            // var cargo = $(this).find('select[name="idCargoSalida[]"]').val();      
            var cargo = $(this).find('input[name="idCargoSalida[]"]').val();
            var nombreCompleto = $(this).find('input[name="idNombreFirmaSalida[]"]').val();
            var numeroDocumento = $(this).find('input[name="idDocumentoFirmaSalida[]"]').val();

            // Validar campos requeridos
            if (!cargo || !nombreCompleto || !numeroDocumento) {
                hasNullFields = true; // Hay al menos un campo nulo
            }

            // Almacena los datos en el arreglo
            firmaData.push({
                episodio: episodio,
                cargo: cargo,
                nombreCompleto: nombreCompleto,
                numeroDocumento: numeroDocumento
            });
        });

        // Verificar si hay campos nulos
        if (hasNullFields) {
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar el registro',
                text: 'Uno o más campos faltan. Por favor, verifica los datos.',
                showConfirmButton: true
            });
            return; // Salir de la función si se detecta un valor nulo
        }

        // Mostrar el array en la consola
        console.log('Datos que se enviarán:', firmaData);

        // Envía los datos usando AJAX
        $.ajax({
            type: 'POST',
            url: '../logica/formFirmaSalidaSQL.php',
            data: {
                firmas: firmaData // Envía el arreglo de firmas
            },
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Verifica la respuesta del servidor
        
                // Verificar si la respuesta es vacía
                if (!response) {
                    console.error('La respuesta está vacía');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar el registro',
                        text: 'La respuesta del servidor está vacía.',
                        showConfirmButton: true
                    });
                    return;
                }

                try {
                    var jsonResponse = JSON.parse(response);
                } catch (e) {
                    console.error('Error al analizar la respuesta como JSON:', e);
                    console.error('Respuesta del servidor no válida:', response); // Muestra la respuesta no válida
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al guardar el registro',
                        text: 'La respuesta del servidor no tiene el formato JSON correcto.',
                        showConfirmButton: true
                    });
                    return;
                }

                if (jsonResponse.error) {
                    Swal.fire({
                        icon: 'error',
                        title: jsonResponse.error,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se guardó el registro correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    // Desactiva todos los campos del formulario
                    $('#firmaSalida input, #firmaSalida select, #firmaSalida button').prop('disabled', true); 
                    
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
