<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

session_start();

foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
}

if (!isset($_SESSION["nombre"])) {

    $_SESSION["PrePage"] = "../Modulos/Cirugia_RH/view/cirugia.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Formularios Terminados";

    require_once '../../../view/template/header.php';

    if ($_SESSION['consultar_procedimiento'] == 1) {

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<link rel="stylesheet" href="http://vmsrv-web2.hospital.com/SaludMod/Modulos/Cirugia_RH/view/CSS/terminados.css?v=<?php echo time(); ?>">


        <div class="content-wrapper">
            <div id="alertContainer" class="alert" role="alert">
            </div>
            <!--- Content Header (Page header) ----->
            <div class="container" style="overflow-y: hidden">
                <div class="col-md-15">
                    <div class="card shadow p-3 mb-8">
                        <div class="card-header">
                            <div class="row" id="MainTittle-UbiCitas">
                                <div class="col-20 text-center" style="top: -15px;">
                                    <h2 class="text-success" style="margin-top: 15px;">Formularios terminados de cirugía</h2>
                                </div>                 
                            </div>
                            <br>
                            <br>
                            <h4 class="form-label text-divider-r"><span class="left-span"></span><span>VER LOS FORMULARIOS COMPLETADOS</span></h4>
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
                                        <tr style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">
                                            <th class="text-center bg-success">Fecha </th>
                                            <th class="text-center bg-success">Número episodio</th>
                                            <th class="text-center bg-success">Número documento</th>
                                            <th class="text-center bg-success">Nombre del paciente</th>
                                            <th class="text-center bg-success">Edad</th>
                                            <th class="text-center bg-success">Sexo</th>
                                            <th class="text-center bg-success">Aseguradora</th>
                                            <th class="text-center bg-success">Procedimiento</th>
                                            <th class="text-center bg-success">Nombre del responsble</th>
                                            <th class="text-center bg-success">Cargo del responsble</th>
                                            <th class="text-center bg-success">Nombre identificación</th>
                                            <th class="text-center bg-success">Consetimiento quirúrgico completo y firmado</th>
                                            <th class="text-center bg-success">Alergia reporta</th>
                                            <th class="text-center bg-success">Consentimiento de anestesia completo y firmado</th>
                                            <th class="text-center bg-success">Marcación del sitio de la cirugia con SI</th>
                                            <th class="text-center bg-success">Seleccione el lugar de la Marcacion</th>
                                            <th class="text-center bg-success">Verificación del funcionamiento de maquinas de anestesia y medicamento por anestesiologo, se diligencio codigo QR</th>
                                            <th class="text-center bg-success">Confirmación de intrumental, implantes, insumos y equipos</th>
                                            <th class="text-center bg-success">Monitoreo en funcionamiento</th>
                                            <th class="text-center bg-success">Perdida de sangre >500ml(ninos 7ml/kg)</th>
                                            <th class="text-center bg-success">Reserva de hemocomponentes</th>
                                            <th class="text-center bg-success">Disponibilidad de hemocomponentes en sala</th>
                                            <th class="text-center bg-success">Estudios diagnosticos disponibles carasteristicas revisada</th>
                                            <th class="text-center bg-success">Via area dificil gestionado</th>
                                            <th class="text-center bg-success">Antibiotico profilactico definido</th>
                                            <th class="text-center bg-success">Suspension de anticoagular y/o antiagregantes plaquetarios</th>
                                            <th class="text-center bg-success">La casa comercial de Vo.Bo para iniciar el procedimiento</th>
                                            <th class="text-center bg-success">Se necesita cultivos</th>
                                            <th class="text-center bg-success">Se necesita patologias</th>
                                            <th class="text-center bg-success">Observaciones Entrada</th>
                                            <th class="text-center bg-success">Equipo humano completo</th>
                                            <th class="text-center bg-success">Paciente, abordaje y procedimiento</th>
                                            <th class="text-center bg-success">Existen riesgo adicionales</th>
                                            <th class="text-center bg-success">Administracion antibioticos en el tiempo correcto</th>
                                            <th class="text-center bg-success">Plan para repetir dosis de antibiotico durante el procedimiento</th>
                                            <th class="text-center bg-success">El anestesiologo da Vo. Bo para iniciar el procedimiento quirurgico</th>
                                            <th class="text-center bg-success">Confirmación de esterilidad</th>
                                            <th class="text-center bg-success">La instrumentadora Vo. Bo para iniciar el procedimiento quirurgico</th>
                                            <th class="text-center bg-success">Detalles relevantes respecto a la canulacion</th>
                                            <th class="text-center bg-success">Se definio a que T llevar al paciente</th>
                                            <th class="text-center bg-success">Necesidad de perfusión selectiva y/o enfriamiento cerebral con hielo</th>
                                            <th class="text-center bg-success">Observaciones Pausa</th>
                                            <th class="text-center bg-success">La cirugia realizada fue la programada</th>
                                            <th class="text-center bg-success">Se presento complicaciones</th>
                                            <th class="text-center bg-success">Conteo completo: cortante, agujas, algodones, cotonoides, gasas, compresas, instrumental</th>
                                            <th class="text-center bg-success">Camilla con barandas para el despertar del paciente</th>
                                            <th class="text-center bg-success">Muestra para laboratorio y/o patologia marcadas, rotuladas y orientas</th>
                                            <th class="text-center bg-success">Plan posopetario definido</th>
                                            <th class="text-center bg-success">Se presentaron problemas con los equipos que haya que resolver</th>
                                            <th class="text-center bg-success">Observaciones Salida</th>
                                            
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
