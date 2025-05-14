<?php
include('../../../config/Conexion.php');

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Consulta para obtener los cargos
$sql = "SELECT id, cargo FROM tbl_cargos_formulario_cirugia";
$result = $conexion->query($sql);

$cargos = [];
if ($result->num_rows > 0) {
    // Guardar los resultados en un array
    while ($row = $result->fetch_assoc()) {
        $cargos[] = $row; // Almacena cada fila en el array
    }
}

// Cerrar la conexión
$conexion->close();

// Devolver los cargos como un JSON
header('Content-Type: application/json'); // Asegúrate de enviar el encabezado JSON
echo json_encode($cargos);
?>
