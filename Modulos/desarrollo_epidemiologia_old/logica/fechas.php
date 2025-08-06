<?php
include('../../../config/Conexion.php');

// Configuración de la cabecera para JSON
header('Content-Type: application/json');

// Verificar conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}
if (isset($_POST['fechaInicio']) && isset($_POST['fechaFinal'])) {
    error_log("Fecha inicio: " . $_POST['fechaInicio']);
    error_log("Fecha final: " . $_POST['fechaFinal']);
} else {
    error_log("Parámetros no recibidos.");
}
// Validar si los parámetros 'identificacion', 'fechaInicio' y 'fechaFinal' están definidos
if (isset($_POST['fechaInicio']) && isset($_POST['fechaFinal'])) {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];

    $excelFechas = [];

    // Preparar la consulta SQL
    $sql = "CALL SP_bundlesFechas(?, ?)"; // Llamamos al procedimiento almacenado con las fechas
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros y ejecutar la consulta
        $stmt->bind_param('ss', $fechaInicio, $fechaFinal); // Se pasa 's' para cadenas de texto (fechas)

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            // Obtener resultados
            while ($row = $result->fetch_assoc()) {
                // Decodificar JSON en evaluaciones
                $evaluacionesnav = json_decode($row['evaluacionesnav'], true);
                $evaluacionesits = json_decode($row['evaluacionesits'], true);
                $evaluacionesistu = json_decode($row['evaluacionesistu'], true);

                $excelFechas[] = [
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
                    'evaluacionesnav' => $evaluacionesnav ?: [],
                    'evaluacionesits' => $evaluacionesits ?: [],
                    'evaluacionesistu' => $evaluacionesistu ?: [],
                    'observaciones' => $row['observaciones']
                ];
            }

            // Respuesta JSON con los datos obtenidos
            echo json_encode(['status' => 'success', 'excelFechas' => $excelFechas]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Preparation failed: ' . $conexion->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
}

$conexion->close();

?>
