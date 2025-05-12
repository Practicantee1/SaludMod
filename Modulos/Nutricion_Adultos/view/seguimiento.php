<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');

ob_start();
session_start();

$parameters = http_build_query($_GET); 

if (!isset($_SESSION["nombre"]) ){
    $_SESSION["PrePage"] = "../Modulos/Nutricion_Adultos?CH=1";
    header("Location: ../../../view/login.php"."?".$parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Nutricion Adultos";

    $_SESSION['module_title'] = "SEGUIMIENTO";
    require_once '../../../view/template/header.php';

if ($_SESSION['ingreso_nutricion']==1)
{
    // if (isset($_GET["param"]) && $_GET["param"] !== "") {
    //     $_SESSION["param"] = $_GET["param"];
    // }
    
    require '../../../logica/ApiURL.php';
    
    // $_SESSION["param"] = "";

   
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/seguimiento.css">
 </head>
 <body>
    <div class="content-wrapper">
        <div class="container" >
            <div class="col-md-15" id="ingreso1-session1">
                <div class="card shadow p-3 mb-8" style="margin-top: 100px; padding: 0 !important;">
                    <div class="card-header" style="padding: 0;">
                        <div class="well" style="margin:0; height: 20%;">
                            <h4 style="margin:0; color:#066E45;">Datos Demograficos <i id="ocultar" class="fa-solid fa-angle-down"></i></h4>
                        </div>
                        <div id="DatosPaciente" class="flex">
                            <div class="grid-row">
                                <div class="div-input">
                                    <input readonly value="Juan Pablo Vasquez" id="idNombrePaciente" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input">
                                    <input readonly value="Masculino" id="idGenero" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input">
                                    <input readonly value="21" id="idEdad" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input" >
                                    <input readonly value="03/09/2003" id="idFNacimiento" class="clsInputDemograficos" type="text">
                                </div>
                            </div>
                            <div class="grid-row">
                                <div class="div-input">
                                    <input readonly value="321564" id="idEpisodio" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input">
                                    <input readonly value="1000874044" id="idCedula" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input">
                                    <input readonly value="21092" id="idNumPaciente" class="clsInputDemograficos" type="text">
                                </div>
                                <div></div>
                            </div>
                            <div class="grid-row" style="padding-bottom:5px;">
                                <div class="div-input">
                                    <input readonly value="Sala1" id="idSala" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input">
                                    <input readonly value="Cama 12" id="idCama" class="clsInputDemograficos" type="text">
                                </div>
                                <div class="div-input">
                                    <input readonly value="Sura" id="idAseguradora" class="clsInputDemograficos" type="text">
                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container">
                        <div class="section-title left">
                            <span class="line"></span>
                            <h3 class="text">EVALUACION NUTRICIONAL</h>
                        </div>
                    </div>
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle active" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#diagnostico"><div class="stepper-circle"></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle"></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle"></div></a>
                    </div> 
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="antropometria">Antropometria</h4>
                        </div>
                    </div>
                    <div>
                        <div>
                            <div class="input-box">
                                <label for="idPesoPrevio">Peso previo</label>
                                <input id="idPesoPrevio" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idPesoActual">Peso actual</label>
                                <input id="idPesoActual" class="clsInput blanco" type="text">
                                <div class="row">
                                    <label for="idObsPesoActual">Observaciones</label>
                                    <input id="idObsPesoActual" class="clsInput blanco" type="text">
                                </div>
                                <div class="row">
                                    <label for="idMetaPesoActual">Meta</label>
                                    <input id="idMetaPesoActual" class="clsInput" type="text">
                                </div>
                            </div>
                            <div class="input-box">
                                <label for="idEstatura">Estatura</label>
                                <input placeholder="Resultado" id="idEstatura" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idIMCActual">IMC actual</label>
                                <input placeholder="Resultado" id="idIMCActual" class="clsInput" type="text">
                                <div style="display:grid; grid-template-columns:1fr 1fr;">
                                    <label for="idMetaIMCActual" class="">Meta</label>
                                    <input id="idMetaIMCActual" class="clsInput" type="text">
                                </div>
                            </div>
                            <div class="input-box">
                                <label for="idClasifIMC">Clasificacion IMC</label>
                                <input placeholder="Resultado" id="idClasifIMC" class="clsInput" type="text">
                                <div class="barra-externa last2 metaIMC">
                                    <div class="barra-interna"></div>
                                </div>
                            </div>
                            <div class="input-box">
                                <label for="idCambioPeso">% Cambio de peso</label>
                                <input placeholder="Resultado" id="idCambioPeso" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idPeriodoEvaluado">Periodo Evaluado</label>
                                <input placeholder="Resultado" id="idPeriodoEvaluado" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idClasif">Clasificacion</label>
                                <input placeholder="Resultado" id="idClasif" class="clsInput" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#diagnostico"><div class="stepper-circle"></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle"></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle"></div></a>
                    </div> 
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="antropometria">Examenes de Laboratorio</h4>
                        </div>
                    </div>
                    <div class="contenedor">
                        <ul class="ul">
                            <li class="li activo">Nutricionales</li>
                            <li class="li">Ionograma</li>
                            <li class="li">Funcion Hepatica</li>
                            <li class="li">Funcion Renal</li>
                            <li class="li">Otros</li>
                        </ul>
                        <div class="subcontenedor">
                            <div class="bloque activo">
                            <table class="tbl-SeguimientoAntropometria">
                                    <thead>
                                        <th style="text-wrap: wrap;">Fecha</th>
                                        <th style="text-wrap: wrap;">2025/02/04</th>
                                        <th style="text-wrap: wrap;">2024/09/03</th>
                                        <th style="text-wrap: wrap;">2024/08/05</th>
                                        <th style="text-wrap: wrap;">2024/03/03</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Prealbumina</td>
                                            <td>0.45</td>
                                            <td>0.45</td>
                                            <td>0.45</td>
                                            <td>0.45</td>
                                        </tr>
                                        <tr>
                                            <td>Albumina</td>
                                            <td>1.2</td>
                                            <td>1.2</td>
                                            <td>1.2</td>
                                            <td>1.2</td>
                                        </tr>
                                        <tr>
                                            <td>Proteinas</td>
                                            <td>0.8</td>
                                            <td>0.8</td>
                                            <td>0.8</td>
                                            <td>0.8</td>
                                        </tr>
                                        <tr>
                                            <td>Vinamina D</td>
                                            <td>1.34</td>
                                            <td>1.34</td>
                                            <td>1.34</td>
                                            <td>1.34</td>
                                        </tr>
                                        <tr>
                                            <td>Vitamina B12</td>
                                            <td>0.2</td>
                                            <td>0.2</td>
                                            <td>0.2</td>
                                            <td>0.2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bloque">
                                <table class="tbl-SeguimientoAntropometria">
                                    <thead>
                                        <th style="text-wrap: wrap;">Fecha</th>
                                        <th style="text-wrap: wrap;">2025/02/04</th>
                                        <th style="text-wrap: wrap;">2024/09/03</th>
                                        <th style="text-wrap: wrap;">2024/08/05</th>
                                        <th style="text-wrap: wrap;">2024/03/03</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Albumina</td>
                                            <td>1.2</td>
                                            <td>1.2</td>
                                            <td>1.2</td>
                                            <td>1.2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bloque"> 
                            <table class="tbl-SeguimientoAntropometria">
                                    <thead>
                                        <th style="text-wrap: wrap;">Fecha</th>
                                        <th style="text-wrap: wrap;">2025/02/04</th>
                                        <th style="text-wrap: wrap;">2024/09/03</th>
                                        <th style="text-wrap: wrap;">2024/08/05</th>
                                        <th style="text-wrap: wrap;">2024/03/03</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Proteinas</td>
                                            <td>0.8</td>
                                            <td>0.8</td>
                                            <td>0.8</td>
                                            <td>0.8</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bloque"> 
                            <table class="tbl-SeguimientoAntropometria">
                                    <thead>
                                        <th style="text-wrap: wrap;">Fecha</th>
                                        <th style="text-wrap: wrap;">2025/02/04</th>
                                        <th style="text-wrap: wrap;">2024/09/03</th>
                                        <th style="text-wrap: wrap;">2024/08/05</th>
                                        <th style="text-wrap: wrap;">2024/03/03</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Vinamina D</td>
                                            <td>1.34</td>
                                            <td>1.34</td>
                                            <td>1.34</td>
                                            <td>1.34</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bloque"> 
                            <table class="tbl-SeguimientoAntropometria">
                                    <thead>
                                        <th style="text-wrap: wrap;">Fecha</th>
                                        <th style="text-wrap: wrap;">2025/02/04</th>
                                        <th style="text-wrap: wrap;">2024/09/03</th>
                                        <th style="text-wrap: wrap;">2024/08/05</th>
                                        <th style="text-wrap: wrap;">2024/03/03</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Vitamina B12</td>
                                            <td>0.2</td>
                                            <td>0.2</td>
                                            <td>0.2</td>
                                            <td>0.2</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#diagnostico"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle"></div></a>
                    </div> 
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="Gastrointestinal">Funcionalidad Gastrointestinal</h4>
                        </div>
                    </div>
                    <div class="Gastrointestinal-container">
                        <div class="Gastrointestinal">
                            <input type="checkbox">
                            <label for="">Nauseas</label>
                        </div>
                        <div class="Gastrointestinal">
                            <input type="checkbox">
                            <label for="">Dolor/Distension abdominal</label>
                            <label for="" class="col4">ml/dia o #/dia</label>
                        </div>
                        <div class="Gastrointestinal">
                            <input type="checkbox">
                            <label for="">Emesis</label>
                            <input type="text" class="clsInput col4" id="idEmesis">
                        </div>
                        <div class="Gastrointestinal">
                            <input type="checkbox">
                            <label for="">Deposiciones</label>
                            <select class="clsInput" id="selectDeposiciones">
                                <option value="Normal">Normal</option>
                                <option value="Diarrea">Diarrea</option>
                                <option value="Estreñimiento">Estreñimiento</option>
                            </select>
                            <input type="text" class="clsInput" id="idDeposicion">
                            <label for="">Observaciones</label>
                            <input type="text" class="clsInput" id="idDeposicion">
                        </div>
                        <div class="Gastrointestinal GastrointestinalBotones" id="debitos">
                            <input type="checkbox">
                            <label for="">Debitos intestinales</label>
                            <select class="clsInput" id="selectDebitos">
                                <option value="Normal">Normal</option>
                                <option value="Diarrea">Diarrea</option>
                                <option value="Estreñimiento">Estreñimiento</option>
                            </select>
                            <div>
                                <input type="text" class="clsInput" id="idDebitos">
                            </div>
                            <div class="buttons">
                                <a href="#" id="btn-mas"><i class="fa-solid fa-plus mas"></i></a>
                                <a href="#" id="btn-menos"><i class="fa-solid fa-minus mas"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#diagnostico"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle" ></div></a>
                    </div> 
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="Adecuacion">Adecuacion</h4>
                        </div>
                    </div>
                    <div>
                        <table class="tbl-Seguimiento" id="tblAdecuacion">
                            <thead>
                                <th></th>
                                <th>Cantidad programada</th>
                                <th>Cantidad recibida</th>
                                <th>Kcal/dia</th>
                                <th>Proteina/dia</th>
                                <th>% Adecuacion</th>
                                <th>Clasificacion</th>
                                <th>Complicaciones</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Dieta</td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput blanco" type="text">
                                            <label for="">%</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">%</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                                <tr>    
                                    <td>Suplemento</td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput blanco" type="text">
                                            <label for="">g/ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">g/ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td>NET</td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput blanco" type="text">
                                            <label for="">ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td>NPT</td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput blanco" type="text">
                                            <label for="">ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <div class="adecuacion-2">
                                <label for="idAbsorcion">% Absorcion estimado</label>
                                <input class="clsInput blanco" type="text" id="idAbsorcion">
                            </div>
                            <div class="adecuacion-2">
                                <label for="idPeriodo">Periodo de tiempo evaluado</label>
                                <input class="clsInput blanco" type="text" id="idPeriodo">
                            </div>
                            <div class="adecuacion-2">
                                <label for="idRespuesta">Respuesta al Ho</label>
                                <input class="clsInput blanco" type="text" id="idRespuesta">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#diagnostico"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle" ></div></a>
                    </div> 
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="Analisis">ANALISIS</h4>
                        </div>
                    </div>
                    <div class="input-area" style="margin-top:75px; display: flex; justify-content:center;">
                        <textarea name="" id="idAnalisis" class="clsInput text-area"></textarea>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container">
                        <div class="section-title left">
                            <span class="line"></span>
                            <h3 class="text" id="Intervencion">INTERVENCION NUTRICIONAL</h3>
                        </div>
                    </div>
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" style="background-color: #066E45"></div>
                        <a href="#diagnostico"><div class="stepper-circle" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle" ></div></a>
                    </div>
                    <div class="header-container doble-titulo">
                        <div class="section-title left">
                            <h4 class="text" >Terapia nutricional prescrita</h4>
                        </div>
                        <div class="section-title left">
                            <h4 class="text" >Requerimiento estimado</h4>
                        </div>
                    </div>
                    <div class="div-container_terapia">
                        <div class="div-2">
                            <div class="input-box">
                                <label for="SelectObjetivo">Objetivo</label>
                                <select name="" id="SelectObjetivo" class="clsInput"> 
                                    <option value="">Seleccione una opcion</option>   
                                    <option value="Otro">Otro</option>   
                                </select>
                                <input style="display: none;" id="idOtroObjetivo" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idRiesgoRealimentacion">Riesgo de Realimentacion</label>
                                <div>
                                    <button id="RiesgoRe-si" class="btn-si riesgo">Si</button>
                                    <button id="RiesgoRe-no" class="btn-no riesgo">No</button>
                                </div>
                            </div>
                            <div class="input-box">
                                <label for="idCriteriosCumple">Criterios que cumple</label>
                                <input placeholder="Resultado" id="idCriteriosCumple" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idClasifRiesgo">Clasificacion del riesgo</label>
                                <input placeholder="Resultado" id="idClasifRiesgo" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idConsumoCalorico">Consumo calorico aprox ultim sem</label>
                                <input placeholder="Resultado" id="idConsumoCalorico" class="clsInput" type="text">
                            </div>
                        </div>
                        <div class="div-2">
                            <div class="input-box">
                                <label for="idPesoTrabajo">Peso de trabajo</label>
                                <input placeholder="Resultado" id="idPesoTrabajo" class="clsInput" type="text">
                            </div>
                            <div>
                                <table id="tbl-Inicio">
                                    <thead>
                                        <th>Nutriente</th>
                                        <th>Aport/Kg</th>
                                        <th>Aport/Dia</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kcal</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Proteina</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Hidrico</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Otro</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="SoporteNutricional">Tipo de soporte nutricional</h4>
                        </div>
                    </div>
                    <div>
                        <table class="tbl-Seguimiento" id="tblAdecuacion">
                            <thead>
                                <th></th>
                                <th>Tipo de soporte</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Kcal/dia</th>
                                <th>Prd/dia</th>
                                <th>CHO/dia</th>
                                <th>Lip/dia</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>Nada via oral</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>Dieta</td>
                                    <td>
                                        <select class="clsInput" name="" id=""></select>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">%</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>Suplemento</td>
                                    <td>
                                        <select class="clsInput" name="" id=""></select>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">g/ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>NET</td>
                                    <td>
                                        <select class="clsInput" name="" id=""></select>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>NPT</td>
                                    <td>
                                        <select class="clsInput" name="" id=""></select>
                                    </td>
                                    <td>
                                        <div class="td-grid">
                                            <input class="clsInput" type="text">
                                            <label for="">ml</label>
                                        </div>
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput blanco" type="text">
                                    </td>
                                    <td>
                                        <input class="clsInput" type="text">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="input-area" style="margin-top:75px; display: flex; justify-content:center;">
                        <label for="">Observaciones</label>
                        <textarea name="" id="idObsAdecuacion" class="clsInput text-area" placeholder="Informacion NPT completa"></textarea>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top:40px;">
                <div class="card-header">
                    <div class="header-container">
                        <div class="section-title left">
                            <h4 class="text" id="PorcentajeAdecuacion">Porcentaje de adecuacion</h4>
                        </div>
                    </div>
                    <div>
                        <table id="tblAdecuacion">
                            <thead>
                                <th></th>
                                <th>Req</th>
                                <th>Prog</th>
                                <th>%</th>
                                <th>Clasificacion</th>
                                <th>Observaciones</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Liquidos</td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                </tr>
                                <tr>
                                    <td>Kcal</td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                </tr>
                                <tr>
                                    <td>Prot</td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                </tr>
                                <tr>
                                    <td>CHO</td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                </tr>
                                <tr>
                                    <td>Lip</td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                    <td><input class="clsInput" type="text"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- <script>
    // Pasamos los datos de PHP a una variable global de JavaScript
    const diagnosticos = <?php echo $diagnosticosJson; ?>;
    document.addEventListener('DOMContentLoaded', function() {
    <?php
    $Medico = isset($_SESSION["CONTROLDATA"]) ? json_encode($_SESSION["CONTROLDATA"]) : "true";
    $DatosIncapacidad = isset($DatosIncapacidad) ? json_encode($DatosIncapacidad) : "null";
    ?>
    
    // Cargar las variables en JavaScript con los valores de PHP
    const params = new URLSearchParams(window.location.search);
    var Medico = <?php echo $Medico ?>;
    let DatosIncapacidad = <?php echo $DatosIncapacidad ?>;
    console.log("DatosIncapacidad:", DatosIncapacidad);
    console.log(DatosIncapacidad["NombreMedico"] +" "+ DatosIncapacidad["Registro"]);

    if (DatosIncapacidad && DatosIncapacidad["NombreMedico"] == "" && DatosIncapacidad["Registro"] == "" && DatosIncapacidad["IDNumberPaciente"] == "") {      
        Swal.fire({
        title: 'No es posible realizar Solicitud',
        text: 'Para realizar una solicitud, por favor ingrese desde el modulo de SAP',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonText: 'Consultar Solicitudes',
        allowOutsideClick: false,
        allowEscapeKey: false,
        iconColor: '#006941',
        customClass: {
            title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
            popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
            content: 'custom-swal-Incapacidad-Content',
            confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
        }
    }).then((result) => {
        // Check if the user clicked the "Confirm" button
        if (result.isConfirmed) {
          // Redirect to another page
          window.location.href = 'ConsultarSolicitud.php';
        } else {
          // Close the current tab
          window.close();
        }});
    }

    else if (DatosIncapacidad["NomEntidad"] == "") {      
      Swal.fire({
      title: 'No es posible realizar Incapacidad',
      text: 'El paciente no tiene aseguradora asignada, por favor avisar a la unidad de atencion al usuario (UAU)',
      icon: 'warning',
      showCancelButton: false,
      confirmButtonText: 'Consultar Incapacidad',
      allowOutsideClick: false,
      allowEscapeKey: false,
      iconColor: '#006941',
      customClass: {
          title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
          popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
          content: 'custom-swal-Incapacidad-Content',
          confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
      }
    }).then((result) => {
        // Check if the user clicked the "Confirm" button
        if (result.isConfirmed) {
          // Redirect to another page
          window.location.href = 'ConsolidadoIncapacidad.php';
        } else {
          // Close the current tab
          window.close();
        }});
    }
    

  });
</script> -->
<script src="../control/paginacion-seguimiento.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</html>
<?php
}
else
{
  require_once '../../../view/noacceso.php';
}

require_once '../../../view/template/footer.php';
?>


<?php 
}
ob_end_flush();
?>

