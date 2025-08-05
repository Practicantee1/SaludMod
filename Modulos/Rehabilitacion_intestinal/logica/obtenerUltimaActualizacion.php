<?php

    include('../../../config/Conexion.php');

    if(!isset($_POST["documento"])){
        echo json_encode(["success" => false, "message" => "La cedula es obligatoria."]);
        exit();
    }

    $documento = $_POST["documento"];
    $sql = "CALL SP_Obtener_ultimaActualizacion";

    if($consulta = $conexion->prepare($sql)){
        if($consulta->execute()){
            $registro = $consulta->get_result();
            $fila = $registro->fetch_assoc();
            
            echo json_encode(["success" => true, "message" => $fila]);

        }else{
            echo json_encode(["success" => false, "message" => "Ha ocurrido un error al ejecutar el procedimiento SP_Obtener_ultimaActualizacion"]);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Ha ocurrido un error en el procedimiento SP_Obtener_ultimaActualizacion"]);
    }
?>