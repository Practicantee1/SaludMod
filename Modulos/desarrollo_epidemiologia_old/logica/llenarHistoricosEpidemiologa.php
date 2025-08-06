<?php
include('../../../config/Conexion.php');

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Comprobar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}



if (isset($_POST['nombreProfesional'])) {
    $nombreProfesional = (int)$_POST['nombreProfesional'];
    $epidemiologa = [];

    $sql = "CALL SP_consultarBundlesEpid(?)"; 
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('s', $nombreProfesional);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                // Procesar evaluaciones como JSON
                $evaluacionesnav = json_decode($row['evaluacionesnav'], true);
                $evaluacionesits = json_decode($row['evaluacionesits'], true);
                $evaluacionesistu = json_decode($row['evaluacionesistu'], true);

                $epidemiologa[] = [
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
                    'observaciones' => $row['observaciones'],
                    'estado' => $row['estado'],
                    'id' => $row['id'],
                ];
            }

            echo json_encode(['status' => 'success', 'epidemiologa' => $epidemiologa]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query execution failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query preparation failed: ' . $conexion->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parameter "nombreProfesional" not set']);
}

$conexion->close();
?>
