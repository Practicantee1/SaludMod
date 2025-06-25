<?php

    include('../../../config/Conexion.php');

    if(isset($_POST["documento_paciente"])){

        $documento_paciente = $_POST["documento_paciente"];
        $SQL = "CALL SP_ObtenerReporteParaclinico(?)";
        
        if($consulta = $conexion->prepare($SQL)){
            $consulta->bind_param("s", $documento_paciente);
            if($consulta->execute()){
                $filas = $consulta->get_result();
                $registros = $filas->fetch_all();
                echo json_encode(["success" => true, "message" => $registros]);
            }else{
                echo json_encode(["success" => false, "message" => "Ocurrió un error en la ejecución del procedimiento SP_ObtenerReporteParaclinico"]);
            }
        }else{
            echo json_encode(["success" => false, "message" => "Ocurrió un error en el procedimiento SP_ObtenerReporteParaclinico"]);
        }
    }else{
        echo json_encode(["success" => false, "message" => "La cedula es un parámetro obligatorio."]);
    }
?>