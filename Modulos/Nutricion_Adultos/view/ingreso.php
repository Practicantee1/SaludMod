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

    $_SESSION['module_title'] = "INGRESO";
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
    <link rel="stylesheet" href="css/ingreso.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
 <body>
    <div class="content-wrapper">
        <div class="container" >
            <div class="col-md-15" id="ingreso1-session1">
                <div class="card shadow p-3 mb-8" style="margin-top: 100px; padding: 0 !important;">
                    <div class="card-header" style="padding: 0;">
                        <div class="well " style="margin:0; height: 20%;">
                            <div class="section-title left">
                                <span class="line"></span>
                                <h3 class="text" style="margin:0; color:#066E45;">DATOS DEMOGRAFICOS <i id="ocultar" class="fa-solid fa-angle-down"></i></h3>
                            </div>
                            <div class="flex" style="padding:0">
                                <div class="div-demograficos">
                                    <label for="">Nombre</label>
                                    <input class="clsDemograficos" type="text" name="" value="Juan Pablo Vasquez" id="nombre">
                                </div>
                                <div class="div-demograficos">
                                    <label for="">Edad</label>
                                    <input class="clsDemograficos" type="text" name="" value="21" id="edad">
                                </div>
                                <div class="div-demograficos">
                                    <label for="">Episodio</label>
                                    <input class="clsDemograficos" type="text" name="" value="321534" id="episodio">
                                </div>
                                <div class="div-demograficos">
                                    <label for="">Cedula</label>
                                    <input class="clsDemograficos" type="text" name="" value="1000874041" id="cedula">
                                </div>
                                <div class="div-demograficos">
                                    <label for="">Cama</label>
                                    <input class="clsDemograficos" type="text" name="" value="cama456" id="cama">
                                </div>
                            </div>
                        </div>
                        <div id="DatosPaciente" style="display:none" class="flex">
                            <div class="div-demograficos">
                                <label for="">Fecha de nacimiento</label>
                                <input class="clsDemograficos" type="date" name="" id="">
                            </div>
                            <div class="div-demograficos">
                                <label for="">Numero de paciente</label>
                                <input class="clsDemograficos" type="text" name="" value="201566" id="numPaciente">
                            </div>
                            <div class="div-demograficos">
                                <label for="">Genero</label>
                                <input class="clsDemograficos" type="text" name="" value="Masculino" id="genero">
                            </div>
                            <div class="div-demograficos">
                                <label for="">Sala</label>
                                <input class="clsDemograficos" type="text" name="" value="Sala 123" id="sala">
                            </div>
                            <div class="div-demograficos">
                                <label for="">Aseguradora</label>
                                <input class="clsDemograficos" type="text" name="" value="Sura" id="aseguradora">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container" style="padding:0;">
                        <div class="section-title left">
                            <span class="line"></span>
                            <h3 class="text">EVALUACION NUTRICIONAL</h>
                        </div>
                    </div>
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle active" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#diagnostico"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle"  ></div></a>
                        <!-- <div class="stepper-line"></div>
                        <div class="stepper-circle" ></div> -->
                    </div> 
                    <div class="antropometria">
                        <div>
                            <div class="antro">
                                <div class="header-container" style="padding:0;">
                                    <div class="section-title left">
                                        <h4 class="text" >Antropometria</h4>
                                    </div>
                                </div>
                                <div class="antropometria-1">
                                    <div class="input-box">
                                        <label for="">Peso usual (kg)</label>
                                        <input placeholder="Ingrese" id="idPesoUsual" class="clsInput inputAntropometria" type="text" step="0.01">
                                    </div>
                                    <div class="input-box">
                                        <label for="SelectFuenteDato">Fuente del dato (peso)</label>
                                        <select name="" id="SelectFuenteDato" class="clsInput inputAntropometria">
                                            <option value="">Seleccione una opcion</option>   
                                        </select>
                                    </div>
                                    <div class="input-box" style="display:none" id="ld-edemas">
                                        <label for="SelectEdemas">Edema</label>
                                        <select name="" id="SelectEdemas" class="clsInput inputAntropometria"> 
                                            <option value="">Seleccione una opcion</option>   
                                        </select>
                                    </div>
                                    <div style="display:none" id="PesoActual" class="input-box">
                                        <label for="">Peso actual (kg)</label>
                                        <input placeholder="Ingrese" id="idPesoActual" class="clsInput inputAntropometria" type="text" step="0.01">
                                    </div>
                                    <div class="input-box" id="brazo" style="display:none">
                                        <label for="">Circunferencia del brazo (cm)</label>
                                        <input placeholder="Ingrese" id="idBrazo" class="clsInput inputAntropometria" type="text" step="0.01">
                                    </div>
                                    <div class="input-box" id="rodilla" style="display:none">
                                        <label for="">Altura de rodilla (cm)</label>
                                        <input placeholder="Ingrese" id="idRodilla" class="clsInput inputAntropometria" type="text" step="0.01">
                                    </div>
                                    <div class="input-box" id="pesoEstimado" style="display:none">
                                        <label for="">Peso estimado (kg)</label>
                                        <input placeholder="Resultado" disabled readonly id="idPesoEstimado" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <!-- <div hidden class="input-box" id="pesoMinimoEstimado" style="display:none">
                                        <label for="">Peso minimo (kg)</label>
                                        <input placeholder="Resultado" disabled readonly id="idPesoMinimoEstimado" class="clsInput inputAntropometria blanco" type="text">
                                    </div>
                                    <div hidden class="input-box" id="pesoMaximoEstimado" style="display:none">
                                        <label for="">Peso maximo (kg)</label>
                                        <input placeholder="Resultado" disabled readonly id="idPesoMaximoEstimado" class="clsInput inputAntropometria blanco" type="text">
                                    </div> -->
                                    <div class="input-box" id="pesoTrabajo" style="display:none">
                                        <label for="">Peso de trabajo (kg)</label>
                                        <input placeholder="Ingrese" id="idPesoTrabajo" class="clsInput inputAntropometria blanco" type="text" step="0.01">
                                    </div>
                                    <div id="minmaxPeso" class="mostrarMINMAX">
                                        <label id="idPesoMinimoEstimado">Peso Minimo:</label>
                                        <label id="idPesoMaximoEstimado">Peso Maximo:</label>
                                    </div>
                                    <div class="input-box" id="pesoSecoEstimado" style="display:none">
                                        <label for="">Peso seco estimado (kg)</label>
                                        <input placeholder="Resultado" disabled readonly id="idPesoSecoEstimado" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box">
                                        <label for="SelectFuenteDato">Fuente del dato (estatura)</label>
                                        <select name="" id="SelectFuenteDatoEstatura" class="clsInput inputAntropometria"> 
                                            <option value="">Seleccione una opcion</option>   
                                            <option value="1">Directo</option>
                                            <option value="2">Longitud rodilla</option>
                                        </select>
                                    </div>
                                    <div class="input-box" id="longitudRodilla" style="display:none">
                                        <label for="">Longitud rodilla maleolo LRM (cm)</label>
                                        <input placeholder="Ingrese" id="idLongitudRodilla" class="clsInput inputAntropometria" type="text" step="0.01">
                                    </div>
                                    <!-- <div class="input-box" id="estaturaMin" style="display:none">
                                        <label for="">Estatura minima(m)</label>
                                        <input placeholder="Resultado" readonly id="idEstaturaMin" class="clsInput inputAntropometria" type="text">
                                    </div>
                                    <div class="input-box" id="estaturaMax" style="display:none">
                                        <label for="">Estatura maxima (m)</label>
                                        <input placeholder="Resultado" readonly id="idEstaturaMax" class="clsInput inputAntropometria" type="text">
                                    </div> -->
                                    <div class="input-box" id="estatura" style="display:none">
                                        <label for="">Estatura (m)</label>
                                        <input placeholder="Resultado" id="idEstatura" class="clsInput inputAntropometria " type="text" step="0.01">
                                    </div>
                                    <div class="input-box" id="EstaturaTrabajo" style="display:none">
                                        <label for="">Estatura de trabajo (kg)</label>
                                        <input placeholder="Ingrese" id="idEstaturaTrabajo" class="clsInput inputAntropometria blanco" type="text" step="0.01">
                                    </div>
                                    <!-- <div class="input-box" id="EstaturaTrabajo" style="display:none">
                                        <label for="">Estatura de trabajo (kg)</label>
                                        <input placeholder="Resultado" id="idEstaturaTrabajo" class="clsInput inputAntropometria blanco" type="text">
                                    </div> -->
                                    <div class="mostrarMINMAX" id="minmaxEstatura">
                                        <label id="idEstaturaMin">Estatura Minimo:</label>
                                        <label id="idEstaturaMax">Estatura Maximo:</label>
                                    </div>
                                    <div class="input-box">
                                        <label for="">IMC actual (kg/m²)</label>
                                        <input placeholder="Resultado" disabled readonly id="idIMCActual" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box">
                                        <label for="">Clasificacion IMC</label>
                                        <input placeholder="Resultado" disabled readonly id="idClasifIMC" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box">
                                        <label for="">IMC Meta (kg/m²)</label>
                                        <input placeholder="Ingrese" id="idIMCMeta" class="clsInput inputAntropometria" type="text" step="0.01">
                                    </div>
                                    <div class="input-box" id="pesoSaludable" style="display:none">
                                        <label for="">Peso saludable (kg)</label>
                                        <input placeholder="Resultado" disabled readonly id="idPesoSaludable" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box" id="pesoObesidad" style="display:none">
                                        <label for="">Peso ajustado por obesidad (kg)</label>
                                        <input placeholder="Resultado" disabled readonly id="idPesoObesidad" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box">
                                        <label for="idPeriodoEvaluado">Periodo evaluado</label>
                                        <!-- <input type="text" class="clsInput inputAntropometria" id="idPeriodoEvaluado" placeholder="Selecciona un rango de fechas"> -->
                                        <select name="" id="SelectPeriodoEvaluado" class="clsInput inputAntropometria"> 
                                            <option value="">Seleccione una opcion</option>   
                                            <option value="1">1 semana</option>
                                            <option value="2">1 mes</option>
                                            <option value="3">3 meses</option>
                                            <option value="5">6 meses</option>
                                            <option value="4">Mas de 6 meses</option>
                                        </select>
                                    </div>
                                    <div class="input-box">
                                        <label for="">Porcentaje cambio de peso</label>
                                        <input placeholder="Resultado" disabled readonly id="idCambioPeso" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box">
                                        <label for="">Clasificacion Cambio de peso</label>
                                        <input placeholder="Resultado" disabled readonly id="idClasifCambioPeso" class="clsInput inputAntropometria oscuro" type="text">
                                    </div>
                                    <div class="input-box">
                                        <label for="idObservaciones">Observaciones</label>
                                        <textarea name="" id="idObservaciones-Antropometria" class="clsInput inputAntropometria text-area"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="antro">
                                <div class="header-container" style="padding:0;">
                                    <div class="section-title left">
                                        <h4 class="text" >Tamizaje Nutricional</h4>
                                    </div>
                                </div>
                                <div class="tamizaje">
                                    <label for="idFechaTamizaje">Fecha</label>
                                    <label for="idRiesgo">Riesgo</label>
                                    <input placeholder="Resultado" id="idFechaTamizaje" class="clsInput inputAntropometria" type="text">
                                    <input placeholder="Resultado" id="idRiesgo" class="clsInput inputAntropometria" type="text">
                                </div>
                            </div>
                            <div class="antro">
                                <div class="header-container" style="padding:0;">
                                    <div class="section-title left">
                                        <h4 class="text" >Criterios Glim</h4>
                                    </div>
                                </div>
                                <div class="glim">
                                    <div class="glimA">
                                        <label class="glimm" for="">a) Criterios fenotipicos</label>
                                        <div class="input-box">
                                            <label for="idPerdidaPeso">Perdida de peso</label>
                                            <input placeholder="Resultado" id="idPerdidaPeso" class="clsInput inputAntropometria blanco" type="text">
                                        </div>
                                        <div class="input-box">
                                            <label for="idIMCBajo">IMC bajo</label>
                                            <input placeholder="Resultado" id="idIMCBajo" class="clsInput inputAntropometria blanco" type="text">
                                        </div>
                                        <div class="input-box">
                                            <label for="idMasaMuscular">Masa muscular</label>
                                            <select name="" id="" class="clsInput">
                                                <option value="">Seleccione un metodo</option>
                                            </select>
                                            <div></div>
                                            <select name="" id="" class="clsInput">
                                                <option value="">Seleccione un resultado</option>
                                                <option value="">Desnutricion leve</option>
                                                <option value="">Desnutricion moderada</option>
                                                <option value="">Desnutricion grave</option>
                                            </select>
                                            <!-- <input placeholder="Resultado" id="idMasaMuscular" class="clsInput inputAntropometria" type="text"> -->
                                        </div>
                                    </div>
                                    <div class="glimB">
                                        <label class="glimm" for="">b) Criterios etiologicos</label>
                                        <div class="input-box ingesta2">
                                            <!-- <input placeholder="Ingesta reducida" id="idIngestaReducida" class="clsInput inputAntropometria" type="text" step="0">
                                            <input placeholder="Tiempo (dias)" id="idIngestaTiempo" class="clsInput inputAntropometria" type="text" stepp="0"> -->
                                            <select name="" id="idIngestaReducida" class="clsInput" style="column:span 2">
                                                <option value="">Ingesta reducida</option>
                                                <option value="1">Menos de 50% (Entre 7 y 15 dias)</option>
                                                <option value="2">Menos de 90% (Mayor a 15 dias)</option>
                                            </select>
                                        </div>
                                        <div class="input-box">
                                            <label for="idIngesta">Ingesta</label>
                                            <input placeholder="Resultado" id="idIngesta" class="clsInput inputAntropometria" type="text">
                                        </div>
                                        <div class="input-box">
                                            <label for="idAbsorcion">Absorcion</label>
                                            <input placeholder="Resultado" id="idAbsorcion" class="clsInput inputAntropometria" type="text">
                                        </div>
                                        <div class="input-box">
                                            <label for="idInflamacion">Inflamacion</label>
                                            <input placeholder="Resultado" id="idInflamacion" class="clsInput inputAntropometria" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div>
                                <div class="header-container" style="padding:0;">
                                    <div class="section-title left">
                                        <h4 class="text" >Examenes de Laboratorio</h4>
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
                                            <table id="tblNutricionales" class="tbl-SeguimientoAntropometria">
                                                <thead>
                                                    <th style="text-wrap: wrap;">Fecha</th>
                                                    <th style="text-wrap: wrap;">Prealbumina</th>
                                                    <th style="text-wrap: wrap;">Albumina</th>
                                                    <th style="text-wrap: wrap;">Proteinas</th>
                                                    <th style="text-wrap: wrap;">Vitamina D</th>
                                                    <th style="text-wrap: wrap;">Vitamina B12</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>0.45</td>
                                                        <td>0.45</td>
                                                        <td>0.45</td>
                                                        <td>0.45</td>
                                                        <td>0.45</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>1.2</td>
                                                        <td>1.2</td>
                                                        <td>1.2</td>
                                                        <td>1.2</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>0.2</td>
                                                        <td>0.2</td>
                                                        <td>0.2</td>
                                                        <td>0.2</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="bloque">
                                            <table id="tblIonograma" class="tbl-SeguimientoAntropometria">
                                                <thead>
                                                    <th style="text-wrap: wrap;">Fecha</th>
                                                    <th style="text-wrap: wrap;">Sodio</th>
                                                    <th style="text-wrap: wrap;">Potasio</th>
                                                    <th style="text-wrap: wrap;">Fosforo</th>
                                                    <th style="text-wrap: wrap;">Magnesio</th>
                                                    <th style="text-wrap: wrap;">Calcio</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>1.2</td>
                                                        <td>1.2</td>
                                                        <td>1.2</td>
                                                        <td>1.2</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="bloque"> 
                                            <table id="tblHepatica" class="tbl-SeguimientoAntropometria">
                                                <thead>
                                                    <th style="text-wrap: wrap;">Fecha</th>
                                                    <th style="text-wrap: wrap;">BT</th>
                                                    <th style="text-wrap: wrap;">BD</th>
                                                    <th style="text-wrap: wrap;">ALT</th>
                                                    <th style="text-wrap: wrap;">AST</th>
                                                    <th style="text-wrap: wrap;">GGT</th>
                                                    <th style="text-wrap: wrap;">FA</th>
                                                    <th style="text-wrap: wrap;">TG</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                        <td>0.8</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="bloque"> 
                                            <table id="tblRenal" class="tbl-SeguimientoAntropometria">
                                                <thead>
                                                    <th style="text-wrap: wrap;">Fecha</th>
                                                    <th style="text-wrap: wrap;">BUN</th>
                                                    <th style="text-wrap: wrap;">CREA</th>
                                                    <th style="text-wrap: wrap;">RELA B/CRE</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10/10/2024</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                        <td>1.34</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="bloque"> 
                                            <table id="tblOtros" class="tbl-SeguimientoAntropometria">
                                                <thead>
                                                    <th style="text-wrap: wrap;">Fecha</th>
                                                    <th style="text-wrap: wrap;">Examen</th>
                                                    <th style="text-wrap: wrap;">Resultado</th>
                                                    <th style="text-wrap: wrap; width:10%; "><button id="btn-AgregarLinea" class="btnNuevoExamen">+</button></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input placeholder="Fecha" class="clsInput" type="date"></td>
                                                        <td><input class="clsInput" placeholder="Nombre Examen" type="text" id="otro"></td>
                                                        <td><input placeholder="Resultado" class="clsInput" type="text"></td>
                                                        <td><button hidden class="btn-eliminar">-</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" style="margin-top: 40px;">
                <div class="card-header">
                    
                    <!-- <div class="input-area">
                        <label for="idOtros">Otros</label>
                        <textarea name="" id="idOtros-examenes" class="clsInput text-area"></textarea>
                    </div>   -->
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="diagnostico" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container" style="padding:0;">
                        <div class="section-title left">
                            <span class="line"></span>
                            <h3 class="text">DIAGNOSTICO NUTRICIONAL</h>
                        </div>
                    </div>
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle active" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" style="background-color: #066E45"></div>
                        <a href="#diagnostico"><div class="stepper-circle"  style="background-color: #066E45"></div></a>
                        <div class="stepper-line"></div>
                        <a href="#intervencion"><div class="stepper-circle" ></div></a>
                        <div class="stepper-line" ></div>
                        <a href="#analisis"><div class="stepper-circle"  ></div></a>
                        <!-- <div class="stepper-line"></div>
                        <div class="stepper-circle" ></div> -->
                    </div> 
                    <div class="diagnostico">
                        <div class="diagnostico1">
                            <div class="input-box">
                                <label for="idDesnutricionGLIM">Desnutricion por criterios GLIM</label>
                                <div>
                                    <button class="btn-si desnutricionGLIM">Si</button>
                                    <button class="btn-no desnutricionGLIM">No</button>
                                </div>
                            </div>
                            <div class="input-box">
                                <label for="idGravedadDesnutricion">Gravedad de la Desnutricion</label>
                                <input placeholder="Resultado" id="idGravedadDesnutricion" class="clsInput blanco" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idEstadoNutricional">Estado nutricional ++</label>
                                <input placeholder="Resultado" id="idEstadoNutricional" class="clsInput blanco" type="text">
                            </div>
                        </div>
                        <div class="diagnostico2">
                            <label for="">CONDICIONES RELACIONADAS CON LA NUTRICION</label>
                            <div class="input-box">
                                <label for="idCIE-10">CIE-10</label>
                                <input placeholder="Resultado" id="idCIE-10" class="clsInput" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="intervencion" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container" style="padding:0;">
                        <div class="section-title left">
                            <span class="line"></span>
                            <h3 class="text">INTERVENCION NUTRICIONAL</h>
                        </div>
                    </div>
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle active" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" style="background-color: #066E45"></div>
                        <a href="#diagnostico"><div class="stepper-circle"  style="background-color: #066E45"></div></a>
                        <div class="stepper-line" style="background-color: #066E45"></div>
                        <a href="#intervencion"><div class="stepper-circle"  style="background-color: #066E45"></div></a>
                        <div class="stepper-line"></div>
                        <a href="#analisis"><div class="stepper-circle" ></div></a>
                        <!-- <div class="stepper-line"></div>
                        <div class="stepper-circle" ></div> -->
                    </div> 
                    <div class="header-container  style="padding:0;"doble-titulo">
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
                                <input placeholder="Resultado" id="idClasifRiesgo" class="clsInput blanco" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idConsumoCalorico">Consumo calorico aprox ultim sem</label>
                                <input placeholder="Resultado" id="idConsumoCalorico" class="clsInput" type="text">
                            </div>
                        </div>
                        <div class="div-2">
                            <div class="input-box">
                                <label for="idPesoTrabajoIN">Peso de trabajo</label>
                                <input placeholder="Resultado" id="idPesoTrabajoIN" class="clsInput" type="text">
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
                                            <td><input type="text" class="clsInput"></td>
                                            <td><input type="text" class="clsInput blanco"></td>
                                        </tr>
                                        <tr>
                                            <td>Proteina</td>
                                            <td><input type="text" class="clsInput"></td>
                                            <td><input type="text" class="clsInput blanco"></td>
                                        </tr>
                                        <tr>
                                            <td>Hidrico</td>
                                            <td><input type="text" class="clsInput"></td>
                                            <td><input type="text" class="clsInput blanco"></td>
                                        </tr>
                                        <tr>
                                            <td>Otro</td>
                                            <td><input type="text" class="clsInput"></td>
                                            <td><input type="text" class="clsInput blanco"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container" style="padding:0;">
                        <div class="section-title left">
                            <h4 class="text" >Tipo de soporte nutricional programado</h4>
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
                    <div class="input-box">
                        <label for="">% de Absorcion estimado</label>
                        <input class="clsInput" type="text">
                    </div>
                    <div class="input-box">
                        <label for="idObservaciones">Observaciones</label>
                        <div style="grid-column:span 2">
                            <textarea name="" id="idObservaciones-Antropometria" style="margin:0" class="clsInput text-area"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container" style="padding:0;">
                        <div class="section-title left">
                            <h4 class="text" >Porcentaje de adecuacion</h4>
                        </div>
                    </div>
                    <div class="adecuacion-content">
                        <div class="adecuacion">
                            <div class="input-box">
                                <label for="idLiquidos">Liquidos</label>
                                <input placeholder="Resultado" id="idLiquidos" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idKcal">Kcal</label>
                                <input placeholder="Resultado" id="idKcal" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idProt">Prot</label>
                                <input placeholder="Resultado" id="idProt" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idCHO">CHO</label>
                                <input placeholder="Resultado" id="idCHO" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idLip">Lip</label>
                                <input placeholder="Resultado" id="idLip" class="clsInput" type="text">
                            </div>
                        </div>
                        <div class="adecuacion">
                            <label for="idKcal" class="porcentajeAdecuacion">%</label>
                            <div class="input-box">
                                <label for="idKcalAdecuacion">Kcal</label>
                                <input placeholder="Resultado" id="idKcalAdecuacion" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idProteina">Proteina</label>
                                <input placeholder="Resultado" id="idProteina" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idHidrico">Hidrico</label>
                                <input placeholder="Resultado" id="idHidrico" class="clsInput" type="text">
                            </div>
                            <div class="input-box">
                                <label for="idOtro">Otro</label>
                                <input placeholder="Resultado" id="idOtro" class="clsInput" type="text">
                            </div>
                        </div>
                        <div class="adecuacion">
                            <label for="idOtro">Clasificacion</label>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idClasificacionKal" class="clsInput inputClasi" type="text">
                            </div>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idClasificacionProteina" class="clsInput inputClasi" type="text">
                            </div>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idClasificacionHidrico" class="clsInput inputClasi" type="text">
                            </div>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idClasificacionOtro" class="clsInput inputClasi" type="text">
                            </div>
                        </div>
                        <div class="adecuacion">
                            <label for="idOtro">Observaciones</label>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idObsKal" class="clsInput inputClasi" type="text">
                            </div>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idObsProteina" class="clsInput inputClasi" type="text">
                            </div>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idObsHidrico" class="clsInput inputClasi" type="text">
                            </div>
                            <div class="input-box">
                                <input placeholder="Resultado" id="idObsOtro" class="clsInput inputClasi" type="text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow p-3 mb-8" id="analisis" style="margin-top: 40px;">
                <div class="card-header">
                    <div class="header-container" style="padding:0;">
                        <div class="section-title left">
                            <span class="line"></span>
                            <h3 class="text">ANALISIS</h>
                        </div>
                    </div>
                    <div class="stepper-container">
                        <a href="#evaluacion"><div class="stepper-circle active" style="background-color: #066E45" ></div></a>
                        <div class="stepper-line" style="background-color: #066E45"></div>
                        <a href="#diagnostico"><div class="stepper-circle"  style="background-color: #066E45"></div></a>
                        <div class="stepper-line" style="background-color: #066E45"></div>
                        <a href="#intervencion"><div class="stepper-circle"  style="background-color: #066E45"></div></a>
                        <div class="stepper-line"  style="background-color: #066E45"></div>
                        <a href="#analisis"><div class="stepper-circle"   style="background-color: #066E45"></div></a>
                        <!-- <div class="stepper-line"></div>
                        <div class="stepper-circle" ></div> -->
                    </div>                  
                    <div class="input-area" style="margin-top:75px; display: flex; justify-content:center;">
                        <textarea name="" id="idAnalisis" class="clsInput text-area"></textarea>
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

    if (DatosIncapacidad && DatosIncapacidad["NombreMedico"] == "" && DatosIncapacidad["Registro"] == "" && DatosIncapacidad["IDtextPaciente"] == "") {      
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
<script src="../control/ingreso.js"></script>
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

