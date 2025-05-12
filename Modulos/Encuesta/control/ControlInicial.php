<?php
include('../../../logica/ApiSap.php');
include('../../../config/Conexion.php');

header("Content-Type: application/javascript");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $episodio = isset($_POST["episodio"]) ? $_POST["episodio"] : "";
    $DataPaciente = getAppointment(0, $episodio);

    if (($DataPaciente !== null) && array_key_exists('DatosPaciente', $DataPaciente) && !is_null($DataPaciente['DatosPaciente'])) {
        $DatosBasicos = $DataPaciente["DatosPaciente"];
        $DatosUltimoEpisodio = isset($DataPaciente["DatosUltimoEpisodio"]) ? $DataPaciente["DatosUltimoEpisodio"] : null;

        // Asignar valores a los campos de entrada
        echo "document.getElementById('idNumeroDocumento').value = '".addslashes($DatosBasicos["Numero_documento"])."';";
        echo "document.getElementById('idNumeroInterno').value = '".addslashes($DatosBasicos["Numero_paciente"])."';";
        echo "document.getElementById('idNombrePaciente').value = '".addslashes($DatosBasicos["Nombre_completo"])."';";
        
        if ($DatosUltimoEpisodio) {
            echo "document.getElementById('idAsegurador').value = '".addslashes($DatosUltimoEpisodio["Aseguradora"])."';";
        }

        if (array_key_exists('DatosEpisodio', $DataPaciente)) {
            $DatosEpisodio = $DataPaciente["DatosEpisodio"];
        
            if (array_key_exists('Diagnosticos', $DatosEpisodio) && is_array($DatosEpisodio['Diagnosticos'])) {
                // Limpiar el select de Diagnósticos antes de agregar nuevas opciones
                echo "var selectDiagnostico = document.getElementById('Diagnostico');";
                //echo "selectDiagnostico.innerHTML = '<option value=\"\" selected>Seleccione una opción</option>';";
                
                // Iterar y agregar cada diagnóstico como una opción en el select
                foreach ($DatosEpisodio['Diagnosticos'] as $diagnostico) {
                    $CodDiagnostico = addslashes($diagnostico['Cod_Diagnostico']);
                    $DescripcionDiagnostico = addslashes($diagnostico['Diagnostico']);
                    $optionText = $CodDiagnostico . ' - ' . $DescripcionDiagnostico;
                    echo "selectDiagnostico.innerHTML += '<option value=\"$CodDiagnostico\">$optionText</option>';";
                }
            }
            
        }
    
    } else {
        echo "document.getElementById('idNumeroInterno').value = '';";
        echo "document.getElementById('idNumeroDocumento').value = '';";
        echo "document.getElementById('idNombrePaciente').value = '';";
        echo "document.getElementById('idAsegurador').value = '';";
        echo "document.getElementById('idFechaCirugia').value = '';";
        echo "Swal.fire({ icon: 'info', title: 'No se encontró el documento solicitado', showConfirmButton: false, timer: 1500 });";
    }
} else {
    echo "console.error('Error: Invalid request method.');";
}
?>
