$(document).ready(function() {
    // $('#idNumeroIdentificacion').on('keypress', function(e) {
    //     if(e.which === 13) { // Código para el ENTER
    //         e.preventDefault();
    //         let id = $("#idNumeroIdentificacion").val();
            verificacion(id);
    //     }
    // });
});

function verificacion(id) {
    console.log(id);
    $.ajax({
        type: "POST",
        url: 'http://localhost/SaludMod/Modulos/DerechoMorirDignamente/control/ApiDMD.php',
        // url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/DerechoMorirDignamente/control/ApiDMD.php',
        data: {NumeroDocumento: id} ,
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
