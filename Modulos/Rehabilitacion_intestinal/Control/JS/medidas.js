function guardarDefinitivo(idTabla) {
    Swal.fire({
        title: "Si desea guardar el registro completo, por favor continúe",
        text: "¿Está seguro de guardar todo el registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#428E3F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, guardar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            savePaciente();
            // Obtener los valores de los inputs de la primera fila
            const peso = document.getElementById("peso").value || "N/A";
            const talla = document.getElementById("talla").value || "N/A";
            const sct = document.getElementById("sct").value || "N/A";
            const tallaEdad = document.getElementById("tallaEdad").value || "N/A";

            // Obtener los valores de los inputs de la segunda fila según la visibilidad
            const pesoEdad = document.getElementById("pesoEdad").value || "N/A";
            const pesoTalla = document.getElementById("pesoTalla").value || "N/A";
            const imc = document.getElementById("imc").value || "N/A";

            // Obtener la fecha y la hora actuales
            const fecha = new Date().toISOString().split('T')[0];

            // Crear una nueva fila en la tabla de registros
            const registroTable = document.getElementById(idTabla).querySelector('tbody');
            if (registroTable) {
                const newRow = registroTable.insertRow();

                // Insertar la fecha y la hora
                newRow.insertCell(0).textContent = fecha;
                newRow.insertCell(1).textContent = peso;
                newRow.insertCell(2).textContent = talla;
                newRow.insertCell(3).textContent = sct;
                newRow.insertCell(4).textContent = tallaEdad;

                // Mostrar y agregar las celdas de acuerdo a la edad configurada
                const pesoParaTallaHeader = document.getElementById("pesoParaTallaHeader");
                const pesoParaEdadHeader = document.getElementById("pesoParaEdadHeader");
                const imcHeader = document.getElementById("imcHeader");
                if (pesoParaEdadHeader.style.display !== "none") {
                    newRow.insertCell(5).textContent = pesoEdad;
                }
                if (pesoParaTallaHeader.style.display !== "none") {
                    newRow.insertCell(6).textContent = pesoTalla;
                }
                if (imcHeader.style.display !== "none") {
                    newRow.insertCell(5).textContent = imc;
                }
            } else {
                console.error(`No se encontró la tabla con id ${idTabla}.`);
            }

            // Swal.fire({
            //     title: "Guardado!",
            //     text: "Tu registro ha sido guardado.",
            //     icon: "success"
            // }).then(() => {
                // Limpiar los valores de los inputs después de guardar
                document.getElementById("peso").value = '';
                document.getElementById("talla").value = '';
                document.getElementById("sct").value = '';
                document.getElementById("tallaEdad").value = '';
                document.getElementById("pesoEdad").value = '';
                document.getElementById("pesoTalla").value = '';
                document.getElementById("imc").value = '';
            // });
        }
    });
}

function savePaciente() {
    let episodio = $("#episodio").val();
    let documento = $("#nroDoc").val();
    let tipo_documento = $("#tipo").val();
    let nombre = $("#nombre").val();
    let edad = $("#edad").val();
    let genero = $("#sexo").val();
    let ubicacion = $("#ubicacion").val();
    let cama = $("#cama").val();
    let entidad = $("#entidad").val();
    let nombreMed =  $("#nombreMed").val();
    let especialidadMedico = $("#especialidad").val()
    let centrosanitario = $("#centrosanitario").val();

    let peso = $("#peso").val();
    let talla = $("#talla").val();
    let sct = $("#sct").val();
    let tallaEdad = $("#tallaEdad").val();
    let pesoEdad = $("#pesoEdad").val();
    let pesoTalla = $("#pesoTalla").val();
    let imc = $("#imc").val();

    console.log("Imagenes",peso, talla, sct, tallaEdad, pesoEdad, pesoTalla, imc)
    $.ajax({
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/guardarMedidasAntropometricas.php',
        type: 'POST',
        data:{
            episodio: episodio,
            tipo_documento: tipo_documento,
            documento: documento,
            nombre: nombre,
            edad: edad,
            genero: genero,
            ubicacion: ubicacion,
            cama: cama,
            entidad: entidad,
            nombreMedico: nombreMed,
            especialidadMedico: especialidadMedico,
            peso :peso,
            talla :talla,
            sct :sct,
            tallaEdad :tallaEdad,
            pesoEdad :pesoEdad,
            pesoTalla :pesoTalla,
            imc :imc,
            centrosanitario: centrosanitario 
        },
        success: function(result) {
            console.log(result);  
            try {
                if (result.status === 'success') {
                    console.log("Se guardó en la BD");
                    
                } else {
                    console.error("Error del servidor:", result.message || "Unknown error");
                }
            } catch (e) {
                console.error("Error parsing response:", e);
            }
        },
        
        error: function(xhr, status, error) {
            console.error("Error:", status, error);
            Swal.fire({
                title: "Error",
                text: "Hubo un problema al guardar los datos. Intente nuevamente.",
                icon: "error"
            });
        }
    });
    

}

$(document).ready(function() {
    
    $('#episodio').change(function() {
        episodio = document.getElementById("episodio").value || "N/A";  
        llenarHistoricoMedidas(episodio); 
    });

    $('#episodio').trigger('change');
});
function llenarHistoricoMedidas(episodio) {
    if (!episodio) {
        console.error("Error: El parámetro 'episodio' no está definido");
        return;
    }

    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/llenarHistoricoMedidas.php',
        data: { episodio: episodio },
        dataType: "json",
        success: function(response) {
            if (response.status !== 'success') {
                console.error("Error del servidor:", response.message || "Respuesta no exitosa");
                return;
            }

            if (response.medidas && response.medidas.length > 0) {
                // $('#tablaMedidas tr:not(:first)').remove(); // Limpiar filas anteriores

                response.medidas.forEach(function (medida) {
                    let pesoTalla = medida.peso_talla || '';
                    let pesoEdad = medida.peso_edad || '';
                    let imc = medida.imc || '';
                
                    // Condiciones para mostrar los valores
                    let pesoTallaCell = '';
                    let pesoEdadCell = '';
                    let imcCell = '';
                
                    if (!pesoTalla && !pesoEdad) {
                        // Si peso_talla y peso_edad están vacíos, mostrar imc
                        imcCell = `<td>${imc}</td>`;
                    } else if (!imc) {
                        // Si imc está vacío, mostrar peso_talla y peso_edad
                        pesoTallaCell = `<td>${pesoTalla}</td>`;
                        pesoEdadCell = `<td>${pesoEdad}</td>`;
                    }
                
                    let newRow = `
                        <tr>
                            <td>${medida.fecha || ''}</td>
                            <td>${medida.peso || ''}</td>
                            <td>${medida.talla || ''}</td>
                            <td>${medida.sct || ''}</td>
                            <td>${medida.talla_edad || ''}</td>
                            ${pesoTallaCell || '<td style="display: none;"></td>'}
                            ${pesoEdadCell || '<td style="display: none;"></td>'}
                            ${imcCell || '<td style="display: none;"></td>'}
                        </tr>`;
                    $('#tablaMedidas').append(newRow);
                });
            } else {
                console.warn("No se encontraron medidas antropométricas para el episodio especificado.");
                console.log("Episodio:", episodio);
                console.log("Respuesta:", response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}