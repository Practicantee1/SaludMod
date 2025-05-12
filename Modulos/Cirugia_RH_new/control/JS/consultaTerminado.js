$(document).ready(function() {
    $('#buscarCampo').on('keypress', function(event) {
        if (event.which === 13) { // 13 es el código de la tecla Enter
            event.preventDefault(); // Evitar el comportamiento por defecto del Enter
            var buscarValor = $(this).val(); // Obtener el valor del campo
            // Realizar la consulta a la base de datos mediante Ajax
            document.getElementById("fechaInicio").value = "";
            document.getElementById("fechaFin").value = "";

            console.log(buscarValor); // Imprimir el valor buscado
            $.ajax({
                url: '../logica/TerminadosSQL.php', // Cambia esto por la URL de tu archivo PHP
                type: 'POST',
                data: { valor: buscarValor },
                success: function(response) {
                    if (Array.isArray(response)) {
                        if (response.length > 0) {
                            var tableBody = $('#registroTablaBody');
                            tableBody.empty(); // Limpiar cualquier fila existente

                            // Iteramos sobre la respuesta para agregar cada fila a la tabla
                            response.forEach(function(item) {
                                var row = '<tr>' +
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
                                '<td class="text-center">' + item.patologias + '</td>' +
                                '<td class="text-center">' + item.observacionesEntrada + '</td>' +
                                '<td class="text-center">' + item.equipoHumano + '</td>' +
                                '<td class="text-center">' + item.Nombre_abordaje + '</td>' +
                                '<td class="text-center">' + item.Existen + '</td>' +
                                '<td class="text-center">' + item.Administracion + '</td>' +
                                '<td class="text-center">' + item.Plan + '</td>' +                           
                                '<td class="text-center">' + item.Anestesiologo + '</td>' +
                                '<td class="text-center">' + item.Esterilidad + '</td>' +
                                '<td class="text-center">' + item.Vo + '</td>' +
                                '<td class="text-center">' + item.Detalles_relevantes + '</td>' +
                                '<td class="text-center">' + item.T + '</td>' +
                                '<td class="text-center">' + item.perfusion + '</td>' +
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
                            var tabla = document.getElementById('tablaFormularios');
                            tabla.removeAttribute('hidden'); // Quita el atributo 'hidden'


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
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud:', textStatus, errorThrown);
                }
            });
        }
    });
});

function exportarExcel() {
    // Obtén la tabla del DOM
    let table = document.getElementById("tablaFormularios");
    
    // Inicializar un array para almacenar las filas
    let data = [];

    // Recorrer las filas de la tabla y almacenar los datos
    const rows = table.rows;
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].cells;
        let rowData = [];
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            // Agregar el contenido de la celda, asegurándonos de que las fechas sean texto
            let cellValue = cell.innerText;
            // Verifica si el contenido parece ser una fecha
            if (cellValue.match(/^\d{4}-\d{2}-\d{2}$/)) {
                rowData.push(cellValue); // Mantén la fecha como texto
            } else {
                rowData.push(cellValue); // Agregar otros valores normalmente
            }
        }
        data.push(rowData);
    }

    // Crear un nuevo libro de trabajo
    let ws = XLSX.utils.aoa_to_sheet(data); // Crear la hoja de trabajo a partir del array
    let wb = XLSX.utils.book_new(); // Crear un nuevo libro
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1"); // Agregar la hoja al libro

    // Escribe el archivo Excel
    XLSX.writeFile(wb, 'cirugia_formulario.xlsx');
}

