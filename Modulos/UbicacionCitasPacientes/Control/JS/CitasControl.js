$(document).ready(function() {
    $('#ConsultaCitaForm').submit(function(e) {
      e.preventDefault();
      llenarUbicacion(this);
      
    });
  });


  function llenarUbicacion(form){
    $.ajax({
      type: "POST",
      url: '../Control/LlenarCitas.php',
      data: $(form).serialize(),
      success: function(response){
        var quickScript = new Function($(response).text());
        quickScript();
        
      },
      error: function(response) {
        /* var txt = "ERROR";
        console.log(txt);
        console.log(response); */
      } 

    });
    

  }