<?php

include('../../../config/Conexion.php');
ob_start();

session_start();


if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/Rehabilitacion_intestinal/view/ayudasDiagnosticas.php";
    header("Location: ../../../view/login.php" . "?" . $parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Ayudas diagnosticas";

    $_SESSION['module_title'] = "Ayudas diagnosticas";
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
            <title>Ayudas diagnosticas</title>
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Rehabilitacion_intestinal/view/css/historia.css">
        </head>

        <body>
            <div class="content-wrapper">
                <div id="alertContainer" class="alert" role="alert"></div>
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card shadow p-2 mb-8">
                            <div class="card-header">
                                <form id="agregarLinea" method="POST" action="ayudasDiagnosticas.php" hidden>
                                    <div class="row">
                                        <div class="form-group col-md-3" >
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
                                                value="<?php echo isset($DatosIncapacidad['IDNumberPaciente']) && !empty($DatosIncapacidad['IDNumberPaciente']) ? $DatosIncapacidad['IDNumberPaciente'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <center><label for -="nombre">Nombre paciente:</label></center>
                                            <input type="text" id="nombre" name="nombre" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NombreApellido']) && !empty($DatosIncapacidad['NombreApellido']) ? $DatosIncapacidad['NombreApellido'] : ''; ?>">
                                        </div>

                                    </div>

                                    <div class="row" >
                                        <div class="form-group col-md-2">
                                            <center><label for="edad">Edad:</label></center>
                                            <input type="text" id="edad" name="edad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Edad']) && !empty($DatosIncapacidad['Edad']) ? $DatosIncapacidad['Edad'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="sexo">Genero:</label></center>
                                            <input type="text" id="sexo" name="sexo" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Sexo']) && !empty($DatosIncapacidad['Sexo']) ? $DatosIncapacidad['Sexo'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <center><label for="ubicacion">Ubicacion:</label></center>
                                            <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                                                value="<?php echo isset($UbicacionPaciente["UbicacionEdificio"]) && !empty($UbicacionPaciente["UbicacionEdificio"]) ? $UbicacionPaciente["UbicacionEdificio"] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <center><label for="cama">Cama:</label></center>
                                            <input type="text" id="cama" name="cama" class="form-control"
                                                value="<?php echo isset($UbicacionPaciente["IdUbicacion_cama"]) && !empty($UbicacionPaciente["IdUbicacion_cama"]) ? $UbicacionPaciente["IdUbicacion_cama"] : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="row" >
                                        <div class="form-group col-md-6">
                                            <center><label for="entidad">Aseguradora:</label></center>
                                            <input type="text" id="entidad" name="entidad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NomEntidad']) && !empty($DatosIncapacidad['NomEntidad']) ? $DatosIncapacidad['NomEntidad'] : ''; ?>">
                                        </div>

                                    
                                    </div>
                                    <div class="row" >
                                        <div class="form-group col-md-4">
                                            <center><label for="especialidad">Especialidad:</label></center>
                                            <input type="text" id="especialidad" name="especialidad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Especialidad']) && !empty($DatosIncapacidad['Especialidad']) ? $DatosIncapacidad['Especialidad'] : ''; ?>">
                                        </div>

                                        <div class="form-group col-md-8">
                                            <center><label for -="nombre">Nombre medico:</label></center>
                                            <input type="text" id="nombreMed" name="nombreMed" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NombreMedico']) && !empty($DatosIncapacidad['NombreMedico']) ? $DatosIncapacidad['NombreMedico'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-1" hidden>
                                            <center><label style="color:black" for="centrosanitario" class="form-label">centrosanitario:</label></center>
                                            <input type="text" class="form-control" id="centrosanitario" name="centrosanitario" value="<?php echo isset($DatosIncapacidad['CentroSanitario']) && !empty($DatosIncapacidad['CentroSanitario']) ?$DatosIncapacidad['CentroSanitario']:''; ?>">
                                        </div>

                                    </div>
                                    <!-- <div class="row">
                                        <div class="form-group col-md-4">
                                            <center><label for="cedula">Identificacion medico:</label></center>
                                            <input type="number" id="cedula" name="cedula" class="form-control">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <center><label for -="registro">Registro:</label></center>
                                            <input type="text" id="registro" name="registro" class="form-control">
                                        </div>

                                    </div> -->
                                </form>
                                <!-- datos del paciente -->

                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span
                                                    class="left-span"></span><span class="span">Imágenes</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <label style="color:black" for="fecha" class="form-label">Fecha:</label>
                                        </center>
                                        <input type="date" class="form-control" id="fecha" name="fecha">
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <label style="color:black" for="tipoEstudio" class="form-label">Tipo
                                            estudio:</label></center>
                                        <select class="form-control" id="tipoEstudio" name="tipoEstudio"
                                            onchange="toggleOtherInput()">
                                            <option value="" disabled selected hidden></option>
                                            <option value="Tránsito intestinal">Tránsito intestinal</option>
                                            <option value="Colon por enema">Colon por enema</option>
                                            <option value="TAC de abdomen contrastado">TAC de abdomen contrastado</option>
                                            <option value="Radiografía de vías digestivas">Radiografía de vías digestivas
                                            </option>
                                            <option value="Radiografía de abdomen">Radiografía de abdomen</option>
                                            <option value="Ecografía Abdominal">Ecografía Abdominal</option>
                                            <option value="Otros">Otros</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-12" id="otherFieldContainer" style="display: none;">
                                        <label style="color:black" for="otherInput" class="form-label">Especificar otro
                                            estudio:</label></center>
                                        <input type="text" class="form-control" id="otherInput" name="otherInput">
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12 col-12">
                                        <label style="color:black margin-top:20px;" for="conclusion"
                                            class="form-label">Conclusión:</label>
                                        <textarea class="form-control" id="conclusionImagenes" name="conclusion"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                                <br>
                                <!-- <button id="guardarBtn" name="guardaRegistro" class="btn waves-effect waves-light"
                                    style="background-color: #428E3F; color:white; display: block; margin: 0 auto;"
                                    onclick="guardarImagenes('tablaImagenes')">
                                    <i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;Registrar datos
                                </button> -->


                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span
                                                    class="left-span"></span><span class="span">Estudios endoscópicos</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-12">
                                        <label style="color:black" for="fecha2" class="form-label">Fecha:</label>
                                        </center>
                                        <input type="date" class="form-control" id="fecha2" name="fecha">
                                    </div>
                                    <div class="col-md-3">
                                        <label style="color:black" for="tipoEstudio" class="form-label">Tipo
                                            estudio:</label></center>
                                        <select id="estudioEndoscopicos" class="form-control">
                                            <option value="" disabled selected hidden></option>
                                            <option value="esofagogastroduodenoscopia">Esofagogastroduodenoscopia</option>
                                            <option value="colonoscopia">Colonoscopia</option>
                                            <option value="gastrostomia">Gastrostomia percutánea</option>
                                            <option value="insercion">Insercion de SNY</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12 col-12" style="margin-top: 20px;">
                                        <label style="color:black" for="conclusion" class="form-label">Conclusión:</label>
                                        <textarea class="form-control" id="conclusionEstudios" name="conclusion"
                                            rows="4"></textarea>
                                    </div>
                                </div>
                                <br>
                                <button id="guardarBtn" name="guardaRegistro" class="btn waves-effect waves-light"
                                    style="background-color: #428E3F; color:white; display: block; margin: 0 auto;"
                                    onclick="guardarRegistro()">
                                    <i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;Registrar datos
                                </button>
                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span
                                                    class="left-span"></span><span class="span">Historico</span></h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-container">
                                    <div class="tab active" onclick="openTab(event, 'tabImagenes')">Tabla de Imágenes</div>
                                    <div class="tab" onclick="openTab(event, 'tabEstudiosEndoscopicos')">Tabla de Estudios
                                        Endoscópicos</div>
                                </div>

                                <div id="tabImagenes" class="tab-content active">
                                    <table id="tablaImagenes">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo estudio</th>
                                            <th>Otro estudio</th>
                                            <th>Conclusión</th>
                                        </tr>
                                        <!-- Filas de datos -->
                                    </table>
                                </div>

                                <div id="tabEstudiosEndoscopicos" class="tab-content">
                                    <table id="tablaEstudiosEndoscopicos">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Tipo estudio</th>
                                            <th>Conclusión</th>
                                        </tr>
                                        <!-- Filas de datos -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- <script src="../control/JS/Reloj.js"></script> -->
            <script src="../Control/JS/controlApi.js"></script>
            <script src="../Control/JS/ayudas.js"></script>
            <script>

                function toggleOtherInput() {
                    var tipoEstudio = document.getElementById("tipoEstudio").value;
                    var otherFieldContainer = document.getElementById("otherFieldContainer");

                    if (tipoEstudio === "Otros") {
                        otherFieldContainer.style.display = "block";
                    } else {
                        otherFieldContainer.style.display = "none";
                    }
                }
                function openTab(event, tabId) {
                    // Ocultar todo el contenido de las tabs
                    const tabContents = document.querySelectorAll('.tab-content');
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Remover la clase 'active' de todas las tabs
                    const tabs = document.querySelectorAll('.tab');
                    tabs.forEach(tab => tab.classList.remove('active'));

                    // Mostrar el contenido de la tab actual y añadir 'active' a la tab
                    document.getElementById(tabId).classList.add('active');
                    event.currentTarget.classList.add('active');
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