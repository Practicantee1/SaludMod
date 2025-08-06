let isEditMode = false;
var id;
let filaDatos=[];
let estado;
//FUNCION PARA EL GUARDADO DE ENFERMERAS Y AUXILIARES
function toggleDivs() {
    // Obtener los valores de los radio buttons
    const ventilacion = document.querySelector('input[name="ventilacion"]:checked');
    const cvc = document.querySelector('input[name="cvc"]:checked');
    const sonde = document.querySelector('input[name="sonda"]:checked');

    // Validación para asegurarse de que al menos una evaluación esté seleccionada
    if ((ventilacion && ventilacion.value === 'no') &&
        (cvc && cvc.value === 'no') &&
        (sonde && sonde.value === 'no')) {
        
        // Mostrar SweetAlert con el mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe seleccionar al menos una evaluación',
        }).then(() => {
            // Limpiar las selecciones de los radio buttons
            const radios = document.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
                radio.checked = false;
            });

            // También podemos ocultar los divs en caso de que estén visibles
            document.getElementById('navDiv').style.display = 'none';
            document.getElementById('itsDiv').style.display = 'none';
            document.getElementById('istuDiv').style.display = 'none';
        });

        // Detener la ejecución para evitar mostrar u ocultar los divs si la validación falla
        return;
    }

    // Mostrar u ocultar el div de NAV
    if (ventilacion && ventilacion.value === 'si') {
        document.getElementById('navDiv').style.display = 'block';
    } else {
        document.getElementById('navDiv').style.display = 'none';
    }

    // Mostrar u ocultar el div de ITS
    if (cvc && cvc.value === 'si') {
        document.getElementById('itsDiv').style.display = 'block';
    } else {
        document.getElementById('itsDiv').style.display = 'none';
    }

    // Mostrar u ocultar el div de ISTU
    if (sonde && sonde.value === 'si') {
        document.getElementById('istuDiv').style.display = 'block';
    } else {
        document.getElementById('istuDiv').style.display = 'none';
    }
}
function guardarDefinitivo_1_2(idTabla, idProfesinal) {
    const ventilacion = document.querySelector('input[name="ventilacion"]:checked');
    const cvc = document.querySelector('input[name="cvc"]:checked');
    const sonde = document.querySelector('input[name="sonda"]:checked');
    if ((ventilacion && ventilacion.value === 'no') &&
        (cvc && cvc.value === 'no') &&
        (sonde && sonde.value === 'no')) {
        // Mostrar SweetAlert con el mensaje de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Debe seleccionar al menos una evaluación.',
        }).then(() => {
            // Limpiar las selecciones de los radio buttons
            const radios = document.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
                radio.checked = false;
            });

            // También podemos ocultar los divs en caso de que estén visibles
            document.getElementById('navDiv').style.display = 'none';
            document.getElementById('itsDiv').style.display = 'none';
            document.getElementById('istuDiv').style.display = 'none';

            // Reajustar los radios a "No"
            $('input[name="ventilacion"][value="no"]').prop('checked', true);
            $('input[name="cvc"][value="no"]').prop('checked', true);
            $('input[name="sonda"][value="no"]').prop('checked', true);
        });

        // Detener la ejecución para evitar mostrar u ocultar los divs si la validación falla
        return;
    }
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
            // Define los ids de las tablas en el orden deseado
            const tabIds = ['neav', 'its', 'istuTable'];
            filaDatos=[];
            let seleccionInvalida = false; // Variable para controlar si hay select sin seleccionar

            // Recorre cada tabla y procesa las filas
            tabIds.forEach(tabId => {
                const tab = document.getElementById(tabId);
                if (tab) {
                    const rows = tab.querySelectorAll('tr');
                    const evaluaciones = [];
                    let cumplimiento = "N/A";

                    rows.forEach((row, rowIndex) => {
                        const cells = row.querySelectorAll('td');

                        if (cells.length > 0) {
                            if (rowIndex === rows.length - 1) {
                                // Última fila es el cumplimiento
                                cumplimiento = cells[cells.length - 1].textContent.trim() || "N/A";
                            } else {
                                // Resto de las filas para evaluaciones
                                const select = row.querySelector('select.response');
                                if (select) {
                                    if (!select.value) {
                                        seleccionInvalida = true; // Marca la selección como inválida
                                    }
                                    evaluaciones.push(select.value || "N/A");
                                } else {
                                    evaluaciones.push(cells[0].textContent.trim() || "N/A");
                                }
                            }
                        }
                    });

                    // Añadir las evaluaciones y el cumplimiento al arreglo de datos de la fila
                    filaDatos.push(...evaluaciones, cumplimiento);
                } else {
                    console.error(`No se encontró la pestaña con id ${tabId}.`);
                }
            });

            // Si hay selección inválida, muestra un mensaje y detiene el proceso
            

            // Obtener la fecha y la hora actuales
            // const fecha = new Date().toISOString().split('T')[0];
            const fecha = document.getElementById("fecha").value || "N/A";
            const hora = new Date().toLocaleTimeString();
            const observaciones = document.getElementById("Observaciones").value || "N/A"; 

            // Crear una nueva fila en la tabla de registros
            const registroTable = document.getElementById(idTabla).querySelector('tbody');
            if (registroTable) {
                const newRow = registroTable.insertRow(0);

                // Insertar la fecha y la hora
                newRow.insertCell(0).textContent = fecha;
                newRow.insertCell(1).textContent = hora;

                // Insertar las evaluaciones y el cumplimiento en el orden correcto
                filaDatos.forEach((dato, index) => {
                    newRow.insertCell(index + 2).textContent = dato;
                });
                newRow.insertCell(22).textContent = observaciones;
            } else {
                console.error(`No se encontró la tabla con id ${idTabla}.`);
            }

            Swal.fire({
                title: "Guardado!",
                text: "Tu registro ha sido guardado.",
                icon: "success"
            }).then(() => {
                saveBundles(idProfesinal);
                document.getElementById('navDiv').style.display = 'none';
                document.getElementById('itsDiv').style.display = 'none';
                document.getElementById('istuDiv').style.display = 'none';

                $('input[name="ventilacion"][value="no"]').prop('checked', true);
                $('input[name="cvc"][value="no"]').prop('checked', true);
                $('input[name="sonda"][value="no"]').prop('checked', true);
                
                const ventilacion = document.querySelector('input[name="ventilacion"]:checked');
                const cvc = document.querySelector('input[name="cvc"]:checked');
                const sonde = document.querySelector('input[name="sonda"]:checked');
                const boton = document.getElementById('guardaRegistroDefinitivo');
                if ((ventilacion && ventilacion.value === 'no') && (cvc && cvc.value === 'no') && (sonde && sonde.value === 'no')) {
                    boton.disabled = true;
                } else {
                    boton.disabled = false;
                }
                document.getElementById('navDiv').style.display = 'none';
                document.getElementById('itsDiv').style.display = 'none';
                document.getElementById('istuDiv').style.display = 'none';
                document.getElementById("episodio").value="";
                document.getElementById("nroDoc").value="";
                document.getElementById("nombrePaciente").value="";
                document.getElementById("tipo").value="";
                document.getElementById("edad").value="";
                document.getElementById("sexo").value="";
                document.getElementById("ubicacion").value="";
                document.getElementById("cama").value="";
                document.getElementById("entidad").value="";
                document.getElementById("Observaciones").value = "";
                document.getElementById("profesional").value = "";
                document.getElementById("especialidad").value = "";
                tabIds.forEach(tabId => {
                    const tab = document.getElementById(tabId);
                    if (tab) {
                        const rows = tab.querySelectorAll('tr');
                        rows.forEach((row, rowIndex) => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length > 0) {
                                if (rowIndex === rows.length - 1) {
                                    const cumplimientoCell = cells[cells.length - 1];
                                    if (cumplimientoCell) {
                                        cumplimientoCell.textContent = '';
                                    }
                                } else {
                                    const select = row.querySelector('select.response');
                                    if (select) {
                                        select.selectedIndex = 0;
                                        select.style.background = "inherit";
                                        select.style.color = "black";
                                    }
                                }
                            }
                        });
                    }
                });
            });
            console.log("Contenido de filaDatos después de guardarDefinitivo_1_2:", filaDatos);
        }



        
    });
}

