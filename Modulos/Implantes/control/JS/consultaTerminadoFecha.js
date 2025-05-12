$(document).ready(function () {
    $('#fechaInicio, #fechaFin').on('change', function () {
        var fechaInicio = $('#fechaInicio').val();
        var fechaFin = $('#fechaFin').val();

        // Validar si ambas fechas están seleccionadas
        if (fechaInicio && fechaFin) {
            if (new Date(fechaInicio) > new Date(fechaFin)) {
                Swal.fire({
                    icon: "error",
                    title: "Fechas inválidas",
                    text: "La fecha de inicio no puede ser mayor que la fecha de fin.",
                });
                return;
            }

            document.getElementById("buscarCampo").value = ""; // Si tienes un campo específico que limpiar
            console.log("Fecha Inicio: " + fechaInicio + ", Fecha Fin: " + fechaFin);

            $.ajax({
                url: '../Logica/terminadosImplanteFechaSQL.php', // Asegúrate de que esta ruta sea correcta
                type: 'POST',
                data: { inicio: fechaInicio, fin: fechaFin },
                dataType: 'json', // Asegúrate de especificar que esperas JSON
                success: function (response) {
                    console.log("Respuesta recibida:", response); // Para depuración

                    if (Array.isArray(response)) {
                        if (response.length > 0) {
                            var tableBody = $('#registroTablaBody');
                            tableBody.empty(); // Limpiar filas existentes

                            response.forEach(function (item) {
                                var row = `
                                    <tr>
                                        <td class="text-center">${item.fecha_cirugía}</td>
                                        <td class="text-center">${item.Episodio}</td>
                                        <td class="text-center">${item.Numero_identificacion}</td>
                                        <td class="text-center">${item.Nombre_paciente}</td>
                                        <td class="text-center">${item.Aseguradora}</td>
                                        <td class="text-center">${item.Nombre_cirujano}</td>
                                        <td class="text-center">${item.Especialidad}</td>
                                        <td class="text-center">${item.Observaciones}</td>
                                        <td class="text-center">${item.diagnosticoNombre}</td>
                                        <td class="text-center">${item.nombre_casaComer}</td>                                        
                                        <td class="text-center">${item.tipoImplante}</td>
                                        <td class="text-center">${item.entrenamiento_Soport}</td>
                                        <td class="text-center">${item.tiempo_Soporte}</td>
                                        <td class="text-center">${item.material_complet}</td>
                                        <td class="text-center">${item.falla_implant_cx}</td>
                                        <td class="text-center">${item.impl_tiempo_corpaul}</td>
                                        <td class="text-center">${item.impl_completo_corpaul}</td>
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
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud:', textStatus, errorThrown);
                    console.error('Detalles de jqXHR:', jqXHR.responseText); 
                    Swal.fire({
                        icon: "error",
                        title: "Error en la solicitud",
                        text: "Por favor, verifica la conexión o intenta de nuevo más tarde.",
                    });
                }
            });
        } else {
            console.warn("Ambas fechas deben estar seleccionadas.");
            // Puedes mostrar una advertencia si es necesario
            // Swal.fire({
            //     icon: "warning",
            //     title: "Fechas requeridas",
            //     text: "Por favor, selecciona ambas fechas.",
            // });
        }
    });
});
