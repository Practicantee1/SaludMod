$(document).ready(function() {
    $('#agregarLinea').on('keypress', function(e) {
        if(e.which === 13) { // Código para el ENTER
            e.preventDefault();
            $("#episodio").attr("readonly", true);
            verificacion(this);
        }
    });
});

function verificacion(form) {
    $.ajax({
        type: "POST",
        url: '../Control/odonto.php',
        data: $(form).serialize(),
        success: function(response) {
            //console.log("Response received:", response); // Depuración
            try {
                var quickScript = new Function(response);
                quickScript(); // Evalúa el código recibido como respuesta
            } catch (error) {
                console.error("Error executing response script:", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", error);
        }
    });
}
