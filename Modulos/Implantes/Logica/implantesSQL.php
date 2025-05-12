<?php

include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
}

// Verificar si se recibieron datos
$response = array(); // Array para almacenar la respuesta
if (isset($_POST['table'])) {
    // Verificar si es un array o una cadena JSON
    if (is_array($_POST['table'])) {
        $table = $_POST['table'];
    } else {
        $table = json_decode($_POST['table'], true);
    }

    // Verificar que el array no esté vacío
    if (!empty($table)) {
        // Ejecutar solo una vez para obtener el ID del paciente
        $episodioInput = $table[0][0];
        $numdocumento = $table[0][1];
        $nombrePaciente = $table[0][2];
        $aseguradora = $table[0][3];
        $cirujano = $table[0][4];
        $especialidad = $table[0][5];
        $date = $table[0][6];
        $observaciones = $table[0][7];
        $centrosanitario = $table[0][19]; 

        // Llamar al procedimiento almacenado para insertar datos del paciente
        $query = "CALL sp_insertar_datos_paciente_implante('$episodioInput', '$numdocumento', '$nombrePaciente', '$aseguradora', '$cirujano', '$especialidad', '$date', '$observaciones', '$centrosanitario')";

        if ($result = $conexion->query($query)) {
            // Recuperar el ID del paciente insertado
            if ($row = $result->fetch_assoc()) {
                $idPaciente = $row['id_paciente'];
                $response['success'] = "Paciente insertado correctamente."; // Mensaje de éxito

                // Iterar sobre todos los registros para insertar detalles del implante
                for ($ii = 0; $ii < count($table); $ii++) {
                    $conexion->next_result();
                    $diagnosticoNombre = $table[$ii][8];
                    $casaComercialId = $table[$ii][9];
                    $tipoImplanteId = $table[$ii][11];
                    $entSoporte = $table[$ii][12];
                    $tiempoSoporte = $table[$ii][13];
                    $material = $table[$ii][14];
                    $falla = $table[$ii][15];
                    $infImplLlegaTiempo = $table[$ii][16];
                    $infImplLlegaCompleto = $table[$ii][17];

                    // Preparar la consulta de detalles del implante
                    $query_insert_detail_implante = "CALL sp_insertar_datos_implantes_detalles
                    ('$idPaciente', '$diagnosticoNombre','$casaComercialId', '$tipoImplanteId', '$entSoporte', '$tiempoSoporte', 
                    '$material', '$falla', '$infImplLlegaTiempo', '$infImplLlegaCompleto')";

                    // Ejecutar la consulta
                    if ($conexion->query($query_insert_detail_implante)) {
                        $response['details'][] = "Detalles del implante insertados correctamente.";
                    } else {
                        $response['error'] = "Error en la ejecución de la consulta de detalle de implante: " . $conexion->error;
                    }
                }
                $result->free();
            } else {
                $response['error'] = "No se pudo recuperar el ID del paciente.";
            }
        } else {
            $response['error'] = "Error en la ejecución de la consulta: " . $conexion->error;
        }
    } else {
        $response['error'] = "No hay datos en la tabla.";
    }
} else {
    $response['error'] = "No se recibieron datos.";
}

// Envía la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión
$conexion->close();
