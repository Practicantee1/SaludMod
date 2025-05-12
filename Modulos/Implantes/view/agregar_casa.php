<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();

// // Configuración de la base de datos
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
    $_SESSION["PrePage"] = "../Modulos/Implantes/View/agregar_casa.php";
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
                            <h4 class="form-label text-divider-r"><span class="left-span"></span><span class="span">Agregar de Casas comerciales</span></h4>
                            
                            <br>
                            <!-- Campo de búsqueda -->
                            <div class="row" style="margin-bottom: 20px">
                                
                                <div class="col-md-8">
                                    <label>Agregar Casa Comercial</label>
                                    <input type="text" class="form-control" id="agregar_casa" style="width: 100%; height: 50%;" name="infTipoImplante" required>
                                </div>
                                 
                                <div class="col-md-4" style="text-align: center;">
                                    <br>
                                    <button type="button" class="btn btn-primary" id="guardarbtn">
                                        <i class="fas fa-save icon-save"></i> GUARDAR
                                    </button>
                                </div>
                                
                            </div>
                            <br><br>
                            
                            
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
