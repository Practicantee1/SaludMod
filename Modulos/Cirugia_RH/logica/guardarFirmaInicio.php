<?php

    include('../../../config/Conexion.php');

    $SQL = "CALL SP_completar_firmar_inicio(?, ?)";

    if(isset($_POST['paciente']) && isset($_POST['usuario'])){
        $paciente = $_POST['paciente'];
        $usuario = $_POST['usuario'];

        if($consulta = $conexion->prepare($SQL)){
            $consulta->bind_param("ii", $paciente, $usuario);
            if($consulta->execute()){
                echo json_encode(["success"=>true, "message"=> "La firma se guardó correctamente."]);
            }else{
                echo json_encode(["success" =>false, "message"=> "Ha ocurrido un error al ejecutar al procedimiento SP_completar_firmar_inicio"]);
            }
        }else{
            echo json_encode(["success" =>false, "message"=> "Ha ocurrido un error en el procedimiento SP_completar_firmar_inicio"]);
        }
    }else{
        echo json_encode(["success" =>false, "message"=> "No se enviaron todos los datos para el procedimiento"]);
    }

?>