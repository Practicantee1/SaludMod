$(document).ready(function(){
    fetch('http://ip-api.com/json/')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        const ciudad = data.city; // Extrae la ciudad
        $("#idCiudad").val(ciudad);
    })
    .catch(error => console.error('Error al obtener la ubicación:', error));
    $("#idFecha").val(obtenerFechaActual());
})

function obtenerFechaActual() {
    const fecha = new Date(); // Obtiene la fecha y hora actuales
    const opciones = { year: 'numeric', month: 'long', day: 'numeric' }; // Opciones para el formato de fecha
    return fecha.toLocaleDateString('es-ES', opciones); // Formatea la fecha en español
}

$('input[type="checkbox"]').on('change', function() {
    let group = $(this).data('group'); // Obtiene el grupo de la pregunta

    if ($(this).is(':checked')) {
        $('input[type="checkbox"][data-group="' + group + '"]').not(this).prop('checked', false);
    }
});


$("#P1-si").change(function() {
    if ($(this).is(':checked')) {
        // Creamos la fila adicional
        var newRow = `<tr id="fila-adicional">
                        <td>Por favor, especifique el diagnóstico:</td>
                        <td><select class="form-control" name="DiagnosticoPrincipal" id="DiagnosticoPrincipal" required="">
                        </select></td>
                      </tr>`;
        $("#row1").after(newRow);

        // Llenamos el select con las opciones
        diagnosticos.forEach(function(opt) {
            console.log(opt);
            var optionText = `${opt.Cod_Diagnostico} - ${opt.Diagnostico}`;
            $('#DiagnosticoPrincipal').append(`<option value="${optionText}">${optionText}</option>`);
        });

        // Agregamos el evento change para capturar el diagnóstico seleccionado

    } else {
        // Si se desmarca, eliminamos la fila adicional
        $("#fila-adicional").remove();
    }
});



$("#P1-no").change(function(){
    if($(this).is(':checked')){
        $("#fila-adicional").remove();
    }
})

// Mapeo de preguntas
const preguntas = {
    P1: "Conozco el diagnóstico de la enfermedad grave o terminal que padece el paciente. ¿Cuál?",
    P2: "El padecimiento de esta enfermedad terminal le produce intensos dolores y sufrimientos.",
    P3: "Se le ha ofrecido al paciente otras alternativas como las del cuidado paliativo para el tratamiento integral del dolor, el alivio del sufrimiento y otros síntomas.",
    P4: "Actualmente el paciente se encuentra recibiendo cuidados paliativos.",
    P5: "El consentimiento del paciente está libre de presiones de terceros y no es producto de episodios anímicos o momentos que puedan afectar el sentido de su decisión.",
    P6: "Se le han aclarado al paciente todas sus dudas, explicando el procedimiento y ha comprendido la naturaleza del mismo.",
    P7: "El consentimiento del paciente es producto de episodios anímicos o momentáneos que puedan afectar el sentido de su decisión.",
    P8: "Se le informo al paciente que en cualquier momento del proceso puedo desistir de la solicitud y optar por otras alternativas terapéuticas como los cuidados paliativos."
};

function obtenerRespuestas() {
    let respuestas = {};
    let camposVacios = []; // Array para almacenar campos vacíos

    $('#idTablaTerminos tbody tr').each(function() {
        let checkboxes = $(this).find('input[type="checkbox"]');
        
        if (checkboxes.length > 0) {
            // Obtener el atributo de grupo de la pregunta y la respuesta seleccionada
            let pregunta = checkboxes.data('group');
            let respuesta = $(this).find('input[type="checkbox"]:checked').val();
    
            // Verificar si es la primera pregunta (P1) y si la respuesta es "Sí"
            if (pregunta === "P1" && respuesta === "Si") {
                // Obtener el diagnóstico seleccionado del select
                console.log("si");
                var diagnostico = $('#DiagnosticoPrincipal option:selected').text();
                console.log("diagnostico")
                // Agregar el diagnóstico a las respuestas o asignar "No especificado" si está vacío
                respuestas["Conozco el diagnóstico de la enfermedad grave o terminal que padece el paciente. ¿Cuál?"] = diagnostico ? diagnostico : "No especificado";
            } else {
                // Asignar la respuesta a la pregunta actual, o "No seleccionado" si no hay respuesta
                respuestas[preguntas[pregunta]] = respuesta ? respuesta : "No seleccionado";
            }
        }
    });

    for (let key in respuestas) {
        if (respuestas[key] === "No seleccionado" || respuestas[key] === "No especificado") {
            camposVacios.push(key); // Agregar a la lista de campos vacíos
        }
    }

    if (camposVacios.length > 0) {
        return '-1'; 
    }

    return JSON.stringify(respuestas); 
}


