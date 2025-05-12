<?php

function getAssocFrom64($Data){

    //Recibe un string en base64, remplaza los caracteres que se colocan en las url en caso de que los tenga, para asi poder recibirlos el decodificador
    $Data64 = urldecode($Data);
    $DataJson = base64_decode($Data64);
    $DataArray = json_decode($DataJson, true);

    return $DataArray;
  
}

function solveArray($Array, $key, $value){

    $keys = array_column($Array, $key);
    $values = array_column($Array, $value);
    
    $Assoc = array_combine($keys, $values);

    return $Assoc;

}


?>
