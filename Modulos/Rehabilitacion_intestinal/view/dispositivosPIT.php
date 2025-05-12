<?php

include('../../../config/Conexion.php');
ob_start();
session_start();


if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/Rehabilitacion_intestinal/view/dispositivosPIT.php";
    header("Location: ../../../view/login.php". "?" . $parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Accesos vasculares";

    $_SESSION['module_title'] = "Accesos vasculares";
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
    <title>Dispositivos PIT</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Rehabilitacion_intestinal/view/css/historia.css">
</head>
<body>
<div class="content-wrapper">
        <div id="alertContainer" class="alert" role="alert"></div>
        <div class="container-fluid">
            <div class="col-md-12"  >
                <div class="card shadow p-2 mb-8">
                <div class="card-header">
                    <!-- datos del paciente -->
                    
                    <div class="row titles-UbiCita">
                        <div class="col">
                        <div class="well">
                            <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">Informacion</span></h4>
                        </div>
                        </div>
                    </div>
                    
                    <table id="tablaPIT">
                        <tr>
                            <th>Fecha</th>
                            <th>Ubicación del dispositivo</th>
                            <th>Dispositivos</th>
                        </tr>
                    </table>
                  
                </div>
            </div>
        </div>
    </div>            
    </div>
    
    
    <script src="../control/JS/Reloj.js"></script>
    <script src="../Control/JS/controlApi.js"></script>

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

