<?php

// Activamos el almacenamiento en el buffer
ob_start();

// Iniciar sesión
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../../Encuesta/view/form_encuestas.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Descargar historico";
    
    $_SESSION['module_title'] = "DESCARGAR HISTORICO";
    require_once '../../../view/template/header.php';

    if ($_SESSION['bundlesHistorico'] == 1) {
        $idusuario = $_SESSION["idusuario"];

        ?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/desarrollo_epidemiologia/view/CSS/estilos.css">
            <title>Prevenir Infecciones Asociadas a Dispositivos Invasivos (BUNDLES)</title>
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
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
                                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span class="span">Ver
                                                    historial</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <!-- Botones de filtro -->
                                <div class="row mb-3">
                                    <div class="col-md-3 text-center">
                                        <button class="btn btn-outline-success" onclick="mostrarFiltroFecha()">Filtrar por
                                            Fechas</button>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <button class="btn btn-outline-success" onclick="mostrarFiltroEpisodio()">Filtrar por
                                            Episodio</button>
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <button class="btn btn-outline-success" onclick="mostrarFiltroIdentificacion()">Filtrar
                                            por Identificación</button>
                                    </div>
                                    <?php
                                    if ($_SESSION['bundlesEpidemiologa'] == 1) {
                                        ?>
                                        <div class="col-md-3 text-center">
                                            <button class="btn btn-outline-success"
                                                onclick="mostrarFiltroUsuario(),mostrarTablaUsuario('<?php echo $idusuario ?>')">Filtrar
                                                por Usuario</button>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <!-- Filtros dinámicos -->
                                <div id="fechaFiltro" class="filtro" style="display:none;">
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-4">
                                            <label for="fechaInicio" class="form-label">Fecha de Inicio:</label>
                                            <input type="date" id="fechaInicio" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="fechaFin" class="form-label">Fecha de Fin:</label>
                                            <input type="date" id="fechaFin" class="form-control">
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <button class="btn btn-success" onclick="mostrarTablaFecha()">Mostrar Tabla</button>
                                        </div>
                                        <div class="col-md-2 text-center" id="botonExcel" style="display:none;">
                                            <button class="btn btn-success" onclick="descargarExcel()" style="width: 150px;">
                                                Descargar Excel <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="episodioFiltro" class="filtro" style="display:none;">
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-6">
                                            <label for="episodio" class="form-label">Número de Episodio:</label>
                                            <input type="text" id="episodio" class="form-control"
                                                placeholder="Buscar por número de episodio">
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <button class="btn btn-success" onclick="mostrarTablaEpisodio()">Mostrar
                                                Tabla</button>
                                        </div>
                                        <div class="col-md-3 text-center" id="botonExcel3" style="display:none;">
                                            <button class="btn btn-success" onclick="descargarExcel()" style="width: 150px;">
                                                Descargar Excel <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="identificacionFiltro" class="filtro" style="display:none;">
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-6">
                                            <label for="identificacion" class="form-label">Número de Identificación:</label>
                                            <input type="text" id="identificacion" class="form-control"
                                                placeholder="Buscar por identificación del paciente">
                                        </div>
                                        <div class="col-md-3 text-center">
                                            <button class="btn btn-success" onclick="mostrarTablaIdentificacion()">Mostrar
                                                Tabla</button>
                                        </div>
                                        <div class="col-md-3 text-center" id="botonExcel2" style="display:none;">
                                            <button class="btn btn-success" onclick="descargarExcel()" style="width: 150px;">
                                                Descargar Excel <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div id="usuarioFiltro" class="filtro" style="display:none;">
                                    <div class="row mb-3 align-items-end">
                                        <div class="col-md-3 text-center" id="botonExcel4" style="display:none;">
                                            <button class="btn btn-success" onclick="descargarExcel()" style="width: 150px;">
                                                Descargar Excel <i class="fas fa-download"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <br>

                                <!-- Tabla de resultados -->
                                <div class="tab-x">
                                    <table class="table-responsive" id="tablaFormularios" border="1" style="margin-top: 20px;"
                                        hidden>
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


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Aquí se agregarán los registros -->
                                        </tbody>
                                    </table>



                                </div>
                            </div>
                        </div>
                    </div>


                    <script src="/SaludMod/Modulos/desarrollo_epidemiologia/control/JS/excel.js"></script>



                    <?php
    } else {
        require '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';
}
ob_end_flush();
?>

</html>