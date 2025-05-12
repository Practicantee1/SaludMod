$(document).ready(function() {
    $('#PELOD2Form').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: '../Logica/GuardarPuntaje.php',
            data: $(this).serialize(),
            success: function(response){
                var quickScript = new Function($(response).text());
                quickScript();
                var txt = "SUCCESS";
                console.log(txt);
            }
  
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    var form = document.getElementById('agregarLinea');

    // Add event listener for keydown event
    form.addEventListener('keydown', function(event) {
        // Check if the pressed key is Enter (key code 13)
        if (event.keyCode === 13) {
            event.preventDefault(); // Prevent default form submission behavior
        }
    });
});

$(document).ready(function() {
    $(document).change(function(e) {
        $.ajax({
            type: "POST",
            url: '../Logica/PELOD2.php',
            data: $('#PELOD2Form').serialize(),
            success: function(response){
                var quickScript = new Function($(response).text());
                quickScript();
            }
        });
    });
});