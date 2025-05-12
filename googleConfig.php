<?php

session_start();

require_once 'vendor/autoload.php';
 
// init configuration DESARROLLOSTIC
$clientID = '14374271811-ch38fb2k3iggtg69hen66m2cm35ujoh5.apps.googleusercontent.com';
$clientSecret = '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';

//Link de direccionamiento al momento de verificar el logueo de google
$redirectUri = 'http://vmsrv-web2.hospital.com/SaludMod/view/login.php';
//$redirectUri = 'http://localhost/SaludMod/view/login.php';
  
// create Client Request to access Google API 
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow 
if (isset($_GET["code"])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

  if (!isset($token['error'])) {

    $client->setAccessToken($token['access_token']);
    
    $_SESSION['access_token'] = $token['access_token'];
    // get profile info 
    $google_oauth = new Google_Service_Oauth2($client);
    $data = $google_oauth->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
  }
}
  //} else {

  //  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
  //}

?>