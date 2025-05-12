<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Habilitar CORS si es necesario

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_implantes";

// // Crear conexión
// $conexion = new mysqli($servername, $username, $password, $dbname);

// // Verificar si la conexión fue exitosa
// if ($conexion->connect_error) {
//     echo json_encode(['success' => false, 'error' => 'Error de conexión: ' . $conexion->connect_error]);
//     exit();
// }
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $casaComercial = $_POST['casaComercial'] ?? null; // Obtener el nombre de la casa comercial

    // Verificar que se haya enviado un nombre
    if (!$casaComercial) {
        echo json_encode(['success' => false, 'error' => 'El nombre de la casa comercial es requerido.']);
        exit();
    }

    // Preparar la consulta para insertar el nombre de la casa comercial
    $consulta = "INSERT INTO tbl_casa_comercial (nombre_casaComer) VALUES (?)";
    $stmt = $conexion->prepare($consulta); // Usamos la conexión correcta

    if ($stmt) {
        $stmt->bind_param('s', $casaComercial); // Vinculamos el parámetro (s para string)

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(['success' => true]); // En caso de éxito
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al ejecutar la consulta: ' . $stmt->error]);
        }

        $stmt->close(); // Cerramos el statement
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta: ' . $conexion->error]);
    }

    $conexion->close(); // Cerramos la conexión
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>
