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
                url: '../Logica/registrosSQL.php', // Cambia esto por la URL de tu archivo PHP
                type: 'POST',
                data: { valor: buscarValor },
                success: function(response) {
                    if (Array.isArray(response)) {
                        if (response.length > 0) {
                            var tableBody = $('#registroTablaBody');
                            tableBody.empty(); // Limpiar filas existentes
                
                            response.forEach(function (item) {
                                var row = `
                                    <tr>
                                        <td class="text-center">${item.fecha_cirugía || ''}</td>
                                        <td class="text-center">${item.Episodio || ''}</td>
                                        <td class="text-center">${item.Numero_identificacion || ''}</td>
                                        <td class="text-center">${item.Nombre_paciente || ''}</td>
                                        <td class="text-center">${item.Aseguradora || ''}</td>
                                        <td class="text-center">${item.Nombre_cirujano || ''}</td>
                                        <td class="text-center">${item.Especialidad || ''}</td>
                                        <td class="text-center">${item.Observaciones || ''}</td>
                                        <td class="text-center">${item.diagnosticoNombre || ''}</td>
                                        <td class="text-center">${item.nombre_casaComer || ''}</td>                                        
                                        <td class="text-center">${item.tipoImplante || ''}</td>
                                        <td class="text-center">${item.entrenamiento_Soport || ''}</td>
                                        <td class="text-center">${item.tiempo_Soporte || ''}</td>
                                        <td class="text-center">${item.material_complet || ''}</td>
                                        <td class="text-center">${item.falla_implant_cx || ''}</td>
                                        <td class="text-center">${item.impl_tiempo_corpaul || ''}</td>
                                        <td class="text-center">${item.impl_completo_corpaul || ''}</td>
                                    </tr>`;
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
                            text: "No se no se encuentran registros!",
                        });
                    }
                },
                
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
    XLSX.writeFile(wb, 'implante_formulario.xlsx');
}

