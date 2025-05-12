<?php
// Obtenemos la conexión
require_once '../../../config/Conexion.php';

// Verificamos si se han enviado datos mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificamos la conexión
    if ($conexion->connect_error) {
        die("La conexión ha fallado: " . $conexion->connect_error);
    }

    // Obtenemos los datos enviados desde el formulario
    $idNumero = $_POST['IdNumero'];//hace referencia al id del paciente
    $id = $_POST['Id'];// hace referencia al id del acompañante
    $nombre_acompanante = $_POST['NombreAcompanante'];//nombre del acompañante
    $estado = $_POST["estado"];//estado del acompañante
    $fecha = $_POST["Fecha"];
    $hora = $_POST["Hora"];
    $opcion = $_POST["compania"];//opcion de compañia
    $tipoDocumento = $_POST["tipoDocumentoAcompanante"]; 
    // Datos del acompañante nuevos
    $apellido_acompanante = $_POST["ApellidoAcompanante"];
    $genero = $_POST["Genero"];
    $telefono = $_POST ["Telefono"];
   // $hora_salida = $_POST ["HoraSalida"];
   // $fecha_salida = $_POST ["FechaSalida"];
    $direccion = $_POST ["Direccion"];
    $id_cama= $_POST["Bed_code"];
    
    // Manejo del archivo (BLOB)
    //aqui se obtiene el archivo que se sube, fot
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $archivo_tmp = $_FILES['archivo']['tmp_name']; // Obtiene el archivo temporal
        $archivo_contenido = file_get_contents($archivo_tmp); // Contenido del archivo
    } else {
        echo "No se ha subido un archivo válido.";
        exit;
    }

    // Preparamos la consulta para insertar los datos en la tabla
    $sql = "CALL SP_Insertar_Acompanante( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparamos la consulta con la conexión
    if ($stmt = $conexion->prepare($sql)) {
        // Enlazamos los parámetros  $fecha_salida, $hora_salida estos datos si algun dia se requieren 
        $stmt->bind_param("ssssssssssssss", $idNumero, $id, $nombre_acompanante, $opcion, $estado, $fecha, $hora, $archivo_contenido,$tipoDocumento, $apellido_acompanante, $telefono,$genero,$direccion,$id_cama);
        
        // Ejecutamos la consulta
        if ($stmt->execute()) {
            echo "Guardado correctamente";
        } else {
            echo "Error al guardar: " . $stmt->error;
        }
        
        // Cerramos la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conexion->error;
    }

    // Cerramos la conexión con la base de datos
    $conexion->close();
}
?>
