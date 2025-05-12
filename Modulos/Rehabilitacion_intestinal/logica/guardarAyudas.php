<?php
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Comprobar la conexi�n
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}
$conexion->set_charset("utf8mb4");

// Verificar la conexi�n
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}


$episodio = $_POST['episodio'] ?? '';
$documento = $_POST['documento'] ?? '';
$tipo_documento = $_POST['tipo_documento'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$edad = $_POST['edad'] ?? '';
$genero = $_POST['genero'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$cama = $_POST['cama'] ?? '';
$entidad = $_POST['entidad'] ?? '';
$nombreMedico = $_POST['nombreMedico'] ?? '';
$especialidadMedico = $_POST['especialidadMedico'] ?? '';
$fechaImagenes= $_POST['fechaImagenes'] ?? '';
$tipoEstudioImagenes= $_POST['tipoEstudioImagenes'] ?? '';
$especificacionImagenes= $_POST['especificacionImagenes'] ?? '';
$conclusionImagenes= $_POST['conclusionImagenes'] ?? '';
$fechaEstudios= $_POST['fechaEstudios'] ?? '';
$tipoEstudioEstudios= $_POST['tipoEstudioEstudios'] ?? '';
$conclusionEstudios= $_POST['conclusionEstudios'] ?? '';
$centrosanitario= $_POST['centrosanitario'] ?? '';


// Verificar si hay datos para guardar

try {
    // Guardar datos del paciente y recuperar el ID del paciente insertado
    $query = "CALL SP_guardar_paciente_RI(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("isssssssssss", $episodio, $tipo_documento, $documento, $nombre, $edad, $genero, $ubicacion, $cama, $entidad, $nombreMedico, $especialidadMedico, $centrosanitario);
    $stmt->execute();
    $stmt->bind_result($idPaciente);
    $stmt->fetch();
    $stmt->close(); // Cierra el statement
    $conexion->next_result(); // Limpia cualquier resultado previo

    if (!empty($fechaImagenes)){
        $query = "CALL SP_guardar_imagenes_RI(?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("issss", $idPaciente, $fechaImagenes, $tipoEstudioImagenes, $especificacionImagenes, $conclusionImagenes);
        $stmt->execute();
        $stmt->close();
        $conexion->next_result();
    }
            
    if (!empty($fechaEstudios)){
        $query = "CALL SP_guardar_estudios_RI(?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("isss", $idPaciente,  $fechaEstudios, $tipoEstudioEstudios, $conclusionEstudios);
        $stmt->execute();
        $stmt->close();
        $conexion->next_result();
    }
    
    
    echo json_encode(['status' => 'success', 'idPaciente' => $idPaciente]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $e->getMessage()]);
}

$conexion->close();
?>