$('#guardar').on('click', function() {
    let respuestas = obtenerRespuestas();
    let ciudad = $("#idCiudad").val();
    let fecha = $("#idFecha").val();
    let registro = $("#idRegistro").val();
    let especialidad = $("#idEspecialidad").val();
    let Medico = $("#idMedicoDMD").val();
    let NombrePaciente = $("#idNombrePaciente").val();
    let NumeroIdentificacion = $("#idNumeroIdentificacion").val();
    let FechaSolicitud = $("#idFechaSolicitud").val();
    let idTipoDocumento = $("#idTipoDocumento").val();
    let idDocumento = $("#idDocumento").val();
    let edad = $("#idEdad").val();
    let idtipoDocumentoP = $("#idTipoIdentificacion").val();
    let observaciones = $("#text-area").val();
    let centrosanitario = $("#centrosanitario").val();
    console.log(respuestas);

    if (ciudad !== "" && fecha !== "" && registro !== "" && especialidad !== "" &&
        Medico !== "" && NombrePaciente !== "" && NumeroIdentificacion !== "" &&
        FechaSolicitud !== "" && idTipoDocumento !== "" && idDocumento !== "" &&
        observaciones !== "" && respuestas !== "-1") {
        
            console.log({
        
                registro: registro,
                especialidad: especialidad,
                Medico: Medico,
                NombrePaciente: NombrePaciente,
                NumeroIdentificacion: NumeroIdentificacion,
                FechaSolicitud: FechaSolicitud,
                ciudad:ciudad,
                observaciones: observaciones,
                idTipoDocumento:idTipoDocumento,
                idDocumento:idDocumento,
                edad:edad,
                idtipoDocumentoP:idtipoDocumentoP,
                centrosanitario:centrosanitario
            });
            console.log(respuestas);
        
            $.ajax({
                type: "POST",
                url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/DerechoMorirDignamente/logica/guardarSolicitud.php',
                // url: 'http://localhost/SaludMod/Modulos/DerechoMorirDignamente/logica/guardarSolicitud.php',
                data: {
                    ciudad: ciudad,
                    registro: registro,
                    especialidad: especialidad,
                    Medico: Medico,
                    NombrePaciente: NombrePaciente,
                    NumeroIdentificacion: NumeroIdentificacion,
                    FechaSolicitud: FechaSolicitud,
                    observaciones: observaciones,
                    respuestas: respuestas,
                    idDocumento: idDocumento,
                    idTipoDocumento: idTipoDocumento,
                    edad: edad,
                    idtipoDocumentoP: idtipoDocumentoP,
                    centrosanitario:centrosanitario
                },
                success: function(response) {
                    console.log("se guardó:", response);
                    Swal.fire({
                        title: "Solicitud Registrada!",
                        icon: "success"
                      });
                     window.open(`../../../Modulos/DerechoMorirDignamente/logica/PDF/GenerarPDF.php?id=${response.id_paciente}`, '_blank');
                     window.location.href = "http://vmsrv-web2.hospital.com/SaludMod/Modulos/DerechoMorirDignamente/view/ConsultarSolicitud.php"
                    //  window.location.href = "http://localhost/SaludMod/Modulos/DerechoMorirDignamente/view/ConsultarSolicitud.php"

                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
    } else {
        Swal.fire({
            title: "Datos incompletos",
            text: "Por favor diligencie todos los campos",
            icon: "warning"
          });        
    }
    // Consola para depurar datos
    
});