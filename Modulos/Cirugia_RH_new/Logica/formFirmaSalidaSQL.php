<?php
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['error' => "Conexión fallida: " . $conexion->connect_error]);
    exit();
}

// Verificar si se recibieron los datos del formulario
if (isset($_POST['firmas'])) {
    $firmas = $_POST['firmas'];

    // Recopilar episodios únicos de las firmas
    $episodios = array_map(function ($firma) {
        return $firma['episodio'];
    }, $firmas);
    $episodios = array_unique($episodios);

    // Obtener los id_paciente correspondientes a los episodios
    $episodios_placeholders = implode(',', array_fill(0, count($episodios), '?'));
    $sql = "
    SELECT episodio, MAX(id_paciente) AS id_paciente 
    FROM tbl_paciente_formulario_cirugia 
    WHERE episodio IN ($episodios_placeholders) 
    GROUP BY episodio
";
$stmt = $conexion->prepare($sql);

    if (!$stmt) {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
        exit();
    }

    $stmt->bind_param(str_repeat('s', count($episodios)), ...$episodios);

    if (!$stmt->execute()) {
        echo json_encode(['error' => "Error en la ejecución de la consulta: " . $stmt->error]);
        $stmt->close();
        $conexion->close();
        exit();
    }

    $result = $stmt->get_result();
    $episodio_paciente_map = [];
    while ($row = $result->fetch_assoc()) {
        $episodio_paciente_map[$row['episodio']] = $row['id_paciente'];
    }
    $stmt->close();

    // Verificar si alguno de los pacientes ya existe en tbl_firma_Salida
    $id_pacientes = array_values($episodio_paciente_map);
    if (count($id_pacientes) > 0) {
        $id_pacientes_placeholders = implode(',', array_fill(0, count($id_pacientes), '?'));
        $sql_check = "SELECT COUNT(*) FROM tbl_firma_salida_formulario_cirugia WHERE id_paciente IN ($id_pacientes_placeholders)";
        $stmt_check = $conexion->prepare($sql_check);

        if (!$stmt_check) {
            echo json_encode(['error' => "Error en la preparación de la consulta de verificación: " . $conexion->error]);
            $conexion->close();
            exit();
        }

        $stmt_check->bind_param(str_repeat('i', count($id_pacientes)), ...$id_pacientes);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            echo json_encode(['error' => "Ya existe un registro de las Personas que ingresaron."]);
            $conexion->close();
            exit();
        }
    }

    // Proceder con el guardado de los datos de la firma
    foreach ($firmas as $firma) {
        $episodio = $firma['episodio'];
        $cargo = $firma['cargo'];
        $nombreCompleto = $firma['nombreCompleto'];
        $numeroDocumento = $firma['numeroDocumento'];

        if (isset($episodio_paciente_map[$episodio])) {
            $id_paciente = $episodio_paciente_map[$episodio];

            // Sanitización de entradas si es necesario
            $cargo = htmlspecialchars($cargo, ENT_QUOTES, 'UTF-8');
            $nombreCompleto = htmlspecialchars($nombreCompleto, ENT_QUOTES, 'UTF-8');
            $numeroDocumento = htmlspecialchars($numeroDocumento, ENT_QUOTES, 'UTF-8');

            $query_firma = "CALL sp_guardar_firmaSalida_formulario_cirugia(?, ?, ?, ?)";
            $stmt_firma = $conexion->prepare($query_firma);
            if (!$stmt_firma) {
                echo json_encode(['error' => "Error en la preparación del procedimiento almacenado: " . $conexion->error]);
                $conexion->close();
                exit();
            }

            $stmt_firma->bind_param("isss", $id_paciente, $cargo, $nombreCompleto, $numeroDocumento);

            if (!$stmt_firma->execute()) {
                echo json_encode(['error' => "Error al guardar la firma: " . $stmt_firma->error]);
                $stmt_firma->close();
                $conexion->close();
                exit();
            }

            $stmt_firma->close();
        } else {
            echo json_encode(['error' => "No se encontró el paciente para el episodio: " . $episodio]);
            $conexion->close();
            exit();
        }
    }

    echo json_encode(['success' => 'Todos los datos de las firmas fueron guardados correctamente.']);
} else {
    echo json_encode(['error' => 'No se recibieron datos para guardar.']);
}

// Cerrar la conexión
$conexion->close();
?>
