<?php
// Conectar a la base de datos
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli

// Comprobar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

header('Content-Type: application/json');
ob_start(); // Inicia el buffer de salida
$conexion->set_charset("utf8mb4"); 

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    ob_end_clean(); // Limpiar el buffer de salida si hay un error
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
    ob_end_clean(); // Limpiar el buffer de salida si hay un error
    exit();
}

// Registrar los datos recibidos para depuración (usa el log de errores en lugar de stderr)
error_log(print_r($data, true));

$idPacienteBundles = $data['idPacienteBundles'] ?? '';
$estado = $data['estado'] ?? '';

try {
    // Guardar datos del paciente
    $query = "CALL SP_actualizar_estado_bundles(?, ?)";
    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        throw new Exception("Error preparando la consulta: " . $conexion->error);
    }
    $stmt->bind_param("ss", $idPacienteBundles, $estado);
    $stmt->execute();
    
    // Comprobar si el UPDATE fue exitoso
    if ($stmt->affected_rows > 0) {
        // Éxito en la actualización
        ob_end_clean(); // Asegurarse de que el buffer de salida esté limpio antes de enviar la respuesta JSON
        echo json_encode(['status' => 'success', 'message' => 'Actualización exitosa']);
    } else {
        // No se afectaron filas, lo que podría significar que el idPacienteBundles no coincide
        ob_end_clean(); 
        echo json_encode(['status' => 'warning', 'message' => 'No se actualizó ningún registro, puede que el ID no coincida']);
    }

    $stmt->close();

} catch (mysqli_sql_exception $e) {
    ob_end_clean(); // Limpiar el buffer si hay errores
    echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $e->getMessage()]);
}

$conexion->close();
?>
