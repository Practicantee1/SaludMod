<?php
include('../../../logica/ApiSap.php');

$primerNombre = isset($_POST["primerNombre"]) ? $_POST["primerNombre"] : "";
$primerApellido = isset($_POST["primerApellido"]) ? $_POST["primerApellido"] : "";
$SegundoApellido = isset($_POST["segundoApellido"]) ? $_POST["segundoApellido"] : "";

$DataPaciente = getUbicacionXnombreApi($primerNombre , $primerApellido , $SegundoApellido );

// Verifica si la clave existe y devuelve el JSON apropiado
if (isset($DataPaciente["DatosPaciente"])) {
    $datosPaciente = $DataPaciente["DatosPaciente"];
    echo json_encode($datosPaciente);
} else {
    echo json_encode([]);
}
?>
