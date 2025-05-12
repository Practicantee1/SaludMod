<?php
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli

// Comprobar la conexi�n
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

header('Content-Type: application/json');
if (isset($_POST['numero_documento'])) {
    $numero_documento = $_POST['numero_documento'];

    // Preparar la consulta
    $sql = "CALL SP_ConsultaOdontograma(?)";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("s", $numero_documento);
        $stmt->execute();
        $result = $stmt->get_result();

        // Inicializar arrays para tratamientos y datos del paciente
        $tratamientos = [];
        $informacionPaciente = null;

        // Procesar la respuesta
        while ($row = $result->fetch_assoc()) {
            if ($informacionPaciente === null) {
                // Asignar datos del paciente solo una vez
                $informacionPaciente = [
                    'cama' => $row['cama'],
                    'ubicacion' => $row['ubicacion'],
                    'diente' => $row['diente'],
                    'edad' => $row['edad'],
                    'entidad' => $row['entidad'],
                    'episodio' => $row['episodio'],
                    'genero' => $row['genero'],
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'numero_documento' => $row['numero_documento'],
                    'tipo_documento' => $row['tipo_documento'],
                    'identificacion' => $row['identificacionMedico'],
                    'especialidad' => $row['especialidad'],
                    'nombreMedico' => $row['nombreMedico'],
                    'registroMedico' => $row['registroMedico']
                ];
            }

            // A�adir tratamientos
            $tratamientos[$row['diente']] = $row['tratamiento'];
        }

        // Crear la respuesta final
        $response = [
            'informacionPaciente' => $informacionPaciente,
            'tratamientos' => $tratamientos
        ];

        echo json_encode($response);

        // Cerrar la declaraci�n
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare query']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'numero_documento not set']);
}

// Cerrar la conexi�n
$conexion->close();
?>
