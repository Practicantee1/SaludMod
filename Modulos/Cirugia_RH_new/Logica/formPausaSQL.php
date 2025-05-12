<?php
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['error' => "Conexión fallida: " . $conexion->connect_error]);
    exit();
}

if (isset($_POST['episodio'])) {
    $episodio = $_POST['episodio'];

    $sql = "SELECT MAX(id_paciente) AS id_paciente
            FROM tbl_paciente_formulario_cirugia
            WHERE episodio = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
        exit();
    }

    $stmt->bind_param("s", $episodio); // "s" indica que el parámetro es una cadena
    
    // Ejecutar la consulta
    if (!$stmt->execute()) {
        echo json_encode(['error' => "Error en la ejecución de la consulta: " . $stmt->error]);
        $stmt->close();
        $conexion->close();
        exit();
    }
    
    // Almacenar el resultado
    $stmt->bind_result($id_paciente);
    
    // Obtener el valor
    if ($stmt->fetch()) {
        // Almacenar el id_paciente en una variable
        // $idPaciente = $id_paciente;  -----> ESTO SE DEBE CAMBIAR
        $idPaciente = 227;

        // Liberar resultados de la consulta previa
        $stmt->free_result();
        
        // Comprobar si hay registros en tbl_pausa
        $sql_check = "SELECT COUNT(*) FROM tbl_pausa_formulario_cirugia WHERE id_paciente = ?";
        $stmt_check = $conexion->prepare($sql_check);
        if (!$stmt_check) {
            echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
            $stmt->close();
            $conexion->close();
            exit();
        }

        $stmt_check->bind_param("s", $idPaciente);
        $stmt_check->execute();
        $stmt_check->bind_result($count);
        $stmt_check->fetch();
        $stmt_check->close();

        if ($count > 0) {
            echo json_encode(['error' => "Ya se guardo anteriormente este formulario."]);
            $stmt->close();
            $conexion->close();
            exit();
        }

        // Recoger otros datos del formulario
        $equipoHumano = $_POST['equipoHumano'];
        $nombre_abordaje = $_POST['nombre_abordaje'];
        $existen = $_POST['existen'];
        $administracion = $_POST['administracion'];
        $plan = $_POST['plan'];
        $textoPlan = $_POST['textoPlan'];
        $anestesiologo = $_POST['anestesiologo'];
        $esterilidad = $_POST['esterilidad'];
        $vo = $_POST['vo'];
        $Detalles_relevantes = $_POST['Detalles_relevantes'];
        $T = $_POST['T'];
        $perfusion = $_POST['perfusion'];
        $observacionesPausa = $_POST['observacionesPausa'];

        $query_pausa = "CALL sp_pausa_formulario_cirugia(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Preparar la declaración para el procedimiento almacenado
        $stmt_pausa = $conexion->prepare($query_pausa);
        if (!$stmt_pausa) {
            echo json_encode(['error' => "Error en la preparación del procedimiento sp_pausa_formulario_cirugia: " . $conexion->error]);
            $stmt->close();
            $conexion->close();
            exit();
        }

        $stmt_pausa->bind_param("ssssssssssssss", $idPaciente, $equipoHumano, $nombre_abordaje, $existen, $administracion, $plan, $anestesiologo, $esterilidad, $vo,$Detalles_relevantes, $T, $perfusion, $observacionesPausa, $textoPlan);

        if ($stmt_pausa->execute()) {
            echo json_encode(['success' => 'Datos guardados correctamente.']);
        } else {
            echo json_encode(['error' => "Error en la ejecución del procedimiento sp_pausa_formulario_cirugia: " . $stmt_pausa->error]);
        }

        // Cerrar declaración del procedimiento
        $stmt_pausa->close();
    } else {
        echo json_encode(['error' => "No se encontró el paciente para el episodio: " . $episodio]);
    }
    
    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conexion->close();
?>
