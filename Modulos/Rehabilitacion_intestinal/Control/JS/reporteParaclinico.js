let isEditMode = false;
let activeColumnIndex=null;
let id;
let reportePlantillas = [];


let nombresTit = [
    "Fecha",
    "LEUCOCITOS",
    "NEUTROFILOS",
    "LINFOCITOS",
    "EOSINOFILOS",
    "HEMOGLOBINA",
    "HEMATOCRITO",
    "PLAQUETAS",
    "VSG",
    "PCR",
    "TGO/AST",
    "TGP/ALT",
    "BILIRRUBINA TOTAL",
    "BILIRRUBINA DIRECTA",
    "GGT",
    "FOSFATASA ALCALINA",
    "TP/INR",
    "TPT",
    "AMILASA",
    "SODIO",
    "FOSFORO",
    "POTASIO",
    "CLORO",
    "CALCIO",
    "MAGNESIO",
    "COLESTEROL TOTAL",
    "COLESTEROL HDL",
    "TRIGLICERIDOS",
    "PROTEINAS TOTALES",
    "ALBUMINA",
    "PRE-ALBUMINA",
    "VITAMINA B12",
    "VITAMINA D",
    "CREATININA",
    "GLICEMIA",
    "GASES HCO₃⁻",
    "GASES EB",
    "GASES Ph",
];



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
                    let examValue = "";
                    if (idExam === "aislamientos") {

                        let datos = document.querySelectorAll("#tabla_cultivos tbody tr");
                        datos.forEach(elemento => {
                            examValue += `${elemento.cells[0].textContent},${elemento.cells[1].textContent},${elemento.cells[3].textContent},${elemento.cells[2].textContent}` + "\n";
                        });

                    } else if(idExam === "examenesComplementarios"){
                        let datos = document.querySelectorAll("#tabla_examenes tbody tr");
                        datos.forEach(elemento => {
                            examValue += `${elemento.cells[0].textContent}:${elemento.cells[1].textContent}` + "\n";
                        });
                    }else {
                        examValue = examItem.querySelector('input.value-input').value;

                    }
                    console.log(`ID: ${idExam}, Valor: ${examValue}`);
                    examValues.push({ examId: idExam, value: examValue }); 

                });
                const newRow = registroTable.querySelector('tr:nth-child(43)');
                savePaciente(examValues);

                const tabla = document.querySelectorAll("#tabla_cultivos tbody tr");
                tabla.forEach(element => {
                    element.remove();
                });
                const idField = document.getElementById("id");
                if (idField) {
                    idField.value = ''; // Limpia el campo 'id'
                }

                $("#mensaje_cultivos").prop("hidden", true);
            
                examItems.forEach(examItem => {
                    const inputFields = examItem.querySelectorAll('input.value-input, select.value-input');
                    inputFields.forEach(input => {
                        input.value = ''; // Limpia los campos
                        input.style.backgroundColor = "white";
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
    let documento = $("#nroDocu").val();
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

                    Swal.fire({
                        icon: "success",
                        title: "Confirmación",
                        text: "Registro guardado con éxito",
                        timer: 2000
                    });
                    limpiarCampos();
                    limpiarRegistrosExamanes();
                    $("#mensaje_cultivos").prop("hidden", true);
                    llenarHistoricoParaclinico(episodio, documento);
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

function limpiarCampos(){
    let filasElim = document.querySelectorAll(".elim");
    filasElim.forEach(elemento => {
        elemento.remove();
    });
}


function limpiarRegistrosExamanes(){
    let filasElim = document.querySelectorAll("#tabla_examenes tbody tr");
    filasElim.forEach(elemento => {
        elemento.remove();
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


function CargarHistoricoEdicion(historico = "full"){
    let episodio = $("#episodio").val();
    let documento = $("#nroDocu").val();
    let datos;
    if(!episodio){
        return;
    }

    if(historico === "full"){
        datos = {
            episodio: episodio,
            documento: documento,
            opcionHistorico: historico
        };
    }else{
        let fechaDesde = $("#fecha_desde").val();
        let fechaHasta = $("#fecha_hasta").val();
        datos = {
            episodio: episodio,
            documento: documento,
            opcionHistorico: historico,
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta
        };
    }

    $.ajax({
        type: "POST",
        url: '../logica/llenarHistoricoParaclinico.php',
        data: datos,
        // data: { episodio: episodio, documento: documento, opcionHistorico: historico },
        dataType: "json",
        success: function(response){
            console.log(response)
            if(response.status == "success"){
                reportePlantillas = response.examenes;
            }
        }
    });
}


function llenarHistoricoParaclinico(episodio, documento, historico = "full") {
    if (!episodio) {
        console.error("Error: El parámetro 'episodio' no está definido");
        return;
    }

    if(historico === "full"){
        datos = {
            episodio: episodio,
            documento: documento,
            opcionHistorico: historico
        };
    }else{
        let fechaDesde = $("#fecha_desde").val();
        let fechaHasta = $("#fecha_hasta").val();
        datos = {
            episodio: episodio,
            documento: documento,
            opcionHistorico: historico,
            fechaDesde: fechaDesde,
            fechaHasta: fechaHasta
        };
    }

    $.ajax({
        type: "POST",
        url: '../logica/llenarHistoricoParaclinico.php',
        // data: { episodio: episodio, documento: documento },
        data: datos,
        dataType: "json",
        success: function (response) {
            if (response.status !== 'success') {
                console.error("Error del servidor:", response.message || "Respuesta no exitosa");
                return;
            }
            reportePlantillas = response.examenes;
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
                        const row = registroTable.find(`tr:eq(${rowIndex})`); 
                        if (row.length) {
                            let cellIndex = row.find("td").length; 
                            if (index < arr.length - 4) {

                                row.append(`<td class="elim">${value || ""}</td>`);
                                // }
                            } else if(index === arr.length - 3 || index === arr.length - 4){
                                row.append(`<td class="elim"><pre>${value || ""}</pre></td>`);
                            } else if (index === arr.length - 2) {
                                // Determinar si se deshabilita el botón
                                const fechaRegistro = arr[0]; // Fecha en la posición 0
                                const disabled = fechaRegistro !== fechaHoy ? "disabled" : "";

                                // Agregar botón después del penúltimo valor
                                row.append(
                                    `<td class="elim"><button class="btn btn-primary" onclick="editarFila('registroTabla', this, ${cellIndex})" ${disabled}>Editar</button></td>`
                                );
                            } else if (index === arr.length - 1) {
                                // Agregar última celda con el ID
                                row.append(`<td class="elim">${value || ""}</td>`);
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

                    if(idExam !== "aislamientos" && idExam !== "examenesComplementarios"){
                        // Rellenar el input correspondiente para otros exámenes
                        const input = examItem.querySelector('input.value-input');
                        input.value = currentValue;
                        if(input.value != ""){
                            input.style.backgroundColor = "#bbffb9";
                            input.style.color = "green";
                        }
                    }

                    // if (idExam === "aislamientos" && idExam === "examenesComplementarios") {

                        
                    // } else {
                    //     // Rellenar el input correspondiente para otros exámenes
                    //     const input = examItem.querySelector('input.value-input');
                    //     input.value = currentValue;
                    //     if(input.value != ""){
                    //         input.style.backgroundColor = "#bbffb9";
                    //         input.style.color = "green";
                    //     }
                    // }
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
                let aisla = false;

                if (idExam === "aislamientos" || idExam === "examenesComplementarios") {

                    aisla = true;
                }
                const row = registroTable.querySelector(`tr#${idExam}`);
                // console.log(idExam);
                if (row && row.cells[columnIndex] && idExam !== "aislamientos" && idExam !== "examenesComplementarios") {
                    dataToSend.push({
                        idExam,
                        value: inputValue !== null ? inputValue : ""
                    });                    
                    row.cells[columnIndex].textContent = inputValue ? inputValue : ''; // Actualizar la tabla
                } else {
                    console.log(`No se encontró la fila con id ${idExam}.`);
                }
            });
            
            const fila = registroTable.querySelector('tr:nth-child(43)');
            const celdas = fila.querySelectorAll('td');
            idPaciente = celdas[columnIndex].textContent.trim();
    
            
            console.log("id:", idPaciente);

            $.ajax({
                type: "POST",
                url: 'http://localhost/SaludMod/Modulos/Rehabilitacion_intestinal/logica/actualizarBD.php',
                contentType: "application/json", 
                data: JSON.stringify({ idPaciente: idPaciente, data: dataToSend }),
                success: async function(response) {
                    console.log("se guardó:", response);
                    if($("#fecha_desde").val() === "" && $("#fecha_hasta").val() === ""){
                        await CargarHistoricoEdicion();
                    }else{
                        await CargarHistoricoEdicion("PorFecha");
                    }
                    
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
                    input.value = ''; 
                }
            });

            document.querySelectorAll(".value-input").forEach(elemento => {
                elemento.style.backgroundColor = "white";
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

    
    let input_documento = document.getElementById("nroDocu");

    input_documento.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            episodio = document.getElementById("episodio").value || "N/A";  
        documento = document.getElementById("nroDocu").value || "N/A";
        llenarHistoricoParaclinico(episodio, documento); 
        }
    });
    
    // $('#ja').on("click", function(event) {
    //     event.preventDefault();
    //     episodio = document.getElementById("episodio").value || "N/A";  
    //     documento = document.getElementById("nroDocu").value || "N/A";
    //     llenarHistoricoParaclinico(episodio, documento); 

    // });

    $('#exampleModal').on('show.bs.modal', function () {
        crearPlantilla();
    });

    $('#exampleModal').on('hidden.bs.modal', function () {
        document.querySelector("#plantilla").value = "";
    });


    function crearPlantilla(){
        let plantilla = "";
        let indiceNombre = 0;

        plantilla += "Laboratorios:\nPARACLÍNICOS INSTITUCIONALES\n\n"

        const indicesAExcluir = [42, 1, 40, 41, 39]; 
        const ancho = 7;


        const matriz = reportePlantillas.map(fila => {
            const datos = Object.values(fila);


            let etiquetaRaw = datos[0] ?? "-";
            let etiqueta = "-";

            if (typeof etiquetaRaw === "string" && etiquetaRaw.includes("-")) {
                const partes = etiquetaRaw.split("-");
                if (partes.length === 3) {
                    etiqueta = `${partes[2]}/${partes[1]}`; 
                } else {
                    etiqueta = etiquetaRaw;
                }
            } else {
                etiqueta = etiquetaRaw;
            }

            etiqueta = String(etiqueta).padEnd(ancho); 

            const resto = datos
                .map((valor, valorIndex) => {
                if (indicesAExcluir.includes(valorIndex) || valorIndex === 0 ) return null;
                    const contenido = (valor === "" || valor === null || valor === undefined) ? "-" : valor;
                    return String(contenido).padEnd(ancho);
                })
                .filter(v => v !== null);
            return [etiqueta, ...resto];
        });
        const numFilas = matriz.length;
        const numColumnas = matriz[0]?.length || 0;
        for (let col = 0; col < numColumnas; col++) {
            
            let nombre = nombresTit[indiceNombre];
            plantilla += String(nombre).padEnd(21);
            
            for (let fila = 0; fila < numFilas; fila++) {
                plantilla += matriz[fila][col];
            }
            plantilla += '\n'; // nueva línea después de cada columna
            if (col === 0) {
                plantilla += "--------------------------------------------------------------------------------------------\n";
            }
            indiceNombre++;
        }

        let examenes = [];
        let textoExamenes = "";
        reportePlantillas.forEach(element => {
            let datos = [element["EXAMENES COMPLEMENTARIOS"], element["FECHA"]];
            examenes.push(datos);
        });

        examenes.forEach(elemento => {
            let fecha = elemento[1];
            let dato = elemento[0].replace(/\r/g, "").split("\n");
            dato.forEach(element => {
                if(element !== "" && fecha != ""){
                    textoExamenes += `${fecha}:   ${element.replace(",", "")}\n`;
                }
            });
        });
        if(textoExamenes !== ""){
            plantilla += "\n--------------------------------------------------------------------------------------------\n";
            plantilla += "Examenes Complementarios:\n\n";
            plantilla += textoExamenes;
        }

        let prueba = [];
        let textoAislamientos = "";
        reportePlantillas.forEach(elemento =>{
            let datos = elemento['AISLAMIENTOS'].split("\n");
            prueba.push(datos);
        });

        prueba.forEach(elemento => {
            elemento.forEach(Element => {
                let dato = Element.split(",");
                if(Element !== ""){
                    textoAislamientos += `${dato[0].split("T")[0]}:   Muestra:${dato[1]} | Origen:${dato[2]} | Valor:${dato[3]}\n`;
                }
            });
        });
        if(textoAislamientos !== ""){
            plantilla += "\n--------------------------------------------------------------------------------------------\n";
            plantilla += "Aislamientos:\n\n"
            plantilla += textoAislamientos + "\n";
        }
        document.querySelector("#plantilla").value = plantilla;
    }


    $("#boton_copiar").on("click", function(){
        let texto = $("#plantilla").val();
        navigator.clipboard.writeText(texto);

        Swal.fire({
            toast: true,
            text: "¡Texto copiado en el portapapeles!",
            icon: "success",
            timer: 3000
        });
    });


    $("#fecha_desde, #fecha_hasta").on("change", function(){
        let episodio = $("#episodio").val();
        let documento = $("#nroDocu").val();
        let fechaDesdeValor = $("#fecha_desde").val();
        let fechaHastaValor = $("#fecha_hasta").val();

        if(fechaDesdeValor === "" || fechaHastaValor === ""){
            return;
        }

        let fechaDesde = new Date(fechaDesdeValor);
        let fechaHasta = new Date(fechaHastaValor);

        if(fechaHasta < fechaDesde){
            Swal.fire({
                icon: "info",
                toast: true,
                text: "La fecha inicio debe ser menor de la fecha final",
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        let datosTabla = document.querySelectorAll(".elim");
        datosTabla.forEach(elemento => {
            elemento.remove();
        });
        llenarHistoricoParaclinico(episodio, documento, "PorFecha");
        document.getElementById("button_plantilla").removeAttribute("hidden");
        console.log("Llego aquí")
    });


    let intervalo = setInterval(() => {
        let episodio = $("#episodio").val();
        let documento = $("#nroDocu").val();

        if(episodio && documento){
            $(".bloquear").prop("disabled", true);
            llenarHistoricoParaclinico(episodio, documento);
            clearInterval(intervalo);
        }
    }, 100);


});