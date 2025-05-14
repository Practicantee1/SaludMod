<?php
    include('../../../config/Conexion.php');

    if(isset($_POST['paciente']) && $_POST['tipo_Firma']){

        $paciente = $_POST['paciente'];
        $tipo_Firma = $_POST['tipo_Firma'];    

        $sql = "CALL sp_actualizar_firmas_finales(?, ?)";
        if($consulta = $conexion->prepare($sql)){
            $consulta->bind_param("is", $paciente, $tipo_Firma);
            if($consulta->execute()){
                echo json_encode(["success" => true, "message" => "Se completo el proceso exitosamente"]);
                
            }else{
                echo json_encode(["success" => false, "message" => "Error en la ejecución de la consulta"]);
            }
        }else{
            echo json_encode(["success" => false, "message" => "Error en la consulta"]);
        }
    
    }else{
        echo json_encode(["success" => false, "message" => "Falta información"]);
    }
?>