<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

session_start();

foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
}

if (!isset($_SESSION["nombre"])) {

    $_SESSION["PrePage"] = "../Modulos/Implantes/view/registros.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Formularios Terminados";
    $_SESSION['module_title'] = "FORMULARIOS TERMINADOS";


    require_once '../../../view/template/header.php';

    if ($_SESSION['historico implantes'] == 1) {

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>


        <div class="content-wrapper">
            <div id="alertContainer" class="alert" role="alert">
            </div>
            <!--- Content Header (Page header) ----->
            <div class="container" style="overflow-y: hidden">
                <div class="col-md-15">
                    <div class="card shadow p-3 mb-8">
                        <div class="card-header">

                            <br>
                            <h4 class="form-label text-divider-r"><span class="left-span"></span><span class="span">VER LOS FORMULARIOS</span></h4>
                            <br>
                            <!-- Campo de búsqueda -->                            
                            <div class="form-group">
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-2">
                                    <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                                    <input type="date" id="fechaInicio" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label for="fechaFin" class="form-label">Fecha de Fin:</label>
                                    <input type="date" id="fechaFin" class="form-control" >
                                </div>
                                <div class="col-md-6">
                                    <input type="text" id="buscarCampo" class="form-control" placeholder="Buscar por número de documento o episodio">
                                </div>
                                <div class="col-md-2 text-center">
                                    <a href="#" class="btn btn-outline-success" onclick="exportarExcel()" style="width: 100px; height: 60px; display: inline-flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <span>Excel</span>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>

                            </div>
                            <br>
                            <div class="table-responsive"> <!-- Asegúrate de que este div contenga la tabla -->
                                <table class="table" id="tablaFormularios" hidden>
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center bg-success" scope="col">Fecha de la cirugia</th>
                                            <th class="text-center bg-success" scope="col">Numero episodio</th>
                                            <th class="text-center bg-success" scope="col">Numero documento</th>
                                            <th class="text-center bg-success" scope="col">Nombre del paciente</th>
                                            <th class="text-center bg-success" scope="col">Aseguradora</th>
                                            <th class="text-center bg-success" scope="col">Nombre del cirujano</th>
                                            <th class="text-center bg-success" scope="col">Especialidad</th>                                            
                                            <th class="text-center bg-success" scope="col">Observaciones</th>
                                            <th class="text-center bg-success" scope="col">Diagnostico</th>
                                            <th class="text-center bg-success" scope="col">Casa Comercial</th>
                                            <th class="text-center bg-success" scope="col">Tipo implante</th>
                                            <th class="text-center bg-success" scope="col">Entrenamiento del soporte</th>
                                            <th class="text-center bg-success" scope="col">Llega a tiempo Soporte</th>
                                            <th class="text-center bg-success" scope="col">Material Completo</th>
                                            <th class="text-center bg-success" scope="col">Falla de implante en cx</th>
                                            <th class="text-center bg-success" scope="col">Implante llega a tiempo</th>
                                            <th class="text-center bg-success" scope="col">Implante llega completo</th>
                                        </tr> 
                                    </thead>
                                    <tbody id="registroTablaBody" style="font-family: Arial, sans-serif; font-size: 12px; background-color: #dedede;">
                                        <!-- Aquí se agregarán las filas dinámicamente -->
                                    </tbody>
                                </table>
                            </div>

                            
                        </div>
                    </div>
                    <br>
                    <br>

                    
                </div>
                <br>
                <br>
            </div>

        </div>


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
<!-- <script src="../control/JS/terminadosForm.js"></script> -->
<script src="../control/JS/consultaTerminado.js"></script>
<script src="../control/JS/consultaTerminadoFecha.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
