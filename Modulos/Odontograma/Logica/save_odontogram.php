<?php
// Conectar a la base de datos
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

// Obtener los datos enviados
$data = json_decode(file_get_contents("php://input"), true);
$odontogram = $data['odontogram'] ?? [];
$episodio = $data['episodio'] ?? '';
$documento = $data['documento'] ?? '';
$tipo_documento = $data['tipo_documento'] ?? '';
$nombre = $data['nombre'] ?? '';
$edad = $data['edad'] ?? '';
$genero = $data['genero'] ?? '';
$ubicacion = $data['ubicacion'] ?? '';
$cama = $data['cama'] ?? '';
$entidad = $data['entidad'] ?? '';
$identificacionMed = $data['identificacionMed'] ?? '';
$nombreMedico = $data['nombreMedico'] ?? '';
$especialidad = $data['especialidad'] ?? '';
$registro = $data['registro'] ?? '';
$centrosanitario = $data['centrosanitario'] ?? '';

// Verificar si hay datos para guardar
if ($odontogram) {
    try {
        // Guardar datos del paciente y recuperar el ID del paciente insertado
        $query = "CALL SP_guardar_odontograma_paciente(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssssss", $episodio, $tipo_documento, $documento, $nombre, $edad, $genero, $ubicacion, $cama, $entidad, $centrosanitario);
        $stmt->execute();
        
        $stmt->store_result();
        $stmt->bind_result($idPaciente);
        $stmt->fetch();
        $stmt->close();

        $insert = "CALL SP_Insertar_Medico_Odontograma(?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($insert);
        $stmt->bind_param("isssss", $idPaciente, $tipo_documento, $identificacionMed, $nombreMedico, $registro, $especialidad);
        $stmt->execute();
        $stmt->close();

        // Guardar el odontograma
        $stmt = $conexion->prepare("INSERT INTO tbl_odontogramas (idpaciente, diente, tratamiento) VALUES (?, ?, ?)");
        foreach ($odontogram as $toothNumber => $treatment) {
            $stmt->bind_param("iss", $idPaciente, $toothNumber, $treatment);
            $stmt->execute();
        }

        $stmt->close();
        echo json_encode(['status' => 'success']);
    } catch (mysqli_sql_exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}

$conexion->close();
?>
