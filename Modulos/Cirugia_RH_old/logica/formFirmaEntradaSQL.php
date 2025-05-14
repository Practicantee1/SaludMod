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

    // Tomar el primer elemento del array de firmas
    $primerFirma = $firmas[0];
    $episodio = $primerFirma['episodio'];

    // Toma el id_paciente en la tabla tbl_paciente
    $sql = "SELECT MAX(id_paciente) AS id_paciente
            FROM tbl_paciente_formulario_cirugia
            WHERE episodio = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
        exit();
    }

    $stmt->bind_param("s", $episodio);

    if (!$stmt->execute()) {
        echo json_encode(['error' => "Error en la ejecución de la consulta: " . $stmt->error]);
        $stmt->close();
        $conexion->close();
        exit();
    }

    $stmt->bind_result($id_paciente);

    if ($stmt->fetch()) {
        // Verificar si el id_paciente ya existe en tbl_firma_entrada
        $stmt->free_result();

        $sql_check = "SELECT COUNT(*) FROM tbl_firma_entrada_formulario_cirugia WHERE id_paciente = ?";
        $stmt_check = $conexion->prepare($sql_check);
        
        if (!$stmt_check) {
            echo json_encode(['error' => "Error en la preparación de la consulta de verificación: " . $conexion->error]);
            $stmt->close();
            $conexion->close();
            exit();
        }

        $stmt_check->bind_param("i", $id_paciente);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            echo json_encode(['error' => "Ya existe un registro"]);
            $stmt->close();
            $conexion->close();
            exit();
        }
    } else {
        echo json_encode(['error' => "No se encontró el paciente para el episodio: " . $episodio]);
        $stmt->close();
        $conexion->close();
        exit();
    }

    $stmt->close();

    // Proceder con el guardado de los datos de las firmas
    foreach ($firmas as $firma) {
        $cargo = $firma['cargo'];
        $nombreCompleto = $firma['nombreCompleto'];
        $numeroDocumento = $firma['numeroDocumento'];

        $query_firma = "CALL sp_guardar_firmaEntrada_formulario_cirugia(?, ?, ?, ?)";
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
    }

    echo json_encode(['success' => 'Todos los datos de las firmas fueron guardados correctamente.']);
} else {
    echo json_encode(['error' => 'No se recibieron datos para guardar.']);
}

// Cerrar la conexión
$conexion->close();
?>
