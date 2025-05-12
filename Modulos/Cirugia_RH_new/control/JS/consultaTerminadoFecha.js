$(document).ready(function() {
    $('#fechaInicio, #fechaFin').on('change', function() {
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

            document.getElementById("buscarCampo").value = "";
            console.log("Fecha Inicio: " + fechaInicio + ", Fecha Fin: " + fechaFin);

            $.ajax({
                url: '../logica/terminadosFechaSQL.php',
                type: 'POST',
                data: { inicio: fechaInicio, fin: fechaFin },
                success: function(response) {
                    if (Array.isArray(response)) {
                        if (response.length > 0) {
                            var tableBody = $('#registroTablaBody');
                            tableBody.empty(); // Limpiar filas existentes

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
                                // Agregar el resto de las columnas necesarias
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
        } else {
            console.warn("Ambas fechas deben estar seleccionadas.");
        }
    });
});
