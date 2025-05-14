<?php
    include('../../../config/Conexion.php');

    $usuario = $_POST['usuario'];
    $paciente = $_POST['ciruPaciente'];
    $tipo = $_POST['tipo'];

    $sql = "CALL sp_verificarFirma(?, ?, ?)";
    if($consulta = $conexion->prepare($sql)){
        $consulta->bind_param("iis", $usuario, $paciente, $tipo);
        if($consulta->execute()){
            $resultado = $consulta->get_result();
    
            if ($resultado && $resultado->num_rows > 0) {
                $datos = $resultado->fetch_all();
                echo json_encode(["success" => true, "data" => $datos]);
            } else {
                echo json_encode(["success" => false, "message" => "No se encontraron resultados"]);
            }
            
        }else{
            echo json_encode(["success" => false, "message" => "Error en la ejecución de la consulta"]);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Error en la consulta"]);
    }

?>