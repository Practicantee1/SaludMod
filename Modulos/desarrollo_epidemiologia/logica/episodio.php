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
    $excelEpisodio = [];

    // Preparar la consulta SQL
    $sql = "CALL SP_bundlesEpisodio(?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetro y ejecutar la consulta
        $stmt->bind_param('i', $episodio);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Obtener resultados
            while ($row = $result->fetch_assoc()) {
                // Decodificar JSON en evaluaciones
                $evaluacionesnav = json_decode($row['evaluacionesnav'], true);
                $evaluacionesits = json_decode($row['evaluacionesits'], true);
                $evaluacionesistu = json_decode($row['evaluacionesistu'], true);

                $excelEpisodio[] = [
                    'id' => $row['id'],
                    'fecha' => $row['fecha'],
                    'hora' => $row['hora'],
                    'episodio' => $row['episodio'],
                    'numero_documento' => $row['numero_documento'],
                    'nombre' => $row['nombre'],
                    'edad' => $row['edad'],
                    'genero' => $row['genero'],
                    'ubicacion' => $row['ubicacion'],
                    'cama' => $row['cama'],
                    'entidad' => $row['entidad'],
                    'evaluacionesnav' => $evaluacionesnav ?: [], // Si es null, asignar un arreglo vacío
                    'evaluacionesits' => $evaluacionesits ?: [],
                    'evaluacionesistu' => $evaluacionesistu ?: [],
                    'observaciones' => $row['observaciones']
                ];
            }

            // Respuesta JSON con los datos obtenidos
            echo json_encode(['status' => 'success', 'excelEpisodio' => $excelEpisodio]);
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
