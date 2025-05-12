let isEditMode = false;
let activeColumnIndex=null;
let id;
function guardarDefinitivoVertical(idTabla) {
    if (isEditMode) {
        Swal.fire({
            title: "Edición en curso",
            text: "No puede guardar mientras hay un registro en edición.",
            icon: "warning"
        });
        return;
    }

    Swal.fire({
        title: "Si desea guardar los valores, por favor continúe",
        text: "¿Está seguro de guardar los valores?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#428E3F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, guardar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            
            const fecha = new Date().toISOString().split('T')[0];
            const hora = new Date().toLocaleTimeString();
            const registroTable = document.getElementById(idTabla);
            if (registroTable) {
                const fechaRow = registroTable.querySelector('tr:nth-child(1)');
                const horaRow = registroTable.querySelector('tr:nth-child(2)');
                const newFechaCell = fechaRow.insertCell(1);
                const newHoraCell = horaRow.insertCell(1);
                newFechaCell.textContent = fecha;
                newHoraCell.textContent = hora;
                const examValues = []; // Array para almacenar los valores de los exámenes
                const examItems = document.querySelectorAll('.exam-container .exam-item');
                examItems.forEach(examItem => {
                    const idExam = examItem.id;
                    let examValue = '';
                    if (idExam === "aislamientos") {
                        // Obtener valores de los campos
                        const fechaAislamiento = document.getElementById("fechaAislamientos").value;
                        const muestra = document.getElementById("tipoEstudio").value;
                        const origen = document.getElementById("origen") ? document.getElementById("origen").value : '';
                        const germen = document.getElementById("germen").value;
                        const cual = document.getElementById("otherInput") ? document.getElementById("otherInput").value : '';
                        const observaciones = document.getElementById("observacionesInput") ? document.getElementById("observacionesInput").value : '';

                        if (muestra === "otros") {
                            examValue = `${fechaAislamiento}, ${muestra},${cual}, ${observaciones}, ${germen}`;
                        } else {
                            examValue = `${fechaAislamiento}, ${muestra}, ${origen}, ${germen}`;
                        }
                    } else {
                        examValue = examItem.querySelector('input.value-input').value;
                        // examValue = examItem.querySelector('input.value-input').value.trim();
                    }
                    console.log(`ID: ${idExam}, Valor: ${examValue}`);
                    examValues.push({ examId: idExam, value: examValue }); 
                    const row = registroTable.querySelector(`tr#${idExam}`);
                    if (row) {
                        const newCell = row.insertCell(1);
                        newCell.textContent = examValue ? examValue : '';
                    }
                });
                const newRow = registroTable.querySelector('tr:nth-child(43)');
                savePaciente(examValues);
                // console.log(id)
                const editarCell = newRow.insertCell(1);
                const editarBtn = document.createElement('button');
                editarBtn.textContent = "Editar";
                editarBtn.classList.add('btn', 'btn-primary');
                editarBtn.onclick = () => editarFila(idTabla, editarBtn, editarCell.cellIndex);
                editarCell.appendChild(editarBtn);

                const formElements = document.querySelectorAll('#agregarLinea input');
                formElements.forEach(input => {
                    if (input.type !== 'hidden') {
                        input.value = ''; // Limpia el valor de los campos
                    }
                });
                const idField = document.getElementById("id");
                if (idField) {
                    idField.value = ''; // Limpia el campo 'id'
                }

                examItems.forEach(examItem => {
                    const inputFields = examItem.querySelectorAll('input.value-input, select.value-input');
                    inputFields.forEach(input => {
                        input.value = ''; // Limpia los campos
                    });
                });
                toggleOtherInput();
            } else {
                console.error(`No se encontró la tabla con id ${idTabla}.`);
            }
        }
    });

}


