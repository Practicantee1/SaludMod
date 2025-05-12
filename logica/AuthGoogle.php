<?php
require_once 'vendor/google/auth/autoload.php';

// Configuración de las credenciales
$clientID = 'TU_ID_DE_CLIENTE';
$clientSecret = 'TU_SECRETO_DE_CLIENTE';
$redirectURI = 'URL_DE_RETORNO_DE_TU_APLICACION';

// Crea un cliente de Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectURI);
$client->addScope('email'); // Puedes agregar más alcances según tus necesidades

// Inicia la sesión
session_start();

// Si no se ha iniciado sesión con Google, redirige a la página de autenticación de Google
if (!isset($_SESSION['access_token'])) {
    $authUrl = $client->createAuthUrl();
    header("Location: $authUrl");
    exit;
}

// Si se ha iniciado sesión con Google, obtén los datos del usuario
$accessToken = $_SESSION['access_token'];
$client->setAccessToken($accessToken);
$oauth = new Google_Service_Oauth2($client);
$userInfo = $oauth->userinfo->get();

// Imprime los datos del usuario
echo 'ID de Google: ' . $userInfo->getId() . '<br>';
echo 'Nombre: ' . $userInfo->getName() . '<br>';
echo 'Correo Electrónico: ' . $userInfo->getEmail() . '<br>';
?>