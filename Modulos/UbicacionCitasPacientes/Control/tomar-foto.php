<?php
include('../../../config/Conexion.php');
if( isset($_POST['blob']) && isset($_POST['submodulos'])) {

    $blob = $_POST['blob'];
    // Decodificar el JSON de submodulos
    $submodulos = json_decode($_POST['submodulos'], true); // Decodificar el JSON a un array

    $sqlSubmodulo = "CALL SP_InsertarSubmodulo(?, ?, ?, ?)";
    foreach ($submodulos as $submodulo) {
        if ($stmt = $conexion->prepare($sqlSubmodulo)) {
            // Obtén los valores de cada submodulo
            $submoduloValue = $submodulo['submodulo'];
            $nombreArchivo = $submodulo['nombreArchivo'];
            $permisoSubmodulo = $submodulo['permiso'];

            // Asigna los valores a los parámetros del procedimiento almacenado
            $stmt->bind_param('ssss',$blob, $permisoSubmodulo,$submoduloValue, $nombreArchivo); 

            // Ejecutar la inserción
            if (!$stmt->execute()) {
                throw new Exception('Error al ejecutar la consulta de submódulo: ' . $stmt->error);
            }
            $stmt->close(); // Cierra el statement después de cada ejecución
        } else {
            echo json_encode(['error' => "Error en la preparación de la consulta de submódulo: " . $conexion->error]);
            exit;
        }
    }

    // Enviar la respuesta JSON al finalizar
    header('Content-Type: application/json');
    echo json_encode([
        "message" => "Data saved successfully"
    ]);
} else {
    echo json_encode(['error' => "Faltan parámetros en la solicitud"]);
}
?>