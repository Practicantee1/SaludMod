<?php

include('../../../config/Conexion.php');

ob_start();
session_start();

$parameters = http_build_query($_GET);

if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/desarrollo_epidemiologia?CH=1";
    header("Location: ../../../view/login.php" . "?" . $parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Epidemiologas";

    $_SESSION['module_title'] = "EPIDEMIOLOGAS";
    require_once '../../../view/template/header.php';

    if ($_SESSION['bundlesEpidemiologa'] == 1) {
        if (isset($_GET["param"]) && $_GET["param"] !== "") {
            //$_SESSION["param"] = $_GET["param"];
        }

        require '../../../logica/ApiURL.php';

        //$_SESSION["param"] = "";
        $idusuario = $_SESSION["idusuario"];

        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/desarrollo_epidemiologia/view/CSS/estilos.css">
            <title>Prevenir Infecciones Asociadas a Dispositivos Invasivos (BUNDLES)</title>

        </head>

        <body>
            <div class="content-wrapper">
                <div id="alertContainer" class="alert" role="alert"></div>
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card shadow p-2 mb-8">
                            <div class="card-header">
                                <br>

                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span class="span">Datos
                                                    Del Paciente</span></h4>
                                        </div>
                                    </div>
                                </div>

                                <form id="agregarLinea" method="POST" action="enfermeras.php">
                                    <div class="row">

                                        <div class="form-group col-md-3">
                                            <center><label for="episodio">Episodio:</label></center>
                                            <input type="number" id="episodio" name="episodio" class="form-control"
                                                value="<?php echo $Doc ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-4" style="display:none;">
                                            <input readonly type="text" id="tipo" name="tipo" class="form-control"
                                                value="<?php echo $DatosIncapacidad['TypeIdentification']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="nroDoc">Numero de documento:</label></center>
                                            <input type="text" id="nroDoc" name="nroDoc" class="form-control" value="<?php echo isset($DatosIncapacidad['IDNumberPaciente']) && !empty($DatosIncapacidad['IDNumberPaciente']) ?$DatosIncapacidad['IDNumberPaciente']:''; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <center><label for -="nombrePaciente">Nombre paciente:</label></center>
                                            <input type="text" id="nombrePaciente" name="nombrePaciente" class="form-control" value="<?php echo isset($DatosIncapacidad['NombreApellido']) && !empty($DatosIncapacidad['NombreApellido']) ?$DatosIncapacidad['NombreApellido']:''; ?>" readonly>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <center><label for="edad">Edad:</label></center>
                                            <input type="text" id="edad" name="edad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Edad']) && !empty($DatosIncapacidad['Edad']) ?$DatosIncapacidad['Edad']:''; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="sexo">Genero:</label></center>
                                            <input type="text" id="sexo" name="sexo" class="form-control" value="<?php echo isset($DatosIncapacidad['Sexo']) && !empty($DatosIncapacidad['Sexo']) ?$DatosIncapacidad['Sexo']:''; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <center><label for="ubicacion">Ubicacion:</label></center>
                                            <input type="text" id="ubicacion" name="ubicacion" class="form-control" value="<?php echo isset($UbicacionPaciente["UbicacionEdificio"]) && !empty($UbicacionPaciente["UbicacionEdificio"]) ?$UbicacionPaciente["UbicacionEdificio"]:''; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="cama">Cama:</label></center>
                                            <input type="text" id="cama" name="cama" class="form-control" value="<?php echo isset($UbicacionPaciente["IdUbicacion_cama"]) && !empty($UbicacionPaciente["IdUbicacion_cama"]) ?$UbicacionPaciente["IdUbicacion_cama"]:''; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <center><label for="entidad">Entidad:</label></center>
                                            <input type="text" id="entidad" name="entidad" class="form-control" value="<?php echo isset($DatosIncapacidad['NomEntidad']) && !empty($DatosIncapacidad['NomEntidad']) ?$DatosIncapacidad['NomEntidad']:''; ?>" readonly>
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
                                        <div class="form-group col-md-6">
                                            <center><label for="profesional">Nombre profesional:</label></center>
                                            <input type="text" id="profesional" name="profesional" class="form-control"
                                            value="<?php echo isset($DatosIncapacidad['NombreMedico']) && !empty($DatosIncapacidad['NombreMedico']) ?$DatosIncapacidad['NombreMedico']:''; ?>" readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <center><label style="color:black" for="especialidad" class="form-label">Cargo:</label>
                                            </center>
                                            <input type="text" class="form-control" id="especialidad" name="especialidad"
                                            value="<?php echo isset($DatosIncapacidad['Especialidad']) && !empty($DatosIncapacidad['Especialidad']) ?$DatosIncapacidad['Especialidad']:''; ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-1" hidden>
                                            <center><label style="color:black" for="id" class="form-label">id:</label></center>
                                            <input type="text" class="form-control" id="id" name="id" readonly>
                                        </div>
                                        <div class="form-group col-md-1" hidden>
                                            <center><label style="color:black" for="centrosanitario" class="form-label">centrosanitario:</label></center>
                                            <input type="text" class="form-control" id="centrosanitario" name="centrosanitario" value="<?php echo isset($DatosIncapacidad['CentroSanitario']) && !empty($DatosIncapacidad['CentroSanitario']) ?$DatosIncapacidad['CentroSanitario']:''; ?>">
                                        </div>
                                    </div>

                                </form>

                                <div class="tab-content tab-pane fade show active">
                                    <div class="question-container">
                                        <div class="question">
                                            <h3>¿El paciente está conectado a ventilación mecánica invasiva?</h3>
                                            <label>
                                                <input type="radio" name="ventilacion" value="si" onchange="toggleDivs(event)"> Sí
                                            </label>
                                            <label>
                                                <input type="radio" name="ventilacion" value="no" onchange="toggleDivs(event)"
                                                    checked> No
                                            </label>
                                        </div>

                                        <div class="question">
                                            <h3>¿El paciente tiene un catéter venoso de inserción central (CVC, PICC, Mahurka,
                                                CCI, etc.)?</h3>
                                            <label>
                                                <input type="radio" name="cvc" value="si" onchange="toggleDivs(event)"> Sí
                                            </label>
                                            <label>
                                                <input type="radio" name="cvc" value="no" onchange="toggleDivs(event)" checked> No
                                            </label>
                                        </div>

                                        <div class="question">
                                            <h3>¿El paciente tiene una sonda vesical insertada?</h3>
                                            <label>
                                                <input type="radio" name="sonda" value="si" onchange="toggleDivs(event)"> Sí
                                            </label>
                                            <label>
                                                <input type="radio" name="sonda" value="no" onchange="toggleDivs(event)" checked> No
                                            </label>
                                        </div>
                                    </div>
                                </div>



                                <!--TABLA NUMERO UNO, NAV_________________________________________________________________________-->
                                <div class="tab-content" id="navDiv" style="display: none;">
                                    <table class="table-responsive tab-pane fade show active" id="neav">
                                        <tr>
                                            <center>
                                                <th class="left-align sub-header" id="row">Neumonia asociada al ventilador (NAV)
                                                </th>
                                            </center>
                                            <th class="sub-header">Evaluacion</th>
                                        </tr>

                                        <tr>
                                            <td class="left-align sub-header" id="row">1. El cambio de equipos de ventilacion
                                                mecanica se realiza segun protocolo (filtro antibacterial y sistema cerrado de
                                                succion).</td>
                                            <td id="tds" class="tds_neav"></td>

                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">2. La cabecera esta elevada: Adultos:
                                                30°- 45° - Pediatricos/neonatos: Trendelemburg invertido.</td>
                                            <td id="tds" class="tds_neav"></td>

                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">3. Realizo higiene de cavidad oral cada 8
                                                h de acuerdo al protocolo y registro en la historia clinica.</td>
                                            <td id="tds" class="tds_neav"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">4. Realizo medicion de la presion del
                                                neumotaponador cada 12 h y registro en la historia clinica. (Adultos: 20-30 cm
                                                H2O - Pediatrico: 15-20 mmH2O).</td>
                                            <td id="tds" class="tds_neav"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">5. Los circuitos estan visiblemente
                                                limpios sin contaminacion de sangre o secreciones.</td>
                                            <td id="tds" class="tds_neav"></td>
                                        </tr>

                                        <tr>
                                            <td class="left-align sub-header">Cumplimiento</td>
                                            <td id="tds" class="tds_neav"></td>
                                        </tr>
                                    </table>
                                </div>

                                <!--TABLA NUMERO DOS, ITS-AC_________________________________________________________________________-->
                                <div class="tab-content" id="itsDiv" style="display: none;">
                                    <table class="table-responsive tab-pane fade show active" id="its">
                                        <tr>
                                            <center>
                                                <th class="left-align sub-header" id="row">Infeccion torrente sanguineo asociado
                                                    a cateter (ITS-AC )</th>
                                            </center>
                                            <th class="sub-header">Evaluacion</th>
                                        </tr>

                                        <tr>
                                            <td class="left-align sub-header" id="row">1. El aposito de fijacion cubre el sitio
                                                de inserción del cateter central y se observa limpio, seco e integro.</td>
                                            <td id="tds" class="tds_its"></td>

                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">2. Higiene de manos antes de manipular el
                                                cateter central, los puertos de inyeccion o los conectores sin aguja.</td>
                                            <td id="tds" class="tds_its"></td>

                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">3. Desinfecta la superficie de la
                                                conexión, los lados del conector sin aguja y los puertos de administración con
                                                clorhexidina alcoholica o alcohol al 70% antes de acceder al cateter.</td>
                                            <td id="tds" class="tds_its"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">4. Los equipos de infusion, conectores
                                                sin aguja, extensiones,llaves 3 vias, alargaderas, etc. estan visiblemente
                                                limpios, integros y se cambian segun protocolo.</td>
                                            <td id="tds" class="tds_its"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">5. La curacion del cateter central esta
                                                vigente.</td>
                                            <td id="tds" class="tds_its"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="row">6. ¿Existe una indicacion para permanecer
                                                con el cateter central?
                                            </td>
                                            <td id="tds" class="tds_its"></td>
                                        </tr>
                                        <tr class="left-align sub-header" id="exclude-row">
                                            <td class="left-align sub-header" id="row">Topicacion con clorexidina en mayores de
                                                2 meses
                                            </td>
                                            <td id="tds" class="tds_its"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header">Cumplimiento</td>
                                            <td id="tds" class="tds_its"></td>
                                        </tr>
                                    </table>
                                </div>

                                <!--TABLA NUMERO TRES, ISTU_AC_________________________________________________________________________-->
                                <div class="tab-content" id="istuDiv" style="display: none;">
                                    <table class="table-responsive tab-pane fade show active" id="istuTable">
                                        <tr>
                                            <th class="left-align sub-header" id="rowISTU">Infección urinaria asociada a sonda
                                                vesical (ISTU-AC) </th>
                                            <th class="sub-header">Evaluacion</th>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">1. La bolsa recolectora de orina esta
                                                por debajo del nivel de la vejiga y no esta apoyando el suelo.</td>
                                            <td id="tds" class="tds_istuTable"></td>

                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">2. El cateter urinario y su sistema
                                                de drenaje deben estar libres de acodamientos.</td>
                                            <td id="tds" class="tds_istuTable"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">3. Higiene de manos y guantes limpios
                                                para manipular la sonda vesical y el sistema de drenaje.</td>
                                            <td id="tds" class="tds_istuTable"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">4. El circuito de drenaje mantiene
                                                cerrado mediante la pinza ubicada en la bolsa recolectora.</td>
                                            <td id="tds" class="tds_istuTable"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">5. Realizo higiene de genitales cada
                                                12 h y registro en la historia clinica.</td>
                                            <td id="tds" class="tds_istuTable"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">6. ¿Existe una indicacion para
                                                permanecer con sonda vesical?
                                            </td>
                                            <td id="tds" class="tds_istuTable"></td>
                                        </tr>
                                        <tr>
                                            <td class="left-align sub-header" id="rowISTU">Cumplimiento
                                            </td>
                                            <td id="tds" class="tds_istuTable"></td>
                                        </tr>
                                    </table>


                                </div>

                                <div class="tab-content">
                                    <div class="input-container-info">
                                        <label for="Observaciones">Observaciones:</label>
                                        <textarea class="form-control" rows="3" cols="500" id="Observaciones"
                                            name="Observaciones" placeholder="Observaciones"></textarea>
                                    </div>
                                </div>

                                <div class="button-container">
                                    <button id="guardaRegistroDefinitivo" name="guardaRegistro" class="btn"
                                        style="background-color: #428E3F; color:white; width:20%"
                                        onclick="guardarParcialEpid('registros','<?php echo $idusuario ?>')">
                                        <i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;Registrar datos
                                    </button>

                                </div>

				<div>
                                    <label for="buttom-search">Buscar:</label>
                                    <input type="text" placeholder="Buscar" id="buttom-search">
                                </div>

                                <div class="tab-x">
                                    <table class="table-responsive" id="registros" border="1" style="margin-top: 20px;">
                                        <thead>
                                            <tr>
                                                <th colspan="2" style="font-weight: bold;">Fecha</th>
                                                <th colspan="8" style="font-weight: bold; background-color:#eceef1;">Datos
                                                    Paciente</th>
                                                <th colspan="6" style="font-weight: bold;">Neumonia asociada al ventilador (NAV)
                                                </th>
                                                <th colspan="8" style="font-weight: bold; background-color:#eceef1;">Infeccion
                                                    torrente sanguineo asociado a cateter (ITS-AC )</th>
                                                <th colspan="7" style="font-weight: bold;">Infección urinaria asociada a sonda
                                                    vesical (ISTU-AC)</th>
                                                <th colspan="1" style="font-weight: bold; background-color:#eceef1;">
                                                    Observaciones</th>
                                                <th colspan="3" style="font-weight: bold; ">Estado</th>
                                                <th colspan="1" style="font-weight: bold; ">iD</th>
                                            </tr>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Hora</th>
                                                <th style="background-color:#eceef1;">Episodio</th>
                                                <th style="background-color:#eceef1;">Numero Documento</th>
                                                <th style="background-color:#eceef1;">Nombre</th>
                                                <th style="background-color:#eceef1;">Edad</th>
                                                <th style="background-color:#eceef1;">Genero</th>
                                                <th style="background-color:#eceef1;">Ubicacion</th>
                                                <th style="background-color:#eceef1;">Cama</th>
                                                <th style="background-color:#eceef1;">Entidad</th>
                                                <th>Evaluacion 1</th>
                                                <th>Evaluacion 2</th>
                                                <th>Evaluacion 3</th>
                                                <th>Evaluacion 4</th>
                                                <th>Evaluacion 5</th>
                                                <th>Cumplimiento</th>
                                                <th style="background-color:#eceef1;">Evaluacion 1</th>
                                                <th style="background-color:#eceef1;">Evaluacion 2</th>
                                                <th style="background-color:#eceef1;">Evaluacion 3</th>
                                                <th style="background-color:#eceef1;">Evaluacion 4</th>
                                                <th style="background-color:#eceef1;">Evaluacion 5</th>
                                                <th style="background-color:#eceef1;">Evaluacion 6</th>
                                                <th style="background-color:#eceef1;">Topicacion</th>
                                                <th style="background-color:#eceef1;">Cumplimiento</th>
                                                <th>Evaluacion 1</th>
                                                <th>Evaluacion 2</th>
                                                <th>Evaluacion 3</th>
                                                <th>Evaluacion 4</th>
                                                <th>Evaluacion 5</th>
                                                <th>Evaluacion 6</th>
                                                <th>Cumplimiento</th>
                                                <th style="background-color:#eceef1;">Observaciones</th>
                                                <th>Estado</th>
                                                <th>Editar</th>
                                                <th>Guardar</th>
                                                <th>id</th>

                                            </tr>
                                        </thead>
                                        <tbody id="table-body-main">
                                            <!-- Aquí se agregarán los registros -->
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>


            <script src="/SaludMod/Modulos/desarrollo_epidemiologia/control/JS/guardarEpidemiologa.js"></script>
            <script src="../control/JS/Reloj.js"></script>
            <script src="../control/JS/select_Cumplimiento.js"></script>
            <script src="../control/JS/controlIni.js"></script>
            <?php $idusuario = $_SESSION["idusuario"]; ?>
            <script>
                var nombreProfesional1 = "<?php echo $idusuario ?>";
                $(document).ready(function () {
                    const verificarEstadoBoton = () => {
                        const ventilacion = document.querySelector('input[name="ventilacion"]:checked');
                        const cvc = document.querySelector('input[name="cvc"]:checked');
                        const sonde = document.querySelector('input[name="sonda"]:checked');
                        const boton = document.getElementById('guardaRegistroDefinitivo');
                        if ((ventilacion && ventilacion.value === 'no') && (cvc && cvc.value === 'no') && (sonde && sonde.value === 'no')) {
                            boton.disabled = true;
                        } else {
                            boton.disabled = false;
                        }
                    };
                    verificarEstadoBoton();
                    $('input[name="ventilacion"], input[name="cvc"], input[name="sonda"]').on('change', function () {
                        verificarEstadoBoton();
                    });
                    llenarHistoricosEpidemiologa(nombreProfesional1);
                    $('#registros th:last-child, #registros td:last-child').hide();
                    $('#agregarLinea').on('keypress', function (e) {
                        if (e.which === 13) {
                            e.preventDefault();
                            
                        }
                    });
                });
                
            </script>
            <script src="../../../view/scripts/usuario.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    $(document).ready(async function(){
        let dato = await new Promise(resolve => {
            $.ajax({
                url: "./prueba.php",
                type: "POST",
                success: function(response){
                    response = JSON.parse(response)
                    console.log(response.DatosPaciente)
                }
            });
        })
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let idProfesional = "<?php echo $idusuario ?>";
        console.log("id: " + idProfesional);
        <?php
        $Medico = isset($_SESSION["CONTROLDATA"]) ? json_encode($_SESSION["CONTROLDATA"]) : "true";
        $DatosIncapacidad = isset($DatosIncapacidad) ? json_encode($DatosIncapacidad) : "null";
        ?>

        // Cargar las variables en JavaScript con los valores de PHP
        const params = new URLSearchParams(window.location.search);
        var Medico = <?php echo $Medico ?>;
        let DatosIncapacidad = <?php echo $DatosIncapacidad ?>;
        console.log("DatosIncapacidad:", DatosIncapacidad);
        console.log(DatosIncapacidad["NombreMedico"] + " " + DatosIncapacidad["Registro"]);

        $.ajax({
            type: "POST",
            url: 'http://localhost/SaludMod/Modulos/desarrollo_epidemiologia/logica/consultarPendientes.php',
            data: {
                idProfesional: idProfesional
            },
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    console.log("Hay registros en la respuesta");

                    
                } else {
                    console.log("No hay registros en la respuesta");
                    // Aqu� puedes manejar el caso en que no hay datos
                    if (DatosIncapacidad["NombreMedico"] == "" && DatosIncapacidad["Registro"] == "" && DatosIncapacidad["IDNumberPaciente"] == "") {
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
                                title: 'custom-swal-Incapacidad-Tittle',
                                popup: 'custom-swal-Incapacidad-popup',
                                content: 'custom-swal-Incapacidad-Content',
                                confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'descargarHistorico.php';
                            } else {
                                window.close();
                            }
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", error);
            }
        });
 
    });
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