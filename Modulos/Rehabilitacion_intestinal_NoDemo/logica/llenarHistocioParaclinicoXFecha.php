<?php
include('../../../config/Conexion.php');

// Configuración de la cabecera para JSON
header('Content-Type: application/json');

// Verificar conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

// Validar si el parámetro 'episodio' está definido
if (isset($_POST['episodio']) && isset($_POST['documento']) && isset($_POST['fechaDesde']) && isset($_POST['fechaHasta'])) {
    $episodio = (int)$_POST['episodio'];
    $documento = $_POST['documento'];
    $fechaDesde = $_POST['fechaDesde'];
    $fechaHasta = $_POST['fechaHasta'];
    $examenes = [];

    // Preparar la consulta SQL
    $sql = "CALL SP_consulta_examenes_porfecha_RI(?, ?, ?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        // Vincular parámetro y ejecutar la consulta
        $stmt->bind_param('is', $episodio, $documento);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Obtener resultados
            while ($row = $result->fetch_assoc()) {
                $examenes[] = [
                    'FECHA'=> $row['fecha'],
                    'HORA' => $row['hora'],
                    'LEUCOCITOS' => $row['leucocitos'],
                    'NEUTROFILOS' => $row['neutrofilos'],
                    'LINFOCITOS' => $row['linfocitos'],
                    'EOSINOFILOS' => $row['eosinofilos'],
                    'HEMOGLOBINA' => $row['hemoglobina'],
                    'HEMATOCRITO' => $row['hematocrito'],
                    'PLAQUETAS' => $row['plaquetas'],
                    'VSG' => $row['vsg'],
                    'PCR' => $row['pcr'],
                    'TGO/AST ' => $row['tgo_ast'],
                    'TGP/ALT' => $row['tgp_alt'],
                    'BILIRRUBINA TOTAL' => $row['bilirrubina_total'],
                    'BILIRRUBINA DIRECTA' => $row['bilirrubina_directa'],
                    'GGT' => $row['ggt'],
                    'FOSFATASA ALCALINA' => $row['fosfatasa_alcalina'],
                    'TP/INR' => $row['tp_inr'],
                    'TPT' => $row['tpt'],
                    'AMILASA' => $row['amilasa'],
                    'SODIO' => $row['sodio'],
                    'FOSFORO' => $row['fosforo'],
                    'POTASIO' => $row['potasio'],
                    'CLORO' => $row['cloro'],
                    'CALCIO' => $row['calcio'],
                    'MAGNESIO' => $row['magnesio'],
                    'COLESTEROL TOTAL' => $row['colesterol_total'],
                    'COLESTEROL HDL' => $row['colesterol_hdl'],
                    'TRIGLICERIDOS' => $row['trigliceridos'],
                    'PROTEINAS TOTALES' => $row['proteinas_totales'],
                    'ALBUMINA' => $row['albumina'],
                    'PRE ALBUMINA' => $row['pre_albumina'],
                    // 'ELECTROFORESIS DE PROTEINAS' => $row['electroforesis_proteinas'],
                    'VITAMINA B12' => $row['vitamina_b12'],
                    'VITAMINA D' => $row['vitamina_d'],
                    'CREATININA' => $row['creatinina'],
                    'GLICEMIA' => $row['glicemia'],
                    'GASES HCO&#8323;&#8315;' => $row['gases_hco'],
                    'GASES EB' => $row['gases_eb'],
                    'GASES PH' => $row['gases_ph'],
                    'EXAMENES COMPLEMENTARIOS' => $row['examenes_complementarios'],
                    'AISLAMIENTOS' => $row['aislamientos'],
                    'x' => $row['edad'],
                    'id'=>$row['id']
                ];
            }

            // Respuesta JSON con los datos obtenidos
            echo json_encode(['status' => 'success', 'examenes' => $examenes]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Preparation failed: ' . $conexion->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parameter "episodio" not set']);
}

$conexion->close();
?>
