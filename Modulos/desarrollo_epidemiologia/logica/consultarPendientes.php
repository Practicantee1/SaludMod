<?php 
include('../../../config/Conexion.php');
if (isset($_POST['idProfesional'])) {

    $idProfesional = $_POST['idProfesional'];
    $sql = "CALL SP_ConsultaPendientesEpidemiologia(?)";
    
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('s', $idProfesional);

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

} else {
    echo json_encode(['error' => 'Faltan parámetros en la solicitud']);
}
