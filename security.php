<?php

/*
 * Script que gestiona el acceso a la aplicación por medio del directorio activo
 * 
 * 
 */
session_start();
require_once './lib/Lib.php';
require_once './Conexion.php'; //inclusión de librerías
$co = new Conexion(); //Nueva instanacia de la conexión
$c = $co->getConn();


$library = new Lib("lib");
$library->ldap();

/* Definición de los permisos de administrador */
$usuario = $_REQUEST['user'];
$clave = $_REQUEST['password'];
if ($usuario == "admin" && $clave == "soporte") {
    $_USERDATA = array(
        "user" => "admin",
        "completeNames" => "Usuario Administrador",
        "phone" => "444 13 33",
        "mail" => "admin",
        "userId" => 0,
        "permission" => "1-r1-r2-adm");


    $_SESSION['fst'] = $_USERDATA;
    $_SESSION['snd'] = base64_encode("Admin");

    // header("Location: admin");
    //echo 'true';
    echo "<script>location.href='admin'</script>";
    exit();
}

try {
    $da = new adLDAP();
} catch (Exception $ex) {
    
}

$res = $c->query("SELECT * FROM colaborador WHERE usuario='$usuario' AND activo=1");
if ($res->num_rows < 1) {
    $validation = $da->authenticate($usuario, $clave);
    if ($validation) {
        $result = $da->user()->info($usuario);
        @$phonenumber = $result[0]['telephonenumber'][0];
        @$displayname = $result[0]['displayname'][0];
        @$mail = $result[0]['mail'][0];


        $_USERDATA = array(
            "user" => $usuario,
            "completeNames" => $displayname,
            "phone" => $phonenumber,
            "mail" => $mail,
            "userId" => 1,
            "permission" => "1");


        $_SESSION['fst'] = $_USERDATA;
        $_SESSION['snd'] = base64_encode("Admin");


        echo "<script>location.href='admin'</script>";
        exit();

        $da->close();
    } else {
        echo "Error, el usuario o la clave están errados.";
        exit();
    }
} else {
    $recibido = $res->fetch_object();
    $validation = $da->authenticate($usuario, $clave);
    if ($validation) {
        $result = $da->user()->info($usuario);
        @$phonenumber = $result[0]['telephonenumber'][0];
        @$displayname = $result[0]['displayname'][0];
        @$mail = $result[0]['mail'][0];


        $_USERDATA = array(
            "user" => $usuario,
            "completeNames" => $displayname,
            "phone" => $phonenumber,
            "mail" => $mail,
            "userId" => 1,
            "permission" => $recibido->permisos);


        $_SESSION['fst'] = $_USERDATA;
        $_SESSION['snd'] = base64_encode("Admin");


        echo "<script>location.href='admin'</script>";
        exit();

        $da->close();
    } else {
        echo "Error, el usuario o la clave están errados.";
        exit();
    }
}
?>