<?php
header('Content-Type: application/json');

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_implantes";

// $conexion = new mysqli($servername, $username, $password, $dbname);

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
    $idCasa = $_POST['id'] ?? null;

    if ($idCasa) {
        $consulta = "UPDATE tbl_casa_comercial SET estado = '0' WHERE id_casa_comer = ?";
        $stmt = $conexion->prepare($consulta);

        if ($stmt) {
            $stmt->bind_param('i', $idCasa);
            $resultado = $stmt->execute();

            echo json_encode(['success' => $resultado]);
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de casa comercial no proporcionado.']);
    }

    $conexion->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>
