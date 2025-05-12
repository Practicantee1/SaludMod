<?php
// include('../../../logica/ApiSap.php');

// if (isset($_GET['numeroDocumento'])) {
//     $numeroDocumento = $_GET['numeroDocumento'];
//     $datosPaciente = getApi(0, $numeroDocumento, "HSVM");

//     if ($datosPaciente && isset($datosPaciente['DatosUltimoEpisodio']['Episodio'])) {
//         echo json_encode(["status" => "success", "episodio" => $datosPaciente['DatosUltimoEpisodio']['Episodio']]);
//     } else {
//         echo json_encode(["status" => "error", "message" => "No se encontró el episodio"]);
//     }
// } else {
//     echo json_encode(["status" => "error", "message" => "Falta el número de documento"]);
// }


include('../../../logica/ApiSap.php');
// include('../../../config/Conexion.php');

header("Content-Type: application/javascript");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $episodio = isset($_POST["episodio"]) ? $_POST["episodio"] : "";
    $datos = getRestriccionesApi($episodio);

 

    if (($datos !== null) && array_key_exists('DatosPaciente', $datos) && !is_null($datos['DatosPaciente'])) {
        $DatosBasicos = $datos["DatosPaciente"];
        // $DatosDireccion = $DatosBasicos["Direcciones"];
        // $DatosUltimoEpisodio = isset($datos["DatosUltimoEpisodio"]) ? $datos["DatosUltimoEpisodio"] : null;

        // Asignar valores a los campos de entrada
        echo "document.getElementById('nombresCompletos').value = '" . addslashes($DatosBasicos["Nombre_completo"]) . "';";
        echo "document.getElementById('numeroDocumento').value = '" . addslashes($DatosBasicos["Numero_documento"]) . "';";
        echo "document.getElementById('tipoDocumento').value = '" . addslashes($DatosBasicos["Desc_documento"]) . "';";

        // Asignar valores a los campos de entrada de modal reisgos
        echo "document.getElementById('nombresCompletosRiesgos').value = '" . addslashes($DatosBasicos["Nombre_completo"]) . "';";
        echo "document.getElementById('numeroDocumentoRiesgos').value = '" . addslashes($DatosBasicos["Numero_documento"]) . "';";
        echo "document.getElementById('tipoDocumentoRiesgos').value = '" . addslashes($DatosBasicos["Desc_documento"]) . "';";
    } else {
        echo "document.getElementById('idNombrePaciente').value = '';";
        echo "document.getElementById('idNumeroIdentificacion').value = '';";
        echo "Swal.fire({ icon: 'info', title: 'No se encontró el episodio solicitado', showConfirmButton: false, timer: 1500 });";
    }
} else {
    echo "console.error('Error: Invalid request method.');";
}


