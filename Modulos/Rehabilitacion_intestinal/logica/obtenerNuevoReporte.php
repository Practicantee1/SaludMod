<?php


    include('../../../config/Conexion.php');

    $documento = $_POST['documento'];
    $fecha_hora = $_POST['fecha_hora'];

    if(!isset($documento) && !isset($fecha_hora)){
        echo json_encode(["success" => false, "message" => "Faltan parámetros para realizar la solicitud."]);
        exit();
    }

    $sql = "CALL SP_ObtenerNuevosReportes(?, ?)";
    $sql2 = "CALL SP_ObtenerFechaNuevoReporte(?, ?)";

    if($consulta = $conexion->prepare($sql)){
        $consulta->bind_param("ss", $documento, $fecha_hora);

        if($consulta->execute()){
            $registros = $consulta->get_result();
            $filas = $registros->fetch_all();
            
        }else{
            echo json_encode(["success" => false, "message" => "Ocurrió un error en la ejecución del procedimiento SP_ObtenerNuevosReportes"]);
            exit();
        }
    }else{
        echo json_encode(["success" => false, "message" => "Ocurrió un error en el procedimiento SP_ObtenerNuevosReportes"]);
        exit();
    }


    // Libera los resultados pendientes si hay más conjuntos
    while ($conexion->more_results() && $conexion->next_result()) {
        $extraResult = $conexion->use_result();
        if ($extraResult instanceof mysqli_result) {
            $extraResult->free();
        }
    }


    if($consulta2 = $conexion->prepare($sql2)){
        $consulta2->bind_param("ss", $documento, $fecha_hora);

        if($consulta2->execute()){
            $registros2 = $consulta2->get_result();
            $filas2 = $registros2->fetch_all();

            echo json_encode(["success" => true, "message" => $filas, "fechas" => $filas2]);
        }else{
            echo json_encode(["success" => false, "message" => "Ocurrió un error en la ejecución del procedimiento SP_ObtenerFechaNuevoReporte"]);
            exit();
        }
    }else{
        echo json_encode(["success" => false, "message" => "Ocurrió un error en el procedimiento SP_ObtenerFechaNuevoReporte"]);
        exit();
    }
?>