<?php
include('../../../config/Conexion.php');

// Configuración de la cabecera para JSON
header('Content-Type: application/json');

// Verificar conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

// Validar si el parámetro 'episodio' está definido
if (isset($_POST['episodio'])) {
    $episodio = (int)$_POST['episodio'];
    $medidas = [];

    // Preparar la consulta SQL
    $sql = "CALL sp_consulta_MedidasAntropometricas(?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetro y ejecutar la consulta
        $stmt->bind_param('i', $episodio);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Obtener resultados
            while ($row = $result->fetch_assoc()) {
                $medidas[] = [
                    'fecha' => $row['fecha'] ?? '',
                    'peso' => $row['peso'] ?? '',
                    'talla' => $row['talla'] ?? '',
                    'sct' => $row['sct'] ?? '',
                    'talla_edad' => $row['talla_edad'] ?? '',
                    'peso_edad' => $row['peso_edad'] ?? '',
                    'peso_talla' => $row['peso_talla'] ?? '',
                    'imc' => $row['imc'] ?? ''
                ];
            }

            // Respuesta JSON con los datos obtenidos
            echo json_encode(['status' => 'success', 'medidas' => $medidas]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Preparation failed: ' . $conexion->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parameter "episodio" not set']);
}

$conexion->close();
?>
