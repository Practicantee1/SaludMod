<?php
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli

// Comprobar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}


header('Content-Type: application/json');

if (isset($_POST['episodio'])) {
    $tabla = $_POST['tabla'];
    $episodio = (int)$_POST['episodio'];
    $nombreProfesional = (int)$_POST['nombreProfesional'];

    $enfermeras = [];
    $epidemiologa = []; 

    // if ($tabla == "1") {
    //     $sql = "CALL SP_consulta_BundlesEnfer(?)";

    //     // Preparar la consulta
    //     if ($stmt = $conn->prepare($sql)) {
    //         // Vincular el parámetro de entrada
    //         $stmt->bind_param('i', $episodio);

    //         // Ejecutar la consulta
    //         if ($stmt->execute()) {
    //             $result = $stmt->get_result();

    //             // Procesar la respuesta
    //             while ($row = $result->fetch_assoc()) {
    //                 $enfermeras[] = [
    //                     'episodio' => $episodio,
    //                     'id' => $row['id'],
    //                     'fecha' => $row['fecha'],
    //                     'hora' => $row['hora'],
    //                     'evaluacionesnav' => $row['evaluacionesnav'],
    //                     'evaluacionesits' => $row['evaluacionesits'],
    //                     'evaluacionesistu' => $row['evaluacionesistu'],
    //                     'observaciones' => $row['observaciones'],
    //                 ];
                    
    //             }

    //             // Crear la respuesta final
    //             $response = [
    //                 'enfermeras' => $enfermeras
    //             ];
    //             echo json_encode($response);
    //         } else {
    //             echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $stmt->error]);
    //         }

    //         // Cerrar la declaración
    //         $stmt->close();
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Preparation failed: ' . $conn->error]);
    //     }
    // } else if ($tabla == "2") {
        $sql = "CALL SP_consultarBundlesEpid(?)";

        // Preparar la consulta
        if ($stmt = $conexion->prepare($sql)) {
            // Vincular el parámetro de entrada
            $stmt->bind_param('i', $nombreProfesional);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $result = $stmt->get_result();

                // Procesar la respuesta
                while ($row = $result->fetch_assoc()) {
                    $epidemiologa[] = [
                        'id' => $row['id'],
                        'fecha' => $row['fecha'],
                        'hora' => $row['hora'],
                        'episodio' => $episodio,
                        'numero_documento' => $row['numero_documento'],
                        'nombre' => $row['nombre'],
                        'edad' => $row['edad'],
                        'genero' => $row['genero'],
                        'ubicacion' => $row['ubicacion'],
                        'cama' => $row['cama'],
                        'entidad' => $row['entidad'],
                        'evaluacionesnav' => $row['evaluacionesnav'],
                        'evaluacionesits' => $row['evaluacionesits'],
                        'evaluacionesistu' => $row['evaluacionesistu'],
                        'observaciones' => $row['observaciones'],
                        'estado' => $row['estado'],
                        'nombreProfesional' => $row['nombreProfesional'],
                        'cargo' => $row['cargo'],
                    ];
                }

                // Crear la respuesta final
                $response = [
                    // 'datosPaciente' => $datosPaciente,
                    'epidemiologa' => $epidemiologa
                ];

                echo json_encode($response);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $stmt->error]);
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Preparation failed: ' . $conexion->error]);
        }
    // }
} else {
    echo json_encode(['status' => 'error', 'message' => 'episodio not set']);
}

$conexion->close();
?>
