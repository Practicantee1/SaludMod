$(document).ready(function() {
    $('#agregarLinea').on('change', function() {
        verificacion(this);
    });
});



function verificacion(form) {
    $.ajax({
        type: "POST",
        url: '../control/ApiEpidemiologia.php',
        data: $(form).serialize(),
        success: function(response) {
            try {
                var quickScript = new Function(response);
                quickScript();
            } catch (error) {
                console.error("Error executing response script:", error);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", error);
        }
    });
}







