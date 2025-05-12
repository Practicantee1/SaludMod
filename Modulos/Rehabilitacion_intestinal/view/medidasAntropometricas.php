<?php

include('../../../config/Conexion.php');
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/Rehabilitacion_intestinal/view/medidasAntropometricas.php";
    header("Location: ../../../view/login.php" . "?" . $parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Medidas antropometricas";

    $_SESSION['module_title'] = "Medidas antropometricas";
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
            <title>Medidas antropometricas</title>
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Rehabilitacion_intestinal/view/css/historia.css">
        </head>

        <body>
            <div class="content-wrapper">
                <div id="alertContainer" class="alert" role="alert"></div>
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card shadow p-2 mb-8">
                            <div class="card-header">

                                <form id="agregarLinea" method="POST" action="medidasAntropometricas.php" hidden>
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
                                        <div class="form-group col-md-3" style="display:none;">
                                            <center><label for="nroDoc">Numero de documento:</label></center>
                                            <input type="text" id="nroDoc" name="nroDoc" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['IDNumberPaciente']) && !empty($DatosIncapacidad['IDNumberPaciente']) ? $DatosIncapacidad['IDNumberPaciente'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-6" style="display:none;">
                                            <center><label for -="nombre">Nombre paciente:</label></center>
                                            <input type="text" id="nombre" name="nombre" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['NombreApellido']) && !empty($DatosIncapacidad['NombreApellido']) ? $DatosIncapacidad['NombreApellido'] : ''; ?>">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <center><label for="edad">Edad:</label></center>
                                            <input type="text" id="edad" name="edad" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Edad']) && !empty($DatosIncapacidad['Edad']) ? $DatosIncapacidad['Edad'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-3" style="display:none;">
                                            <center><label for="sexo">Genero:</label></center>
                                            <input type="text" id="sexo" name="sexo" class="form-control"
                                                value="<?php echo isset($DatosIncapacidad['Sexo']) && !empty($DatosIncapacidad['Sexo']) ? $DatosIncapacidad['Sexo'] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-4" style="display:none;">
                                            <center><label for="ubicacion">Ubicacion:</label></center>
                                            <input type="text" id="ubicacion" name="ubicacion" class="form-control"
                                                value="<?php echo isset($UbicacionPaciente["UbicacionEdificio"]) && !empty($UbicacionPaciente["UbicacionEdificio"]) ? $UbicacionPaciente["UbicacionEdificio"] : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-3" style="display:none;">
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

                                <!-- tabla de informacion -->
                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span
                                                    class="span">Medidas Antropometricas</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Peso -->
                                    <div class="form-group col-md-3">
                                        <center><label for="peso">Peso:</label></center>
                                        <input type="text" id="peso" name="peso" class="form-control">
                                    </div>

                                    <!-- Talla -->
                                    <div class="form-group col-md-3">
                                        <center><label for="talla">Talla:</label></center>
                                        <input type="text" id="talla" name="talla" class="form-control">
                                    </div>

                                    <!-- SCT -->
                                    <div class="form-group col-md-3">
                                        <center><label for="sct">SCT:</label></center>
                                        <input type="text" id="sct" name="sct" class="form-control">
                                    </div>

                                    <!-- Talla para la Edad -->
                                    <div class="form-group col-md-3">
                                        <center><label for="tallaEdad">Talla para la edad:</label></center>
                                        <input type="text" id="tallaEdad" name="tallaEdad" class="form-control">
                                    </div>
                                </div>

                                <!-- Segunda fila de campos adicionales -->
                                <div class="row" id="pesoImcContainer">
                                    <!-- Peso para la Edad -->
                                    <div class="form-group col-md-3 offset-md-3" id="pesoEdadContainer" style="display: none;">
                                        <center><label for="pesoEdad">Peso para la edad:</label></center>
                                        <input type="text" id="pesoEdad" name="pesoEdad" class="form-control">
                                    </div>

                                    <!-- Peso para la Talla -->
                                    <div class="form-group col-md-3" id="pesoTallaContainer" style="display: none;">
                                        <center><label for="pesoTalla">Peso para la talla:</label></center>
                                        <input type="text" id="pesoTalla" name="pesoTalla" class="form-control">
                                    </div>
                                    <!-- IMC -->
                                    <div class="form-group col-md-3 offset-md-3" id="imcContainer" style="display: none;">
                                        <center><label for="imc">IMC:</label></center>
                                        <input type="text" id="imc" name="imc" class="form-control">
                                    </div>

                                </div>
                                <button id="guardarBtn" name="guardaRegistro" class="btn waves-effect waves-light"
                                    style="background-color: #428E3F; color:white; display: block; margin: 0 auto;"
                                    onclick="guardarDefinitivo('tablaMedidas')">
                                    <i class="fa-regular fa-floppy-disk"></i>&nbsp;&nbsp;Registrar datos
                                </button>
                                <div class="row titles-UbiCita">
                                    <div class="col">
                                        <div class="well">
                                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span
                                                    class="span">Historico</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <table id="tablaMedidas">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Peso</th>
                                        <th>Talla</th>
                                        <th>SCT</th>
                                        <th>Talla para la edad</th>
                                        <th id="pesoParaTallaHeader" style="display: none;">Peso para la talla</th>
                                        <th id="pesoParaEdadHeader" style="display: none;">Peso para la edad</th>
                                        <th id="imcHeader" style="display: none;">IMC</th>
                                    </tr>
                                    <!-- Filas de datos -->
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>


            <script src="../control/JS/Reloj.js"></script>
            <script src="../Control/JS/controlApi.js"></script>
            <script src="../Control/JS/medidas.js"></script>
<script>
    
    // $(document).ready(function() {
        
    //     $('#episodio').change(function() {
    //         episodio = document.getElementById("episodio").value || "N/A";  
    //         llenarHistoricoMedidas(episodio); 
    //     });

    //     $('#episodio').trigger('change');
    // });
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