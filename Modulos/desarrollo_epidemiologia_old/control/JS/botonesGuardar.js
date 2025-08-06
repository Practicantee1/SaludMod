let isEditMode = false;
var id;
let filaDatos=[];
let estado;
//FUNCION PARA EL GUARDADO DE ENFERMERAS Y AUXILIARES

function guardarDefinitivo_1_2(idTabla) {
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
            const fecha = new Date().toISOString().split('T')[0];
            const hora = new Date().toLocaleTimeString();
            const observaciones = document.getElementById("Observaciones").value || "N/A"; 

            // Crear una nueva fila en la tabla de registros
            const registroTable = document.getElementById(idTabla).querySelector('tbody');
            if (registroTable) {
                const newRow = registroTable.insertRow();

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
                saveBundles();
                // Limpia los valores de las tablas después de guardar
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

function saveBundles() {
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
    let nombreProfesional = $("#profesional").val();
    let cargo = $("#especialidad").val();

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
            cargo: cargo
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

//FUNCIONES PARA EL GUARDADO DE EPIDEMIOLOGIA
function guardarParcialEpid(idTabla) {
    estado='PENDIENTE';
    if (isEditMode) {
        // Si está en modo de edición, prevenir guardado parcial
        Swal.fire({
            title: "Edición en curso",
            text: "No puede guardar parcialmente mientras hay un registro en edición.",
            icon: "warning"
        });
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
            const tabIds = ['neav', 'its', 'istuTable'];
            filaDatos=[];
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
                                // Capturar el cumplimiento de la última fila
                                cumplimiento = cells[cells.length - 1].textContent.trim() || "N/A";
                            } else {
                                // Capturar las evaluaciones
                                const select = row.querySelector('select.response');
                                if (select) {
                                    if (select.value === "") {
                                        tieneSelectVacio = true; // Marca si hay un select vacío
                                    }
                                    evaluaciones.push(select.value || "N/A");
                                } else {
                                    evaluaciones.push(cells[0].textContent.trim() || "N/A");
                                }
                            }
                        }
                    });

                    // Añadir evaluaciones y cumplimiento al arreglo de datos de la fila
                    filaDatos.push(...evaluaciones, cumplimiento);
                } else {
                    console.error(`No se encontró la pestaña con id ${tabId}.`);
                }
            });
            // Obtener valores adicionales de Episodio, Número de Documento, Nombre, Edad, Género, Ubicación, Cama y Entidad desde el HTML
            const episodio = document.getElementById("episodio").value.trim();
            const numeroDocumento = document.getElementById("nroDoc").value.trim();
            const nombre = document.getElementById("nombrePaciente").value.trim();
            const edad = document.getElementById("edad").value.trim();
            const genero = document.getElementById("sexo").value.trim();
            const ubicacion = document.getElementById("ubicacion").value.trim();
            const cama = document.getElementById("cama").value.trim();
            const entidad = document.getElementById("entidad").value.trim();
            const observaciones = document.getElementById("Observaciones").value.trim() || "N/A";

            // Obtener fecha y hora actuales
            const fecha = new Date().toISOString().split('T')[0];
            const hora = new Date().toLocaleTimeString();

            // Crear nueva fila en la tabla de registros
            const registroTable = document.getElementById(idTabla).querySelector('tbody');
            if (registroTable) {
                const newRow = registroTable.insertRow();

                // Insertar la fecha y la hora
                newRow.insertCell(0).textContent = fecha;
                newRow.insertCell(1).textContent = hora;

                // Insertar los valores adicionales capturados
                newRow.insertCell(2).textContent = episodio;
                newRow.insertCell(3).textContent = numeroDocumento;
                newRow.insertCell(4).textContent = nombre;
                newRow.insertCell(5).textContent = edad;
                newRow.insertCell(6).textContent = genero;
                newRow.insertCell(7).textContent = ubicacion;
                newRow.insertCell(8).textContent = cama;
                newRow.insertCell(9).textContent = entidad;

                // Insertar las evaluaciones y el cumplimiento
                filaDatos.forEach((dato, index) => {
                    newRow.insertCell(index + 10).textContent = dato;
                });
                newRow.insertCell(filaDatos.length + 10).textContent = observaciones;

                // Añadir celdas "Estado" "Editar" "Guardar definitivo"
                const estadoCell = newRow.insertCell(filaDatos.length + 11); 
                estadoCell.textContent = "Pendiente";

                const editarCell = newRow.insertCell(filaDatos.length + 12); 
                const editarBtn = document.createElement('button');

                editarBtn.textContent = "Editar";
                editarBtn.classList.add('btn', 'btn-primary');
                editarBtn.onclick = () => editarFila(newRow);
                editarCell.appendChild(editarBtn);

                const guardarCell = newRow.insertCell(filaDatos.length + 13);
                const guardarBtn = document.createElement('button');
                guardarBtn.textContent = "Guardar Definitivo";
                guardarBtn.classList.add('btn');
                guardarBtn.style.backgroundColor = "#97BF0D"; // Color de fondo verde
                guardarBtn.style.color = "white";
                guardarBtn.onclick = () => guardarDefinitivo(newRow);
                guardarCell.appendChild(guardarBtn);
                
            } else {
                console.error(`No se encontró la tabla con id ${idTabla}.`);
            }

            Swal.fire({
                title: "Guardado!",
                text: "Tu registro ha sido guardado.",
                icon: "success"
            }).then(() => {
                saveBundlesEpid(estado);
                document.getElementById("episodio").value = "";
                document.getElementById("nroDoc").value = "";
                document.getElementById("nombrePaciente").value = "";
                document.getElementById("edad").value = "";
                document.getElementById("sexo").value = "";
                document.getElementById("ubicacion").value = "";
                document.getElementById("cama").value = "";
                document.getElementById("entidad").value = "";
                document.getElementById("Observaciones").value = "";
                document.getElementById("profesional").value = "";
                document.getElementById("especialidad").value = "";
                document.getElementById("id").value = "";
                // Limpieza de los selects y valores de cumplimiento
                tabIds.forEach(tabId => {
                    const tab = document.getElementById(tabId);
                    if (tab) {
                        const rows = tab.querySelectorAll('tr');
                        rows.forEach((row, rowIndex) => {
                            const cells = row.querySelectorAll('td');
                            if (cells.length > 0) {
                                if (rowIndex === rows.length - 1) {
                                    // Limpiar cumplimiento
                                    const cumplimientoCell = cells[cells.length - 1];
                                    if (cumplimientoCell) {
                                        cumplimientoCell.textContent = '';
                                        cumplimientoCell.style.color = 'black';
                                        
                                        
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
        }
    });
}

function saveBundlesEpid(estado) {
    let episodio = $("#episodio").val();
    let documento = $("#nroDoc").val();
    let tipo_documento = $("#tipo").val();
    let nombre = $("#nombre").val();
    let edad = $("#edad").val();
    let genero = $("#sexo").val();
    let ubicacion = $("#ubicacion").val();
    let cama = $("#cama").val();
    let entidad = $("#entidad").val();
    let evaluacionesnav = filaDatos.slice(0, 6);
    let evaluacionesits = filaDatos.slice(6, 14);
    let evaluacionesistu = filaDatos.slice(14, 21);
    let observaciones = $("#Observaciones").val();
    let estadoEvaluacion = estado;
    let nombreProfesional = $("#profesional").val();
    let cargo = $("#cargo").val();

    function obtenerValoresDeTabla(idTabla) {
        let claves = [];
        let tabla = document.querySelector(`#${idTabla}`);
        
        // Select all the cells in the first column that have the class 'left-align sub-header'
        let celdas = tabla.querySelectorAll('td.left-align.sub-header');
        
        // Iterate over the cells and extract the text
        celdas.forEach(celda => {
            claves.push(celda.textContent.trim());
        });
        
        return claves;
    }
    let clavesEvaluacionesNav = obtenerValoresDeTabla('neav');
    let clavesEvaluacionesIts = obtenerValoresDeTabla('its');
    let clavesEvaluacionesIstu = obtenerValoresDeTabla('istuTable');

    // Ejemplo de creación de JSON para las evaluaciones
    let jsonEvaluacionesNav = {};
    let jsonEvaluacionesIts = {};
    let jsonEvaluacionesIstu = {};

    // Suponiendo que tienes un arreglo de evaluaciones para cada tabla (evaluacionesnav, evaluacionesits, evaluacionesistu)
    for (let i = 0; i < clavesEvaluacionesNav.length; i++) {
    jsonEvaluacionesNav[clavesEvaluacionesNav[i]] = evaluacionesnav[i] || '';  
    }
    for (let i = 0; i < clavesEvaluacionesIts.length; i++) {
    jsonEvaluacionesIts[clavesEvaluacionesIts[i]] = evaluacionesits[i];
    }
    for (let i = 0; i < clavesEvaluacionesIstu.length; i++) {
    jsonEvaluacionesIstu[clavesEvaluacionesIstu[i]] = evaluacionesistu[i] || '';  
    }

    // Puedes usar los JSON creados para lo que necesites
    // console.log(jsonEvaluacionesNav);
    // console.log(jsonEvaluacionesIts);
    // console.log(jsonEvaluacionesIstu);

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
            cargo: cargo
        })
    })
    .then(response => response.json())
    .then(result => {
        console.log(result);
        if (result.status === 'success') {
            console.log("Se guardó en la BD");
            id = result.idPaciente;
            document.getElementById("id").value = id;

            const registroTable = document.getElementById('registros').querySelector('tbody');
            const lastRow = registroTable ? registroTable.lastElementChild : null;

            if (lastRow) {
                // Insertar el ID en una nueva celda después de "Guardar definitivo"
                const idCell = lastRow.insertCell(filaDatos.length + 14);
                idCell.textContent = id;
                idCell.style.display = 'none';
            }
            

        } else {
            console.log("Error al guardar en la BD");
        }
    })
    .catch(error => {
        console.log('Error al guardar los datos en las tablas');
        console.error('Error:', error);
    });
}


//FUNCION PARA EDITAR LA TABLA 
function editarFila(row) {
    if (isEditMode) {
        Swal.fire({
            title: "Edición en progreso",
            text: "Guarde o cancele la edición actual antes de continuar.",
            icon: "warning"
        });
        return;
    }

    isEditMode = true; // Marcar que estamos en modo de edición

    const cells = row.querySelectorAll('td');
    const evaluaciones = [];
    const cumplimientos = [];

    // Extraer los valores de las evaluaciones de la fila de la tabla "registros"
    for (let i = 10; i < cells.length - 4; i++) { // Ajuste aquí para las evaluaciones
        evaluaciones.push(cells[i].textContent.trim());
    }

    // Extraer los valores de cumplimiento con posiciones ajustadas por la nueva columna
    const cumplimiento1 = cells[cells.length - 21].textContent.trim(); // Cumplimiento neav
    const cumplimiento2 = cells[cells.length - 13].textContent.trim(); // Cumplimiento its
    const cumplimiento3 = cells[cells.length - 6].textContent.trim();  // Cumplimiento istu
    cumplimientos.push(cumplimiento1, cumplimiento2, cumplimiento3);

    // Verificar si los cumplimientos son "N/A" y reemplazarlos por vacíos
    const normalizedCumplimientos = cumplimientos.map(c => c === 'N/A' ? '' : c);

    // Asignar valores de evaluación y cumplimiento para la tabla 'neav'
    asignarValores('neav', evaluaciones.slice(0, 5), normalizedCumplimientos[0]);

    // Asignar valores de evaluación y cumplimiento para la tabla 'its'
    asignarValores('its', evaluaciones.slice(6, 13), normalizedCumplimientos[1]);

    // Asignar valores de evaluación y cumplimiento para la tabla 'istuTable'
    asignarValores('istuTable', evaluaciones.slice(14, 20), normalizedCumplimientos[2]);

    // Extraer y asignar los valores de los campos "Episodio", "Cama", "Ubicación", etc.
    document.getElementById("episodio").value = cells[2].textContent.trim();
    document.getElementById("nroDoc").value = cells[3].textContent.trim();
    document.getElementById("nombre").value = cells[4].textContent.trim();
    document.getElementById("edad").value = cells[5].textContent.trim();
    document.getElementById("sexo").value = cells[6].textContent.trim();
    document.getElementById("ubicacion").value = cells[7].textContent.trim();
    document.getElementById("cama").value = cells[8].textContent.trim();
    document.getElementById("entidad").value = cells[9].textContent.trim();
    document.getElementById("Observaciones").value = cells[cells.length - 5].textContent.trim(); 
    document.getElementById("id").value = cells[cells.length - 1].textContent.trim();

    // Cambiar el botón "Editar" a "Guardar"
    const editButton = row.querySelector('button');
    if (editButton) {
        editButton.textContent = "Guardar";
        editButton.onclick = function () {
            guardarEdicion(row);
            isEditMode = false; // Cambiar el modo de edición después de guardar
        };
    }
}


//FUNCION PARA ASIFGNAR LOS VALORES A LOS SELECT
function asignarValores(tabId, evaluaciones, cumplimiento) {
    const tab = document.getElementById(tabId);
    if (tab) {
        const rows = tab.querySelectorAll('tr');
        let evalIndex = 0; // Reiniciar índice de evaluación para cada tabla

        rows.forEach((formRow, rowIndex) => {
            if (rowIndex === rows.length - 1) {
                // Asignar el valor de cumplimiento de esa tabla (última fila)
                const cumplimientoCell = formRow.querySelector('td:last-child');
                if (cumplimientoCell) {
                    cumplimientoCell.textContent = cumplimiento; // Cumplimiento value
                }
            } else {
                // Asignar los valores de evaluación a los selects correspondientes
                const select = formRow.querySelector('select.response');
                if (select && evalIndex < evaluaciones.length) {
                    select.value = evaluaciones[evalIndex] || "N/A"; // Evaluation value
                    evalIndex++;
                }
            }
        });
    }
}
let evaluacionesEdicion = [];
function guardarEdicion(row) {
    estado = 'PENDIENTE';
    const tabIds = ['neav', 'its', 'istuTable'];
    evaluacionesEdicion = [];
    const cells = row.querySelectorAll('td');
    let evalIndex = 10; 
    tabIds.forEach(tabId => {
        const table = document.getElementById(tabId);
        if (table) {
            const rows = table.querySelectorAll('tr');
            let tableEvaluations = [];
            let cumplimiento = "N/A";

            rows.forEach((formRow, rowIndex) => {
                if (rowIndex === rows.length - 1) {
                    const cumplimientoCell = formRow.querySelector('td:last-child');
                    if (cumplimientoCell) {
                        cumplimiento = cumplimientoCell.textContent.trim() || "N/A";
                    }
                } else {
                    // Filas de evaluación
                    const select = formRow.querySelector('select.response');
                    if (select) {
                        tableEvaluations.push(select.value || "N/A");
                    }
                }
            });

            // Guardar las evaluaciones y el cumplimiento de esta tabla
            evaluacionesEdicion.push(...tableEvaluations, cumplimiento);
        } else {
            console.error(`No se encontró la tabla con id ${tabId}.`);
        }
    });

    // Actualizar los campos de evaluación en la fila original con los nuevos valores
    evaluacionesEdicion.forEach((evaluation, index) => {
        cells[evalIndex].textContent = evaluation; // Actualizar evaluaciones
        evalIndex++;
    });

    // Recolectar y actualizar los valores de los campos específicos
    const episodio = document.getElementById("episodio").value.trim();
    const numeroDocumento = document.getElementById("nroDoc").value.trim();
    const nombre = document.getElementById("nombre").value.trim();
    const edad = document.getElementById("edad").value.trim();
    const genero = document.getElementById("sexo").value.trim();
    const ubicacion = document.getElementById("ubicacion").value.trim();
    const cama = document.getElementById("cama").value.trim();
    const entidad = document.getElementById("entidad").value.trim();
    const observaciones = document.getElementById("Observaciones").value.trim();

    // Actualizar los valores en la fila de la tabla
    cells[2].textContent = episodio;
    cells[3].textContent = numeroDocumento;
    cells[4].textContent = nombre;
    cells[5].textContent = edad;
    cells[6].textContent = genero;
    cells[7].textContent = ubicacion;
    cells[8].textContent = cama;
    cells[9].textContent = entidad;
    cells[cells.length - 5].textContent = observaciones; // Ajustado a cells.length - 5 por la nueva columna

    // Actualizar la fecha y la hora
    cells[0].textContent = new Date().toISOString().split('T')[0]; // Fecha
    cells[1].textContent = new Date().toLocaleTimeString(); // Hora

    // Cambiar el botón "Guardar" a "Editar"
    const editButton = cells[cells.length - 3].querySelector('button'); // Ajustado a cells.length - 3 por la nueva columna
    if (editButton) {
        editButton.textContent = "Editar";
        editButton.onclick = function () {
            editarFila(row);
        };
    }
    isEditMode = false;
    updateBundlesEpid();
    // Limpiar los selectores y los campos de cumplimiento en todas las tablas
    tabIds.forEach(tabId => {
        document.getElementById("episodio").value = "";
        document.getElementById("nroDoc").value = "";
        document.getElementById("nombre").value = "";
        document.getElementById("edad").value = "";
        document.getElementById("sexo").value = "";
        document.getElementById("ubicacion").value = "";
        document.getElementById("cama").value = "";
        document.getElementById("entidad").value = "";
        document.getElementById("Observaciones").value = "";
        document.getElementById("id").value = "";
        const table = document.getElementById(tabId);
        if (table) {
            const rows = table.querySelectorAll('tr');
            rows.forEach((formRow, rowIndex) => {
                if (rowIndex === rows.length - 1) {
                    // Limpiar el campo de cumplimiento
                    const cumplimientoCell = formRow.querySelector('td:last-child');
                    if (cumplimientoCell) {
                        cumplimientoCell.textContent = ""; // Limpiar el texto de la celda de cumplimiento
                    }
                } else {
                    // Limpiar los selectores
                    const select = formRow.querySelector('select.response');
                    if (select) {
                        select.value = ""; 
                        select.style.background = "inherit";
                        select.style.color = "black";
                    }
                }
            });
        }
    });
}

function updateBundlesEpid() {
    let idPacienteBundles =$("#id").val();
    let evaluacionesnav = evaluacionesEdicion.slice(0, 6);
    let evaluacionesits = evaluacionesEdicion.slice(6, 14);
    let evaluacionesistu = evaluacionesEdicion.slice(14, 21);
    let observaciones = $("#Observaciones").val();

    function obtenerValoresDeTabla(idTabla) {
        let claves = [];
        let tabla = document.querySelector(`#${idTabla}`);
        
        // Select all the cells in the first column that have the class 'left-align sub-header'
        let celdas = tabla.querySelectorAll('td.left-align.sub-header');
        
        // Iterate over the cells and extract the text
        celdas.forEach(celda => {
            claves.push(celda.textContent.trim());
        });
        
        return claves;
    }
    let clavesEvaluacionesNav = obtenerValoresDeTabla('neav');
    let clavesEvaluacionesIts = obtenerValoresDeTabla('its');
    let clavesEvaluacionesIstu = obtenerValoresDeTabla('istuTable');

    // Ejemplo de creación de JSON para las evaluaciones
    let jsonEvaluacionesNav = {};
    let jsonEvaluacionesIts = {};
    let jsonEvaluacionesIstu = {};

    // Suponiendo que tienes un arreglo de evaluaciones para cada tabla (evaluacionesnav, evaluacionesits, evaluacionesistu)
    for (let i = 0; i < clavesEvaluacionesNav.length; i++) {
    jsonEvaluacionesNav[clavesEvaluacionesNav[i]] = evaluacionesnav[i] || '';  
    }
    for (let i = 0; i < clavesEvaluacionesIts.length; i++) {
    jsonEvaluacionesIts[clavesEvaluacionesIts[i]] = evaluacionesits[i];
    }
    for (let i = 0; i < clavesEvaluacionesIstu.length; i++) {
    jsonEvaluacionesIstu[clavesEvaluacionesIstu[i]] = evaluacionesistu[i] || '';  
    }

    // Puedes usar los JSON creados para lo que necesites
    // console.log(jsonEvaluacionesNav);
    // console.log(jsonEvaluacionesIts);
    // console.log(jsonEvaluacionesIstu);

    fetch('/SaludMod/Modulos/desarrollo_epidemiologia/logica/actualizarBD.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idPacienteBundles:idPacienteBundles,
            evaluacionesnav: jsonEvaluacionesNav,
            evaluacionesits: jsonEvaluacionesIts,
            evaluacionesistu: jsonEvaluacionesIstu,
            observaciones: observaciones
        })
    })
    .then(response => response.json()).then(result => {
        if (result.status === 'success') {
            console.log("Se actualizó en la BD");
        } else {
            console.log("Error al actualizar en la BD:", result.message || 'Sin detalles adicionales');
        }
    })
    .catch(error => {
        console.error('Error al procesar la respuesta:', error);
    });
}
function guardarDefinitivo(row) {
    if (isEditMode) {
        // Si está en modo de edición, prevenir guardado parcial
        Swal.fire({
            title: "Edición en curso",
            text: "No puede guardar definitivamente mientras hay un registro en edición.",
            icon: "warning"
        });
        return;
    }
    Swal.fire({
        title: "¿Está seguro de guardar todo el registro definitivo?",
        text: "No podrá volverlo a editar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#428E3F",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, guardar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            estado = "FINALIZADO";
            
            const cells = row.querySelectorAll('td');

            // Cambiar el estado a "Finalizado"
            const estadoCell = cells[cells.length - 4]; // La celda de estado es la cuarta desde el final
            if (estadoCell.textContent === "Pendiente") {
                estadoCell.textContent = "Finalizado";

                // Deshabilitar el botón de "Editar"
                const editarCell = cells[cells.length - 3]; // La celda del botón "Editar" es la tercera desde el final
                const editarBtn = editarCell.querySelector('button');
                if (editarBtn) {
                    editarBtn.disabled = true; // Deshabilitar el botón
                }

                // Deshabilitar el botón "Guardar Definitivo"
                const guardarCell = cells[cells.length - 2]; // La celda del botón "Guardar Definitivo" es la segunda desde el final
                const guardarBtn = guardarCell.querySelector('button');
                if (guardarBtn) {
                    guardarBtn.disabled = true; // Deshabilitar el botón
                }

                // Mostrar alerta de éxito con SweetAlert
                Swal.fire({
                    title: "Guardado Definitivo",
                    text: "El registro ha sido marcado como Finalizado.",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
                updateEstado(estado,cells);
            } else {
                Swal.fire({
                    title: "Ya Finalizado",
                    text: "Este registro ya ha sido finalizado.",
                    icon: "info",
                    confirmButtonText: "Aceptar"
                });
            }
        }
        return estado;
    });
}

function updateEstado(status,cells) {
    let idPacienteBundles =cells[cells.length - 1].textContent.trim();
    let estado=status;

    fetch('/SaludMod/Modulos/desarrollo_epidemiologia/logica/actualizarEstado.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            idPacienteBundles:idPacienteBundles,
            estado: estado
        })
    })
    .then(response => {return response.json()}).then(result => {
        if (result.status === 'success') {
            console.log("Se actualizó el estado");
        } else {
            console.error("Error al actualizar el estado:", result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function validarColumna(tablaID, columnaIndex) {
    const tabla = document.getElementById(tablaID);
    let seleccionInvalida = false;
    
    if (tabla) {
        const rows = tabla.querySelectorAll('tr');
        rows.forEach((row, rowIndex) => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 0) {
                const select = cells[columnaIndex].querySelector('select');
                if (select) {
                    const value = select.value;
                    if (value === "" || value === "N/A") {
                        seleccionInvalida = true; // Si algún select está vacío, la validación falla
                    }
                }
            }
        });
    }

    return seleccionInvalida;
}

function toggleDivs() {
    // Obtener valores de los radio buttons
    const ventilacion = document.querySelector('input[name="ventilacion"]:checked');
    const cvc = document.querySelector('input[name="cvc"]:checked');
    const sonde = document.querySelector('input[name="sonda"]:checked');

    // Mostrar u ocultar el div de NAV
    const navDiv = document.getElementById('navDiv');
    navDiv.style.display = ventilacion && ventilacion.value === 'si' ? 'block' : 'none';

    // Mostrar u ocultar el div de ITS
    const itsDiv = document.getElementById('itsDiv');
    itsDiv.style.display = cvc && cvc.value === 'si' ? 'block' : 'none';

    // Mostrar u ocultar el div de ISTU
    const istuDiv = document.getElementById('istuDiv');
    istuDiv.style.display = sonde && sonde.value === 'si' ? 'block' : 'none';
}

// $(document).ready(function() {
    
//     function llenarHistoricos(episodio, tabla, profesional) {
//         $.ajax({
//             type: "POST",
//             url: '../../logica/llenarHistoricos.php', 
//             data: {
//                 episodio: episodio,
//                 tabla: tabla,
//                 profesional: profesional
//             },
//             dataType: "json", // Esperamos JSON como respuesta
//             success: function(response) {
//                 console.log(response);
//                 if (tabla === "1" && response['enfermeras'] && response['enfermeras'].length > 0) {
//                     $('#registros tbody').empty(); 
                    
//                     let uniqueDates = {}; // Fechas únicas para evitar duplicados
//                     response['enfermeras'].forEach(function(enfermeras) {
//                         if (!uniqueDates[enfermeras.fecha]) {
//                             uniqueDates[enfermeras.fecha] = enfermeras;
//                             let newRow = `<tr>
//                                 <td style="text-align: center;">${enfermeras['fecha'] || ''}</td>
//                                 <td style="text-align: center;">${enfermeras['hora'] || ''}</td>
//                                 <td style="text-align: center;">${enfermeras['evaluacionesnav'] || ''}</td>
//                                 <td style="text-align: center;">${enfermeras['evaluacionesits'] || ''}</td>
//                                 <td style="text-align: center;">${enfermeras['evaluacionesistu'] || ''}</td>
//                                 <td style="text-align: center;">${enfermeras['observaciones'] || ''}</td>
//                             </tr>`;
//                             $('#registros tbody').prepend(newRow); 
//                         }
//                     });
//                 }
//                 else if (tabla === "2" && response['epidemiologa'] && response['epidemiologa'].length > 0) {
//                     $('#registros tbody').empty(); 
                    
//                     response['epidemiologa'].forEach(function(epid) {
//                         let newRow = `<tr>
//                             <td style="text-align: center;">${epid['fecha'] || ''}</td>
//                             <td style="text-align: center;">${epid['hora'] || ''}</td>
//                             <td style="text-align: center;">${epid['episodio'] || ''}</td>
//                             <td style="text-align: center;">${epid['numero_documento'] || ''}</td>
//                             <td style="text-align: center;">${epid['nombre'] || ''}</td>
//                             <td style="text-align: center;">${epid['edad'] || ''}</td>
//                             <td style="text-align: center;">${epid['genero'] || ''}</td>
//                             <td style="text-align: center;">${epid['ubicacion'] || ''}</td>
//                             <td style="text-align: center;">${epid['cama'] || ''}</td>
//                             <td style="text-align: center;">${epid['entidad'] || ''}</td>
//                             <td style="text-align: center;">${epid['evaluacionesnav'] || ''}</td>
//                             <td style="text-align: center;">${epid['evaluacionesits'] || ''}</td>
//                             <td style="text-align: center;">${epid['evaluacionesistu'] || ''}</td>
//                             <td style="text-align: center;">${epid['observaciones'] || ''}</td>
//                             <td style="text-align: center;">${epid['estado'] || ''}</td>
//                         </tr>`;
//                         $('#registros tbody').prepend(newRow); 
//                     });
//                 } else {
//                     console.log("No hay registros para la tabla " + tabla);
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error("AJAX Error:", status, error);
//                 console.log("Response Text:", xhr.responseText); // Mostrar la respuesta completa para depuración
//             }
//         });
//     }

//     let episodio = $('#episodio').val();
//     let nombreProfesional = $('#profesional').val();
//     if (episodio) {
//         $("#Episodio").attr("readonly", true);
        
//         llenarHistoricos(episodio, "1", nombreProfesional); 
//         llenarHistoricos( episodio,"2",nombreProfesional); 
//     }
// });

