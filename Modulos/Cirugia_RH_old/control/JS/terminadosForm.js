$(document).ready(function() {
    // Llama a la función de consulta o cualquier otra función al cargar el documento
    consultar();

    // // Manejador de eventos para el botón "Completar"
    // $('#registroTablaBody').on('click', '.btnCompletar', function(e) {
    //     e.preventDefault(); // Prevenir la acción por defecto del enlace
    //     var episodio = $(this).data('episodio');
    //     completarFormulario(episodio);
    // });
});

function consultar() {
    $.ajax({
        type: "POST",
        url: '../logica/terminadosSQL.php',
        success: function(response) {
            if (Array.isArray(response)) {
                if (response.length > 0) {
                    // console.log("Data:", response);

                    var tableBody = $('#registroTablaBody');
                    tableBody.empty(); // Limpiar cualquier fila existente

                    // Iteramos sobre la respuesta para agregar cada fila a la tabla
                    response.forEach(function(item) {
                        var row = '<tr>' +
                            // '<td class="text-center">' +
                            //     '<a href="#" class="btn btn-primary btnCompletar" onclick="exportarExcel()">' +
                            //         '<i class="fas fa-download"></i>' + // Ícono de descarga
                            //     '</a>' +
                            // '</td>'+
                            '<td class="text-center">' + item.fecha_cirugía + '</td>' +
                            '<td class="text-center">' + item.Episodio + '</td>' +
                            '<td class="text-center">' + item.Numero_identificacion + '</td>' +
                            '<td class="text-center">' + item.Nombre_paciente + '</td>' +
                            '<td class="text-center">' + item.edad + '</td>' +
                            '<td class="text-center">' + item.sexo + '</td>' +                           
                            '<td class="text-center">' + item.Aseguradora + '</td>' +
                            '<td class="text-center">' + item.procedimiento + '</td>' +
                            '<td class="text-center">' + item.Nombre_cirujano + '</td>' +
                            '<td class="text-center">' + item.Especialidad + '</td>' +
                            '<td class="text-center">' + item.Nombre_identificacion + '</td>' +
                            '<td class="text-center">' + item.Instrumental + '</td>' +
                            '<td class="text-center">' + item.Alergia_reporta + '</td>' +
                            '<td class="text-center">' + item.Consentimiento + '</td>' +                           
                            '<td class="text-center">' + item.Marcacion + '</td>' +
                            '<td class="text-center">' + item.Seleccione + '</td>' +
                            '<td class="text-center">' + item.Verificacion + '</td>' +
                            '<td class="text-center">' + item.Confirmacion + '</td>' +
                            '<td class="text-center">' + item.Monitoreo + '</td>' +
                            '<td class="text-center">' + item.Perdida + '</td>' +
                            '<td class="text-center">' + item.Reserva + '</td>' +
                            '<td class="text-center">' + item.Disponibilidad + '</td>' +
                            '<td class="text-center">' + item.Estudios + '</td>' +
                            '<td class="text-center">' + item.Via + '</td>' +                           
                            '<td class="text-center">' + item.Antibiotico + '</td>' +
                            '<td class="text-center">' + item.Suspension + '</td>' +
                            '<td class="text-center">' + item.Comercial + '</td>' +
                            '<td class="text-center">' + item.Cultivos + '</td>' +
                            '<td class="text-center">' + item.observacionesEntrada + '</td>' +
                            '<td class="text-center">' + item.Nombre_abordaje + '</td>' +
                            '<td class="text-center">' + item.Existen + '</td>' +
                            '<td class="text-center">' + item.Administracion + '</td>' +
                            '<td class="text-center">' + item.Plan + '</td>' +                           
                            '<td class="text-center">' + item.Anestesiologo + '</td>' +
                            '<td class="text-center">' + item.Esterilidad + '</td>' +
                            '<td class="text-center">' + item.Vo + '</td>' +
                            '<td class="text-center">' + item.Observaciones_pausa + '</td>' +
                            '<td class="text-center">' + item.programada + '</td>' +
                            '<td class="text-center">' + item.complicaciones + '</td>' +
                            '<td class="text-center">' + item.conteo + '</td>' +
                            '<td class="text-center">' + item.camilla + '</td>' +
                            '<td class="text-center">' + item.muestra + '</td>' +                           
                            '<td class="text-center">' + item.posopetario + '</td>' +
                            '<td class="text-center">' + item.problemas + '</td>' +
                            '<td class="text-center">' + item.observaciones + '</td>' +                            
                            '</tr>';
                        tableBody.append(row);
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
                    text: "Algo salió mal, intenta de nuevo!",
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


function completarFormulario(episodio) {
    // Redirige al usuario con el parámetro episodio en la URL
    window.location.href = "../view/cirugiaCompletar.php?episodio=" + encodeURIComponent(episodio);
}

// aca buscamos por docmento o episodio y ponemos color al valor encontrado

function buscarTabla() {
    let input = document.getElementById("buscarCampo").value.toLowerCase().trim();
    let table = document.getElementById("tablaFormularios");
    let rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    if (input === "") {
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = "";
            limpiarResaltado(rows[i].getElementsByTagName("td")[1]);
            limpiarResaltado(rows[i].getElementsByTagName("td")[2]);
        }
        return;
    }

    for (let i = 0; i < rows.length; i++) {
        let numeroEpisodioCell = rows[i].getElementsByTagName("td")[1];
        let numeroDocumentoCell = rows[i].getElementsByTagName("td")[2];

        let numeroEpisodio = numeroEpisodioCell.innerText.toLowerCase().trim();
        let numeroDocumento = numeroDocumentoCell.innerText.toLowerCase().trim();

        limpiarResaltado(numeroEpisodioCell);
        limpiarResaltado(numeroDocumentoCell);

        if (numeroEpisodio.includes(input) || numeroDocumento.includes(input)) {
            rows[i].style.display = "";
            if (numeroEpisodio.includes(input) && numeroEpisodio !== "null" && numeroEpisodio !== "") {
                resaltarContenido(numeroEpisodioCell);
            }
            if (numeroDocumento.includes(input) && numeroDocumento !== "null" && numeroDocumento !== "") {
                resaltarContenido(numeroDocumentoCell);
            }
        } else {
            rows[i].style.display = "none";
        }
    }
}

function resaltarContenido(cell) {
    let span = document.createElement("span");
    span.classList.add("resaltado");
    span.innerText = cell.innerText;
    cell.innerHTML = "";  // Limpiar el contenido actual de la celda
    cell.appendChild(span);  // Añadir el nuevo contenido con el resaltado
}

function limpiarResaltado(cell) {
    cell.innerHTML = cell.innerText;  // Eliminar el span y dejar solo el texto
}
// busa por fecha
function buscarPorFecha() {
    let fechaInicio = new Date(document.getElementById("fechaInicio").value);
    let fechaFin = new Date(document.getElementById("fechaFin").value);
    let table = document.getElementById("tablaFormularios");
    let rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    if (isNaN(fechaInicio.getTime()) || isNaN(fechaFin.getTime())) {
        // Si alguna de las fechas no es válida, mostrar todas las filas
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = "";
        }
        return;
    }

    for (let i = 0; i < rows.length; i++) {
        let fechaCirugiaCell = rows[i].getElementsByTagName("td")[0]; // Ajusta el índice según la columna de la fecha
        let fechaCirugiaTexto = fechaCirugiaCell.innerText.trim();
        let fechaCirugia = new Date(fechaCirugiaTexto);

        if (fechaCirugia >= fechaInicio && fechaCirugia <= fechaFin) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}

function exportarExcel() {
    let table = document.getElementById("tablaFormularios");
    let wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
    XLSX.writeFile(wb, 'cirugia_rh.xlsx');
}
