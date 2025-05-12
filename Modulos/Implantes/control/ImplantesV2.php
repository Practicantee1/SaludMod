<?php
if(session_id() === "") session_start();
include("../../../logica/ApiSapV2.php");
include("../../../config/Conexion.php");
include("../../../logica/getURLData.php");
 

$URL = isset($_SESSION["param"]) ? $_SESSION["param"] : "";
$Datos = getAssocFrom64($URL);
$Datos = isset($Datos["parametros"]) ? $Datos["parametros"] : [];
$Datos = solveArray($Datos, "campo", "valor");
$Episodio = isset($Datos["Episodio"]) ? $Datos["Episodio"] : "";
//

// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");
// $RawData = getApiImplantes(1,$Episodio ,"HSVM");



$PersonalData = []; 
$PersonalData["Episodio"] = $Episodio;
$PersonalData["Ubicacion"] = "";
$PersonalData["Nombre"] = "";
$PersonalData["Apellidos"] = "";
$PersonalData["TipoDocumento"] = "";
$PersonalData["Documento"] = "";
$PersonalData["Edad"] = "0";
$PersonalData["Sexo"] = "";
$PersonalData["Aseguradora"] = "";
$PersonalData["NombreMedico"] = isset($Datos["NombreUsuario"]) ? $Datos["NombreUsuario"] :"";
$PersonalData['Registro'] =  isset($Datos["NMédicoSS"]) ? $Datos["NMédicoSS"] : "";
$PersonalData['Especialidad'] =  isset($Datos["Especialidad"]) ? $Datos["Especialidad"] : "";
$Diagnosticos = [];
$PersonalData["Observaciones"] = "";


if(($RawData !== null) && array_key_exists('DatosPaciente', $RawData) && !is_null($RawData['DatosPaciente'])){
    
    $DatosBasicos = $RawData["DatosPaciente"];

    $PersonalData["Nombre"] = $DatosBasicos["Primer_nombre"]." ".$DatosBasicos["Segundo_nombre"]." ".$DatosBasicos["Primer_apellido"]." ".$DatosBasicos["Segundo_apellido"];
    //$PersonalData["Apellidos"] = $DatosBasicos["Primer_apellido"]." ".$DatosBasicos["Segundo_apellido"];
    $PersonalData["TipoDocumento"] = $DatosBasicos["Tipo_documento"];
    $PersonalData["Documento"] = $DatosBasicos["Numero_documento"];
    $PersonalData["Edad"] = $DatosBasicos["Edad"];
    $PersonalData["Sexo"] = $DatosBasicos["Sexo"];

    if(array_key_exists('DatosUltimoEpisodio', $RawData)){
                
        $DatosExtra = $RawData["DatosUltimoEpisodio"];
        $PersonalData['Aseguradora'] = $DatosExtra["Aseguradora"];

    }

    if(array_key_exists('DatosEpisodio', $RawData)){
        $DatosEpisodio = $RawData["DatosEpisodio"];
    
        if(array_key_exists('Diagnosticos', $DatosEpisodio)){
            
            $Diagnosticos = $DatosEpisodio["Diagnosticos"];
    
        }
        else{
            $Diagnosticos = false;
        }

        if(array_key_exists('Ubicacion', $DatosEpisodio)){

            $UbicacionPaciente = $DatosEpisodio["Ubicacion"];
            if(array_key_exists('Unidad_Organizativa', $UbicacionPaciente)){
            
                $PersonalData["Ubicacion"] =  $UbicacionPaciente["Unidad_Organizativa"];
        
            }
        }
    
    }
}
