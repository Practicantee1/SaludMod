<?php
    include('../../../config/Conexion.php');

    $usuario = $_POST['usuario_id'];
    $paciente = $_POST['paciente_id'];
    $tipo = $_POST['tipo'];

    $consulta_procedimiento = "CALL sp_firmas_ultima_pausa(?,?,?)";

    if($consulta = $conexion->prepare($consulta_procedimiento)){
        $consulta->bind_param("iis", $paciente, $usuario, $tipo);
        if($consulta->execute()){
            $resultado = $consulta->get_result();
            $fila = $resultado->fetch_assoc();
            echo json_encode(["success" => true, "message" => $fila]);
        }else{
            echo json_encode(["success" => false, "message" => "Error en la ejecución de la consulta"]);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Error al preparar de la consulta"]);
    }

?>