function saveBundles(idProfesinal) {
    let episodio = $("#episodio").val();
    let documento = $("#nroDoc").val();
    let tipo_documento = $("#tipo").val();
    let nombre = $("#nombrePaciente").val();
    let edad = $("#edad").val();
    let genero = $("#sexo").val();
    let ubicacion = $("#ubicacion").val();
    let cama = $("#cama").val();
    let entidad = $("#entidad").val();
    let evaluacionesnav = filaDatos.slice(0, 6);
    let evaluacionesits = filaDatos.slice(6, 13);
    let evaluacionesistu = filaDatos.slice(13, 20);
    let observaciones = $("#Observaciones").val();
    let estadoEvaluacion = 'FINALIZADO';
    let nombreProfesional = idProfesinal;
    let cargo = $("#especialidad").val();
    let centrosanitario = $("#centrosanitario").val();

    function obtenerValoresDeTabla(idTabla) {
        let claves = [];
        let tabla = document.querySelector(`#${idTabla}`);
        
        // Seleccionamos todas las celdas de la primera columna que tienen la clase 'left-align sub-header'
        let celdas = tabla.querySelectorAll('td.left-align.sub-header');
        
        // Recorremos las celdas y extraemos el texto
        celdas.forEach(celda => {
            claves.push(celda.textContent.trim());
        });
        
        return claves;
    }
    
    let clavesEvaluacionesNav = obtenerValoresDeTabla('neav');
    let clavesEvaluacionesIts = obtenerValoresDeTabla('its');
    let clavesEvaluacionesIstu = obtenerValoresDeTabla('istuTable');
    
    let jsonEvaluacionesNav = {};
    let jsonEvaluacionesIts = {};
    let jsonEvaluacionesIstu = {};
    
    for (let i = 0; i < clavesEvaluacionesNav.length; i++) {
        jsonEvaluacionesNav[clavesEvaluacionesNav[i]] = evaluacionesnav[i] || null;  
    }
    for (let i = 0; i < clavesEvaluacionesIts.length; i++) {
        // Si encontramos "Cumplimiento", primero agregamos la nueva pregunta
        if (clavesEvaluacionesIts[i] === "Cumplimiento") {
            jsonEvaluacionesIts["Topicación con clorhexidina en mayores de 2 meses"] = "N/A Enfermera o Aux";
        }
        jsonEvaluacionesIts[clavesEvaluacionesIts[i]] = evaluacionesits[i] || null;
    }
    for (let i = 0; i < clavesEvaluacionesIstu.length; i++) {
        jsonEvaluacionesIstu[clavesEvaluacionesIstu[i]] = evaluacionesistu[i] || null;  
    }
    
    // Mostrar los JSON en consola (para depuración)
    console.log(jsonEvaluacionesNav);
    console.log(jsonEvaluacionesIts);
    console.log(jsonEvaluacionesIstu);

    fetch('/SaludMod/Modulos/desarrollo_epidemiologia/logica/guardarBD.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            episodio: episodio,
            documento: documento,
            tipo_documento: tipo_documento,
            nombre: nombre,
            edad: edad,
            genero: genero,
            ubicacion: ubicacion,
            cama: cama,
            entidad: entidad,
            evaluacionesnav: jsonEvaluacionesNav,
            evaluacionesits: jsonEvaluacionesIts,
            evaluacionesistu: jsonEvaluacionesIstu,
            observaciones: observaciones,
            estadoEvaluacion: estadoEvaluacion,
            nombreProfesional: nombreProfesional,
            cargo: cargo,
            centrosanitario: centrosanitario
        })
    })
    .then(response => response.json())
    .then(result => {
        console.log(result);
        if (result.status === 'success') {
            console.log("Se guardó en la BD");
            id = result.idPaciente;
            console.log(id);
        } else {
            console.log("Error al guardar en la BD");
        }
    })
    .catch(error => {
        console.log('Error al guardar los datos en las tablas');
        console.error('Error:', error);
    });
}
function llenarHistoricoEnfermeras(episodio) {
    if (!episodio) {
        console.error("Error: El parámetro 'episodio' no está definido");
        return;
    }

    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/desarrollo_epidemiologia/logica/llenarHistoricosEnfermeras.php',
        data: { episodio: episodio },
        dataType: "json",
        success: function(response) {
            if (response.enfermeras && response.enfermeras.length > 0) {
                $('#registros tbody').empty();

                // Lista de claves a excluir
                const clavesExcluir = [
                    "Topicación con clorhexidina en mayores de 2 meses"
                ];

                response.enfermeras.forEach(function(enfermera) {
                    let newRow = `<tr>
                        <td style="text-align: center;">${enfermera.fecha || ''}</td>
                        <td style="text-align: center;">${enfermera.hora || ''}</td>`;
                    
                    // Procesar evaluaciones de NAV dinámicamente
                    if (enfermera.evaluacionesnav) {
                        Object.keys(enfermera.evaluacionesnav).forEach(function(key) {
                            if (!clavesExcluir.includes(key)) {  // Verificar si la clave no está en la lista de exclusión
                                newRow += `<td style="text-align: center;">${enfermera.evaluacionesnav[key] || ''}</td>`;
                            }
                        });
                    }

                    // Procesar evaluaciones de ITS dinámicamente
                    if (enfermera.evaluacionesits) {
                        Object.keys(enfermera.evaluacionesits).forEach(function(key) {
                            if (!clavesExcluir.includes(key)) {  // Verificar si la clave no está en la lista de exclusión
                                newRow += `<td style="text-align: center;">${enfermera.evaluacionesits[key] || ''}</td>`;
                            }
                        });
                    }

                    // Procesar evaluaciones de ISTU dinámicamente
                    if (enfermera.evaluacionesistu) {
                        Object.keys(enfermera.evaluacionesistu).forEach(function(key) {
                            if (!clavesExcluir.includes(key)) {  // Verificar si la clave no está en la lista de exclusión
                                newRow += `<td style="text-align: center;">${enfermera.evaluacionesistu[key] || ''}</td>`;
                            }
                        });
                    }

                    // Añadir el campo de observaciones al final de la fila
                    newRow += `<td style="text-align: center;">${enfermera.observaciones || ''}</td>`;
                    newRow += `</tr>`;

                    $('#registros tbody').prepend(newRow);
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}


