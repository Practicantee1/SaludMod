<?php
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Content-Type: application/json');
// Comprobar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}
$conexion->set_charset("utf8mb4"); 

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
file_put_contents('php://stderr', print_r($data, true));

// Obtener los datos enviados
$data = json_decode(file_get_contents("php://input"), true);
$episodio = $data['episodio'] ?? '';
$documento = $data['documento'] ?? '';
$tipo_documento = $data['tipo_documento'] ?? '';
$nombre = $data['nombre'] ?? '';
$edad = $data['edad'] ?? '';
$genero = $data['genero'] ?? '';
$ubicacion = $data['ubicacion'] ?? '';
$cama = $data['cama'] ?? '';
$entidad = $data['entidad'] ?? '';
$centrosanitario = $data['centrosanitario'] ?? '';

$evaluacionesnav = $data['evaluacionesnav'] ?? '';
$evaluacionesits = $data['evaluacionesits'] ?? '';
$evaluacionesistu = $data['evaluacionesistu'] ?? '';
$observaciones = $data['observaciones'] ?? '';
$estado = $data['estadoEvaluacion'] ?? '';
$idProfesional = $data['nombreProfesional'] ?? '';
$cargo = $data['cargo'] ?? '';
$registro = $data['registro'] ?? '';
$evaluacionesnav1 = json_encode($evaluacionesnav, JSON_UNESCAPED_UNICODE);
$evaluacionesits1 = json_encode($evaluacionesits, JSON_UNESCAPED_UNICODE);
$evaluacionesistu1 = json_encode($evaluacionesistu, JSON_UNESCAPED_UNICODE);
// Verificar si hay datos para guardar

try {
    // Guardar datos del paciente y recuperar el ID del paciente insertado
    $query = "CALL 	SP_guardar_paciente_bundles(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssssss", $episodio, $tipo_documento, $documento, $nombre, $edad, $genero, $ubicacion, $cama, $entidad, $centrosanitario);
    $stmt->execute();
    
    $stmt->store_result();
    $stmt->bind_result($idPaciente);
    $stmt->fetch();
    $stmt->close();

    $query = "CALL 	SP_guardar_evaluaciones_bundles(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssss", $idPaciente, $evaluacionesnav1, $evaluacionesits1, $evaluacionesistu1, $observaciones, $estado, $idProfesional, $cargo);
    $stmt->execute();
    
    $stmt->store_result();
    $stmt->fetch();
    $stmt->close();
    
    echo json_encode(['status' => 'success', 'idPaciente' => $idPaciente,'centrosanitario' => $centrosanitario]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $e->getMessage()]);
}

$conexion->close();
?>
