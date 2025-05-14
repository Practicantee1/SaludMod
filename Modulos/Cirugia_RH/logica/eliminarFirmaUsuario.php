<?php  
    include('../../../config/Conexion.php');

    $usuario = $_POST['usuario_id'];
    $tipo_Firma = $_POST['tipo_Firma'];
    $id_paciente = $_POST['paciente'];

    $sql = "CALL sp_eliminar_firma_cirugia(?, ?, ?)";
    if($consulta = $conexion->prepare($sql)){
        $consulta->bind_param("isi", $usuario, $tipo_Firma, $id_paciente);
        if($consulta->execute()){
            echo json_encode(["success" => true, "message" => "Firma eliminada correctamente"]);
        }else{
            echo json_encode(["success" => false, "message" => "Ocurrió un problema inesperado al ejecutar la consulta"]);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Ocurrió un problema inesperado al preparar la consulta"]);
    }

?>