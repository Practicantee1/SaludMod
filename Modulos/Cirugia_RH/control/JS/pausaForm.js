$(document).ready(function() {
    $('#guardarPausa').on('click', function(event) {
        event.preventDefault();

  
        // Datos de FORM Pausa 
        var episodio = $("#episodio").val(); 
        var equipoHumano = $("#id_equipoHumano").val();     
        var nombre_abordaje = $("#id_abordaje").val();
        var existen = $("#id_Existen").val();
        var administracion = $("#id_Administracion").val();
        var plan = $("#id_Plan").val();
	    var textoPlan = $("#textoarea_Plan").val();
        var anestesiologo = $("#id_anestesiologo").val();
        var esterilidad = $("#id_esterilidad").val();
        var vo = $("#id_Vo").val();
        var Detalles_relevantes = $("#id_Detalles_relevantes").val();
        var T = $("#id_T").val();
        var perfusion = $("#id_perfusion").val();
        var observacionesPausa = $("#idObservacionesPausa").val();


         console.log("Episodio:", episodio);
        // console.log("Nombre abordaje:", nombre_abordaje);
        // console.log("Existen riesgos:", existen);
        // console.log("Administración:", administracion);
        // console.log("Plan:", plan);
        // console.log("Anestesiólogo:", anestesiologo);
        // console.log("Esterilidad:", esterilidad);
        // console.log("Vo:", vo);
        // console.log("Observaciones:", observacionesPausa);

        // Validar si hay campos nulos
        if (
            episodio === null || equipoHumano === null || nombre_abordaje === null || existen === null || administracion === null ||
            plan === null || anestesiologo === null ||  vo === null  || Detalles_relevantes === null || T === null || perfusion === null
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
            url: '../logica/formPausaSQL.php',
            data: {
                episodio: episodio,
                equipoHumano: equipoHumano,
                nombre_abordaje: nombre_abordaje,
                existen: existen,
                administracion: administracion,
                plan: plan,
		        textoPlan: textoPlan,
                anestesiologo: anestesiologo,
                esterilidad: esterilidad,
                vo: vo,
                Detalles_relevantes: Detalles_relevantes,
                T: T,
                perfusion: perfusion,
                observacionesPausa: observacionesPausa
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
                    // Habilitar los formularios de salida
                    $('#salida-tab').prop('disabled', false).removeClass('disabled');
                    $('#idFormPausa input, #idFormPausa select, #idFormPausa textarea').prop('disabled', true); 

                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Se guardó el registro correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Habilitar y mostrar la tercera pestaña
                        $('#salida-tab').prop('disabled', false).removeClass('disabled');    
                        const salidaTab = new bootstrap.Tab(document.querySelector('#salida-tab'));
                        salidaTab.show();

                       
                        setTimeout(() => {
                            const elemento = document.querySelector('#myTab'); 
                            const posicion = elemento.offsetTop;

                            window.scrollTo({
                                top: posicion,
                                behavior: 'smooth'
                            });
                        }, 300); 
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
