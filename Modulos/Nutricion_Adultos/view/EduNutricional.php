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
    <link rel="stylesheet" href="css/EduNutricional.css">
 </head>
 <body>
    <div class="content-wrapper">
         
        <div class="container">
            <div class="col-md-15">
                <div class="card shadow p-3 mb-8" style="margin-top: 100px;">
                    <div class="card-header">
                        <div class="well" style="margin:0">
                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style=" padding: .5em">Informacion General</span></h4>
                        </div>
                        <div class="grid">
                            <div class="div-input">
                                <label class="lb-inicio" for="idEpisodio">Numero de episodio</label>
                                <input id="idEpisodio" class="clsInput" type="text">
                            </div>
                            <div class="div-input">
                                <label class="lb-inicio" for="idDocumento">Numero de documento</label>
                                <input id="idDocumento" class="clsInput" type="text">
                            </div>
                            <div class="div-input">
                                <label class="lb-inicio" for="idNombrePaciente">Nombre del paciente</label>
                                <input id="idNombrePaciente" class="clsInput" type="text">
                            </div>
                            <div class="div-input">
                                <label class="lb-inicio" for="idAseguradora">Aseguradora</label>
                                <input id="idAseguradora" class="clsInput" type="text">
                            </div>
                        </div>
                        <div class="grid2">
                            <div class="div-input">
                                <label class="lb-inicio" for="idNumeroCirujano">Numero del cirujano</label>
                                <input id="idNumeroCirujano" class="clsInput" type="text">
                            </div>
                            <div class="div-input">
                                <label class="lb-inicio" for="idEspecialidad">Especialidad</label>
                                <input id="idEspecialidad" class="clsInput" type="text">
                            </div>
                            <div class="div-input">
                                <label class="lb-inicio" for="idFechaCirugia">Fecha de la cirugia</label>
                                <input id="idFechaCirugia" class="clsInput" type="date">
                            </div>
                        </div>
                        <div class="div-observaciones">
                            <div class="div-input">
                                <label class="lb-inicio" for="idObservaciones">Observaciones</label>
                                <textarea id="idObservaciones" class="clsInput obs" type="text"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-md-15">
                <div class="card shadow p-3 mb-8" >
                    <div class="card-header">
                        <div class="well" style="margin:0">
                            <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style=" padding: .5em">Educación Nutricional</span></h4>
                        </div>
                        <div class="grid3">
                            <div class="div-container">
                                <input type="checkbox">
                                <div class="div-input">
                                    <label class="lb-inicio" for="idFechaCirugia">Fecha de la cirugia</label>
                                    <select name="" class="clsInput" id=""></select>
                                </div>
                            </div>
                            <div class="div-container">
                                <input type="checkbox">
                                <div class="div-input">
                                    <label class="lb-inicio" for="idFechaCirugia">Fecha de la cirugia</label>
                                    <select name="" class="clsInput" id=""></select>
                                </div>
                            </div>
                            <div class="div-container">
                                <input type="checkbox">
                                <div class="div-input">
                                    <label class="lb-inicio" for="idFechaCirugia">Fecha de la cirugia</label>
                                    <select name="" class="clsInput" id=""></select>
                                </div>
                            </div>
                            <div class="area-container">
                                <label class="lb-inicio" for="idOtro">Otro</label>
                                <textarea id="idOtro" class="clsInput" type="text"></textarea>
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

