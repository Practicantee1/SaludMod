<?php
ob_start();
session_start();
if(!isset($_GET['log']) || $_GET['log'] == ""){
  $login = '';
  $readonly = '';
}
else{
  $login = $_GET['log'];
  $readonly = 'readonly';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="shortcut icon" href="..\favicon.ico" type="image/x-icon">
  <title>Cambiar Contraseña</title>
</head>
<body>
<div class="content-wrapper">
  <div id="alertContainer" class="alert" role="alert"></div>
  <div class="container">
      <div class="col-md-15">
        <div class="card shadow p-3 mb-8" >
          <div class="card-header">
              <div class="row" id="MainTittle-Incapacidad">
                <div class="col-20 text-center top: -15px;">
                  <h2 class="text-success " style="margin-top: 15px;">Cambiar contraseña</h2>
                </div>  
              </div> 

              <br>
              
                <br>
            <form id="cambiar_contraseña" method="POST" action="../controller/cambiar_contraseña.php">
            
            
            <div class="row">
                <div class="col-md-6">
                <center><label style="color:black" for="user" class="form-label"><strong>Nombre de usuario</strong></label></center>
                <input type="text" onblur="consultarPregunta()" name="login" id="login" placeholder="" class="form-control" value="<?php echo $login?>" <?php echo $readonly?> >
                </div>
            </div>

            <div class="row titles" style="margin-top: 50px">
                <div class="col">
                  <div class="well">
                    <center><h4 class="form-label"><span class="left-span"></span>Responder pregunta secreta</span></h4></center>
                  </div>
                </div>
              </div>
              <div class="row  row">
                <div class="col-md-6">
                <center><label style="color:black" for="Question" class="form-label"><strong>Pregunta Secreta:</strong></label></center>
                <input type="text" name="pregunta" id="pregunta" class="form-control"  readonly>
                </div>

                <div class="col-md-6">
                  <center><label style="color:black" for="Respuesta" class="form-label"><strong>Ingrese la respuesta</strong></label></center>
                  <input type="text" name="respuesta" id="respuesta" placeholder="Registre aquí" class="form-control" oninput="checkInput(this)" required>
                  </div>
                </div>
                <br>
              
              <br>
              <div class="row titles">
                <div class="col">
                  <div class="well">
                    <center><h4 class="form-label"><span class="left-span"></span>Configurar contraseña</span></h4></center>
                  </div>
                </div>
              </div>

              <div class="row  row">
                <div class="col-md-6">
                    <center><label style="color:black" for="NewContraseña" class="form-label"><strong>Nueva contraseña</strong></label></center>
                  <input type="password" name="clave" id="clave" class="form-control bg-white" placeholder="Ingrese la contraseña" required>
                </div>
                 
                <div class="col-md-6">
                  <center><label style="color:black"  for="ConfirmarContraseña" class="form-label"><strong>Confirmar contraseña</strong></label></center>
                    <input type="password" name="Nuevaclave" id="Nuevaclave"  class="form-control" placeholder="Confirmar contraseña" oninput="checkPasswordMatch()" required>
                    <div id="passwordMatchAlert" style="color:red; display:none;">Las contraseñas no coinciden</div> 
                </div>
              </div>
              <br>
                <br>
                  <div class="row row">                    
                    <center><button type="button" id="enviar" class="btn" onclick="ConfirmarContraseña();" style="background-color: #428E3F; color:white">Enviar</button>
                    <button type="button" id="regresar" class="btn btn-danger" onclick="returnToLogin();" style="margin-left: 10px;">Regresar</button></center>
                  </div>
                  </form>
              </div>
            </div>
         </div>
        </div>
      </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

//Al ingresar el nombre de usuario o la información al darle Enter o tab se muestra la pregunta que ingreso el usuario y se mostrara en el campo pregunta
$(document).ready(function(){
  var login = $("#login").val();
  if(login !== ""){
    consultarPregunta();
  }
  

    // Cuando se haga clic en el botón "Consultar Pregunta Secreta"
    $("#login").keydown(function(event){
        if (event.keyCode === 13 || event.keyCode === 9) { // 13 es el código de tecla para "Enter", 9 es para "Tab"
            event.preventDefault(); // Previene la acción por defecto del Enter o Tab (que sería enviar el formulario o cambiar de campo)
            consultarPregunta(); // Llama a la función para mostrar la pregunta secreta
        }
    });

    // Función para consultar la pregunta secreta
    

});

function returnToLogin() {
  logueado = false;
  <?php 
  if(isset($_SESSION['nombre'])){
    ?>
    logueado = true;
    <?php
  }
  ?>
  if(logueado){
    window.location.href = "escritorio.php";
  }
  else{
    window.location.href = "login.php";
  }
  
}

function consultarPregunta() {
        var login = $("#login").val(); // Obtener el nombre de usuario ingresado

        // Realizar la solicitud AJAX
        $.ajax({
            type: "POST",
            url: "../controller/cambiar_contraseña.php", // Archivo PHP que maneja la consulta a la base de datos
            data: {login: login}, // Datos a enviar
            success: function(response){
                // Mostrar la pregunta secreta devuelta por el servidor en el campo de entrada correspondiente
                $("#pregunta").val(response);
            }
        });
    }

    function checkInput(input) {
    //Convierte el valor de entrada a mayúsculas
    input.value = input.value.toUpperCase();

    // Elimina todos los caracteres que no sean alfabéticos (incluidos los espacios) del valor de entrada
    input.value = input.value.replace(/[^A-Z0-9\s]/g, '');
    
  }

  function checkPasswordMatch() {e
        var password = document.getElementById("clave").value;
        var confirmPassword = document.getElementById("Nuevaclave").value;
        var passwordMatchAlert = document.getElementById("passwordMatchAlert");

        if (password !== confirmPassword) {
        document.getElementById("passwordMatchAlert").style.display = "block";
        return false; // Evita que el formulario se envíe si las contraseñas no coinciden
    } else {
            passwordMatchAlert.style.display = "none"; // Oculta la alerta
        }
    }

  function ConfirmarContraseña() {
    var respuesta = document.getElementById("respuesta").value;
    var password = document.getElementById("clave").value;
    var confirmPassword = document.getElementById("Nuevaclave").value;
    var form = document.getElementById("cambiar_contraseña");

        // Verificar si los campos de contraseña están vacíos
    if (password.trim() === '' || confirmPassword.trim() === '') {
        // Mostrar mensaje de error si los campos de contraseña están vacíos
        Swal.fire({
            title: "Error",
            text: "Por favor, Complete Todos Los Campos.",
            icon: "error",
            timer: 2000

        });

      }else{
        if (password !== confirmPassword) {
            Swal.fire({
            title: "Contraseñas no coinciden",
            text: "Contraseñas no coinciden",
            icon: "error",
            timer: 2000
          });     
        } 
        else {
          if (password === "1234") {
            Swal.fire({
              text: "Debes colocar otra contraseña diferente",
              icon: "error",
              timer: 2000
            });
          } else {
            
              var form = document.getElementById("cambiar_contraseña");
              var RealForm = new FormData(form);
              RealForm.append("respuesta", respuesta);
              $.ajax({
                type: "POST",
                url: "../controller/cambiar_contraseña.php", // Reemplaza 
                data: RealForm,
                processData: false,
                contentType: false,
                success: function(response){
                  // Manejar la respuesta del servidor
                  if (response === "ANSWER") { // Corregido "reapuesta" por "respuesta"
                    // Si la respuesta es correcta, llamar a la función para confirmar la contraseña
                    confirmar_respuesta()
                  } else {
                    // Si la respuesta es incorrecta, mostrar un mensaje de error
                    Swal.fire({
                        text: "Respuesta incorrecta",
                        icon: "warning",
                        timer: 2000
                    });
                  }
                }
            });
          }
    
    
        }
    }
      
}
          
function confirmar_respuesta() {
  var respuesta = document.getElementById("respuesta").value;
  var password = document.getElementById("clave").value;
  var form = document.getElementById("cambiar_contraseña");
  var RealForm = new FormData(form);

  RealForm.append("clave", password);
  RealForm.append("SAVE", "SAVE");

  // Realizar la solicitud AJAX para verificar la respuesta
  $.ajax({
      type: "POST",
      url: "../controller/cambiar_contraseña.php", // Reemplaza 
      data: RealForm,
      processData: false,
      contentType: false,
      success: function(response){
        // Manejar la respuesta del servidor
        if (response === "SAVED") { // Corregido "reapuesta" por "respuesta"
          Swal.fire({
              text: "Contraseña guardada con exito",
              icon: "success",
              timer: 2000
          });
          setTimeout(function(){
            window.location.href = "login.php";
          },2000);

        } else {
          console.log(response);
          // Si la respuesta es incorrecta, mostrar un mensaje de error
          Swal.fire({
              text: "Error al guardar la contraseña",
              icon: "warning",
              timer: 2000
          });
        }
      }
  });
}

</script>



</body>
</html>



<?php
?>


<?php 

ob_end_flush();
?>



<script>
  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>


