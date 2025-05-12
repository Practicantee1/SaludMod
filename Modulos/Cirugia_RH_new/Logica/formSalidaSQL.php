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
        $idPaciente = $id_paciente;

        // Liberar resultados de la consulta previa
        $stmt->free_result();
         // Cerrar la declaración antes de proceder
        
        // Comprobar si hay registros en tbl_salida
        $sql_check = "SELECT COUNT(*) FROM tbl_salida_formulario_cirugia WHERE id_paciente = ?";
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
        $programada = $_POST['programada'];
        $complicaciones = $_POST['complicaciones'];
        $conteo = $_POST['conteo'];
        $camilla = $_POST['camilla'];
        $muestra = $_POST['muestra'];
        $posopetario = $_POST['posopetario'];
        // $problemas = $_POST['problemas'];
        $observaciones = $_POST['observaciones'];

        $query_salida = "CALL sp_salida_formulario_cirugia(?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Preparar la declaración para el procedimiento almacenado
        $stmt_salida = $conexion->prepare($query_salida);
        if (!$stmt_salida) {
            echo json_encode(['error' => "Error en la preparación del procedimiento sp_salida_formulario_cirugia: " . $conexion->error]);
            $stmt->close();
            $conexion->close();
            exit();
        }

        $stmt_salida->bind_param("ssssssss", $idPaciente, $programada, $complicaciones, $conteo, $camilla, $muestra, $posopetario, $observaciones);

        if ($stmt_salida->execute()) {
            echo json_encode(['success' => 'Datos guardados correctamente.']);
        } else {
            echo json_encode(['error' => "Error en la ejecución del procedimiento sp_salida_formulario_cirugia: " . $stmt_salida->error]);
        }

        // Cerrar declaración
        $stmt_salida->close();
    } else {
        echo json_encode(['error' => "No se encontró el paciente para el episodio: " . $episodio]);
    }
    
    // Cerrar la conexión
    $conexion->close();
}
?>
