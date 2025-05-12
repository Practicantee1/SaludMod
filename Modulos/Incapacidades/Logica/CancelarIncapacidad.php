<?php
include('../../../config/Conexion.php');

$IdIncapacidad = $_POST["IdIncapacidad"];
$Razon = $_POST["Razon"];

$procedure = $conexion->prepare("CALL SPIncap_CancelarIncapacidad(?,?)");
$procedure->bind_param("ss", $IdIncapacidad, $Razon);

if($procedure->execute()){
    echo "1";
}
else{
    echo "2";
}

?>