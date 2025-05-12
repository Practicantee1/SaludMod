$(document).ready(function() {
    $.ajax({
        url: '../logica/cargos.php', // Asegúrate de que esta ruta sea correcta
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Iterar sobre los datos y llenar el <select>
            $.each(data, function(index, cargo) {
                $('select[name="idCargoEntrada[]"]').append(
                    '<option value="' + cargo.id + '">' + cargo.cargo + '</option>'
                );
                $('select[name="idCargoSalida[]"]').append(
                    '<option value="' + cargo.id + '">' + cargo.cargo + '</option>'
                );
            });
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener los datos:', error);
        }
    });
});
