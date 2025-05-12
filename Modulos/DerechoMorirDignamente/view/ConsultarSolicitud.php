<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/odontograma/odontograma.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Derecho a Morir Dignamente";
    $_SESSION['module_title'] = "CONSULTA DE SOLICITUDES";
    require_once '../../../view/template/header.php';

if ($_SESSION['ConsultarSolicitud_DMD']==1)
{
 
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilosDMD.css">
    <link rel="stylesheet" href="CSS/Consultar.css">
 </head>
 <body>
 <div class="content-wrapper">
    <div id="alertContainer" class="alert" role="alert">
    </div>
    <div class="container">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8" >
                <div class="card-header">
                        
                        <div class="row titles">
                            <div class="col">
                                <div class="well" style="margin-bottom:10px">
                                    <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span  class="span">CONSULTAR</span></h4>
                                </div>
                                <div class="div-documento">
                                    <label class="lb" for="idDocumento">Consulta por Documento</label>
                                    <input id="idDocumento" type="text">
                                    <button id="btn-Consultar">Consultar</button>
                                    <iframe id="iframePDF" style="display:none;"></iframe>
                                </div>
                                <div class="div-tablaDMD">
                                    <table id="tbl_DMD" hidden>
                                        <th>PDF</th>
                                        <th>Nombre del Paciente</th>
                                        <th>Cedula del Paciente</th>
                                        <th>Nombre del Medico</th>
                                        <th>Especialidad del Medico</th>
                                        <th>Fecha de solicitud</th>
                                        <th>Observaciones</th>
                                        <tbody id="tbl_DMD_tbody">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../control/JS/consultarSolicitudes.js"></script>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</html>
<?php
}
else
{
  require_once '../../../view/noacceso.php';
}

require_once '../../../view/template/footer.php';
?>


<?php 
}
ob_end_flush();
?>

