let isEditMode = false;
let filaDatos=[];

//Funci�n para realizar un filtro
$('#buttom-search').on('input', function () {
    //Selecciona el texto del input de busqueda, eliminando mayusculas y espacios en blanco
    let filtro = $(this).val().toLowerCase().replace(/\s+/g, '');

    //Se realiza una iteraci�n en cada elemento tr del body de la tabla, esto para a�adir un m�todo
    $('#table-body-main tr').each(function () {
        let fila = $(this);   //Se guarda la referencia de la fila actual
        let coincide = false;   //Se asume que la fila no coincide con el filtro

        fila.find('td').each(function () {   //Se itera en cada columna de la fila actual
            let celda = $(this);

            // Si la celda contiene botones o �conos, la ignoramos en la comparaci�n
            if (celda.find('button, i').length > 0) return;

            let textoComparado = celda.text().toLowerCase().replace(/\s+/g, '');
                
            if (textoComparado.includes(filtro)) {
                coincide = true;
                return false; // Sale del loop de celdas, ya que al menos una coincidi�
            }
        });

        fila.toggle(coincide); // Muestra u oculta la fila seg�n el resultado
    });
});


function limpiarCampos(nombreTabla){
    const opcionPredeterminada = document.querySelectorAll("."+nombreTabla);
    opcionPredeterminada.forEach(opcionPredeterminada => {
        const select = opcionPredeterminada.querySelector("select");
        if(select){
            select.value = "";
            select.style.background = "white";
            select.style.color = "black";
        }else{
            opcionPredeterminada.textContent = "";
        }
    });
}


