<?php

include('../../../config/Conexion.php');
ob_start();
session_start();

$parameters = http_build_query($_GET);

if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/Rehabilitacion_intestinal/view/reporteParaclinico.php";
    header("Location: ../../../view/login.php" . "?" . $parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Reportes paraclinicos";

    $_SESSION['module_title'] = "Reportes paraclinicos";
    require_once '../../../view/template/header.php';

    if ($_SESSION['Rehabilitacion_intestinal'] == 1) {
        if (isset($_GET["param"]) && $_GET["param"] !== "") {
            // $_SESSION["param"] = $_GET["param"];
        }

        require '../../../logica/ApiURL.php';

        // $_SESSION["param"] = "";
        $idusuario = $_SESSION["idusuario"];


        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reportes paraclinicos</title>
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Rehabilitacion_intestinal/view/css/historia.css">
        </head>

        <body>
            <div class="content-wrapper">
                <div id="alertContainer" class="alert" role="alert"></div>
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card shadow p-2 mb-8">
                            <div class="card-header">
                                <!-- titulo -->
                                
                                <!-- datos del paciente -->
                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span class="span">Datos
                                                    Del Paciente</span></h4>
                                        </div>
                                    </div>
                                </div>

                                <form id="agregarLinea" method="POST" action="reporteParaclinico.php">
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <center><label for="episodio">Episodio:</label></center>
                                            <input type="text" id="episodio" name="episodio" class="form-control"
                                                value="<?php echo $Doc ?>">
                                        </div>
                                        <div class="form-group col-md-4" style="display:none;">
                                            <input readonly type="text" id="tipo" name="tipo" class="form-control"
                                                value="<?php echo $DatosIncapacidad['TypeIdentification']; ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="nroDoc">Numero de documento:</label></center>
                                            <input type="text" id="nroDoc" name="nroDoc" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['IDNumberPaciente']) && !empty($DatosIncapacidad['IDNumberPaciente']) ?$DatosIncapacidad['IDNumberPaciente']:''; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <center><label for -="nombre">Nombre paciente:</label></center>
                                            <input type="text" id="nombre" name="nombre" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NombreApellido']) && !empty($DatosIncapacidad['NombreApellido']) ?$DatosIncapacidad['NombreApellido']:''; ?>">
                                        </div>
                                        <div class="form-group col-md-1" hidden>
                                            <center><label style="color:black" for="centrosanitario" class="form-label">centrosanitario:</label></center>
                                            <input type="text" class="form-control" id="centrosanitario" name="centrosanitario" value="<?php echo isset($DatosIncapacidad['CentroSanitario']) && !empty($DatosIncapacidad['CentroSanitario']) ?$DatosIncapacidad['CentroSanitario']:''; ?>">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <center><label for="edad">Edad:</label></center>
                                            <input type="text" id="edad" name="edad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Edad']) && !empty($DatosIncapacidad['Edad']) ?$DatosIncapacidad['Edad']:''; ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="sexo">Genero:</label></center>
                                            <input type="text" id="sexo" name="sexo" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Sexo']) && !empty($DatosIncapacidad['Sexo']) ?$DatosIncapacidad['Sexo']:''; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <center><label for="ubicacion">Ubicacion:</label></center>
                                            <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                                                value="<?php echo isset($UbicacionPaciente["UbicacionEdificio"]) && !empty($UbicacionPaciente["UbicacionEdificio"]) ?$UbicacionPaciente["UbicacionEdificio"]:''; ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="cama">Cama:</label></center>
                                            <input type="text" id="cama" name="cama" class="form-control"
                                                value="<?php echo isset($UbicacionPaciente["IdUbicacion_cama"]) && !empty($UbicacionPaciente["IdUbicacion_cama"]) ?$UbicacionPaciente["IdUbicacion_cama"]:''; ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <center><label for="entidad">Aseguradora:</label></center>
                                            <input type="text" id="entidad" name="entidad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NomEntidad']) && !empty($DatosIncapacidad['NomEntidad']) ?$DatosIncapacidad['NomEntidad']:''; ?>">
                                        </div>

                                        <div class="col-md-3">
                                            <center><label style="color:black" for="fecha" class="form-label">Fecha
                                                    Ingreso:</label></center>
                                            <input type="text" class="form-control" id="fecha" name="fecha" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <center><label style="color:black" for="hora" class="form-label">Hora
                                                    Ingreso:</label></center>
                                            <input type="text" class="form-control" id="hora" name="hora" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <center><label for="especialidad">Especialidad:</label></center>
                                            <input type="text" id="especialidad" name="especialidad" class="form-control" value="<?php echo isset($DatosIncapacidad['Especialidad']) && !empty($DatosIncapacidad['Especialidad']) ?$DatosIncapacidad['Especialidad']:''; ?>" >
                                        </div>
                                        
                                        <div class="form-group col-md-7">
                                            <center><label for -="nombre">Nombre medico:</label></center>
                                            <input type="text" id="nombreMed" name="nombreMed" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NombreMedico']) && !empty($DatosIncapacidad['NombreMedico']) ?$DatosIncapacidad['NombreMedico']:''; ?>">
                                        </div>
                                        <div class="form-group col-md-1" hidden >
                                            <center><label style="color:black" for="id" class="form-label">id:</label></center>
                                            <input type="text" class="form-control" id="id" name="id" >
                                        </div>

                                    </div>
                                </form>

                                <!-- examenes -->
                                <div class="container mx-auto p-4">
                                    <div class="row titles-UbiCita">
                                        <div class="col">
                                            <div class="well">
                                                <h4 class="form-label text-divider-Epid"><span
                                                        class="left-span"></span><span class="span">Examenes</span></h4>
                                            </div>
                                        </div>
                                        <div class="search-container">
                                            <div class="relative">
                                                <input type="text" id="searchInput" onkeyup="filterExams()" placeholder="Search"
                                                    class="search">
                                                <i class="fas fa-search absolute right-3 top-2 text-gray-500"></i>
                                            </div>
                                        </div>
                                        <td>
                                            <a id="pdf" onclick="window.open('../../../Modulos/Rehabilitacion_intestinal/logica/PDF/GenerarPDF.php?episodio=<?php echo $Doc ?>', '_blank')" style="cursor: pointer;">
                                                <i class="fa-solid fa-file-pdf fa-2x" ></i>
                                            </a>
                                        </td>
                                    </div>
                                    <div class="exam-container">
                                        <div class="exam-item" id="leucocitos">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>LEUCOCITOS</label>
                                        </div>
                                        <div class="exam-item" id="neutrofilos">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>NEUTROFILOS</label>
                                        </div>
                                        <div class="exam-item" id="linfocitos">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>LINFOCITOS</label>
                                        </div>
                                        <div class="exam-item" id="eosinofilos">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>EOSINOFILOS</label>
                                        </div>
                                        <div class="exam-item" id="hemoglobina">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>HEMOGLOBINA</label>
                                        </div>
                                        <div class="exam-item" id="hematocrito">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>HEMATOCRITO</label>
                                        </div>
                                        <div class="exam-item" id="plaquetas">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>PLAQUETAS</label>
                                        </div>
                                        <div class="exam-item" id="vsg">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>VSG</label>
                                        </div>
                                        <div class="exam-item" id="pcr">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>PCR</label>
                                        </div>
                                        <div class="exam-item" id="tgo">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>TGO/AST</label>
                                        </div>
                                        <div class="exam-item" id="tgp">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>TGP/ALT</label>
                                        </div>
                                        <div class="exam-item" id="bilirrubina_total">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>BILIRRUBINA TOTAL</label>
                                        </div>
                                        <div class="exam-item" id="bilirrubina_directa">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>BILIRRUBINA DIRECTA</label>
                                        </div>
                                        <div class="exam-item" id="ggt">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>GGT</label>
                                        </div>
                                        <div class="exam-item" id="fosfatasa_alcalina">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>FOSFATASA ALCALINA</label>
                                        </div>
                                        <div class="exam-item" id="tp_inr">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>TP/INR</label>
                                        </div>
                                        <div class="exam-item" id="tpt">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>TPT</label>
                                        </div>
                                        <div class="exam-item" id="amilasa">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>AMILASA</label>
                                        </div>
                                        <div class="exam-item" id="sodio">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>SODIO</label>
                                        </div>
                                        <div class="exam-item" id="fosforo">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>FOSFORO</label>
                                        </div>
                                        <div class="exam-item" id="potasio">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>POTASIO</label>
                                        </div>
                                        <div class="exam-item" id="cloro">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>CLORO</label>
                                        </div>
                                        <div class="exam-item" id="calcio">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>CALCIO</label>
                                        </div>
                                        <div class="exam-item" id="magnesio">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>MAGNESIO</label>
                                        </div>
                                        <div class="exam-item" id="colesterol_total">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>COLESTEROL TOTAL</label>
                                        </div>
                                        <div class="exam-item" id="colesterol_hdl">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>COLESTEROL HDL</label>
                                        </div>
                                        <div class="exam-item" id="trigliceridos">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>TRIGLICERIDOS</label>
                                        </div>
                                        <div class="exam-item" id="proteinas_totales">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>PROTEINAS TOTALES</label>
                                        </div>
                                        <div class="exam-item" id="albumina">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>ALBUMINA</label>
                                        </div>
                                        <div class="exam-item" id="pre_albumina">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>PRE-ALBUMINA</label>
                                        </div>
                                        <div class="exam-item" id="electroforesis_proteinas">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>ELECTROFORESIS DE PROTEINAS</label>
                                        </div>
                                        <div class="exam-item" id="vitamina_b12">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>VITAMINA B12</label>
                                        </div>
                                        <div class="exam-item" id="vitamina_d">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>VITAMINA D</label>
                                        </div>

                                        <div class="exam-item" id="creatinina">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>CREATININA</label>
                                        </div>
                                        <div class="exam-item" id="glicemia">
                                            <input type="text" placeholder="Valor" class="value-input">
                                            <label>GLICEMIA</label>
                                        </div>
                                        <div class="exam-item" id="gases">
                                            <div class="input-group exam-item" id="HCO">
                                                <input type="text" placeholder="Valor" class="value-input">
                                                <label>GASES HCO&#8323;&#8315;</label>
                                            </div>
                                            <div class="input-group exam-item" id="EB">
                                                <input type="text" placeholder="Valor" class="value-input">
                                                <label>GASES EB</label>
                                            </div>
                                            <div class="input-group exam-item" id="Ph">
                                                <input type="text" placeholder="Valor" class="value-input">
                                                <label>GASES Ph</label>
                                            </div>
                                        </div>
                                        <div class="exam-item" id="aislamientos">
                                            <label style="font-size:16px; font-weight:bold;"
                                                for="aislamientos">AISLAMIENTOS</label>
                                            <div class="row gy-2">
                                                <div class="col-md-6 col-12">
                                                    <label for="fechaAislamientos">FECHA</label>
                                                    <input type="date" placeholder="Valor" class="value-input"
                                                        id="fechaAislamientos">
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label for="tipoEstudio">MUESTRA</label>
                                                    <select class="value-input" id="tipoEstudio" name="tipoEstudio"
                                                        onchange="toggleOtherInput()">
                                                        <option value="" disabled selected hidden></option>
                                                        <option value="urocultivo">Urocultivo</option>
                                                        <option value="hemocultivo">Hemocultivo</option>
                                                        <option value="otros">Otros</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-12" id="otherFieldContainer" style="display: none;">
                                                    <label for="otherInput">¿Cuál?</label>
                                                    <input type="text" class="value-input" id="otherInput" name="otherInput">
                                                </div>
                                                <div class="col-md-6 col-12" id="observaciones" style="display: none;">
                                                    <label for="observaciones">Observaciones</label>
                                                    <input type="text" class="value-input" id="observacionesInput"
                                                        name="otherInput">
                                                </div>
                                                <div class="col-md-6 col-12" style="display: none;" id="origenContainer">
                                                    <label for="origen">ORIGEN</label>
                                                    <select class="value-input" id="origen" name="origen">
                                                        <option value="" disabled selected hidden></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label for="germen">GERMEN</label>
                                                    <input type="text" placeholder="Valor" class="value-input" id="germen">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="exam-item" id="examenesComplementarios">
                                            <label>EXAMENES COMPLEMENTARIOS</label>
                                            <input type="text" placeholder="Valor" class="value-input">
                                        </div>
                                    </div>

                                    <br>
                                        
                                    <button id="guardarBtn" name="guardaRegistro" class="btn waves-effect waves-light"
                                        style="background-color: #428E3F; color:white; display: block; margin: 0 auto;"
                                        onclick="guardarDefinitivoVertical('registroTabla')">
                                        <i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;Registrar datos
                                    </button>

                                </div>
                                <!-- tabla de registros -->
                                <div class="container">
                                    <div class="row titles-UbiCita">
                                        <div class="col">
                                            <div class="well">
                                                <h4 class="form-label text-divider-Epid"><span
                                                        class="left-span"></span><span class="span">Registros</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-container">
                                        <table id="registroTabla">
                                            <tr id="fecha">
                                                <th>FECHA</td>
                                            </tr>
                                            <tr id="hora">
                                                <th>HORA</td>
                                            </tr>
                                            <tr id="leucocitos">
                                                <td>LEUCOCITOS</td>
                                            </tr>
                                            <tr id="neutrofilos">
                                                <td>NEUTROFILOS</td>
                                            </tr>
                                            <tr id="linfocitos">
                                                <td>LINFOCITOS</td>
                                            </tr>
                                            <tr id="eosinofilos">
                                                <td>EOSINOFILOS</td>
                                            </tr>
                                            <tr id="hemoglobina">
                                                <td>HEMOGLOBINA</td>
                                            </tr>
                                            <tr id="hematocrito">
                                                <td>HEMATOCRITO</td>
                                            </tr>
                                            <tr id="plaquetas">
                                                <td>PLAQUETAS</tds>
                                            </tr>
                                            <tr id="vsg">
                                                <td>VSG</td>
                                            </tr>
                                            <tr id="pcr">
                                                <td>PCR</td>
                                            </tr>
                                            <tr id="tgo">
                                                <td>TGO/AST </td>
                                            </tr>
                                            <tr id="tgp">
                                                <td>TGP/ALT </td>
                                            </tr>
                                            <tr id="bilirrubina_total">
                                                <td>BILIRRUBINA TOTAL</td>
                                            </tr>
                                            <tr id="bilirrubina_directa">
                                                <td>BILIRRUBINA DIRECTA</td>
                                            </tr>
                                            <tr id="ggt">
                                                <td>GGT</td>
                                            </tr>
                                            <tr id="fosfatasa_alcalina">
                                                <td>FOSFATASA ALCALINA</td>
                                            </tr>
                                            <tr id="tp_inr">
                                                <td>TP/INR</td>
                                            </tr>
                                            <tr id="tpt">
                                                <td>TPT</td>
                                            </tr>
                                            <tr id="amilasa">
                                                <td>AMILASA</td>
                                            </tr>
                                            <tr id="sodio">
                                                <td>SODIO</td>
                                            </tr>
                                            <tr id="fosforo">
                                                <td>FOSFORO</td>
                                            </tr>
                                            <tr id="potasio">
                                                <td>POTASIO</td>
                                            </tr>
                                            <tr id="cloro">
                                                <td>CLORO</td>
                                            </tr>
                                            <tr id="calcio">
                                                <td>CALCIO</td>
                                            </tr>
                                            <tr id="magnesio">
                                                <td>MAGNESIO</td>
                                            </tr>
                                            <tr id="colesterol_total">
                                                <td>COLESTEROL TOTAL</td>
                                            </tr>
                                            <tr id="colesterol_hdl">
                                                <td>COLESTEROL HDL</td>
                                            </tr>
                                            <tr id="trigliceridos">
                                                <td>TRIGLICERIDOS</td>
                                            </tr>
                                            <tr id="proteinas_totales">
                                                <td>PROTEINAS TOTALES</td>
                                            </tr>
                                            <tr id="albumina">
                                                <td>ALBUMINA</td>
                                            </tr>
                                            <tr id="pre_albumina">
                                                <td>PRE-ALBUMINA</td>
                                            </tr>
                                            <tr id="electroforesis_proteinas">
                                                <td>ELECTROFORESIS DE PROTEINAS</td>
                                            </tr>
                                            <tr id="vitamina_b12">
                                                <td>VITAMINA B12</td>
                                            </tr>
                                            <tr id="vitamina_d">
                                                <td>VITAMINA D</td>
                                            </tr>
                                            <tr id="creatinina">
                                                <td>CREATININA</td>
                                            </tr>
                                            <tr id="glicemia">
                                                <td>GLICEMIA</td>
                                            </tr>
                                            <tr id="HCO">
                                                <td>GASES HCO&#8323;&#8315;</td>
                                            </tr>
                                            <tr id="EB">
                                                <td>GASES EB</td>
                                            </tr>
                                            <tr id="Ph">
                                                <td>GASES Ph</td>
                                            </tr>
                                            <tr id="aislamientos">
                                                <td>AISLAMIENTOS</td>
                                            </tr>
                                            <tr id="examenesComplementarios">
                                                <td>EXAMENES COMPLEMENTARIOS</td>
                                            </tr>
                                            <tr id="btnEditar">
                                                <td>Editar</td>
                                            </tr>
                                            <tr id="id" hidden>
                                                <td>id</td>
                                            </tr>

                                        </table>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script src="../Control/JS/Reloj.js"></script>
            <script src="../Control/JS/reporteParaclinico.js"></script>
            <script src="../Control/JS/controlApi.js"></script>
            <script>
                function toggleOtherInput() {
                    var tipoEstudio = document.getElementById("tipoEstudio").value;
                    var otherFieldContainer = document.getElementById("otherFieldContainer");
                    var origenContainer = document.getElementById("origenContainer");
                    var observaciones = document.getElementById("observaciones");
                    var origen = document.getElementById("origen");

                    // Reset visibility
                    otherFieldContainer.style.display = "none";
                    origenContainer.style.display = "none";
                    observaciones.style.display = "none";

                    // Reset options in origen select
                    origen.innerHTML = '<option value="" disabled selected hidden></option>';

                    // Check the selected value and update options accordingly
                    if (tipoEstudio === "otros") {
                        otherFieldContainer.style.display = "block"; // Show other input
                        observaciones.style.display = "block"; // Show Observaciones
                    } else if (tipoEstudio === "urocultivo") {
                        // Show origen and set options for urocultivo
                        origenContainer.style.display = "block";
                        var option1 = document.createElement("option");
                        option1.value = "sonda";
                        option1.textContent = "Sonda";

                        var option2 = document.createElement("option");
                        option2.value = "ocasional";
                        option2.textContent = "Ocasional";

                        origen.appendChild(option1);
                        origen.appendChild(option2);
                    } else if (tipoEstudio === "hemocultivo") {
                        // Show origen and set options for hemocultivo
                        origenContainer.style.display = "block";
                        var option1 = document.createElement("option");
                        option1.value = "Periferico";
                        option1.textContent = "Periférico";

                        var option2 = document.createElement("option");
                        option2.value = "central";
                        option2.textContent = "Central";

                        origen.appendChild(option1);
                        origen.appendChild(option2);
                    }
                }

            </script>
        </body>


        <?php
    } else {
        require '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';
    ?>

    <?php
}
ob_end_flush();
?>

</html>