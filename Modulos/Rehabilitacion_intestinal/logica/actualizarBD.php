
<?php 
include('../../../config/Conexion.php');
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['idPaciente']) && isset($data['data'])) {
    $idPaciente = $data['idPaciente'];
    $values = $data['data'];

    // Convertir el array de objetos a un array asociativo plano
    $parsedValues = [];
    foreach ($values as $item) {
        $parsedValues[$item['idExam']] = $item['value'];
    }

    $sql = "CALL SP_actualizar_examenes_RI(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param(
            'ssssssssssssssssssssssssssssssssssssss', 
            $idPaciente,
            $parsedValues['leucocitos'], $parsedValues['neutrofilos'], $parsedValues['linfocitos'], $parsedValues['eosinofilos'], $parsedValues['hemoglobina'],$parsedValues['hematocrito'], $parsedValues['plaquetas'], $parsedValues['vsg'], $parsedValues['pcr'], $parsedValues['tgo'],$parsedValues['tgp'], $parsedValues['bilirrubina_total'], $parsedValues['bilirrubina_directa'], $parsedValues['ggt'], $parsedValues['fosfatasa_alcalina'],$parsedValues['tp_inr'], $parsedValues['tpt'], $parsedValues['amilasa'], $parsedValues['sodio'], $parsedValues['fosforo'],$parsedValues['potasio'], $parsedValues['cloro'], $parsedValues['calcio'], $parsedValues['magnesio'], $parsedValues['colesterol_total'],$parsedValues['colesterol_hdl'], $parsedValues['trigliceridos'], $parsedValues['proteinas_totales'], $parsedValues['albumina'], $parsedValues['pre_albumina'], $parsedValues['vitamina_b12'], $parsedValues['vitamina_d'], $parsedValues['creatinina'], $parsedValues['glicemia'],$parsedValues['HCO'], $parsedValues['EB'], $parsedValues['Ph']);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Data saved successfully"]);
        } else {
            echo json_encode(['error' => "Error al ejecutar la consulta: " . $stmt->error]);
        }
    } else {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
    }
} else {
    echo json_encode(['error' => "Faltan parametros en la solicitud"]);
}