<?php 

$parameters = http_build_query($_GET); 
//redireccionar a la vista de loginss
header ('Location: view/form_encuesta.php'.'?'.$parameters);