<?php
// ob_start(); // Inicia el almacenamiento en búfer para evitar salidas accidentales

// include('../../../config/Conexion.php');

// // Verificar conexión
// if ($conexion->connect_error) {
//     die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
// }


header('Content-Type: application/json'); // Aseguramos el formato JSON

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_implantes";

// // Crear conexión
// $conexion = new mysqli($servername, $username, $password, $dbname);

// // Verificar la conexión
// if ($conexion->connect_error) {
//     echo json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error));
//     exit;
// }
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
}

if (isset($_POST['inicio']) && isset($_POST['fin'])) {
    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];

    // Validar que las fechas no estén vacías
    if (empty($inicio) || empty($fin)) {
        echo json_encode(array("error" => "Las fechas de inicio y fin son requeridas."));
        exit;
    }

    // Debug: Verificar los valores en el log de PHP
    error_log("Fecha de inicio: $inicio, Fecha de fin: $fin");

    // Preparar la consulta SQL
    $sql = "SELECT DISTINCT
                Episodio,
                Numero_identificacion,
                Nombre_paciente,
                Aseguradora,
                Nombre_cirujano, 
                Especialidad,
                fecha_cirugía, 
                Observaciones, 
                tid.diagnosticoNombre,
                tbl_casa_comercial.nombre_casaComer,
                tid.tipoImplante,
                tid.entrenamiento_Soport,
                tid.tiempo_Soporte,
                tid.material_complet,
                tid.falla_implant_cx,
                tid.impl_tiempo_corpaul,
                tid.impl_completo_corpaul
            FROM tbl_implantes ti
            INNER JOIN tbl_implantes_detalles tid ON ti.Id_paciente = tid.Id_paciente
            INNER JOIN tbl_casa_comercial ON tid.Id_casa_Comercial = tbl_casa_comercial.id_casa_comer
            WHERE fecha_cirugía BETWEEN ? AND ?
            ORDER BY fecha_cirugía ASC;";

    // Preparar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("ss", $inicio, $fin); // Vincular parámetros

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = array();

            // Recoger los resultados
            while ($fila = $result->fetch_assoc()) {
                $data[] = $fila;
            }

            // Verificar si hay datos
            if (empty($data)) {
                echo json_encode(array("mensaje" => "No se encontraron registros para las fechas seleccionadas."));
            } else {
                // Devolver los resultados en formato JSON
                echo json_encode($data);
            }
        } else {
            // Manejo de error en la ejecución
            echo json_encode(array("error" => "Error en la ejecución de la consulta: " . $stmt->error));
        }

        $stmt->close(); // Cerrar la sentencia
    } else {
        // Manejo de error en la preparación
        echo json_encode(array("error" => "Error en la preparación de la consulta: " . $conexion->error));
    }
} else {
    // Manejo de error si no se reciben los datos necesarios
    echo json_encode(array("error" => "No se recibieron los datos necesarios."));
}

$conexion->close(); // Cerrar conexión a la base de datos
?>
