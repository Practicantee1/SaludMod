<?php
include('../../../../../config/Conexion.php');

if (isset($_POST['F_inicial']) && isset($_POST['F_final'])) {
    $F_inicial = date('Y-m-d', strtotime($_POST['F_inicial']));
    $F_final = date('Y-m-d', strtotime($_POST['F_final']));

    try {
        // Consulta para obtener todos los datos
        $sql = "SELECT `episode`, `fecha`, `nombre_completo`, `cc_document`, `pregunta_1`, `pregunta_2`, `pregunta_3`, `pregunta_4`, `pregunta_5`, `pregunta_8`, `usuarioRegistra`  
        FROM `satisfaccion` 
        WHERE `fecha` BETWEEN ? AND ?";
        // Preparar la consulta con MySQLi
        $stmt = $conexion->prepare($sql);
        // Verifica si la preparación fue exitosa
        if ($stmt === false) {
            die('Error al preparar la consulta: ' . $conexion->error);
        }
        // Enlazar los parámetros a la consulta
        $stmt->bind_param('ss', $F_inicial, $F_final);
        // Ejecutar la consulta 
        $stmt->execute();
        // Obtener los resultados
        $resultado = $stmt->get_result();
        $data = $resultado->fetch_all(MYSQLI_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($data); 
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Las fechas no están definidas']);
}
?>
