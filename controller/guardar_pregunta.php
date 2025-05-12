<?php
    require "../config/Conexion.php";

    if ($conexion) {
        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger los datos del formulario
            $pregunta = $_POST['Pregunta'];
            $respuesta = $_POST['Respuesta'];
            $clave = $_POST['clave'];
            $nuevaclave = $_POST['Nuevaclave'];
            $login = $_POST['login'];


            // Llamar al procedimiento almacenado
            if ($clave !== $nuevaclave) {
                // Las contraseñas no coinciden, devuelve un mensaje de error al cliente
                header("Location: ../view/configurar_contraseña.php");
                echo "Las contraseñas no coinciden";
                
            } else {
                // Las contraseñas coinciden, procede con el hash de la nueva contraseña
                $clavehash = hash("SHA256", $clave);
                
                // Llamar al procedimiento almacenado solo si las contraseñas coinciden
                $sql = "CALL Registrar_Preguntas_Secretas_Usuario('$login', '$pregunta', '$respuesta', '$clavehash')";
                
                if ($conexion->query($sql) === TRUE) {
                    // La llamada al procedimiento almacenado se realizó correctamente, redirige al usuario
                    header("Location: ../view/login.php");
                    exit();
                } else {
                    // Ocurrió un error al ejecutar el procedimiento almacenado
                    echo "Error al ejecutar el procedimiento almacenado: " . $conexion->error;
                }
            }
            if($clave === 1234){
                
                header("Location: ../view/configurar_contraseña.php");
            }else{
                header("Location: ../view/login.php");
            }
            }
    } else {
        echo $conexion->error;
    }
   
    

    

    $conexion->close();
    ?>
