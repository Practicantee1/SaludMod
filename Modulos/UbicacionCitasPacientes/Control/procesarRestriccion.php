<?php
// Incluimos la conexión a la base de datos
include('../../../config/Conexion.php');
session_start();

// Validamos que los datos llegaron correctamente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $episodioPaciente = $_POST['episodioPaciente'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $numeroDocumento = $_POST['numeroDocumento'];
    $nombresCompletos = $_POST['nombresCompletos'];
    $tipoRestriccion = $_POST['tipoRestriccion'];

    try {
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO tbl_restriccionesAcompañanteVisitantes 
                (episodioPaciente, tipoDocumentoAcomVisi, numeroDocumentoAcomVisi, nombresCompletosAcomVisi, tiporRestricción) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssi", $episodioPaciente, $tipoDocumento, $numeroDocumento, $nombresCompletos, $tipoRestriccion);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Datos registrados correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar los datos"]);
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
}
?>
