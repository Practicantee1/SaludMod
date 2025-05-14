function getParameterByName(name) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name); // Obtiene el valor del parámetro 'name'
}

// Obtener el valor del parámetro 'id_paciente' desde la URL
document.addEventListener('DOMContentLoaded', (event) => {
    const id_Paciente = getParameterByName('id_paciente'); // Buscar 'id_paciente' en la URL
    if (id_Paciente) {
        consultar(id_Paciente); // Llamar a 'consultar' con el 'idPaciente' encontrado
    }
});

// Manejar evento de clic en botones 'Completar' dentro del cuerpo de la tabla
$(document).ready(function() {
    $('#registroTablaBody').on('click', '.btnCompletar', function(e) {
        e.preventDefault(); // Prevenir la acción predeterminada
        const id_Paciente = $(this).data('id_paciente'); // Obtener 'id_paciente' del atributo data
        completarFormulario(id_Paciente); // Llamar a 'completarFormulario' con el id
    });
});


function consultar(id_Paciente) { // Cambiado a 'idPaciente'
    $.ajax({
        type: "POST",
        url: '../logica/completarSQL.php',
        data: { id_paciente: id_Paciente }, // Enviar el episodio en los datos
        success: function(response) {
            if (Array.isArray(response)) {
                console.log("Respuesta del servidor:", response);
                if (response.length > 0) {
                    // Suponiendo que sólo necesitas el primer registro
                    var item = response[0]; // Toma el primer elemento del array

                    // Ocultar botones y bloqueo de observaciones

                    if (item.Numero_identificacion === null || item.Numero_identificacion === undefined) {
                    } else {
                        document.getElementById('guardarEntrada').style.display = 'none'; // Oculta el botón
                        document.getElementById('idObservacionesEntrada').disabled = true;  
                        document.getElementById('guardarFirmaEntrada').removeAttribute('disabled'); 
                        $('#pausa-tab').prop('disabled', false).removeClass('disabled');                 
                    }
                   
                   
                    if (item.Nombre_abordaje === null || item.Nombre_abordaje === undefined) {
                    } else {
                        document.getElementById('guardarPausa').style.display = 'none'; // Oculta el botón
                        document.getElementById('idObservacionesPausa').disabled = true;
                        $('#salida-tab').prop('disabled', false).removeClass('disabled');   
                    }


                    if (item.camilla === null || item.camilla === undefined) {
                    } else {
                        document.getElementById('guardarSalida').style.display = 'none'; // Oculta el botón
                        document.getElementById('idObservacionesSalida').disabled = true;
                        document.getElementById('guardarFirmaSalida').removeAttribute('disabled');   
                    }

                    // Asignar valores a los campos del formulario
                    $('#episodio').val(item.Episodio);
                    $('#idNumeroDocumento').val(item.Numero_identificacion);
                    $('#idEdad').val(item.edad);
                    $('#idSexo').val(item.sexo);
                    $('#idNombrePaciente').val(item.Nombre_paciente);
                    $('#idAsegurador').val(item.Aseguradora);
                    $('#idProcedimiento').val(item.procedimiento);
                    $('#idNombreCirujano').val(item.Nombre_cirujano);
                    $('#idEspecialidad').val(item.Especialidad);
                    $('#Fecha').val(item.fecha_cirugía);
                    $('#id_NombrIdentificacion').val(item.Nombre_identificacion);
                    $('#id_intrumental').val(item.Instrumental);
                    $('#id_AlergiaReporta').val(item.Alergia_reporta);
		    if(item.AlergiasReportadasIndicacion !== "" && item.AlergiasReportadasIndicacion !== null){
                        $('#textoarea_alergia_completar').val(item.AlergiasReportadasIndicacion);
                    }else{
                        $("#texto_alergia_completar").attr("hidden", true);
                    }
                    $('#id_Consentimiento').val(item.Consentimiento);
                    $('#Marcacion').val(item.Marcacion);
                    $('#idSeleccione').val(item.Seleccione);
                    $('#id_Verificacion').val(item.Verificacion);
                    $('#id_Confirmacion').val(item.Confirmacion);
		    $("#id_esterilidad").val(item.esterilidad);
                    $('#id_Monitoreo').val(item.Monitoreo);
                    $('#id_Perdida').val(item.Perdida);
                    $('#id_Reserva').val(item.Reserva);
                    $('#id_Disponibilidad').val(item.Disponibilidad);
                    $('#id_Estudios').val(item.Estudios);
                    $('#id_Via').val(item.Via);
                    $('#id_Antibiotico').val(item.Antibiotico);
		    if(item.AntibioticosDefinidos !== "" && item.AntibioticosDefinidos !== null){
                        $('#textoarea_antibiotico_completar').val(item.AntibioticosDefinidos); 
                    }else{
                        $("#texto_antibiotico_completar").attr("hidden", true);
                    }
                    $('#id_Suspension').val(item.Suspension);
                    $('#id_comercial').val(item.Comercial);
                    $('#id_cultivos').val(item.Cultivos);
                    $('#id_patologias').val(item.patologias);
                    $('#idObservacionesEntrada').val(item.observacionesEntrada);
                    $('#id_equipoHumano').val(item.equipoHumano);
                    $('#id_abordaje').val(item.Nombre_abordaje);
                    $('#id_Existen').val(item.Existen);
                    $('#id_Administracion').val(item.Administracion);
                    $('#id_Plan').val(item.Plan);
		    if(item.textoPlan !== "" && item.textoPlan !== null){
                        $("#textoarea_Plan").val(item.textoPlan);
                    }else{
                        $("#texto_Plan_completar").attr("hidden", true);
                        
                    }
                    $('#id_anestesiologo').val(item.Anestesiologo);
                    $('#id_Vo').val(item.Vo);
                    $('#id_Detalles_relevantes').val(item.Detalles_relevantes);
                    $('#id_T').val(item.T);
                    $('#id_perfusion').val(item.perfusion);
                    $('#idObservacionesPausa').val(item.Observaciones_pausa);
                    $('#id_programada').val(item.programada);
                    $('#id_complicaciones').val(item.complicaciones);
                    $('#id_Conteo').val(item.conteo);
                    $('#id_Camilla').val(item.camilla);
                    $('#id_Muestra').val(item.muestra);
                    $('#id_posopetario').val(item.posopetario);
                    $('#id_problemas').val(item.problemas);
                    $('#idObservacionesSalida').val(item.observaciones);
                
                    
                    // Lógica para habilitar/deshabilitar campos según los valores
                    const fieldsToCheck = [
                        'episodio',
                        'idNumeroDocumento',
                        'idEdad',
                        'idSexo',
                        'idNombrePaciente',
                        // 'idAsegurador',
                        'idProcedimiento',
                        'idNombreCirujano',
                        'idEspecialidad',
                        'Fecha',
                        'id_NombrIdentificacion',
                        'id_intrumental',
                        'id_AlergiaReporta',
                        'id_Consentimiento',
                        'Marcacion',
                        // 'idSeleccione',
                        'id_Verificacion',
                        'id_Confirmacion',
                        'id_Monitoreo',
                        'id_Perdida',
                        'id_Reserva',
                        'id_Disponibilidad',
                        'id_Estudios',
                        'id_Via',
                        'id_Antibiotico',
                        'id_Suspension',
                        'id_comercial',
                        'id_cultivos',
                        'id_patologias',
                        'idObservacionesEntrada',
                        'id_equipoHumano',
                        'id_abordaje',
                        'id_Existen',
                        'id_Administracion',
                        'id_Plan',
                        'id_anestesiologo',
                        'id_esterilidad',
                        'id_Vo',
                        'id_Detalles_relevantes',
                        'id_T',
                        'id_perfusion',
                        'idObservacionesPausa',
                        'id_programada',
                        'id_complicaciones',
                        'id_Conteo',
                        'id_Camilla',
                        'id_Muestra',
                        'id_posopetario',
                        'id_problemas',
                        'idObservacionesSalida'


                    ];

                    fieldsToCheck.forEach(fieldId => {
                        const fieldValue = $(`#${fieldId}`).val();
                        if (fieldValue) {
                            // Bloquear el campo si tiene valor
                            if ($(`#${fieldId}`).is('select')) {
                                $(`#${fieldId}`).prop('disabled', true); // Deshabilitar el select
                            } else {
                                $(`#${fieldId}`).prop('readonly', true); // Bloquear el campo de texto
                            }
                        } else {
                            // Habilitar el campo si no tiene valor
                            if ($(`#${fieldId}`).is('select')) {
                                $(`#${fieldId}`).prop('disabled', false); // Habilitar el select
                            } else {
                                $(`#${fieldId}`).prop('readonly', false); // Habilitar el campo de texto
                            }
                        }
                    });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "No se encontró información...",
                        text: "No hay registros disponibles",
                    });
                }
            } else {
                console.error("Formato de respuesta inválido:", response);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salió MAL, intenta de nuevo!",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Texto de respuesta:", xhr.responseText);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error en la solicitud AJAX.",
            });
        }
    });
}


const dosis = document.getElementById("id_Plan");
dosis.addEventListener("change", function(e){

    const texto = document.getElementById("textoarea_Plan");
    const texto_dosis = document.getElementById("texto_Plan_completar");
    if(e.target.value === "si"){
        texto_dosis.removeAttribute("hidden");
        texto.removeAttribute("readonly");
    }else{
        texto_dosis.setAttribute("hidden", true);
        texto.value = "";
    }
});

