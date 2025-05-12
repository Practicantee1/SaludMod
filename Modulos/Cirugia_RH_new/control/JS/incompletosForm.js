$(document).ready(function() {
    // Llama a la función de consulta o cualquier otra función al cargar el documento
    consultar();

    // Manejador de eventos para el botón "Completar"
    $('#registroTablaBody').on('click', '.btnCompletar', function(e) {
        e.preventDefault(); // Prevenir la acción por defecto del enlace
        var id_paciente = $(this).data('id_paciente'); // Obtener el id_paciente del atributo data
        console.log(id_paciente); // Para verificar el valor capturado
        completarFormulario(id_paciente); // Llamar a la función de completar formulario
    });
});

function consultar() {
    $.ajax({
        type: "POST",
        url: '../logica/formRegistrosIncompletosSQL.php',
        success: function(response) {
            if (Array.isArray(response)) {
                if (response.length > 0) {
                    var tableBody = $('#registroTablaBody');
                    tableBody.empty(); // Limpiar cualquier fila existente

                    // Iteramos sobre la respuesta para agregar cada fila a la tabla
                    response.forEach(function(item) {
                        console.log(item); // Para verificar el objeto
                        var row = '<tr>' +
                            '<td class="text-center">' + item.fecha_cirugía + '</td>' +
                            '<td class="text-center">' + item.Episodio + '</td>' +
                            '<td class="text-center">' + item.Numero_identificacion + '</td>' +
                            '<td class="text-center">' + item.Nombre_paciente + '</td>' +
                            '<td class="text-center estado">' + wrapEstado(item.entrada) + '</td>' +
                            '<td class="text-center estado">' + wrapEstado(item.pausa) + '</td>' +                           
                            '<td class="text-center estado">' + wrapEstado(item.salida) + '</td>' +
                            '<td class="text-center estado">' + wrapEstado(item.firmaEntrada) + '</td>' +
                            '<td class="text-center estado">' + wrapEstado(item.firmaSalida) + '</td>' +
                            '<td class="text-center">' +
                                '<a href="#" class="btn btn-primary btnCompletar" data-id_paciente="' + item.id_paciente + '">Completar</a>' +
                            '</td>' +
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

function wrapEstado(estado) {
    if (estado === 'PENDIENTE') {
        return '<span class="tabla-yellow">' + estado + '</span>';
    } else if (estado === 'COMPLETADO') {
        return '<span class="tabla-green">' + estado + '</span>';
    } else {
        return estado; // Si no es "pendiente" ni "completado", simplemente devuelve el estado
    }
}

function completarFormulario(id_paciente) {
    // Redirige al usuario con el parámetro id_paciente en la URL
    window.location.href = "../view/cirugiaCompletar.php?id_paciente=" + encodeURIComponent(id_paciente);
}
