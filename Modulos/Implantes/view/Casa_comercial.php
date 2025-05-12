<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();

// Configuración de la base de datos
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_implantes";

// $conexion2 = new mysqli($servername, $username, $password, $dbname);

// // Verificar la conexión
// if ($conexion2->connect_error) {
//     die("Conexión fallida: " . $conexion2->connect_error);
// }
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
}


// Guardar parámetros GET en la sesión
foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/Implantes/View/Casa_comercial.php";
    header("Location: ../../../view/login.php");
    exit();
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Casa Comercial";

    require_once '../../../view/template/header.php';

    if ($_SESSION['implantes'] == 1) {
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

        <div class="content-wrapper">
            <div id="alertContainer" class="alert" role="alert"></div>
            <!-- Content Header (Page header) -->
            <div class="container" style="overflow-y: hidden">
                <div class="col-md-15">
                    <div class="card shadow p-3 mb-8">
                        <div class="card-header">
                                                        <br><br>
                            <h4 class="form-label text-divider-r"><span class="left-span"></span><span class="span">Gestion de Casas comerciales</span></h4>
                            <br>
                            <div class="row" style="margin-bottom: 20px">
                                <!-- <label>CASAS COMERCIALES:</label> -->
                                <br>
                                <br>
                                <div class="col-md-4" style="text-align: center;">
                                    <button type="button" class="btn btn-success" id="agregarCasaBtn"><i class="fas fa-plus icon-add"></i> Agregar Casa </button>
                                </div>
                                <div class="col-md-4" style="text-align: center;">
                                    <button type="button" class="btn btn-danger" id="inhabilitarCasaBtn"><i class="fas fa-minus icon-remove"></i> Inhabilitar Casa </button>
                                </div>
                                <div class="col-md-4" style="text-align: center;">
                                    <button type="button" class="btn btn-primary" id="habilitarCasaBtn"><i class="fas fa-check-circle icon-enable"></i> Habilitar Casa </button> 
                                </div> 
                            </div>
                            <br>
                            <br>
                            <br>
                            
                            
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <?php
    } else {
        require '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';
}
ob_end_flush();
?>
<script src="../control/JS/manejo_casa.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
