<script>  
        
        <?php
require ('../../../logica/ApiSap.php');
require ('../../../config/Conexion.php');
require ('../../../logica/getURLData.php');

$URL = isset($_SESSION["param"]) ? $_SESSION["param"] : "";

$DatosIncapacidad = [];
$Doc = "";

$_SESSION["CONTROLDATA"] = "true";

$answer = getAssocFrom64($URL);
if (isset($answer)) {
    $Array = $answer["parametros"];

    $DoctorData = solveArray($Array, "campo", "valor");

    $TipoIDMedico = substr($DoctorData["NUIP"], 0, 2);
    $IDNumberMedico = substr($DoctorData["NUIP"], 2);

    $DatosIncapacidad["NombreMedico"] = $DoctorData["NombreUsuario"];
    $DatosIncapacidad["TipoIDMedico"] = $TipoIDMedico;
    $DatosIncapacidad["IDNumberMedico"] = $IDNumberMedico;
    $DatosIncapacidad['Especialidad'] = $DoctorData["Especialidad"];
    $DatosIncapacidad['Registro'] = isset($DoctorData["NMédicoSS"]);
    $DatosIncapacidad['CentroSanitario'] =  $DoctorData["CentroSanitario"];

    $Doc = ltrim($DoctorData["Episodio"], '0');} else {
    $DatosIncapacidad["NombreMedico"] = "";
    $DatosIncapacidad["TipoIDMedico"] = "";
    $DatosIncapacidad["IDNumberMedico"] = "";
    $DatosIncapacidad['Especialidad'] = "";
    $DatosIncapacidad['Registro'] = "";
}


    $DatosIncapacidad["RazonSocial"] = "";
    $DatosIncapacidad["NIT"] = "";
    $DatosIncapacidad["CodAseguradora"] = "";
    $DatosIncapacidad["NomEntidad"] = "";
    $DatosIncapacidad["Lugar"] = "";
    $DatosIncapacidad["NombreApellido"] = "";
    $DatosIncapacidad["TypeIdentification"] = "";
    $DatosIncapacidad["IDNumberPaciente"] = "";
    $DatosIncapacidad["Diagnosticos"] = "";
    //$DatosIncapacidad["CausaAtencion"] = "";
    $DatosIncapacidad['CentroSanitario'] = "";
    $Diagnosticos = [];
       
    /* $Episodio = isset($_SESSION["Episodio"]) ? $_SESSION["Episodio"] : "";
    $DataPacienteMedellin = getApi(1,$Episodio,"HSVM");
    $DataPacienteRionegro = getApi(1,$Episodio,"RSVF"); */

    //This SESSION variable name will change

    
    
    $DataPacienteMedellin = getApi(1,$Doc,"HSVM");
    $DataPacienteRionegro = getApi(1,$Doc,"RSVF");

    $messageMedellin = isset($DataPacienteMedellin["IdMessageDatosPaciente"]) ? $DataPacienteMedellin["IdMessageDatosPaciente"] : "FOUND";
    $messageRionegro = isset($DataPacienteRionegro["IdMessageDatosPaciente"]) ? $DataPacienteRionegro["IdMessageDatosPaciente"] : "FOUND";

    if($messageMedellin === "000"){
        $DataPaciente = $DataPacienteMedellin;
        $CentroSanitario = "HSVM";
        $Lugar = "Medellín";
        
    }elseif($messageRionegro === "000"){
        $DataPaciente = $DataPacienteRionegro;
        $CentroSanitario = "RSVF";
        $Lugar = "Rionegro";
    }else{
        $CentroSanitario = "Empty";
        $DataPaciente = null;
    }

    $query = "CALL SPIncap_FillDatosHospital('$CentroSanitario')";
    $result = mysqli_query($conexion, $query);
    $Hospital = mysqli_fetch_array($result);

    if($result && mysqli_num_rows($result) > 0){
        $DatosIncapacidad["RazonSocial"] = $Hospital["RazonSocial"];
        $DatosIncapacidad["CentroSanitario"] = $Hospital["CentroSanitario"];
        $DatosIncapacidad["NIT"] = $Hospital["NIT"];
        $DatosIncapacidad['Lugar'] = $Lugar;
        $DatosIncapacidad['CodAseguradora'] = $Hospital["CodigoREPS"];
    }


        if(($DataPaciente !== null) && array_key_exists('DatosPaciente', $DataPaciente) && !is_null($DataPaciente['DatosPaciente'])){
            
            $DatosBasicos = $DataPaciente["DatosPaciente"];

            $DatosIncapacidad['NombreApellido'] = $DatosBasicos["Nombre_completo"];
            $DatosIncapacidad['TypeIdentification'] = $DatosBasicos["Tipo_documento"];
            $DatosIncapacidad['Documento'] = $DatosBasicos["Desc_documento"];
            $DatosIncapacidad['IDNumberPaciente'] = $DatosBasicos["Numero_documento"];
            $DatosIncapacidad['Edad'] = $DatosBasicos["Edad"];
            $DatosIncapacidad['Sexo'] = $DatosBasicos["Sexo"];
            $UbicacionPaciente = isset($DataPaciente["DatosEpisodio"]["Ubicacion"]) 
            ? $DataPaciente["DatosEpisodio"]["Ubicacion"] 
            : "Ubicación no disponible";
        
            if(array_key_exists('DatosUltimoEpisodio', $DataPaciente)){
                
                $DatosExtra = $DataPaciente["DatosUltimoEpisodio"];
                $DatosIncapacidad['NomEntidad'] = $DatosExtra["Aseguradora"];

            }

            if(array_key_exists('DatosEpisodio', $DataPaciente)){
                $DatosEpisodio = $DataPaciente["DatosEpisodio"];
                
                if(array_key_exists('Diagnosticos', $DatosEpisodio)){
                    
                    $Diagnosticos = $DatosEpisodio["Diagnosticos"];
                    $DatosIncapacidad["Diagnosticos"] = true;
                }
                else{
                    $Diagnosticos = false;
                }

            }
            
            


            

            
        }

        foreach($DatosIncapacidad as $key => $value){
            if($value == ""){
                $_SESSION["CONTROLDATA"] = "-1";
            }
        }
              ?> 
        //var datosInc = <?php echo json_encode($DatosIncapacidad, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); ?>

    <?php     
    ?> 

</script>