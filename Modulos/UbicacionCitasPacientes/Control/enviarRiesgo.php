

<?php
// Incluir el archivo de conexión a la base de datos
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}
error_log(print_r($_POST, true));


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['episodioPaciente']) && isset($_POST['numeroDocumentoRiesgos']) && isset($_POST['tipoRiesgo']) && isset($_POST['observacionRiesgo']) ) {
    

    

    $episodioPaciente = $_POST['episodioPaciente'];//episodioPacienteRiesgos
    $numeroDocumentoRiesgos = $_POST['numeroDocumentoRiesgos'];//numeroDocumentoRiesgosAcomp
    $tipoRiesgo = $_POST['tipoRiesgo']; //numeroDocumentoAcompanate
    $observacionRiesgo = $_POST['observacionRiesgo'];//nombresCompletosAcomp
   

          // Preparar la llamada al procedimiento almacenado
        $sql = "CALL SP_Insertar_Riesgos(?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isis", $episodioPaciente, $numeroDocumentoRiesgos, $tipoRiesgo, $observacionRiesgo);

        if ($stmt->execute()) {
            echo json_encode([
                "message" => "Data saved successfully"
            ]);
        } else {
            error_log("Error al guardar los datos: " . $stmt->error);
            echo json_encode([
                "Error" => "Error al guardar los datos: " . $stmt->error
            ]);
        }

        // Log the SQL statement and parameters
        error_log("SQL: " . $sql);
        error_log("Parameters: episodioPaciente=$episodioPaciente, numeroDocumento=$numeroDocumento, tipoRiesgo=$tipoRiesgo, observacionRiesgo=$observacionRiesgo");

}else{
     echo json_encode(["Error" => "Algunos datos están vacíos"]);
}
?>
