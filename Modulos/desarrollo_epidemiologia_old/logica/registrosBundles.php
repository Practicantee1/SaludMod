
<?php
include('../../../config/Conexion.php');

// Crear conexión

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

header('Content-Type: application/json'); // Especificamos que queremos retornar JSON

if (isset($_POST['valor'])) {
    $episodio = $_POST['valor']; // Recuperamos el valor del episodio que nos manda el AJAX
    $numero_identificacion = $_POST['valor']; // Recuperamos el número de identificación

    $sql = "SELECT
        Episodio,
        Numero_identificacion,
        edad,
        sexo,
        Nombre_paciente,
        Aseguradora,
        tpro.procedimiento,
        Nombre_cirujano, 
        Especialidad,
        fecha_cirugía,
        te.Nombre_identificacion,
        te.Instrumental,
        te.Al
        ts.posopetario,
        ts.problemas,
        ts.observaciones
    FROM tbl_paciente_formulario_cirugia tp
        LEFT JOIN tbl_entrada_formulario_cirugia te ON tp.Id_paciente = te.Id_paciente
        LEFT JOIN tbl_pausa_formulario_cirugia tpa ON tp.Id_paciente = tpa.Id_paciente
        LEFT JOIN tbl_salida_formulario_cirugia ts ON tp.Id_paciente = ts.Id_paciente
        LEFT JOIN tbl_procedimiento_formulario_cirugia tpro ON tp.Id_paciente = tpro.Id_paciente
    WHERE tp.entrada = 'COMPLETADO' 
        AND tp.pausa = 'COMPLETADO' 
        AND tp.salida = 'COMPLETADO' 
        AND tp.firmaEntrada = 'COMPLETADO' 
        AND tp.firmaSalida = 'COMPLETADO'
        AND (Episodio = ? OR Numero_identificacion = ?)  -- Aquí validamos ambos campos
    ORDER BY `tp`.`fecha_cirugía` ASC;"; // Guardamos la consulta SQL en una variable

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("ss", $episodio, $numero_identificacion); // Ajustamos los parámetros para incluir ambos valores

        if ($stmt->execute()) {
            $result = $stmt->get_result(); // Obtenemos los resultados de la consulta
            $data = array(); // Creamos un array
            if ($result->num_rows > 0) {
                while ($fila = $result->fetch_assoc()) { // Convertimos el resultado en un array asociativo y lo guardamos en $fila
                    $data[] = $fila;
                }
            } 
            echo json_encode($data);
        } else {
            echo json_encode(array("error" => "Error en la ejecución de la consulta: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("error" => "Error en la preparación de la consulta: " . $conexion->error));
    }
} else {
    echo json_encode(array("error" => "No se recibieron los datos necesarios."));
}

$conexion->close();
?>