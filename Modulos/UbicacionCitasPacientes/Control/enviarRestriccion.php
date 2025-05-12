<?php
// Incluir el archivo de conexión a la base de datos
include('../../../config/Conexion.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['episodioPaciente']) && isset($_POST['tipoDocumento']) && isset($_POST['numeroDocumentoAcompanate']) && isset($_POST['nombresCompletosAcomp']) && isset($_POST['tipoRestriccion'])) {
    
    $episodioPaciente = $_POST['episodioPaciente'];//episodioPaciente
    $tipoDocumento = $_POST['tipoDocumento'];//tipoDocumentoAcomp
    $numeroDocumento = $_POST['numeroDocumentoAcompanate']; //numeroDocumentoAcompanate
    $nombresCompletos = $_POST['nombresCompletosAcomp'];//nombresCompletosAcomp
    $tipoRestriccion = $_POST['tipoRestriccion'];//tipoRestriccion

          // Preparar la llamada al procedimiento almacenado
        $sql = "CALL SP_Insertar_RestriccionesAcompVist(?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("isssi", $episodioPaciente, $tipoDocumento, $numeroDocumento, $nombresCompletos, $tipoRestriccion);

        if ($stmt->execute()) {
            echo json_encode([
                "message" => "Data saved successfully"
            ]);
        } else {
            echo json_encode([
                "Error" => "Error al guardar los datos: " . $stmt->error
            ]);
        }

}else{
    echo "Datos vacios" ;
}
?>
