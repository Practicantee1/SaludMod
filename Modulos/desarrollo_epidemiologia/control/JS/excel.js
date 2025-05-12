function mostrarFiltroFecha() {
    $('#tablaFormularios tbody').empty(); 
    document.getElementById('tablaFormularios').hidden = true;
    ocultarTodosFiltros();
    document.getElementById('fechaFiltro').style.display = 'block';
    // getUsuarioDeCookie();
}
function mostrarFiltroEpisodio() {
    $('#tablaFormularios tbody').empty(); 
    document.getElementById('tablaFormularios').hidden = true;
    ocultarTodosFiltros();
    document.getElementById('episodioFiltro').style.display = 'block';
}
function mostrarFiltroIdentificacion() {
    $('#tablaFormularios tbody').empty(); 
    document.getElementById('tablaFormularios').hidden = true;
    ocultarTodosFiltros();
    document.getElementById('identificacionFiltro').style.display = 'block';
}
function mostrarFiltroUsuario() {
    $('#tablaFormularios tbody').empty(); 
    // document.getElementById('tablaFormularios').hidden = true;
    ocultarTodosFiltros();
    document.getElementById('usuarioFiltro').style.display = 'block';
}
function ocultarTodosFiltros() {
    var filtros = document.querySelectorAll('.filtro');
    filtros.forEach(function(f) {
        f.style.display = 'none';
    });
}

function mostrarTablaUsuario(usu) {
    document.getElementById('tablaFormularios').hidden = false;
    document.getElementById('botonExcel4').style.display = 'block';
    console.log(usu)
    llenarHistoricoExcelUsuario(usu);
}

function mostrarTablaFecha() {  
    var fechaInicio = document.getElementById("fechaInicio").value || "N/A";
    var fechaFinal = document.getElementById("fechaFin").value || "N/A";
    if (fechaInicio === "N/A" || fechaFinal === "N/A") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, ingresa un rango de fechas.',
        });
        return;
    }
    document.getElementById('tablaFormularios').hidden = false;
    document.getElementById('botonExcel').style.display = 'block';
    llenarHistoricoExcelFechas(fechaInicio, fechaFinal)
}
function mostrarTablaIdentificacion() {
    var identificacion = document.getElementById("identificacion").value || "N/A"; 
    if (!identificacion || identificacion === "N/A") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, ingresa un numero de identificacion.',
        });
        return;
    }
    document.getElementById('tablaFormularios').hidden = false;
    document.getElementById('botonExcel2').style.display = 'block';
    llenarHistoricoExcelIdentificacion(identificacion)
}
function mostrarTablaEpisodio() {
    var episodio = document.getElementById("episodio").value || "N/A"; 
    if (!episodio || episodio === "N/A") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor, ingresa un numero de episodio.',
        });
        return;
    }
    document.getElementById('tablaFormularios').hidden = false;
    document.getElementById('botonExcel3').style.display = 'block';
    llenarHistoricoExcelEpisodio(episodio);
}

