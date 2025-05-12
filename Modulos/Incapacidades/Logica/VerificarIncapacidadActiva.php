<?php 

include('../../../config/Conexion.php');

$IDNumberPaciente = $_POST["IDPaciente"];


$IDQuery = "CALL SP_VerificarIncapacidadesActivas(?)";


if($consulta = $conexion->prepare($IDQuery)){

    $consulta->bind_param("i", $IDNumberPaciente);
    if($consulta->execute()){
        $registros = $consulta->get_result(); // Necesario para contar filas
        $filas = $registros->fetch_assoc();
        echo json_encode(["success" => true, "message" => $filas]);

    }else{
        echo json_encode(["success" => false, "message" => "Ocurrió algo inesperado al ejecutar la consulta"]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Ocurrió algo inesperado con la consulta"]);
}



?>