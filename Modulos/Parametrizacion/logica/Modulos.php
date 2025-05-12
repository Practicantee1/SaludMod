<?php
include('../../../config/Conexion.php');
if( isset($_POST['nombreModulo']) && isset($_POST['submodulos'])&& isset($_POST['nombreCarpeta'])) {

    $nombreModulo = $_POST['nombreModulo'];
    $nombreCarpeta = $_POST['nombreCarpeta'];

    // Insertar el módulo
    $sql = "CALL SP_InsertarModulo( ?, ?,?)";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('sss', $nombreModulo,$nombreModulo,$nombreCarpeta );

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $idModulo = $row['id_modulo'];  // Capturar el ID devuelto
            // Recibir el resultado que contiene el ID generado
            $stmt->close(); // Cierra el statement después de la ejecución

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
                    $stmt->bind_param('ssss',$idModulo, $permisoSubmodulo,$submoduloValue, $nombreArchivo); 

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
            throw new Exception('Error al ejecutar la consulta de módulo: ' . $stmt->error);
        }
    } else {
        echo json_encode(['error' => "Error en la preparación de la consulta de módulo: " . $conexion->error]);
    }
} else {
    echo json_encode(['error' => "Faltan parámetros en la solicitud"]);
}
?>