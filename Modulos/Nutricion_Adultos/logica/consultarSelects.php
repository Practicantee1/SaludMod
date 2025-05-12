<?php 
include('../../../config/Conexion.php');
$opcion = $_POST["lista"];
if($opcion == "fuentePeso"){
    $sql = "CALL SP_listarFuenteDatosPeso()";
    if ($stmt = $conexion->prepare($sql)) {

        if ($stmt->execute()) {
            // Obtenemos el resultado de la consulta
            $result = $stmt->get_result();
            
            // Creamos un array para almacenar los datos
            $data = [];
            
            // Iteramos sobre el resultado y lo guardamos en el array
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            // Enviamos el resultado en formato JSON
            header('Content-Type: application/json');
            echo json_encode($data);

        } else {
            echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmt->error]);
        }
        
        // Cerramos el statement
        $stmt->close();
        
    } else {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conexion->error]);
    }

    // Cerramos la conexión
    $conexion->close();
}else if($opcion == "edemas"){
    $sql = "CALL SP_listarEdemas()";
    if ($stmt = $conexion->prepare($sql)) {

        if ($stmt->execute()) {
            // Obtenemos el resultado de la consulta
            $result = $stmt->get_result();
            
            // Creamos un array para almacenar los datos
            $data = [];
            
            // Iteramos sobre el resultado y lo guardamos en el array
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            // Enviamos el resultado en formato JSON
            header('Content-Type: application/json');
            echo json_encode($data);

        } else {
            echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $stmt->error]);
        }
        
        // Cerramos el statement
        $stmt->close();
        
    } else {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $conexion->error]);
    }

    // Cerramos la conexión
    $conexion->close();
}
