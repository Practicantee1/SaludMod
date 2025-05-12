<?php
// include('/SaludMod/logica/ApiSap.php');
$file_path = realpath('../../../../logica/ApiSap.php');
if ($file_path === false) {
    echo json_encode("File not found: " . $file_path);
} else {
    include($file_path);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['Documento'])){

    $Documento = $_POST['Documento'];
    $dataR = getProg_edu_API($Documento);

    header('Content-Type: application/json');

    if (!empty($dataR)) {
        echo json_encode($dataR);
    } else {
        $error = isset($dataR['error']) ? $dataR['error'] : 'No data returned from API';
        echo json_encode(['error' => $error]);
    }
}
}
?>