function savePaciente(examValues) {
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
    let especialidadMedico = $("#especialidad").val();
    let centrosanitario = $("#centrosanitario").val();
    let examData = {};
    examValues.forEach(exam => {
        examData[exam.examId] = exam.value;
    });
    console.log("Datos que se envían al servidor:", JSON.stringify(examData));

    $.ajax({
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/guardarPaciente.php',
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
            centrosanitario: centrosanitario,
            entidad: entidad,
            nombreMedico: nombreMed,
            especialidadMedico: especialidadMedico,
            examData: JSON.stringify(examData)
        },
        success: function(result) {
            console.log(result);  
            try {
                if (result.status === 'success') {
                    console.log("Se guardó en la BD");
                    id = result.idPaciente;
                    // document.getElementById("id").value = '';
                    document.getElementById("id").value = id;
                    const registroTable = document.getElementById('registroTabla');
                    const newRow = registroTable.querySelector('tr:nth-child(44)');
                    if (newRow) {
                        const idCell = newRow.insertCell(1);
                        idCell.textContent = id;
                        idCell.style.display = 'none';
                    }
                    const idField = document.getElementById("id");
                    if (idField) {
                        idField.value = ''; // Limpia el campo 'id'
                    }
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


function filterExams() {
    const searchValue = document.getElementById("searchInput").value.toLowerCase();
    const examItems = document.getElementsByClassName("exam-item");

    for (let i = 0; i < examItems.length; i++) {
        const examLabel = examItems[i].getElementsByTagName("label")[0].innerText.toLowerCase(); // Change from "div" to "label"
        if (examLabel.includes(searchValue)) {
            examItems[i].style.display = ""; // Show the exam item
        } else {
            examItems[i].style.display = "none"; // Hide the exam item
        }
    }
}



function llenarHistoricoParaclinico(episodio) {
    if (!episodio) {
        console.error("Error: El parámetro 'episodio' no está definido");
        return;
    }

    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/llenarHistoricoParaclinico.php',
        data: { episodio: episodio },
        dataType: "json",
        success: function (response) {
            if (response.status !== 'success') {
                console.error("Error del servidor:", response.message || "Respuesta no exitosa");
                return;
            }
        
            // Verifica si existen datos en el response
            if (response.examenes && response.examenes.length > 0) {
                const registroTable = $("#registroTabla tbody");
                if (!registroTable.length) {
                    console.error("No se encontró la tabla con ID 'registroTabla'.");
                    return;
                }

                // Obtener la fecha actual en formato "YYYY-MM-DD"
                const fechaHoy = new Date().toISOString().split("T")[0];

                // Procesar registros en orden inverso
                const examenesInvertidos = response.examenes.slice().reverse();

                examenesInvertidos.forEach((examen) => {
                    let rowIndex = 0;

                    Object.values(examen).forEach((value, index, arr) => {
                        const row = registroTable.find(`tr:eq(${rowIndex})`); // Selecciona la fila por índice
                        if (row.length) {
                            let cellIndex = row.find("td").length; // Calcula el índice actual basado en la cantidad de celdas
                            if (index < arr.length - 2) {
                                // Agregar celdas para valores normales (hasta penúltimo valor)
                                row.append(`<td>${value || ""}</td>`);
                            } else if (index === arr.length - 2) {
                                // Determinar si se deshabilita el botón
                                const fechaRegistro = arr[0]; // Fecha en la posición 0
                                const disabled = fechaRegistro !== fechaHoy ? "disabled" : "";

                                // Agregar botón después del penúltimo valor
                                row.append(
                                    `<td><button class="btn btn-primary" onclick="editarFila('registroTabla', this, ${cellIndex})" ${disabled}>Editar</button></td>`
                                );
                            } else if (index === arr.length - 1) {
                                // Agregar última celda con el ID
                                row.append(`<td>${value || ""}</td>`);
                            }
                        } else {
                            console.warn(`No se encontró la fila en el índice ${rowIndex}`);
                        }
                        rowIndex++;
                    });
                });
            } else {
                console.warn("No se encontraron registros en la respuesta del servidor.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}


function editarFila(idTabla, editButton, columnIndex) {

    isEditMode = true;
    activeColumnIndex = columnIndex;
    const registroTable = document.getElementById(idTabla);

    if (registroTable) {
        const examItems = document.querySelectorAll('.exam-container .exam-item');
        console.log("examItems " + examItems);

        if (editButton.textContent === "Editar") {
            // Modo de edición: rellenar los inputs con los valores actuales
            examItems.forEach(examItem => {
                const idExam = examItem.id; // Obtener el id del examen
                const row = registroTable.querySelector(`tr#${idExam}`);
                
                
                if (row && row.cells[columnIndex]) {
                    // Obtener el valor actual de la celda correspondiente
                    const currentValue = row.cells[columnIndex].textContent; // Esta es la columna que se va a editar

                    if (idExam === "aislamientos") {
                        const tipoEstudioSelect = document.getElementById("tipoEstudio");
                        // console.log(currentValue)
                        if (tipoEstudioSelect) {
                            // Divide currentValue en partes y asegura que cada elemento está definido
                            const [fecha, muestra, origen,germen, extra] = currentValue.split(',').map(val => val ? val.trim() : "");
                        
                            if (muestra === "otros") {
                                const [cual] = origen ? origen.split(',').map(val => val.trim()) : ["", ""];
                                
                                // Asigna valores a los campos correspondientes
                                document.getElementById("fechaAislamientos").value = fecha || "";
                                tipoEstudioSelect.value = muestra;
                                document.getElementById("otherInput").value = cual || ""; // Cual (debe ser cual en "otros")
                                document.getElementById("observacionesInput").value = germen || ""; // Observaciones
                                document.getElementById("germen").value = extra;
                        
                                // Mostrar campos específicos para "otros"
                                document.getElementById("otherFieldContainer").style.display = 'block';
                                document.getElementById("observaciones").style.display = 'block';
                                document.getElementById("origenContainer").style.display = 'none';
                        
                            } else {
                                // Para otros valores, configura los selectores de origen
                                const origenSelect = document.getElementById("origen");
                                origenSelect.innerHTML = ""; // Limpiar opciones anteriores
                        
                                if (muestra === "urocultivo") {
                                    origenSelect.add(new Option("Sonda", "sonda"));
                                    origenSelect.add(new Option("Ocasional", "ocasional"));
                                } else if (muestra === "hemocultivo") {
                                    origenSelect.add(new Option("Periférico", "Periferico"));
                                    origenSelect.add(new Option("Central", "central"));
                                }
                        
                                // Asigna el valor de origen y muestra el selector adecuado
                                origenSelect.value = origen || ""; // Asegúrate de asignar el valor correcto a origen
                                document.getElementById("fechaAislamientos").value = fecha || "";
                                tipoEstudioSelect.value = muestra;
                                document.getElementById("germen").value = germen;
                        
                                document.getElementById("origenContainer").style.display = 'block';
                                document.getElementById("otherFieldContainer").style.display = 'none';
                                document.getElementById("observaciones").style.display = 'none';
                            }
                        }
                        
                        
                    } else {
                        // Rellenar el input correspondiente para otros exámenes
                        const input = examItem.querySelector('input.value-input');
                        input.value = currentValue;

                    }
                }
            });
            
            const lastRow = registroTable.querySelector('tr:last-child');
            const idValue = lastRow ? lastRow.textContent.trim() : ""; 
            const idNumber = idValue.replace(/[^\d]/g, "");
            document.getElementById("id").value = idNumber || "";

            // Cambiar el texto del botón a "Guardar Cambios"
            editButton.textContent = "Guardar Cambios";
        } else {
            const dataToSend = [];
            // Modo de guardar: guardar los cambios en la tabla
            examItems.forEach(examItem => {
                const idExam = examItem.id;
                let inputValue = examItem.querySelector('input.value-input').value.trim();

                if (idExam === "aislamientos") {
                    const tipoEstudioSelect = document.getElementById("tipoEstudio");
                    const fechaAislamiento = document.getElementById("fechaAislamientos").value;
                    const muestra = tipoEstudioSelect.value;
                    const germen = document.getElementById("germen").value;
                    let origen = '';
                    let cual = '';
                    let observaciones = '';

                    // Si seleccionaron "otros"
                    if (muestra === "otros") {
                        cual = document.getElementById("otherInput").value;
                        observaciones = document.getElementById("observacionesInput").value;
                        inputValue = `${fechaAislamiento}, ${muestra}, ${cual}, ${observaciones}, ${germen}`;
                    } else {
                        // Si no seleccionaron "otros"
                        origen = document.getElementById("origen").value;
                        inputValue = `${fechaAislamiento}, ${muestra}, ${origen}, ${germen}`;
                    }
                }

                const row = registroTable.querySelector(`tr#${idExam}`);
                // console.log(idExam);
                if (row && row.cells[columnIndex]) {
                    dataToSend.push({
                        idExam,
                        value: inputValue !== null ? inputValue : ""
                    });                    
                    row.cells[columnIndex].textContent = inputValue ? inputValue : ''; // Actualizar la tabla
                } else {
                    console.log(`No se encontró la fila con id ${idExam}.`);
                }
            });
            
            const fila = registroTable.querySelector('tr:nth-child(44)');
            const celdas = fila.querySelectorAll('td');
            idPaciente = celdas[columnIndex].textContent.trim();
    
            
            console.log("id:", idPaciente);
            // console.log("id:", idPaciente, "data:", JSON.stringify(dataToSend, null, 2));

            $.ajax({
                type: "POST",
                url: 'http://localhost/SaludMod/Modulos/Rehabilitacion_intestinal/logica/actualizarBD.php',
                contentType: "application/json", 
                data: JSON.stringify({ idPaciente: idPaciente, data: dataToSend }),
                success: function(response) {
                    console.log("se guardó:", response);
                    Swal.fire({
                        title: "Solicitud Registrada!",
                        icon: "success"
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });

            isEditMode = false;
            examItems.forEach(examItem => {
                const input = examItem.querySelector('input.value-input');
                if (input) {
                    input.value = ''; // Limpiar el valor del input
                }
            });

            // Limpieza específica para "aislamientos"
            if (document.getElementById("aislamientos")) {
                document.getElementById("tipoEstudio").value = '';
                document.getElementById("fechaAislamientos").value = '';
                document.getElementById("germen").value = '';
                document.getElementById("otherInput").value = '';
                document.getElementById("observacionesInput").value = '';
                const origenSelect = document.getElementById("origen");
                if (origenSelect) {
                    origenSelect.value = '';
                    origenSelect.innerHTML = '';
                }

                document.getElementById("origenContainer").style.display = 'none';
                document.getElementById("otherFieldContainer").style.display = 'none';
                document.getElementById("observaciones").style.display = 'none';
            }
            editButton.textContent = "Editar";
            // });

        }
    } else {
        console.error(`No se encontró la tabla con id ${idTabla}.`);
    }
}

$(document).ready(function() {
    
    $('#episodio').change(function() {
        episodio = document.getElementById("episodio").value || "N/A";  
        llenarHistoricoParaclinico(episodio); 
    });

    $('#episodio').trigger('change');
});