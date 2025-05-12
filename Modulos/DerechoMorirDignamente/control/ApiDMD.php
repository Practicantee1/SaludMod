<?php
include('../../../logica/ApiSap.php');
include('../../../config/Conexion.php');
require_once '../../../logica/ApiURL.php';
header("Content-Type: application/javascript");

$_SESSION["param"] = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NumeroDocumento = isset($_POST["NumeroDocumento"]) ? $_POST["NumeroDocumento"] : "";
    $DataPaciente = getDerechoMorirDignamenteApi($NumeroDocumento,$DatosIncapacidad['CentroSanitario']);

    if (($DataPaciente !== null) && array_key_exists('DatosPaciente', $DataPaciente) && !is_null($DataPaciente['DatosPaciente'])) {
        $DatosBasicos = $DataPaciente["DatosPaciente"];
        $DatosDireccion = $DatosBasicos["Direcciones"];
        $DatosUltimoEpisodio = isset($DataPaciente["DatosUltimoEpisodio"]) ? $DataPaciente["DatosUltimoEpisodio"] : null;

        // Asignar valores a los campos de entrada
        echo "document.getElementById('idNombrePaciente').value = '".addslashes($DatosBasicos["Nombre_completo"])."';";
        echo "document.getElementById('idNumeroIdentificacion').value = '".addslashes($DatosBasicos["Numero_documento"])."';";
        
        
    } else {
        echo "document.getElementById('idNombrePaciente').value = '';";
        echo "document.getElementById('idNumeroIdentificacion').value = '';";
        echo "Swal.fire({ icon: 'info', title: 'No se encontró el episodio solicitado', showConfirmButton: false, timer: 1500 });";
    }
} else {
    echo "console.error('Error: Invalid request method.');";
}

