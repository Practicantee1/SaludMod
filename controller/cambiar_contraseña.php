<?php
// Conexión a la base de datos
require_once "../config/Conexion.php";
if(isset($_POST["SAVE"]) && $_POST["SAVE"]=="SAVE" && isset($_POST["clave"])){
    $login = $_POST["login"];
    $clave = $_POST['clave'];

    $clavehash = hash("SHA256", $clave);
    $sql_update_clave = "UPDATE usuario SET clave = '$clavehash' WHERE login = '$login'";
        
    
    if ($conexion->query($sql_update_clave) === TRUE) {
        echo 'SAVED';
    } else {
        echo 'ENOTSAVED';
    }

}
else{

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['respuesta'])){
        $login = $_POST['login'];
        $respuesta = $_POST['respuesta'];
    
        $sql="SELECT psu.Respuesta 
        FROM Preguntas_Secretas_Usuarios psu
        WHERE psu.login = '$login'";
       $result= $conexion->query($sql);

       if($result) {
        // Verificar si se encontró una respuesta secreta
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $respuesta_correcta = $row['Respuesta'];
            
           
            // Verificar si la respuesta proporcionada por el usuario es correcta
            if ($respuesta === $respuesta_correcta) {
                echo "ANSWER";                
                    
                } else {
                    echo "NOTANSWER";
                    
                    
                }

                
        
            }
        }
    }  
    else{

        if(isset($_POST['login'])) {
            $login = $_POST['login'];
            
            // Consulta la pregunta secreta asociada al nombre de usuario
            $sql = "SELECT psu.Pregunta
                    FROM Preguntas_Secretas_Usuarios psu
                    WHERE psu.login = '$login'";
            
            $result = $conexion->query($sql);
    
            if($result) {
                // Verifica si se encontró una pregunta secreta
                if($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $pregunta = $row['Pregunta'];
                    echo $pregunta;
                    // Devuelve la pregunta secreta como respuesta JSON
                    
                } else {
                    // No encontró una pregunta secreta para el usuario
                    echo  'No se encontró una pregunta secreta para este usuario';
                }
            } else {
                // Error en la consulta SQL
                echo 'Error en la consulta ' . $conexion->error;
            }
        } else {
            // No se recibió el nombre de usuario
            echo 'error =>No se recibió el nombre de usuario';
        }

    }  
// Verificar si se recibió un nombre de usuario
    

    /* if ($conexion->more_results()) {
        $conexion->next_result();
    } */
}    

// Cerrar la conexión a la base de datos
$conexion->close();
?>
