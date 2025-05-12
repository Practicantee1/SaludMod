<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');

ob_start();
session_start();

$parameters = http_build_query($_GET); 

if (!isset($_SESSION["nombre"]) ){
    $_SESSION["PrePage"] = "../Modulos/Nutricion_Adultos?CH=1";
    header("Location: ../../../view/login.php"."?".$parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Nutricion Adultos";

    $_SESSION['module_title'] = "NUTRICION ADULTOS";
    require_once '../../../view/template/header.php';

if ($_SESSION['ingreso_nutricion']==1)
{
    // if (isset($_GET["param"]) && $_GET["param"] !== "") {
    //     $_SESSION["param"] = $_GET["param"];
    // }
    
    require '../../../logica/ApiURL.php';
    
    // $_SESSION["param"] = "";

   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/indicaciones.css">
    </head>
    <body>
        <div class="content-wrapper">
            <div class="container" >
                <div class="col-md-15" id="ingreso1-session1">
                    <div class="card shadow p-3 mb-8" style="margin-top: 100px; padding: 0 !important;">
                        <div class="card-header" style="padding: 0;">
                            <div class="well" style="margin:0; height: 20%;">
                                <h4 style="margin:0; color:#066E45;">Datos Demograficos <i id="ocultar" class="fa-solid fa-angle-down"></i></h4>
                            </div>
                            <div id="DatosPaciente" class="flex">
                                <div class="grid-row">
                                    <div class="div-input">
                                        <input readonly value="Juan Pablo Vasquez" id="idNombrePaciente" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input">
                                        <input readonly value="Masculino" id="idGenero" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input">
                                        <input readonly value="21" id="idEdad" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input" >
                                        <input readonly value="03/09/2003" id="idFNacimiento" class="clsInputDemograficos" type="text">
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <div class="div-input">
                                        <input readonly value="321564" id="idEpisodio" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input">
                                        <input readonly value="1000874044" id="idCedula" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input">
                                        <input readonly value="21092" id="idNumPaciente" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div></div>
                                </div>
                                <div class="grid-row" style="padding-bottom:5px;">
                                    <div class="div-input">
                                        <input readonly value="Sala1" id="idSala" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input">
                                        <input readonly value="Cama 12" id="idCama" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div class="div-input">
                                        <input readonly value="Sura" id="idAseguradora" class="clsInputDemograficos" type="text">
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow p-3 mb-8" id="evaluacion" style="margin-top: 40px;">
                    <div class="card-header">
                        <div class="header-container">
                            <div class="section-title left">
                                <span class="line"></span>
                                <h3 class="text">SOPORTE NUTRICIONAL</h>
                            </div>
                        </div>
                        <div>
                            <div>
                                <div>
                                    <table class="tbl-Seguimiento" id="tblSoporteNutricional">
                                        <thead>
                                            <th></th>
                                            <th>Tipo</th>
                                            <th>Indicacion</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="div-tbl">
                                                        <input type="checkbox">
                                                        <label>Nada via oral</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idNadaViaOralTipo" type="text">
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idNadaViaOralIndicacion" type="text">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="div-tbl">
                                                        <input type="checkbox">
                                                        <label>Dieta</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idDietaTipo" type="text">
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idDietaIndicacion" type="text">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="div-tbl">    
                                                        <input type="checkbox">
                                                        <label>Suplemento</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idSuplementoTipo" type="text">
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idSuplementoIndicacion" type="text">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="div-tbl">
                                                        <input type="checkbox">
                                                        <label>NET</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idNetTipo" type="text">
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idNetIndicacion" type="text">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="div-tbl">
                                                        <input type="checkbox">
                                                        <label>NPT</label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idNptTipo" type="text">
                                                </td>
                                                <td>
                                                    <input class="clsInput" id="idNptIndicacion" type="text">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

<!-- <script>
    // Pasamos los datos de PHP a una variable global de JavaScript
    const diagnosticos = <?php echo $diagnosticosJson; ?>;
    document.addEventListener('DOMContentLoaded', function() {
    <?php
    $Medico = isset($_SESSION["CONTROLDATA"]) ? json_encode($_SESSION["CONTROLDATA"]) : "true";
    $DatosIncapacidad = isset($DatosIncapacidad) ? json_encode($DatosIncapacidad) : "null";
    ?>
    
    // Cargar las variables en JavaScript con los valores de PHP
    const params = new URLSearchParams(window.location.search);
    var Medico = <?php echo $Medico ?>;
    let DatosIncapacidad = <?php echo $DatosIncapacidad ?>;
    console.log("DatosIncapacidad:", DatosIncapacidad);
    console.log(DatosIncapacidad["NombreMedico"] +" "+ DatosIncapacidad["Registro"]);

    if (DatosIncapacidad && DatosIncapacidad["NombreMedico"] == "" && DatosIncapacidad["Registro"] == "" && DatosIncapacidad["IDNumberPaciente"] == "") {      
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
            title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
            popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
            content: 'custom-swal-Incapacidad-Content',
            confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
        }
    }).then((result) => {
        // Check if the user clicked the "Confirm" button
        if (result.isConfirmed) {
          // Redirect to another page
          window.location.href = 'ConsultarSolicitud.php';
        } else {
          // Close the current tab
          window.close();
        }});
    }

    else if (DatosIncapacidad["NomEntidad"] == "") {      
      Swal.fire({
      title: 'No es posible realizar Incapacidad',
      text: 'El paciente no tiene aseguradora asignada, por favor avisar a la unidad de atencion al usuario (UAU)',
      icon: 'warning',
      showCancelButton: false,
      confirmButtonText: 'Consultar Incapacidad',
      allowOutsideClick: false,
      allowEscapeKey: false,
      iconColor: '#006941',
      customClass: {
          title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
          popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
          content: 'custom-swal-Incapacidad-Content',
          confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
      }
    }).then((result) => {
        // Check if the user clicked the "Confirm" button
        if (result.isConfirmed) {
          // Redirect to another page
          window.location.href = 'ConsolidadoIncapacidad.php';
        } else {
          // Close the current tab
          window.close();
        }});
    }
    

  });

</script> -->
<script src="../control/paginacion-indicaciones.js"></script>
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

