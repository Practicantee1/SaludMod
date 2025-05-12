<?php
include('../../../logica/ApiSap.php');
include('../../../config/Conexion.php');
require_once '../../../logica/ApiURL.php';

header("Content-Type: application/javascript");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $episodio = isset($_POST["episodio"]) ? $_POST["episodio"] : "";
    $DataPaciente = getEpidemiologiaApi($episodio,$DatosIncapacidad['CentroSanitario']);

    if (($DataPaciente !== null) && array_key_exists('DatosPaciente', $DataPaciente) && !is_null($DataPaciente['DatosPaciente'])) {
        $DatosBasicos = $DataPaciente["DatosPaciente"];
        $DatosUltimoEpisodio = isset($DataPaciente["DatosUltimoEpisodio"]) ? $DataPaciente["DatosUltimoEpisodio"] : null;

        // Asignar valores a los campos de entrada
        echo "document.getElementById('nroDoc').value = '".addslashes($DatosBasicos["Numero_documento"])."';";
        echo "document.getElementById('nombrePaciente').value = '".addslashes($DatosBasicos["Nombre_completo"])."';";
        echo "document.getElementById('sexo').value = '".addslashes($DatosBasicos["Sexo"])."';";
        echo "document.getElementById('edad').value = '".addslashes($DatosBasicos["Edad"])."';";
        echo "document.getElementById('tipo').value = '".addslashes($DatosBasicos["Tipo_documento"])."';";

        
        if ($DatosUltimoEpisodio) {
            echo "document.getElementById('entidad').value = '".addslashes($DatosUltimoEpisodio["Aseguradora"])."';";
        }

        if(array_key_exists('DatosEpisodio', $DataPaciente)){
            if(array_key_exists('Ubicacion', $DataPaciente['DatosEpisodio'])){
                $UbicacionPaciente = $DataPaciente["DatosEpisodio"]["Ubicacion"];

                ?>
                document.getElementById("ubicacion").value = '<?php echo $UbicacionPaciente["UbicacionEdificio"]; ?>';
                document.getElementById("cama").value = '<?php echo $UbicacionPaciente["IdUbicacion_cama"]; ?>';


                <?php

            }
        }

        // if (array_key_exists('DatosEpisodio', $DataPaciente)) {
        //     $DatosEpisodio = $DataPaciente["DatosEpisodio"];
        
        //     if (array_key_exists('Diagnosticos', $DatosEpisodio) && is_array($DatosEpisodio['Diagnosticos'])) {
        //         echo "document.getElementById('ubicacion').value = '".addslashes($DatosEpisodio["UbicacionEdificio"])."';";
        //         echo "document.getElementById('cama').value = '".addslashes($DatosEpisodio["IdUbicacion_cama"])."';";
                
                
        //     }
            
        // }
    } else {
        echo "document.getElementById('nroDoc').value = '';";
        echo "document.getElementById('nombrePaciente').value = '';";
        echo "document.getElementById('sexo').value = '';";
        echo "document.getElementById('edad').value = '';";
        echo "document.getElementById('entidad').value = '';";
        echo "document.getElementById('ubicacion').value = '';";
        echo "document.getElementById('cama').value = '';";
        // echo "Swal.fire({ icon: 'info', title: 'No se encontró el episodio solicitado', showConfirmButton: false, timer: 1500 });";
    }
} else {
    echo "console.error('Error: Invalid request method.');";
}

