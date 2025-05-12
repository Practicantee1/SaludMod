<?php
require_once '../../../config/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Verificar si se han enviado IDs seleccionados
    if (isset($_POST['selectedIds']) && is_array($_POST['selectedIds']) && count($_POST['selectedIds']) > 0) {
        // Almacena el ID que se seleccionó
        $selectedIds = $_POST['selectedIds'];

        // Iterar sobre los IDs y ejecutar el procedimiento almacenado para cada uno
        foreach ($selectedIds as $id) {
            $sql = "CALL SP_Actualizar_Estado_Acompanante($id)";

            if ($conexion->query($sql) === TRUE) {
                
            } else {
                
            }
        }
    } else {
        echo "No se han enviado IDs seleccionados";
    }

    // Cerrar la conexión
    $conexion->close();
}
?>
