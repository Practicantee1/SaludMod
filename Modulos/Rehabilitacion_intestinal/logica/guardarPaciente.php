<?php
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Comprobar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}
$conexion->set_charset("utf8mb4");

// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}


$episodio = $_POST['episodio'] ?? '';
$documento = $_POST['documento'] ?? '';
$tipo_documento = $_POST['tipo_documento'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$edad = $_POST['edad'] ?? '';
$genero = $_POST['genero'] ?? '';
$ubicacion = $_POST['ubicacion'] ?? '';
$cama = $_POST['cama'] ?? '';
$entidad = $_POST['entidad'] ?? '';
$nombreMedico = $_POST['nombreMedico'] ?? '';
$especialidadMedico = $_POST['especialidadMedico'] ?? '';
$centrosanitario = $_POST['centrosanitario'] ?? '';

$examData = json_decode($_POST['examData'], true);

// Verifica si los datos de examen fueron recibidos correctamente
if ($examData === null) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid exam data']);
    exit();
}
$leucocitos = $examData['leucocitos'] ?? '';
$neutrofilos = $examData['neutrofilos'] ?? '';
$linfocitos = $examData['linfocitos'] ?? '';
$eosinofilos = $examData['eosinofilos'] ?? '';
$hemoglobina = $examData['hemoglobina'] ?? '';
$hematocrito = $examData['hematocrito'] ?? '';
$plaquetas = $examData['plaquetas'] ?? '';
$vsg = $examData['vsg'] ?? '';
$pcr = $examData['pcr'] ?? '';
$tgo_ast = $examData['tgo'] ?? '';
$tgp_alt = $examData['tgp'] ?? '';
$bilirrubina_total = $examData['bilirrubina_total'] ?? '';
$bilirrubina_directa = $examData['bilirrubina_directa'] ?? '';
$ggt = $examData['ggt'] ?? '';
$fosfatasa_alcalina = $examData['fosfatasa_alcalina'] ?? '';
$tp_inr = $examData['tp_inr'] ?? '';
$tpt = $examData['tpt'] ?? '';
$amilasa = $examData['amilasa'] ?? '';
$sodio = $examData['sodio'] ?? '';
$fosforo = $examData['fosforo'] ?? '';
$potasio = $examData['potasio'] ?? '';
$cloro = $examData['cloro'] ?? '';
$calcio = $examData['calcio'] ?? '';
$magnesio = $examData['magnesio'] ?? '';
$colesterol_total = $examData['colesterol_total'] ?? '';
$colesterol_hdl = $examData['colesterol_hdl'] ?? '';
$trigliceridos = $examData['trigliceridos'] ?? '';
$proteinas_totales = $examData['proteinas_totales'] ?? '';
$albumina = $examData['albumina'] ?? '';
$pre_albumina = $examData['pre_albumina'] ?? '';
$electroforesis_proteinas = $examData['electroforesis_proteinas'] ?? '';
$vitamina_b12 = $examData['vitamina_b12'] ?? '';
$vitamina_d = $examData['vitamina_d'] ?? '';
$creatinina = $examData['creatinina'] ?? '';
$glicemia = $examData['glicemia'] ?? '';
$gases_hco = $examData['HCO'] ?? '';
$gases_eb = $examData['EB'] ?? '';
$gases_ph = $examData['Ph'] ?? '';
$aislamientos = $examData['aislamientos'] ?? '';
$examenes_complementarios = $examData['examenesComplementarios'] ?? '';

// Verificar si hay datos para guardar

try {
    // Guardar datos del paciente y recuperar el ID del paciente insertado
    $query = "CALL SP_guardar_paciente_RI(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("isssssssssss", $episodio, $tipo_documento, $documento, $nombre, $edad, $genero, $ubicacion, $cama, $entidad, $nombreMedico, $especialidadMedico, $centrosanitario);
    $stmt->execute();
    $stmt->bind_result($idPaciente);
    $stmt->fetch();
    $stmt->close(); // Cierra el statement
    $conexion->next_result(); // Limpia cualquier resultado previo

    $query = "CALL SP_guardar_examenes_RI(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("issssssssssssssssssssssssssssssssssssssss", $idPaciente, $leucocitos, $neutrofilos, $linfocitos, $eosinofilos, $hemoglobina, $hematocrito, $plaquetas, $vsg, $pcr, $tgo_ast, $tgp_alt, $bilirrubina_total, $bilirrubina_directa, $ggt, $fosfatasa_alcalina, $tp_inr, $tpt, $amilasa, $sodio, $fosforo, $potasio, $cloro, $calcio, $magnesio, $colesterol_total, $colesterol_hdl, $trigliceridos, $proteinas_totales, $albumina, $pre_albumina, $electroforesis_proteinas, $vitamina_b12, $vitamina_d, $creatinina, $glicemia, $gases_hco, $gases_eb, $gases_ph, $aislamientos, $examenes_complementarios);
    $stmt->execute();
    $stmt->close();
    $conexion->next_result();
    
    
    
    echo json_encode(['status' => 'success', 'idPaciente' => $idPaciente,'centrosanitario'=> $centrosanitario]);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $e->getMessage()]);
}

$conexion->close();
?>