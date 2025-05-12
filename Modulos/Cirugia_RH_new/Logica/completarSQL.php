<?php
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
}

header('Content-Type: application/json; charset=utf-8'); // Asegurar tipo JSON

if (isset($_POST['id_paciente'])) {
    $id_paciente = $_POST['id_paciente']; // Recuperar id_paciente enviado por AJAX

    // Preparar consulta SQL
    $sql = "SELECT 
        Episodio, Numero_identificacion, edad, sexo, Nombre_paciente, Aseguradora, 
        tpro.procedimiento, Nombre_cirujano, Especialidad, fecha_cirugía,
        te.Nombre_identificacion, te.Instrumental, te.Alergia_reporta, 
        te.Consentimiento, te.Marcacion, te.Seleccione, te.Verificacion, 
        te.Confirmacion, te.Monitoreo, te.Perdida, te.Reserva, te.Disponibilidad, 
        te.Estudios, te.Via, te.Antibiotico, te.Suspension, te.Comercial, 
        te.Cultivos, te.patologias, te.observacionesEntrada,te.AlergiasReportadasIndicacion, te.AntibioticosDefinidos, te.esterilidad
        tpa.equipoHumano, tpa.Nombre_abordaje, tpa.Existen, tpa.Administracion, 
        tpa.Plan, tpa.Anestesiologo, tpa.Esterilidad, tpa.Vo, tpa.Detalles_relevantes, 
        tpa.T, tpa.perfusion, tpa.Observaciones_pausa, tpa.textoPlan,
        ts.programada, ts.complicaciones, ts.conteo, ts.camilla, ts.muestra, 
        ts.posopetario, ts.problemas, ts.observaciones
        FROM tbl_paciente_formulario_cirugia tp    
        LEFT JOIN tbl_entrada_formulario_cirugia te ON tp.Id_paciente = te.Id_paciente
        LEFT JOIN tbl_pausa_formulario_cirugia tpa ON tp.Id_paciente = tpa.Id_paciente
        LEFT JOIN tbl_salida_formulario_cirugia ts ON tp.Id_paciente = ts.Id_paciente
        LEFT JOIN tbl_procedimiento_formulario_cirugia tpro ON tp.Id_paciente = tpro.Id_paciente
        WHERE tp.Id_paciente = ?
        ORDER BY tp.Id_paciente ASC;";

    // Preparar la consulta
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("s", $id_paciente); // Pasar el parámetro correctamente

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = array();

            if ($result->num_rows > 0) {
                while ($fila = $result->fetch_assoc()) {
                    $data[] = $fila;
                }
            } else {
                $data = array("message" => "No se encontraron registros para id_paciente: " . $id_paciente);
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
    echo json_encode(array("error" => "No se recibió ningún id_paciente."));
}

$conexion->close();
?>
