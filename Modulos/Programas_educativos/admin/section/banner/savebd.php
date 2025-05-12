<?php 
include('../../../../../config/Conexion.php');
if(isset($_POST['Episodio']) && isset($_POST['Documento']) && isset($_POST['Nombre']) && isset($_POST['Fecha']) && isset($_POST['Sugerencias']) && isset($_POST['pregunta1'])&& isset($_POST['pregunta2'])&& isset($_POST['pregunta3'])&& isset($_POST['pregunta4'])&& isset($_POST['pregunta5'])){

    $Episodio = $_POST['Episodio'];
    $Documento = $_POST['Documento'];
    $Nombre = $_POST['Nombre'];
    $Fecha = $_POST['Fecha'];
    $Sugerencias = $_POST['Sugerencias'];
    $pregunta1 = $_POST['pregunta1'];
    $pregunta2 = $_POST['pregunta2'];
    $pregunta3 = $_POST['pregunta3'];
    $pregunta4 = $_POST['pregunta4'];
    $pregunta5 = $_POST['pregunta5'];
    $usuario = $_POST['usuario'];

    $sql = "INSERT INTO `satisfaccion` 
    (`id_formulario`, `episode`, `nombre_completo`, `cc_document`, `fecha`, `pregunta_1`, `pregunta_2`, `pregunta_3`, `pregunta_4`, `pregunta_5`, `pregunta_8`, `usuarioRegistra`)
    VALUES ('1', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('sssssssssss', $Episodio, $Nombre, $Documento, $Fecha, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5, $Sugerencias,$usuario);

        if ($stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode(["message" => "Data saved successfully"]);
        } else {
            throw new Exception('Error al ejecutar la consulta: ' . $stmt->error);
        }
    }else {
        echo json_encode(['error' => "Error en la preparación de la consulta: " . $conexion->error]);
    }
}else {
    echo json_encode(['error' => "Faltan parámetros en la solicitud"]);
}