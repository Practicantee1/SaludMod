$(document).ready(function() {
    $('#guardarEntrada').on('click', function(event) {
        event.preventDefault();

        // Datos de FORM información general del paciente
        // var episodio = $("#episodio").val();
        // var num_documento = $("#idNumeroDocumento").val();
        // var edad = $("#idEdad").val();
        // var sexo = $("#idSexo").val();
        // var nombre = $("#idNombrePaciente").val();
        // var asegurador = $("#idAsegurador").val();
        // var procedimiento = $("#idProcedimiento").val();
        // var cirujano = $("#idNombreCirujano").val();
        // var especialidad = $("#idEspecialidad").val();
        // var fecha = $("#Fecha").val();
        // var centrosanitario = $("#centrosanitario").val();    ----> ESTO SE DEBE CAMBIAR

        var episodio = "1";
        var num_documento = "70079759";
        var edad = "22 años";
        var sexo = "MASCULINO";
        var nombre = "YOELIS PATRICIA HUERTAS";
        var asegurador = "SEGUROS GENERALES SURAMERICANA S.A.";
        var procedimiento = "JUAN FELIPE BRAVO PINEDA";
        var cirujano = "ENFERMERIA";
        var especialidad = "ENFERMERIA";
        var fecha = "2025-03-31";
        var centrosanitario = "1";    //------> ESTO SE DEBE ELIMINAR

        // Datos de FORM ENTRADA
        var nombreIdentificacion = $("#id_NombrIdentificacion").val();
        var instrumental = $("#id_intrumental").val();
        var alergiaReporta = $("#id_AlergiaReporta").val();
        var IndicacionAlergia = $("#textoarea_alergia").val();
        var consentimiento = $("#id_Consentimiento").val();
        var marcacion = $("#Marcacion").val();
        var seleccione = $("#idSeleccione").val();
        var verificacion = $("#id_Verificacion").val();
        var confirmacion = $("#id_Confirmacion").val();
        var esterilidad = $("#id_esterilidad").val();
        var monitoreo = $("#id_Monitoreo").val();
        var perdida = $("#id_Perdida").val();
        var reserva = $("#id_Reserva").val();
        var disponibilidad = $("#id_Disponibilidad").val();
        var estudios = $("#id_Estudios").val();
        var via = $("#id_Via").val();
        var antibiotico = $("#id_Antibiotico").val();
        var IndicacionAntibiotico = $("#textoarea_antibiotico").val();
        var suspension = $("#id_Suspension").val();
        var comercial = $("#id_comercial").val();
        var cultivos = $("#id_cultivos").val();
        var patologias = $("#id_patologias").val();

        var observaciones = $("#idObservacionesEntrada").val();
        
        //Validar si hay campos nulos no se pone asegurador ni observaciones
        // if (
        //     !episodio || !num_documento || !edad || !sexo ||
        //     !nombre || !procedimiento || !cirujano ||
        //     !especialidad || !fecha || !nombreIdentificacion ||
        //     !instrumental || !alergiaReporta || !consentimiento ||
        //     !marcacion || !verificacion || !confirmacion ||
        //     !monitoreo || !perdida || !reserva || !disponibilidad ||
        //     !estudios || !via || !antibiotico || !suspension ||
        //     !comercial || !cultivos || !patologias   
        // ) {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Error al guardar el registro',
        //         text: 'Uno o más campos faltan. Por favor, verifica los datos.',
        //         showConfirmButton: true
        //     });
        //     return; // Salir de la función si se detecta un valor nulo
        // }    -------> ESTO SE DEBE CAMBIAR

        // Envía los datos combinados usando AJAX
        $.ajax({
            type: 'POST',
            url: '../logica/formEntradaSQL.php',
            data: {
                episodio: episodio,
                num_documento: num_documento,
                edad: edad,
                sexo: sexo,
                nombre: nombre,
                procedimiento: procedimiento,
                cirujano: cirujano,
                especialidad: especialidad,
                fecha: fecha,
                centrosanitario:centrosanitario,
                asegurador: asegurador,
                nombreIdentificacion: nombreIdentificacion,
                instrumental: instrumental,
                alergiaReporta: alergiaReporta,
                IndicacionAlergia: IndicacionAlergia,
                consentimiento: consentimiento,
                marcacion: marcacion,
                seleccione: seleccione,
                verificacion: verificacion,
                confirmacion: confirmacion,
                esterilidad: esterilidad,
                monitoreo: monitoreo,
                perdida: perdida,
                reserva: reserva,
                disponibilidad: disponibilidad,
                estudios: estudios,
                via: via,
                antibiotico: antibiotico,
                IndicacionAntibiotico: IndicacionAntibiotico,
                suspension: suspension,
                comercial: comercial,
                cultivos: cultivos,
                patologias: patologias,
                observaciones: observaciones
            },


            success: function(response) {
                console.log('Datos enviados con éxito:', response);
            
                // Asegurarse de que la respuesta se trate como un objeto JSON
                var jsonResponse = JSON.parse(response); // Si el servidor no devuelve JSON directamente
            
                if (jsonResponse.error) {
                    Swal.fire({
                        icon: 'error', // Cambiado a error
                        title: jsonResponse.error, // Muestra el mensaje de error devuelto por el servidor
                        showConfirmButton: true,
                        confirmButtonText: 'OK', // Texto del botón
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../view/continuarForm.php'; // Redirige después de la confirmación
                        }
                    });
                } else {
                    // Habilitar los formularios de pausa y salida
                    $('#pausa-tab').prop('disabled', false).removeClass('disabled');
                    //$('#salida-tab').prop('disabled', false).removeClass('disabled');
                    $('#idFormEntrada input, #idFormEntrada select, #idFormEntrada textarea').prop('disabled', true); 
                    $('#idProcedimientoDatos input, #idProcedimientoDatos select, #idProcedimientoDatos textarea').prop('disabled', true); 
                    document.getElementById('guardarFirmaEntrada').removeAttribute('disabled');

                    
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
