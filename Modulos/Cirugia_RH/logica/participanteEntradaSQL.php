<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../../config/Conexion.php');

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

header('Content-Type: application/json'); // Especificamos que queremos retornar JSON

if (isset($_POST['id_paciente']) && isset($_POST['completado'])) {
    $id_paciente = $_POST['id_paciente']; // Recuperamos el valor del episodio que nos manda el AJAX
    $completado = $_POST['completado'];
    $tipo = "INICIO";

// la anterior consulta si se usa el selec para cargos: 
// SELECT c.cargo, e.nombre_completoE, e.numero_documentoE
// FROM tbl_firma_entrada_formulario_cirugia e
// JOIN tbl_cargos_formulario_cirugia c ON e.cargoE = c.id
// WHERE e.Id_paciente = (
//     SELECT Id_paciente
//     FROM tbl_paciente_formulario_cirugia
//     WHERE Id_paciente = ?
// );

    $sql = "CALL sp_verificar_firmas_completado(?, ?, ?)";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincula el parámetro
        $stmt->bind_param("iis", $id_paciente, $completado, $tipo);

        if ($stmt->execute()) {
            $result = $stmt->get_result(); // Obtenemos los resultados de la consulta

            if ($result->num_rows > 0) {
                $fila = $result->fetch_all(MYSQLI_ASSOC);
                    
                echo json_encode(["success" => true, "message" => $fila]); // Retornamos el array como JSON
            }else{
                echo json_encode(["success" => false, "message" => "No se encontraron firmas completas para esta pausa"]);
            }    
        } else {
            echo json_encode(["success" => false, "message" => "Error en la ejecución de la consulta: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta: " . $conexion->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No se recibió ningún"]);
}

$conexion->close();
?>
