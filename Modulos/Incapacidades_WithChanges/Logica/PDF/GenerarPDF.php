<?php
 include('../../../../config/Conexion.php');

require "../../../../dompdf/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$Id_Incapacidad = 0;

if(isset($_GET["Id_Incapacidad"]) && $_GET["Id_Incapacidad"] != ""){
    $Id_Incapacidad = $_GET["Id_Incapacidad"];
}

//$dompdf = new Dompdf;   //crear objeto pdf comun
$options = new Options;
$options->setChroot(__DIR__);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);  //Crear objeto PDF, que, en caso de contener imagenes pueda acceder a ellas facilmente,

$dompdf->setPaper("A4","landscape");
//Captura todo el codigo html del archivo
$html = file_get_contents("Incapacidadpdf.php");

//reemplaza variables crudas ({{ variable }}) en el html por variables dinamicas

$IDQuery = "SELECT * FROM `Incapacidad_RegistroIncapacidades` WHERE `Id_Incapacidad` = '$Id_Incapacidad'";
    
$result = mysqli_query($conexion, $IDQuery);
$Info = mysqli_fetch_assoc($result);
$InfoExtra = json_decode($Info['Datos_Incapacidad'], true);

if(!isset($Info["FechaExpedicion"])){ $Info["FechaExpedicion"] = "";}
if(!isset($InfoExtra["Lugar"])){ $InfoExtra["Lugar"] = "";}
if(!isset($InfoExtra["TotalDias"])){ $InfoExtra["TotalDias"] = "";}
if(!isset($InfoExtra["RazonSocial"])){ $InfoExtra["RazonSocial"] = "";}
if(!isset($InfoExtra["NIT"])){ $InfoExtra["NIT"] = "";}
if(!isset($InfoExtra["NombreApellido"])){ $InfoExtra["NombreApellido"] = "";}
if(!isset($InfoExtra["TypeIdentification"])){ $InfoExtra["TypeIdentification"] = "";}
if(!isset($Info["IdentificacionPaciente"])){ $Info["IdentificacionPaciente"] = "";}
if(!isset($InfoExtra["IDNumberPaciente"])){ $InfoExtra["IDNumberPaciente"] = "";}
if(!isset($InfoExtra["CodAseguradora"])){ $InfoExtra["CodAseguradora"] = "";}
if(!isset($InfoExtra["NomEntidad"])){ $InfoExtra["NomEntidad"] = "";}
if(!isset($InfoExtra["GroupService"])){ $InfoExtra["GroupService"] = "";}
if(!isset($InfoExtra["ModelService"])){ $InfoExtra["ModelService"] = "";}
if(!isset($InfoExtra["DiagnosticoP"])){ $InfoExtra["DiagnosticoP"] = "";}
if(!isset($InfoExtra["DiagnosticoR"])){ $InfoExtra["DiagnosticoR"] = "";}
if(!isset($InfoExtra["OrigenIncapacidad"])){ $InfoExtra["OrigenIncapacidad"] = "";}
if(!isset($InfoExtra["CausaAtencion"])){ $InfoExtra["CausaAtencion"] = "";}
if(!isset($InfoExtra["RetroActive"])){ $InfoExtra["RetroActive"] = "";}
if(!isset($InfoExtra["FechaInicial"])){ $InfoExtra["FechaInicial"] = "";}
if(!isset($InfoExtra["FechaFinal"])){ $InfoExtra["FechaFinal"] = "";}
if(!isset($InfoExtra["Prorroga"])){ $InfoExtra["Prorroga"] = "";}
if(!isset($InfoExtra["NombreMedico"])){ $InfoExtra["NombreMedico"] = "";}
if(!isset($InfoExtra["TipoIDMedico"])){ $InfoExtra["TipoIDMedico"] = "";}
if(!isset($Info["IdentificacionMedico"])){ $Info["IdentificacionMedico"] = "";}
if(!isset($InfoExtra["Especialidad"])){ $InfoExtra["Especialidad"] = "";}
if(!isset($InfoExtra["Registro"])){ $InfoExtra["Registro"] = "";}



$html = str_replace("{{ CodIncapacidad }}", $Id_Incapacidad, $html);
$html = str_replace("{{ FechaExpedicion }}", $Info["FechaExpedicion"], $html);
$html = str_replace("{{ TotalDias }}", $InfoExtra["TotalDias"], $html);
$html = str_replace("{{ Lugar }}", $InfoExtra["Lugar"], $html);
$html = str_replace("{{ RazonSocial }}", $InfoExtra["RazonSocial"], $html);
$html = str_replace("{{ NIT }}", $InfoExtra["NIT"], $html);
$html = str_replace("{{ NombreApellido }}", $InfoExtra["NombreApellido"], $html);
$html = str_replace("{{ TypeIdentification }}", $InfoExtra["TypeIdentification"], $html);
$html = str_replace("{{ IdentificacionPaciente }}", $Info["IdentificacionPaciente"], $html);
$html = str_replace("{{ IDNumberPaciente }}", $InfoExtra["IDNumberPaciente"], $html);
$html = str_replace("{{ CodAseguradora }}", $InfoExtra["CodAseguradora"], $html);
$html = str_replace("{{ NomEntidad }}", $InfoExtra["NomEntidad"], $html);
$html = str_replace("{{ GroupService }}", $InfoExtra["GroupService"], $html);
$html = str_replace("{{ ModelService }}", $InfoExtra["ModelService"], $html);
$html = str_replace("{{ DiagnosticoP }}", $InfoExtra["DiagnosticoP"], $html);
$html = str_replace("{{ DiagnosticoR }}", $InfoExtra["DiagnosticoR"], $html);
$html = str_replace("{{ OrigenIncapacidad }}", $InfoExtra["OrigenIncapacidad"], $html);
$html = str_replace("{{ CausaAtencion }}", $InfoExtra["CausaAtencion"], $html);
$html = str_replace("{{ RetroActive }}", $InfoExtra["RetroActive"], $html);
$html = str_replace("{{ FechaInicial }}", $InfoExtra["FechaInicial"], $html);
$html = str_replace("{{ FechaFinal }}", $InfoExtra["FechaFinal"], $html);
$html = str_replace("{{ Prorroga }}", $InfoExtra["Prorroga"], $html);
$html = str_replace("{{ NombreMedico }}", $InfoExtra["NombreMedico"], $html);
$html = str_replace("{{ TipoIDMedico }}", $InfoExtra["TipoIDMedico"], $html);
$html = str_replace("{{ IdentificacionMedico }}", $Info["IdentificacionMedico"], $html);
$html = str_replace("{{ Especialidad }}", $InfoExtra["Especialidad"], $html);
$html = str_replace("{{ Registro }}", $InfoExtra["Registro"], $html);


/* //Verificar caracteres con tildes
$html = str_replace("u00c1", "�", $html);
$html = str_replace("u00c9", "�", $html);
$html = str_replace("u00cd", "�", $html);
$html = str_replace("u00d3", "�", $html);
$html = str_replace("u00da", "�", $html);
$html = str_replace("u00e1", "�", $html);
$html = str_replace("u00e9", "�", $html);
$html = str_replace("u00ed", "�", $html);
$html = str_replace("u00f3", "�", $html);
$html = str_replace("u00fa", "�", $html);
$html = str_replace("u00d1", "�", $html);
$html = str_replace("u00f1", "�", $html); */
$dompdf -> loadhtml($html);

$dompdf -> render();

$dompdf -> stream("Incapacidad-".$Id_Incapacidad, ["Attachment" => 0]);




?> 