<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../../config/Conexion.php');

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

header('Content-Type: application/json'); // Especificamos que queremos retornar JSON

if (isset($_POST['id_paciente'])) {
    $id_paciente = $_POST['id_paciente']; // Recuperamos el valor del episodio que nos manda el AJAX

    // la anterior consulta si se usa el selec para cargos: 
    // SELECT c.cargo, s.nombre_completoS, s.numero_documentoS
    // FROM tbl_firma_salida_formulario_cirugia s
    // JOIN tbl_cargos_formulario_cirugia c ON s.cargoS = c.id
    // WHERE s.Id_paciente = (
    //     SELECT Id_paciente
    //     FROM tbl_paciente_formulario_cirugia
    //     WHERE Id_paciente = ?
    // );
    
    $sql = "SELECT s.cargoS AS cargo, s.nombre_completoS, s.numero_documentoS
FROM tbl_firma_salida_formulario_cirugia s
WHERE s.Id_paciente = (
    SELECT Id_paciente
    FROM tbl_paciente_formulario_cirugia
    WHERE Id_paciente = ?
);
";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincula el parámetro
        $stmt->bind_param("s", $id_paciente);

        if ($stmt->execute()) {
            $result = $stmt->get_result(); // Obtenemos los resultados de la consulta
            $data = array(); // Creamos un array
            if ($result->num_rows > 0) {
                while ($fila = $result->fetch_assoc()) {
                    $data[] = $fila; // Guardamos cada fila en el array
                }
            }
            echo json_encode($data); // Retornamos el array como JSON
        } else {
            echo json_encode(array("error" => "Error en la ejecución de la consulta: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "Error en la preparación de la consulta: " . $conexion->error));
    }
} else {
    echo json_encode(array("error" => "No se recibió ningún episodio."));
}

$conexion->close();
?>
