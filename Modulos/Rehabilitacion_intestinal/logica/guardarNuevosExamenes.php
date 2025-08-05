<?php

include('../../../config/Conexion.php');

    if(!isset($_POST["episodio"]) || !isset($_POST["documento"])){
        echo json_encode(["success" => false, "message" => "Faltan parámetro de episodio o cedula del paciente para completar el proceso."]);
        exit();
    }

    $episodio = $_POST["episodio"] ?? '';
    $documento = $_POST["documento"] ?? '';
    $nombre_paciente = $_POST["nombre_paciente"] ?? '';
    $edad = $_POST["edad"] ?? '';
    $genero = $_POST["genero"] ?? '';
    $ubicacion = $_POST["ubicacion"] ?? '';
    $cama = $_POST["cama"] ?? '';
    $aseguradora = $_POST["aseguradora"] ?? '';
    $especialidad = $_POST["especialidad"] ?? '';
    $medico = $_POST["medico"] ?? '';
    $centrosanitario = "";
    $examenes = $_POST["examenes"] ?? '';


    $sql_examen = "CALL SP_guardar_examenes_RI(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    foreach($examenes AS $examen){
        $hora = $examen["HORA"] ?? '';
        $fecha = $examen["FECHA"] ?? '';
        $LEUCOCITOS = $examen["LEUCOCITOS"] ?? '';
        $NEUTROFILOS = $examen["NEUTROFILOS"] ?? '';
        $LINFOCITOS = $examen["LINFOCITOS"] ?? '';
        $EOSINOFILOS = $examen["EOSINOFILOS"] ?? '';
        $HEMOGLOBINA = $examen["HEMOGLOBINA"] ?? '';
        $HEMATOCRITO = $examen["HEMATOCRITO"] ?? '';
        $PLAQUETAS = $examen["PLAQUETAS"] ?? '';
        $VSG = $examen["VSG"] ?? '';
        $PCR = $examen["PCR"] ?? '';
        $TGO = $examen["TGO/AST"] ?? '';
        $TGP = $examen["TGP/ALT"] ?? '';
        $BILIRRUBINA_TOTAL = $examen["BILIRRUBINA TOTAL"] ?? '';
        $BILIRRUBINA_DIRECTA = $examen["BILIRRUBINA DIRECTA"] ?? '';
        $GGT = $examen["GGT"] ?? '';
        $FOSFATASA_ALCALINA = $examen["FOSFATASA ALCALINA"] ?? '';
        $TP = $examen["TP"] ?? '';
        $INR = $examen["INR"] ?? '';
        $TPT = $examen["TPT"] ?? '';
        $AMILASA = $examen["AMILASA"] ?? '';
        $SODIO = $examen["SODIO"] ?? '';
        $FOSFORO = $examen["FOSFORO"] ?? '';
        $POTASIO = $examen["POTASIO"] ?? '';
        $CLORO = $examen["CLORO"] ?? '';
        $CALCIO = $examen["CALCIO"] ?? '';
        $MAGNESIO = $examen["MAGNESIO"] ?? '';
        $COLESTEROL_TOTAL = $examen["COLESTEROL TOTAL"] ?? '';	
        $HDL = $examen["COLESTEROL HDL"] ?? '';
        $TRIGLICERIDOS = $examen["TRIGLICERIDOS"] ?? '';
        $PROTEINAS_TOTALES = $examen["PROTEINAS TOTALES"] ?? '';
        $ALBUMINA = $examen["ALBUMINA"] ?? '';
        $PRE_ALBUMINA = $examen["PRE-ALBUMINA"] ?? '';
        $VITAMINA_B12 = $examen["VITAMINA B12"] ?? '';
        $VITAMINA_D = $examen["VITAMINA D"] ?? '';
        $CREATININA = $examen["CREATININA"] ?? '';
        $GLICEMIA = $examen["GLICEMIA"] ?? '';
        $HCO = $examen["GASES HCO₃⁻"] ?? '';
        $EB = $examen["GASES EB"] ?? '';
        $Ph = $examen["GASES Ph"] ?? '';
        $AISLAMIENTOS = $examen["AISLAMIENTOS"] ?? '';
        $electroforesis_proteinas = "";
        $examenes_complementarios = "";

        if($consulta = $conexion->prepare($sql_examen)){
            $consulta->bind_param("isssssssssssssssssssssssssssssssssssssssssissssssssssss", $id,
                                                                                                    $LEUCOCITOS,
                                                                                                        $NEUTROFILOS,
                                                                                                        $LINFOCITOS,
                                                                                                        $EOSINOFILOS,
                                                                                                        $HEMOGLOBINA,
                                                                                                        $HEMATOCRITO,
                                                                                                        $PLAQUETAS,
                                                                                                        $VSG,
                                                                                                        $PCR,
                                                                                                        $TGO,
                                                                                                        $TGP,
                                                                                                        $BILIRRUBINA_TOTAL,
                                                                                                        $BILIRRUBINA_DIRECTA,
                                                                                                        $GGT,
                                                                                                        $FOSFATASA_ALCALINA,
                                                                                                        $TPT,
                                                                                                        $AMILASA,
                                                                                                        $SODIO,
                                                                                                        $FOSFORO,
                                                                                                        $POTASIO,
                                                                                                        $CLORO,
                                                                                                        $CALCIO,
                                                                                                        $MAGNESIO,
                                                                                                        $COLESTEROL_TOTAL,
                                                                                                        $HDL,
                                                                                                        $TRIGLICERIDOS,
                                                                                                        $PROTEINAS_TOTALES,
                                                                                                        $ALBUMINA,
                                                                                                        $PRE_ALBUMINA,
                                                                                                        $electroforesis_proteinas,
                                                                                                        $VITAMINA_B12,
                                                                                                        $VITAMINA_D,
                                                                                                        $CREATININA,
                                                                                                        $GLICEMIA,
                                                                                                        $HCO,
                                                                                                        $EB,
                                                                                                        $Ph,
                                                                                                        $AISLAMIENTOS,
                                                                                                        $examenes_complementarios,
                                                                                                        $TP,
                                                                                                        $INR,
                                                                                                        $episodio,
                                                                                                        $documento,
                                                                                                        $nombre_paciente,
                                                                                                        $edad, 
                                                                                                        $genero,
                                                                                                        $ubicacion,
                                                                                                        $cama,
                                                                                                        $aseguradora,
                                                                                                        $medico,
                                                                                                        $especialidad,
                                                                                                        $fecha,
                                                                                                        $hora,
                                                                                                        $centrosanitario
                                                                                                    );
            $consulta->execute();
            
        }
    }
    echo json_encode(["success" => true, "message" => "Proceso exitoso"]);
?>