function llenarHistoricosEpidemiologa(nombreProfesional) {
    // console.log("Nombre del profesional:", nombreProfesional);
    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/desarrollo_epidemiologia/logica/llenarHistoricosEpidemiologa.php',
        data: { nombreProfesional: nombreProfesional },
        dataType: "json", 
        success: function(response) {
            
            // Verificar que la respuesta tiene el formato esperado
            if (response.epidemiologa &&  response.epidemiologa.length > 0) {
                $('#registros tbody').empty(); // Limpiar la tabla antes de agregar filas nuevas
                
                response.epidemiologa.forEach(function(epid) {
                    console.log("Respuesta completa:", response);
                    console.log("ID del paciente:", epid.id || epid.pb_id || 'Clave desconocida');

                    // Extraer evaluaciones para nav, its e istu de manera dinámica
                    let evalNav = epid.evaluacionesnav || {};
                    let evalITS = epid.evaluacionesits || {};
                    let evalISTU = epid.evaluacionesistu || {};
                    
                    // Obtener las claves de las evaluaciones de manera dinámica
                    let navColumns = Object.keys(evalNav);
                    let itsColumns = Object.keys(evalITS);
                    let istuColumns = Object.keys(evalISTU);
                    
                    // Crear las celdas de la tabla para las evaluaciones dinámicamente
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td style="text-align: center;">${epid.fecha || ''}</td>
                        <td style="text-align: center;">${epid.hora || ''}</td>
                        <td style="text-align: center;">${epid.episodio || ''}</td>
                        <td style="text-align: center;">${epid.numero_documento || ''}</td>
                        <td style="text-align: center;">${epid.nombre || ''}</td>
                        <td style="text-align: center;">${epid.edad || ''}</td>
                        <td style="text-align: center;">${epid.genero || ''}</td>
                        <td style="text-align: center;">${epid.ubicacion || ''}</td>
                        <td style="text-align: center;">${epid.cama || ''}</td>
                        <td style="text-align: center;">${epid.entidad || ''}</td>
                    `;
                    
                    // Agregar las celdas de las evaluaciones nav
                    navColumns.forEach(function(column) {
                        row.innerHTML += `<td style="text-align: center;">${evalNav[column] || ''}</td>`;
                    });

                    // Agregar las celdas de las evaluaciones its
                    itsColumns.forEach(function(column) {
                        row.innerHTML += `<td style="text-align: center;">${evalITS[column] || ''}</td>`;
                    });

                    // Agregar las celdas de las evaluaciones istu
                    istuColumns.forEach(function(column) {
                        row.innerHTML += `<td style="text-align: center;">${evalISTU[column] || ''}</td>`;
                    });

                    // Celdas de observaciones y estado
                    row.innerHTML += `
                        <td style="text-align: center;">${epid.observaciones || ''}</td>
                        <td style="text-align: center;">${epid.estado || ''}</td>
                        <td>
                            <button class="btn btn-primary" onclick="editarFila(this.closest('tr'))">Editar</button>
                        </td>
                        <td>
                            <button class="btn" style="background-color: #97BF0D; color: white;" onclick="guardarDefinitivo(this.closest('tr'))">Guardar Definitivo</button>
                        </td>
                        <td style="text-align: center;" hidden>${epid.id || ''}</td>
                    `;
                    
                    $('#registros tbody').prepend(row); // Agregar fila a la tabla
                });
            } else {
                console.log("Datos no encontrados o estructura de datos inesperada.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Texto de la respuesta:", xhr.responseText || "No hay respuesta del servidor");
        }
    });
}


async function toggleDivs(event) {
    // Obtener los valores de los radio buttons
    const ventilacion = document.querySelector('input[name="ventilacion"]:checked');
    const cvc = document.querySelector('input[name="cvc"]:checked');
    const sonde = document.querySelector('input[name="sonda"]:checked');

    // Validación para asegurarse de que al menos una evaluación esté seleccionada
    if (((ventilacion && ventilacion.value === 'no') &&
        (cvc && cvc.value === 'no') &&
        (sonde && sonde.value === 'no'))  && isEditMode) {
        
    	// Mostrar SweetAlert con el mensaje de error
        const result = await Swal.fire({
            icon: 'info',
            title: '¿Estás seguro de eliminar la última evalución?',
            text: 'Esta acción hará que todas las evaluciones aparezcan como N/A',
            showCancelButton: true,
            cancelButtonText: "No, cancelar",
            confirmButtonText: "Si, confirmar",
            confirmButtonColor: "#066E45"
        });

        console.log(result.isConfirmed);

        if(!result.isConfirmed){
            const radio = document.querySelectorAll(`input[name="${event.target.name}"]`);
            radio.forEach( radio => {
                if(radio.value === "si"){
                    radio.checked = true;
                }
            });
            console.log("Cancelar");
            return;
        }
    }

    // Mostrar u ocultar el div de NAV
    if (ventilacion && ventilacion.value === 'si') {
        document.getElementById('navDiv').style.display = 'block';
    } else {
        document.getElementById('navDiv').style.display = 'none';
	limpiarCampos("tds_neav");
    }

    // Mostrar u ocultar el div de ITS
    if (cvc && cvc.value === 'si') {
        document.getElementById('itsDiv').style.display = 'block';
    } else {
        document.getElementById('itsDiv').style.display = 'none';
	limpiarCampos("tds_its");	
    }

    // Mostrar u ocultar el div de ISTU
    if (sonde && sonde.value === 'si') {
        document.getElementById('istuDiv').style.display = 'block';
    } else {
        document.getElementById('istuDiv').style.display = 'none';
	limpiarCampos("tds_istuTable");
    }
}

//FUNCIONES PARA EL GUARDADO DE EPIDEMIOLOGIA
function guardarParcialEpid(idTabla,idProfesional) {
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

    const estado='PENDIENTE';
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
            filaDatos = [];

            // Recorrer cada tabla de evaluación
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
                    filaDatos.push(...evaluaciones);
                    filaDatos.push(cumplimiento);  // Insertar cumplimiento separado
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
                const newRow = registroTable.insertRow(0);

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
                // Añadir celdas "Estado" y "Editar"
                const estadoCell = newRow.insertCell(filaDatos.length + 11); 
                estadoCell.textContent = estado;

                const editarCell = newRow.insertCell(filaDatos.length + 12); 
                const editarBtn = document.createElement('button');
                editarBtn.textContent = "Editar";
                editarBtn.classList.add('btn', 'btn-primary');
                editarBtn.onclick = () => editarFila(newRow); 
                editarCell.appendChild(editarBtn);
                // editarBtn.textContent = "Editar";

                const guardarCell = newRow.insertCell(filaDatos.length + 13);
                const guardarBtn = document.createElement('button');
                guardarBtn.textContent = "Guardar Definitivo";
                guardarBtn.classList.add('btn');
                guardarBtn.style.backgroundColor = "#97BF0D"; // Color de fondo verde
                guardarBtn.style.color = "white";
                guardarBtn.onclick = () => guardarDefinitivo(newRow);
                guardarCell.appendChild(guardarBtn);
                saveBundlesEpid(estado,newRow,idProfesional);
                // newRow.insertCell(filaDatos.length + 14).textContent = "1";
            } else {
                console.error(`No se encontró la tabla con id ${idTabla}.`);
            }

            Swal.fire({
                title: "Guardado!",
                text: "Tu registro ha sido guardado.",
                icon: "success"
            }).then(() => {
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
                // const radios = document.querySelectorAll('input[type="radio"]');
                // radios.forEach(radio => {
                //     radio.checked = false;
                // });
                document.getElementById("episodio").value="";
                document.getElementById("nroDoc").value="";
                document.getElementById("nombrePaciente").value="";
                document.getElementById("edad").value="";
                document.getElementById("sexo").value="";
                document.getElementById("ubicacion").value="";
                document.getElementById("cama").value="";
                document.getElementById("entidad").value="";
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
function saveBundlesEpid(estado, newRow, idProfesional) {
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
    let evaluacionesits = filaDatos.slice(6, 14);
    let evaluacionesistu = filaDatos.slice(14, 21);
    let observaciones = $("#Observaciones").val();
    let estadoEvaluacion = estado;
    let nombreProfesional = idProfesional;
    let cargo = $("#especialidad").val();
    let centrosanitario = $("#centrosanitario").val();
    console.log(idProfesional);
    function obtenerValoresDeTabla(idTabla) {
        let claves = [];
        let tabla = document.querySelector(`#${idTabla}`);
        let celdas = tabla.querySelectorAll('td.left-align.sub-header');
        celdas.forEach(celda => {
            claves.push(celda.textContent.trim());
        });
        return claves;
    }

    let clavesEvaluacionesNav = obtenerValoresDeTabla('neav');
    let clavesEvaluacionesIts = obtenerValoresDeTabla('its');
    let clavesEvaluacionesIstu = obtenerValoresDeTabla('istuTable');

    // Crear JSON inicial para las evaluaciones
    let jsonEvaluacionesNav = {};
    let jsonEvaluacionesIts = {};
    let jsonEvaluacionesIstu = {};

    for (let i = 0; i < clavesEvaluacionesNav.length; i++) {
        jsonEvaluacionesNav[clavesEvaluacionesNav[i]] = evaluacionesnav[i] || '';
    }
    for (let i = 0; i < clavesEvaluacionesIts.length; i++) {
        jsonEvaluacionesIts[clavesEvaluacionesIts[i]] = evaluacionesits[i];
    }
    for (let i = 0; i < clavesEvaluacionesIstu.length; i++) {
        jsonEvaluacionesIstu[clavesEvaluacionesIstu[i]] = evaluacionesistu[i] || '';
    }

    // Función para compactar claves de un JSON
    function compactarJSON(json) {
        let jsonCompacto = {};
        for (let clave in json) {
            let claveLimpia = clave.replace(/\s+/g, ' ').trim(); // Eliminar espacios y saltos de línea
            jsonCompacto[claveLimpia] = json[clave];
        }
        return jsonCompacto;
    }

    // Compactar las claves de cada JSON
    jsonEvaluacionesNav = compactarJSON(jsonEvaluacionesNav);
    jsonEvaluacionesIts = compactarJSON(jsonEvaluacionesIts);
    jsonEvaluacionesIstu = compactarJSON(jsonEvaluacionesIstu);

    console.log(idProfesional);

    // Enviar los datos al backend
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
            let id = result.idPaciente;
            document.getElementById("id").value = id;
            if (newRow) {
                const idCell = newRow.insertCell(newRow.cells.length);
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

function activarDivsPorEvaluaciones(evaluacionesNav, evaluacionesIts, evaluacionesIstu) {
    // Si alguna evaluación de 'nav' es diferente de 'N/A', mostramos el div 'navDiv'
    if (evaluacionesNav.some(evaluacion => evaluacion !== 'N/A')) {
        document.getElementById('navDiv').style.display = 'block';
        // Marcar el radioButton correspondiente para 'nav'
        const navRadio = document.querySelector('input[name="ventilacion"][value="si"]');
        if (navRadio) {
            navRadio.checked = true; // Marcar como seleccionado
        }
    } else {
        document.getElementById('navDiv').style.display = 'none';
    }

    // Mostrar/ocultar el div 'itsDiv' según las evaluaciones
    if (evaluacionesIts.some(evaluacion => evaluacion !== 'N/A')) {
        document.getElementById('itsDiv').style.display = 'block';
        // Marcar el radioButton correspondiente para 'its'
        const itsRadio = document.querySelector('input[name="cvc"][value="si"]');
        if (itsRadio) {
            itsRadio.checked = true; // Marcar como seleccionado
        }
    } else {
        document.getElementById('itsDiv').style.display = 'none';
    }

    // Mostrar/ocultar el div 'istuDiv' según las evaluaciones
    if (evaluacionesIstu.some(evaluacion => evaluacion !== 'N/A')) {
        document.getElementById('istuDiv').style.display = 'block';
        // Marcar el radioButton correspondiente para 'istu'
        const istuRadio = document.querySelector('input[name="sonda"][value="si"]');
        if (istuRadio) {
            istuRadio.checked = true; // Marcar como seleccionado
        }
    } else {
        document.getElementById('istuDiv').style.display = 'none';
    }
}
//FUNCION PARA EDITAR LA TABLA 
function editarFila(row) {
    if (isEditMode) {
        // Si ya está en modo de edición, evitar nueva edición hasta que se guarde
        Swal.fire({
            title: "Edición en progreso",
            text: "Guarde o cancele la edición actual antes de continuar.",
            icon: "warning"
        });
        return;
    }

    isEditMode = true; // Marcar que estamos en modo de edición

    // Extraer las celdas de la fila seleccionada en la tabla "registros"
    const cells = row.querySelectorAll('td');
    const evaluaciones = [];
    const cumplimientos = [];

    // Extraer los valores de las evaluaciones de la fila de la tabla "registros"
    for (let i = 10; i < cells.length - 4; i++) {
        evaluaciones.push(cells[i].textContent.trim());
    }
    // for (let i = 10; i < cells.length - 3; i++) {
    //     evaluaciones.push(cells[i].textContent.trim());
    // }

    // Extraer los valores de cumplimiento
    const cumplimiento1 = cells[cells.length - 21].textContent.trim(); // Cumplimiento neav
    const cumplimiento2 = cells[cells.length - 13].textContent.trim(); // Cumplimiento its
    const cumplimiento3 = cells[cells.length - 6].textContent.trim(); // Cumplimiento istu
    cumplimientos.push(cumplimiento1, cumplimiento2, cumplimiento3);
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
    document.getElementById("nombrePaciente").value = cells[4].textContent.trim();
    document.getElementById("edad").value = cells[5].textContent.trim();
    document.getElementById("sexo").value = cells[6].textContent.trim();
    document.getElementById("ubicacion").value = cells[7].textContent.trim();
    document.getElementById("cama").value = cells[8].textContent.trim();
    document.getElementById("entidad").value = cells[9].textContent.trim();
    document.getElementById("Observaciones").value = cells[cells.length - 5].textContent.trim(); 
    document.getElementById("id").value = cells[cells.length - 1].textContent.trim();

    activarDivsPorEvaluaciones(evaluaciones.slice(0, 5), evaluaciones.slice(6, 13), evaluaciones.slice(14, 20));

    // Cambiar el botón "Editar" a "Guardar"
    const editButton = row.querySelector('button');
    if (editButton) {
        editButton.textContent = "Guardar";
        editButton.onclick = function () {
            guardarEdicion(row);
            isEditMode = false; // Cambiar el modo de edición después de guardar
	    document.querySelector('input[name="ventilacion"][value="no"]').checked = true;
            document.querySelector('input[name="cvc"][value="no"]').checked = true;
            document.querySelector('input[name="sonda"][value="no"]').checked = true;
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

		    if(select.value === "si"){
                        select.style.backgroundColor = "rgb(223, 242, 191)"
                        select.style.color = "green";
                    }else if(select.value === "no"){
                        select.style.background = "rgb(255, 186, 186)";
                        select.style.color = "red";
                    }else if(select.value === "N/A"){
                        select.style.color = 'black';
                    }
                }
            }
        });
    }
}

let evaluacionesEdicion = [];
function guardarEdicion(row) {
    // estado = 'PENDIENTE';
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
            console.error("No se encontró la tabla con id ${tabId}.");
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
    const nombre = document.getElementById("nombrePaciente").value.trim();
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
        const radios = document.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => {
            radio.checked = false;
        });
        document.getElementById('navDiv').style.display = 'none';
        document.getElementById('itsDiv').style.display = 'none';
        document.getElementById('istuDiv').style.display = 'none';
        document.getElementById("episodio").value = "";
        document.getElementById("nroDoc").value = "";
        document.getElementById("nombrePaciente").value = "";
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
    function compactarJSON(json) {
        let jsonCompacto = {};
        for (let clave in json) {
            let claveLimpia = clave.replace(/\s+/g, ' ').trim(); // Eliminar espacios y saltos de línea
            jsonCompacto[claveLimpia] = json[clave];
        }
        return jsonCompacto;
    }
    jsonEvaluacionesNav = compactarJSON(jsonEvaluacionesNav);
    jsonEvaluacionesIts = compactarJSON(jsonEvaluacionesIts);
    jsonEvaluacionesIstu = compactarJSON(jsonEvaluacionesIstu);
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
            document.querySelector('input[name="ventilacion"][value="no"]').checked = true;
            document.querySelector('input[name="cvc"][value="no"]').checked = true;
            document.querySelector('input[name="sonda"][value="no"]').checked = true;
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
            if (estadoCell.textContent === "PENDIENTE") {
                estadoCell.textContent = "FINALIZADO";

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
