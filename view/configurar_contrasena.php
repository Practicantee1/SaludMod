<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="shortcut icon" href="..\favicon.ico" type="image/x-icon">
  <title>Configurar contraseña</title>
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
                  <h2 class="text-success " style="margin-top: 15px;">Configurar contraseña</h2>
                </div>  
              </div> 

              <br>
              
                <br>
            <form id="configurar_contraseña" method="POST" action="../controller/guardar_pregunta.php">

            <div class="row  row">
                <div class="col-md-6">
                <center><label style="color:black" for="name" class="form-label"><strong>Ingrese el nombre de usuario</strong></label></center>
                <input type="text" name="login" id="login" placeholder="Registre aquí" class="form-control" value="<?php echo $_SESSION['login'];?>" readonly>
                </div>
            </div>

            <div class="row titles" style="margin-top: 50px">
                <div class="col">
                  <div class="well">
                    <center><h4 class="form-label "><span class="left-span"></span><span>Configurar pregunta secreta</span></h4></center>
                  </div>
                </div>
              </div>

              <div class="row  row">
                <div class="col-md-6">
                <center><label style="color:black" for="Question" class="form-label"><strong>Pregunta Sec</strong></label></center>
                <input type="text" name="Pregunta" id="Pregunta" placeholder="Registre aquí" class="form-control" oninput="checkInput(this)" required >
                </div>

                <div class="col-md-6">
                  <center><label style="color:black" for="Respuesta" class="form-label"><strong>Ingrese la respuesta</strong></label></center>
                  <input type="text" name="Respuesta" id="Respuesta" placeholder="Registre aquí" class="form-control" oninput="checkInput(this)" required>
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
                    <center><label style="color:black" for="form-label" class="form-label"><strong>Nueva contraseña</strong></label></center>
                  <input type="password" name="clave" id="clave" class="form-control bg-white" placeholder="Ingrese la contraseña" required>
                </div>
                 
                <div class="col-md-6">
                  <center><label style="color:black"  for="ConfirmarContraseña" class="form-label"><strong>Confirmar contraseña</strong></label></center>
                    <input type="password" name="Nuevaclave" id="Nuevaclave"  class="form-control" placeholder="Confirmar contraseña" oninput="checkPasswordMatch()" required > 
                  <div id="passwordMatchAlert" style="color:red; display:none;">Las contraseñas no coinciden</div>
                  </div>
              </div>
              <br>
              
                <br>

                  <div class="row row">                    
                    <div>
                      <center><button type="button" id="Ingresar" name="Ingresar" onclick="ConfirmarContraseña()" style="background-color: #428E3F; color:white" class="btn">Guardar</button></center> 
                    </div>
                    <div class="col-md-1"></div>
                  </form>
              </div>
            </div>
         </div>
        </div>
      </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!--Funcion para eliminar caracteres y solo agregar en mayusculas y espacios-->
<script>
function checkInput(input) {
    //Convierte el valor de entrada a mayúsculas
    input.value = input.value.toUpperCase();

    // Elimina todos los caracteres que no sean alfabéticos (incluidos los espacios) del valor de entrada
    input.value = input.value.replace(/[^A-Z0-9\s]/g, '');
    
  }

  function checkPasswordMatch() {
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
        var password = document.getElementById("clave").value;
        var confirmPassword = document.getElementById("Nuevaclave").value;
        var form = document.getElementById("configurar_contraseña");
           // Verificar si los campos de contraseña están vacíos
    if (password.trim() === '' || confirmPassword.trim() === '') {
        // Mostrar mensaje de error si los campos de contraseña están vacíos
        Swal.fire({
            title: "Error",
            text: "Por favor, Complete Todos Los Campos.",
            icon: "error",
            timer: 2000

        });
         // Evita que el formulario se envíe si los campos de contraseña están vacíos
         return false;  
      }
       if (password !== confirmPassword) {
            Swal.fire({
            title: "Contraseñas no coinciden",
            text: "Contraseñas no coinciden",
            icon: "error",
            timer: 2000
          });     
    } else {
        if (password === "1234") {
            Swal.fire({
              text: "Debes colocar otra contraseña diferente",
              icon: "error",
              timer: 2000
            });
          } else {
            Swal.fire({
              text: "Contraseña válida",
              icon: "success",
              timer: 2000
            });
            setTimeout(function(){
              form.submit();
            },2000)
          }
          
        }

        
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