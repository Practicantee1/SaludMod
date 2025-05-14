<?php
// Incluir la clase Usuario
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (file_exists("../../../model/Usuario.php")) {
    require_once "../../../model/Usuario.php";
} else {
    // Respuesta de error en formato JSON
    die(json_encode(["success" => false, "message" => "Error: El archivo de conexión no se encuentra USUARIO."]));
}
if (isset($_POST['login']) && isset($_POST['clave'])) {
    $login = $_POST['login'];
    $clave = $_POST['clave'];

    // Crear una instancia de la clase Usuario
    $usuario = new Usuario();
    // Llamar al método para verificar las credenciales
    $resultado = $usuario->verificar($login, hash("SHA256", $clave));
    // Verificar si la consulta fue exitosa y si se encontró el usuario
    if ($resultado && $resultado->num_rows > 0) {
        // Usuario autenticado correctamente
        // Obtener el nombre y el número de documento del usuario
        $datosUsuario = $resultado->fetch_assoc(); // Obtener datos del usuario
        $nombre = $datosUsuario['nombre']; // Cambia 'nombre' al nombre real de la columna
        $num_documento = $datosUsuario['num_documento']; // Cambia 'num_documento' al nombre real de la columna
        $cargo = $datosUsuario['cargo'];
        // Respuesta de éxito
        echo json_encode([
            "success" => true,
            "message" => "Usuario autenticado correctamente",
            "nombre" => $nombre,
            "num_documento" => $num_documento,
            "cargo" => $cargo
        ]);
    } else {
        // Si el usuario no fue encontrado, puedes hacer otra consulta para buscarlo
        echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos"]);
    }
} else {
    // Respuesta de error si faltan campos
    echo json_encode(["success" => false, "message" => "Por favor, complete todos los campos."]);
}
?>

