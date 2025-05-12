$(document).ready(function() {
    // Función para obtener parámetros de la URL
    function obtenerParametroUrl(nombre) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(nombre);
    }

    // Obtener el valor de id_paciente desde la URL
    const id_paciente = obtenerParametroUrl('id_paciente');

    console.log("Valor del parámetro id_paciente:", id_paciente); // Verificar el valor

    if (id_paciente) {
        $('#id_paciente').val(id_paciente); // Rellenar el campo del formulario
        console.log("ID Paciente:", id_paciente);
        consultarFS(id_paciente); // Llamar a la función con el ID
    } else {
        console.log("id_paciente es null o vacío");
    }
});

function consultarFS(id_paciente) {
    $.ajax({
        type: "POST",
        url: '../logica/participanteSalidaSQL.php',
        data: { id_paciente: id_paciente },
        dataType: "json",
        success: function(response) {
            if (Array.isArray(response)) {
                if (response.length > 0) {
                    console.log("Data:", response);

                    var tableBody = $('.table-salida tbody'); // Selecciona específicamente la tabla de salida
                    tableBody.empty(); // Limpiar cualquier fila existente

                    // Asegúrate de que 'response' es un array de objetos
                    response.forEach(function(item) {
                        // Asegúrate de que las claves existen en 'item'
                        var row = '<tr>' +
                            '<td class="text-center">' + (item.cargo || '') + '</td>' +
                            '<td class="text-center">' + (item.nombre_completoS || '') + '</td>' +
                            '<td class="text-center">' + (item.numero_documentoS || '') + '</td>' +
                            '</tr>';
                        tableBody.append(row);

                        $(document).ready(function() {
                            $('#firmaSalida').hide(); // Oculta el formulario al cargar la página
                            $('#firmas-container-salida').hide(); // Oculta el contenedor de firmas al cargar la página
                        });                    
                    });
                } else {
                    $(document).ready(function() {
                        $('.table-salida').hide(); // Oculta la tabla al cargar la página
                    });
                }
            } else {
                console.error("Invalid response format:", response);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salió mal, intenta de nuevo!",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText); // Muestra el texto completo de la respuesta
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error en la solicitud AJAX.",
            });
        }
    });
}
