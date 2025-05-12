<?php 
if(session_id() === "") session_start();
$parameters = http_build_query($_GET); 

$_SESSION["PrePage"] = "escritorio.php";
//redireccionar a la vista de loginss
header ('Location: view/login.php'.'?'.$parameters);