<?php
include('../../../logica/ApiSap.php');
include('../../../config/Conexion.php');
require '../../../logica/ApiURL.php';
// se realiza el consumo de la API por medio del episodio
header("Content-Type: application/javascript");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $episodio = isset($_POST["Episodio"]) ? $_POST["Episodio"] : "";

    // Verificar si el episodio fue proporcionado
    if (empty($episodio)) {
        echo "Swal.fire({ icon: 'error', title: 'Episodio vacío', text: 'Por favor, ingresa un número de episodio válido.', showConfirmButton: true });";
        exit();
    }

    // Llamada a la API
    $DataPaciente = getAppointment(0, $episodio,$DatosIncapacidad['CentroSanitario']);

    if (($DataPaciente !== null) && array_key_exists('DatosPaciente', $DataPaciente) && !is_null($DataPaciente['DatosPaciente'])) {
        $DatosBasicos = $DataPaciente["DatosPaciente"];
        $DatosUltimoEpisodio = isset($DataPaciente["DatosUltimoEpisodio"]) ? $DataPaciente["DatosUltimoEpisodio"] : null;

        // Asignar valores a los campos de entrada
        echo "document.getElementById('idNumeroDocumento').value = '".addslashes($DatosBasicos["Numero_documento"])."';";
        // echo "document.getElementById('idNumeroInterno').value = '".addslashes($DatosBasicos["Numero_paciente"])."';";
        echo "document.getElementById('idNombrePaciente').value = '".addslashes($DatosBasicos["Nombre_completo"])."';";
        echo "document.getElementById('idEdad').value = '".addslashes($DatosBasicos["Edad"])."';";
        echo "document.getElementById('idSexo').value = '".addslashes($DatosBasicos["Sexo"])."';";
        
        if ($DatosUltimoEpisodio) {
            echo "document.getElementById('idAsegurador').value = '".addslashes($DatosUltimoEpisodio["Aseguradora"])."';";
        }
        // if (array_key_exists('DatosEpisodio', $DataPaciente)) {
        //     $DatosEpisodio = $DataPaciente["DatosEpisodio"];
        
        //     if (array_key_exists('Diagnosticos', $DatosEpisodio) && is_array($DatosEpisodio['Diagnosticos'])) {
        //         // Limpiar el select de Diagnósticos antes de agregar nuevas opciones
        //         echo "var selectDiagnostico = document.getElementById('Diagnostico');";
        //         echo "selectDiagnostico.innerHTML = '<option value=\"\" selected>Seleccione una opción</option>';";
                
        //         // Iterar y agregar cada diagnóstico como una opción en el select
        //         foreach ($DatosEpisodio['Diagnosticos'] as $diagnostico) {
        //             $CodDiagnostico = addslashes($diagnostico['Cod_Diagnostico']);
        //             $DescripcionDiagnostico = addslashes($diagnostico['Diagnostico']);
        //             $optionText = $CodDiagnostico . ' - ' . $DescripcionDiagnostico;
        //             echo "selectDiagnostico.innerHTML += '<option value=\"$CodDiagnostico\">$optionText</option>';";
        //         }
        //     }
            
            
        // }
    } else {
        // No se encontraron datos para el episodio
        echo "document.getElementById('idNumeroDocumento').value = '';";
        echo "document.getElementById('idNombrePaciente').value = '';";
        echo "document.getElementById('idEdad').value = '';";
        echo "document.getElementById('idSexo').value = '';";
        echo "document.getElementById('idAsegurador').value = '';";
        echo "Swal.fire({ icon: 'info', title: 'Episodio no encontrado', text: 'No se encontró información para el episodio ingresado.', showConfirmButton: true });";
    }
} else {
    // Respuesta cuando el método de solicitud no es POST
    echo "Swal.fire({ icon: 'error', title: 'Error de solicitud', text: 'Método de solicitud inválido. Por favor, verifica la solicitud.', showConfirmButton: true });";
}
?>
