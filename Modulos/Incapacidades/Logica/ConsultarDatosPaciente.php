<?php

    require ('../../../logica/ApiSap.php');

    $episodio = $_POST['episodio'];

    if(isset($episodio)){
        $DataPacienteMedellin = getApi(1,$episodio,"HSVM");
        $DataPacienteRionegro = getApi(1,$episodio,"RSVF");
        
        $messageMedellin = isset($DataPacienteMedellin["IdMessageDatosPaciente"]) ? $DataPacienteMedellin["IdMessageDatosPaciente"] : "FOUND";
        $messageRionegro = isset($DataPacienteRionegro["IdMessageDatosPaciente"]) ? $DataPacienteRionegro["IdMessageDatosPaciente"] : "FOUND";

        if($messageMedellin === "000"){
            $DataPaciente = $DataPacienteMedellin;
            
        }elseif($messageRionegro === "000"){
            $DataPaciente = $DataPacienteRionegro;
        }else{
            $DataPaciente = null;
        }

        if(!isset($DataPaciente)){
            echo json_encode(["success" => false, "message" => "Datos del episodio no encontrados."]);
            exit();
        }

        if(!isset($DataPaciente["DatosPaciente"])){
            echo json_encode(["success" => false, "message" => "Datos del paciente no encontrados."]);
            exit();
        }

        echo json_encode(["success" => true, "message" => $DataPaciente["DatosPaciente"]]);
    }else{
        echo json_encode(["success" => false, "message" => "No se envió el episodio. No se puede continuar con el proceso."]);
    }

?>