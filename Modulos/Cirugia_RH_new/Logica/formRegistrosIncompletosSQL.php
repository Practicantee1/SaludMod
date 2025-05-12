<?php
include('../../../config/Conexion.php');

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

header('Content-Type: application/json'); // Especificamos que queremos retornar JSON

// Consulta SQL sin necesidad de parámetros
$sql = "SELECT *
        FROM tbl_paciente_formulario_cirugia tp
        WHERE tp.entrada = 'PENDIENTE' OR tp.pausa = 'PENDIENTE' OR tp.salida = 'PENDIENTE' OR tp.firmaEntrada = 'PENDIENTE' OR tp.firmaSalida = 'PENDIENTE'
        ORDER BY tp.fecha_cirugía ASC;";

// Guardamos la consulta SQL en una variable
if ($stmt = $conexion->prepare($sql)) {

    if ($stmt->execute()) {
        $result = $stmt->get_result(); // Obtenemos los resultados de la consulta
        $data = array(); // Creamos un array
        if ($result->num_rows > 0) {
            while ($fila = $result->fetch_assoc()) { // Convertimos el resultado en un array asociativo y lo guardamos en $fila
                $data[] = $fila;
            }
        } else {
            // Si no hay registros, puedes devolver un mensaje personalizado si lo deseas
            // $data[] = array("message" => "No se encontraron registros");
        }
        echo json_encode($data); // Enviamos los datos como respuesta en formato JSON
    } else {
        echo json_encode(array("error" => "Error en la ejecución de la consulta: " . $stmt->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("error" => "Error en la preparación de la consulta: " . $conexion->error));
}

$conexion->close();
?>
