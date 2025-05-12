<?php 
include('../../../config/Conexion.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST['ciudad']) && isset($_POST['registro']) && isset($_POST['especialidad']) && isset($_POST['Medico']) && isset($_POST['NombrePaciente'])&& isset($_POST['NumeroIdentificacion'])&& isset($_POST['FechaSolicitud'])&& isset($_POST['observaciones'])&& isset($_POST['respuestas'])&& isset($_POST['idtipoDocumentoP'])&& isset($_POST['edad'])){

    $NombrePaciente = $_POST['NombrePaciente'];
    $idDocumento = $_POST['idDocumento'];
    $Medico = $_POST['Medico'];
    $registro = $_POST['registro'];
    $especialidad = $_POST['especialidad'];
    $FechaSolicitud = $_POST['FechaSolicitud'];
    $respuestas = $_POST['respuestas'];
    $observaciones = $_POST['observaciones'];
    $ciudad = $_POST['ciudad'];
    $NumeroIdentificacion = $_POST['NumeroIdentificacion']; 
    $idTipoDocumento = $_POST['idTipoDocumento'];
    $edad = $_POST['edad'];
    $idtipoDocumentoP = $_POST['idtipoDocumentoP'];
    $centrosanitario = $_POST['centrosanitario'];
    $sql = "CALL SP_InsertarSolicitudDMD( ?, ?, ?, ?, ?, ?,?, ?, ?,?,?,?,?,?)";
     if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('ssssssssssssss', $NombrePaciente, $NumeroIdentificacion, $Medico,$registro, $especialidad, $FechaSolicitud, $respuestas, $observaciones, $ciudad,$idDocumento,$idTipoDocumento,$idtipoDocumentoP,$edad, $centrosanitario);


        if ($stmt->execute()) {
            // Recibir el resultado que contiene el ID generado
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $id_paciente = $row['id_paciente'];  // Capturar el ID devuelto
    
            // Enviar el JSON con el ID
            header('Content-Type: application/json');
            echo json_encode([
                "message" => "Data saved successfully",
                "id_paciente" => $id_paciente
            ]);
        }  else {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }
    }else {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
    }
}else {
    echo json_encode(['error' => "Faltan parámetros en la solicitud"]);
}