function llenarHistoricoExcelUsuario(usuario) {
    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/desarrollo_epidemiologia/logica/usuario.php',
        data: { usuario: usuario },
        dataType: "json",
        success: function(response) {
            console.log("Respuesta del servidor:", response);  // Depuración: Verificar la respuesta

            if (response.excelUsuario && response.excelUsuario.length > 0) {
                $('#tablaFormularios tbody').empty(); // Limpiar la tabla antes de llenarla

                response.excelUsuario.forEach(function(excelId) {
                    let newRow = `<tr>
                        <td style="text-align: center;">${excelId.fecha || ''}</td>
                        <td style="text-align: center;">${excelId.hora || ''}</td>
                        <td style="text-align: center;">${excelId.episodio || ''}</td>
                        <td style="text-align: center;">${excelId.numero_documento || ''}</td>
                        <td style="text-align: center;">${excelId.nombre || ''}</td>
                        <td style="text-align: center;">${excelId.edad || ''}</td>
                        <td style="text-align: center;">${excelId.genero || ''}</td>
                        <td style="text-align: center;">${excelId.ubicacion || ''}</td>
                        <td style="text-align: center;">${excelId.cama || ''}</td>
                        <td style="text-align: center;">${excelId.entidad || ''}</td>`;

                    // Procesar evaluaciones de NAV dinámicamente
                    if (excelId.evaluacionesnav && Object.keys(excelId.evaluacionesnav).length > 0) {
                        Object.keys(excelId.evaluacionesnav).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelId.evaluacionesnav[key] || ''}</td>`;
                        });
                    }
                    
                    if (excelId.evaluacionesits && Object.keys(excelId.evaluacionesits).length > 0) {
                        Object.keys(excelId.evaluacionesits).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelId.evaluacionesits[key] || ''}</td>`;
                        });
                    }
                    
                    if (excelId.evaluacionesistu && Object.keys(excelId.evaluacionesistu).length > 0) {
                        Object.keys(excelId.evaluacionesistu).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelId.evaluacionesistu[key] || ''}</td>`;
                        });
                    }
                    

                    // Añadir el campo de observaciones al final de la fila
                    newRow += `<td style="text-align: center;">${excelId.observaciones || ''}</td>`;
                    newRow += `</tr>`;

                    $('#tablaFormularios tbody').prepend(newRow); // Añadir la fila a la tabla
                });
            } else {
                console.log("No se encontraron datos.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}
function llenarHistoricoExcelIdentificacion(identificacion) {
    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/desarrollo_epidemiologia/logica/identificacion.php',
        data: { identificacion: identificacion },
        dataType: "json",
        success: function(response) {
            console.log("Respuesta del servidor:", response);  // Depuración: Verificar la respuesta

            if (response.excelIdentificacion && response.excelIdentificacion.length > 0) {
                $('#tablaFormularios tbody').empty(); // Limpiar la tabla antes de llenarla

                response.excelIdentificacion.forEach(function(excelId) {
                    let newRow = `<tr>
                        <td style="text-align: center;">${excelId.fecha || ''}</td>
                        <td style="text-align: center;">${excelId.hora || ''}</td>
                        <td style="text-align: center;">${excelId.episodio || ''}</td>
                        <td style="text-align: center;">${excelId.numero_documento || ''}</td>
                        <td style="text-align: center;">${excelId.nombre || ''}</td>
                        <td style="text-align: center;">${excelId.edad || ''}</td>
                        <td style="text-align: center;">${excelId.genero || ''}</td>
                        <td style="text-align: center;">${excelId.ubicacion || ''}</td>
                        <td style="text-align: center;">${excelId.cama || ''}</td>
                        <td style="text-align: center;">${excelId.entidad || ''}</td>`;

                    // Procesar evaluaciones de NAV dinámicamente
                    if (excelId.evaluacionesnav && Object.keys(excelId.evaluacionesnav).length > 0) {
                        Object.keys(excelId.evaluacionesnav).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelId.evaluacionesnav[key] || ''}</td>`;
                        });
                    }
                    
                    if (excelId.evaluacionesits && Object.keys(excelId.evaluacionesits).length > 0) {
                        Object.keys(excelId.evaluacionesits).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelId.evaluacionesits[key] || ''}</td>`;
                        });
                    }
                    
                    if (excelId.evaluacionesistu && Object.keys(excelId.evaluacionesistu).length > 0) {
                        Object.keys(excelId.evaluacionesistu).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelId.evaluacionesistu[key] || ''}</td>`;
                        });
                    }
                    

                    // Añadir el campo de observaciones al final de la fila
                    newRow += `<td style="text-align: center;">${excelId.observaciones || ''}</td>`;
                    newRow += `</tr>`;

                    $('#tablaFormularios tbody').prepend(newRow); // Añadir la fila a la tabla
                });
            } else {
                console.log("No se encontraron datos.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}
function llenarHistoricoExcelEpisodio(episodio) {
    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/desarrollo_epidemiologia/logica/episodio.php',
        data: { episodio: episodio },
        dataType: "json",
        success: function(response) {
            console.log("Respuesta del servidor:", response);  // Depuración: Verificar la respuesta

            if (response.excelEpisodio && response.excelEpisodio.length > 0) {
                $('#tablaFormularios tbody').empty(); // Limpiar la tabla antes de llenarla

                response.excelEpisodio.forEach(function(excelEpi) {
                    let newRow = `<tr>
                        <td style="text-align: center;">${excelEpi.fecha || ''}</td>
                        <td style="text-align: center;">${excelEpi.hora || ''}</td>
                        <td style="text-align: center;">${excelEpi.episodio || ''}</td>
                        <td style="text-align: center;">${excelEpi.numero_documento || ''}</td>
                        <td style="text-align: center;">${excelEpi.nombre || ''}</td>
                        <td style="text-align: center;">${excelEpi.edad || ''}</td>
                        <td style="text-align: center;">${excelEpi.genero || ''}</td>
                        <td style="text-align: center;">${excelEpi.ubicacion || ''}</td>
                        <td style="text-align: center;">${excelEpi.cama || ''}</td>
                        <td style="text-align: center;">${excelEpi.entidad || ''}</td>`;

                    // Procesar evaluaciones de NAV dinámicamente
                    if (excelEpi.evaluacionesnav) {
                        Object.keys(excelEpi.evaluacionesnav).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excelEpi.evaluacionesnav[key] || ''}</td>`;                       
                        });
                    }

                    // Procesar evaluaciones de ITS dinámicamente
                    if (excelEpi.evaluacionesits) {
                        Object.keys(excelEpi.evaluacionesits).forEach(function(key) {                  
                            newRow += `<td style="text-align: center;">${excelEpi.evaluacionesits[key] || ''}</td>`;
                        });
                    }

                    // Procesar evaluaciones de ISTU dinámicamente
                    if (excelEpi.evaluacionesistu) {
                        Object.keys(excelEpi.evaluacionesistu).forEach(function(key) {                         
                            newRow += `<td style="text-align: center;">${excelEpi.evaluacionesistu[key] || ''}</td>`;                           
                        });
                    }

                    // Añadir el campo de observaciones al final de la fila
                    newRow += `<td style="text-align: center;">${excelEpi.observaciones || ''}</td>`;
                    newRow += `</tr>`;

                    $('#tablaFormularios tbody').prepend(newRow); // Añadir la fila a la tabla
                });
            } else {
                console.log("No se encontraron datos.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}
function llenarHistoricoExcelFechas(fechaInicio, fechaFinal) {
    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/desarrollo_epidemiologia/logica/fechas.php',
        data: {
            fechaInicio: fechaInicio,
            fechaFinal: fechaFinal
        },
        dataType: "json",
        success: function(response) {
            if (!response || !response.excelFechas) {
                console.error("Datos no recibidos correctamente:", response);
            }
            console.log("Respuesta del servidor:", response);  // Depuración: Verificar la respuesta

            if (response.excelFechas && response.excelFechas.length > 0) {
                $('#tablaFormularios tbody').empty(); // Limpiar la tabla antes de llenarla

                response.excelFechas.forEach(function(excel) {
                    let newRow = `<tr>
                        <td style="text-align: center;">${excel.fecha || ''}</td>
                        <td style="text-align: center;">${excel.hora || ''}</td>
                        <td style="text-align: center;">${excel.episodio || ''}</td>
                        <td style="text-align: center;">${excel.numero_documento || ''}</td>
                        <td style="text-align: center;">${excel.nombre || ''}</td>
                        <td style="text-align: center;">${excel.edad || ''}</td>
                        <td style="text-align: center;">${excel.genero || ''}</td>
                        <td style="text-align: center;">${excel.ubicacion || ''}</td>
                        <td style="text-align: center;">${excel.cama || ''}</td>
                        <td style="text-align: center;">${excel.entidad || ''}</td>`;

                    // Procesar evaluaciones de NAV dinámicamente
                    if (excel.evaluacionesnav && Object.keys(excel.evaluacionesnav).length > 0) {
                        Object.keys(excel.evaluacionesnav).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excel.evaluacionesnav[key] || ''}</td>`;
                        });
                    }
                    
                    if (excel.evaluacionesits && Object.keys(excel.evaluacionesits).length > 0) {
                        Object.keys(excel.evaluacionesits).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excel.evaluacionesits[key] || ''}</td>`;
                        });
                    }
                    
                    if (excel.evaluacionesistu && Object.keys(excel.evaluacionesistu).length > 0) {
                        Object.keys(excel.evaluacionesistu).forEach(function(key) {
                            newRow += `<td style="text-align: center;">${excel.evaluacionesistu[key] || ''}</td>`;
                        });
                    }

                    // Añadir el campo de observaciones al final de la fila
                    newRow += `<td style="text-align: center;">${excel.observaciones || ''}</td>`;
                    newRow += `</tr>`;

                    $('#tablaFormularios tbody').prepend(newRow); // Añadir la fila a la tabla
                });
            } else {
                console.log("No se encontraron datos.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function descargarExcel() {
    // Seleccionar la tabla
    var tabla = document.getElementById('tablaFormularios');

    // Verificar si la tabla tiene contenido
    if (!tabla || tabla.hidden) {
        alert('No hay datos para exportar.');
        return;
    }

    // Crear una hoja de trabajo a partir de la tabla
    var ws = XLSX.utils.table_to_sheet(tabla);

    // Crear un libro de trabajo
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Datos Tabla');

    // Exportar el libro de trabajo a un archivo Excel
    XLSX.writeFile(wb, 'Datos_Tabla.xlsx');
}
