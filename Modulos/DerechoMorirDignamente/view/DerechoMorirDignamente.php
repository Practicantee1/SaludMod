<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');

ob_start();
session_start();

$parameters = http_build_query($_GET); 

if (!isset($_SESSION["nombre"]) ){
    $_SESSION["PrePage"] = "../Modulos/DerechoMorirDignamente/view/DerechoMorirDignamente.php";
    header("Location: ../../../view/login.php"."?".$parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Derecho a Morir Dignamente";

    $_SESSION['module_title'] = "DERECHO A MORIR DIGNAMENTE";
    require_once '../../../view/template/header.php';

if ($_SESSION['Derecho_morir_dignamente']==1)
{
    if (isset($_GET["param"]) && $_GET["param"] !== "") {
        $_SESSION["param"] = $_GET["param"];
    }
    
    require_once '../../../logica/ApiURL.php';
    
    $_SESSION["param"] = "";

   
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilosDMD.css">
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
                                <div class="datos_container">
                                    <div class="div-input">
                                        <label for="idCiudad">Ciudad</label>
                                        <input readonly class="input" id="idCiudad" type="text">
                                    </div>
                                    <div class="div-input">
                                        <label for="idFecha">Fecha</label>
                                        <input readonly class="input" id="idFecha" type="text">
                                    </div>
                                </div>
                                <div class="well" style="margin-bottom:10px">
                                    <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">DATOS MEDICO QUE RECEPCIONA LA SOLICITUD</span></h4>
                                </div>
                                <div id="datosPaciente_container">
                                    <div class="div-input div-input_Medico">
                                        <label for="idMedicoDMD">Médico que recepciona
                                        la solicitud:</label>
                                        <input readonly id="idMedicoDMD" class="input" type="text" value="<?php echo $DatosIncapacidad['NombreMedico']; ?>">
                                    </div>
                                    <div class="div-input">
                                        <label for="idRegistro">Tipo de documento</label>
                                        <input readonly id="idTipoDocumento" class="input" type="text" value="<?php echo $DatosIncapacidad['TipoIDMedico']; ?>">
                                    </div>
                                    <div class="div-input">
                                        <label for="idRegistro">Número del documento</label>
                                        <input readonly id="idDocumento" class="input" type="text" value="<?php echo $DatosIncapacidad['IDNumberMedico']; ?>" >
                                    </div>
                                    <div class="div-input">
                                        <label for="idRegistro">Registro Médico No.</label>
                                        <input readonly id="idRegistro" class="input" type="text" value="<?php echo $DatosIncapacidad['Registro']; ?>">
                                    </div>
                                    
                                    <div class="div-input">
                                        <label for="idEspecialidad">Especialidad:</label>
                                        <input readonly id="idEspecialidad" class="input" type="text" value="<?php echo $DatosIncapacidad['Especialidad']; ?>">
                                    </div>
                                    
                                </div>
                                
                                <div class="well" style="margin-bottom:10px">
                                    <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">DATOS DEL PACIENTE</span></h4>
                                </div>
                                <div id="datosPaciente_container">
                                    <div class="div-input" id="div-paciente">
                                        <label for="idNombrePaciente">Nombre del Paciente:</label>
                                        <input readonly class="input" id="idNombrePaciente" type="text" onkeydown="return /[a-z, ]/i.test(event.key)" value="<?php echo $DatosIncapacidad['NombreApellido']; ?>">
                                    </div>
                                    <div class="div-input">
                                        <label for="idTipoIdentificacion">Tipo de Documento:</label>
                                        <input readonly class="input" id="idTipoIdentificacion" type="text" value="<?php echo $DatosIncapacidad['Documento']; ?>">
                                    </div>
                                    <div class="div-input">
                                        <label for="idNumeroIdentificacion">Número de identificación:</label>
                                        <input readonly class="input" id="idNumeroIdentificacion" type="text" value="<?php echo $DatosIncapacidad['IDNumberPaciente']; ?>">
                                    </div>
                                    <div class="div-input">
                                        <label for="idEdad">Edad:</label>
                                        <input readonly class="input" id="idEdad" type="text" value="<?php echo $DatosIncapacidad['Edad']; ?>">
                                    </div>
                                    <div class="div-input">
                                        <label for="idFechaSolicitud">Fecha de la Solicitud:</label>
                                        <input id="idFechaSolicitud" class="input" type="date" required>
                                    </div>
                                    <div class="div-input" hidden>
                                        <label for="centrosanitario">centrosanitario:</label>
                                        <input readonly class="input" id="centrosanitario" type="text" value="<?php echo $DatosIncapacidad['CentroSanitario']; ?>">
                                    </div>
                                </div>

                                <div class="well" style="margin-bottom:10px">
                                    <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">INFORME Y DECLARACIONES</span></h4>
                                </div>
                                <div id="informe-tabla">
                                    <p id="idInforme_declaraciones">
                                    En uso del derecho a morir con dignidad, el paciente arriba en mención elevó la solicitud para dar inicio al
                                    procedimiento de muerte anticipada a través de la eutanasia, por lo cual dando cumplimiento a las
                                    disposiciones contempladas en la Resolución 1216/2015 expedida por el Ministerio de Salud y Protección
                                    Social, me permito convocar formalmente al Comité de Muerte Digna de la Fundación Hospitalaria San
                                    Vicente de Paúl para verificar la existencia de los presupuestos de la solicitud y dar inicio al trámite para
                                    hacer efectivo el derecho a morir con dignidad.
                                    Por lo anterior expuesto y en consideración con las atenciones médicas realizadas al paciente, procedo a
                                    emitir informe en los siguientes términos:
                                    </p>
                                    <div class="table-Container">
                                    <table id="idTablaTerminos">
                                        <thead>
                                            <tr>
                                                <th>Términos</th>
                                                <th>Respuesta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="row1">
                                                <td>1. Conozco el diagnóstico de la enfermedad grave o terminal que padece el paciente. ¿Cuál?</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P1-si">Sí</label>
                                                            <input id="P1-si" name="P1" value="Si" type="checkbox" class="checkbox-si" data-group="P1">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P1-no">No</label>
                                                            <input id="P1-no" name="P1" value="No" type="checkbox" class="checkbox-no" data-group="P1">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2. El padecimiento de esta enfermedad terminal le produce intensos dolores y sufrimientos.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P2-si">Si</label>
                                                            <input id="P2-si" name="P2" value="Si" type="checkbox" class="checkbox-si" data-group="P2">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P2-no">No</label>
                                                            <input id="P2-no" name="P2" value="No" type="checkbox" class="checkbox-no" data-group="P2">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3.
                                                Se le ha ofrecido al paciente otras alternativas como las del cuidado paliativo para el
                                                tratamiento integral del dolor, el alivio del sufrimiento y otros sintomas.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P3-si">Si</label>
                                                            <input id="P3-si" name="P3" value="Si" type="checkbox" class="checkbox-si" data-group="P3">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P3-no">No</label>
                                                            <input id="P3-no" name="P3" value="No" type="checkbox" class="checkbox-no" data-group="P3">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4.
                                                Actualmente el paciente se encuentra recibiendo cuidados paliativos.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P4-si">Si</label>
                                                            <input id="P4-si" name="P4" value="Si" type="checkbox" class="checkbox-si" data-group="P4">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P4-no">No</label>
                                                            <input id="P4-no" name="P4" value="No" type="checkbox" class="checkbox-no" data-group="P4">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5.
                                                El consentimiento del paciente esta libre de presiones de terceros y no es producto de
                                                episodios anemicos o momentos que puedan afectar el sentido de su decision.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P5-si">Si</label>
                                                            <input id="P5-si" name="P5" value="Si" type="checkbox" class="checkbox-si" data-group="P5">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P5-no">No</label>
                                                            <input id="P5-no" name="P5" value="No" type="checkbox" class="checkbox-no" data-group="P5">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6.
                                                Se le han aclarado al paciente todas sus dudas, explicando el procedimiento y ha
                                                comprendido la naturaleza del mismo.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P6-si">Si </label>
                                                            <input id="P6-si" name="P6" value="Si" type="checkbox" class="checkbox-si" data-group="P6">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P6-no">No</label>
                                                            <input id="P6-no" name="P6" value="No" type="checkbox" class="checkbox-no" data-group="P6">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7.
                                                El consentimiento del paciente es producto de episodios anemicos o momentaneos que
                                                puedan afectar el sentido de su decision.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P7-si">Si</label>
                                                            <input id="P7-si" name="P7" value="Si" type="checkbox" class="checkbox-si" data-group="P7">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P7-no">No</label>
                                                            <input id="P7-no" name="P7" value="No" type="checkbox" class="checkbox-no" data-group="P7">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>8. Se le informó al paciente que en cualquier momento del proceso puedo desistir de la
                                                solicitud y optar por otras alternativas terapéuticas como los cuidados paliativos.</td>
                                                <td>
                                                    <div class="div-dos-checks">
                                                        <div class="div-checks">
                                                            <label for="P8-si">Si</label>
                                                            <input id="P8-si" name="P8" value="Si" type="checkbox" class="checkbox-si" data-group="P8">
                                                        </div>
                                                        <div class="div-checks">
                                                            <label for="P8-no">No</label>
                                                            <input id="P8-no" value="No" name="P8" type="checkbox" class="checkbox-no" data-group="P8">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="well" style="margin-bottom:10px">
                                    <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">OBSERVACIONES</span></h4>
                                </div>
                                <div class="div-textarea">
                                    <textarea name="" id="text-area" class="input"></textarea>
                                </div>
                                <div class="div-btn">
                                    <button id="guardar">GUARDAR SOLICITUD</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="../control/JS/guardarTerminos.js"></script>
</body>
<?php 
// Convertimos el arreglo PHP en JSON
$diagnosticosJson = json_encode($Diagnosticos);
$DatosJson = json_encode($DatosIncapacidad);
?>

<script>
    // AsegSIrate de que las variables PHP se estSIn generando correctamente
const diagnosticos = <?php echo $diagnosticosJson; ?>;
console.log(diagnosticos);

//const DatosIncapacidad = datosInc || {};



document.addEventListener('DOMContentLoaded', function() {
    // Obtener los parSImetros de la URL
    const params = new URLSearchParams(window.location.search);

    // Suponiendo que 'param' es el parSImetro que quieres decodificar
    const encodedParam = params.get('param');

    if (encodedParam) {
        // Decodificar el parSImetro en base64
        let parametros = window.atob(encodedParam);

        // Parsear el JSON
        const data = JSON.parse(parametros);

        // Obtener el SIltimo objeto del array `parametros`
        const lastParam = data.parametros[data.parametros.length - 1];

        // Obtener el valor del campo
        const lastValue = lastParam.valor;

        // Actualizar el valor en el elemento con id `idRegistro`
        $("#idRegistro").val(lastValue);

    } else {
        console.log("Encoded parameter 'param' not found in URL");
    }

      let medico = $("#idMedicoDMD").val();
        let Documento = $("#idDocumento").val();
        let Registro = $("#idRegistro").val();
        let Especialidad = $("#idEspecialidad").val();
        let NombrePaciente = $("#idNombrePaciente").val();
        let NumeroIdentificacion = $("#idNumeroIdentificacion").val();

    if (medico == "" || Documento == "" || Registro == "" || Especialidad == "" || NombrePaciente == "" || NumeroIdentificacion == "" ) {
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
            }
        });
    }

    //else if (DatosIncapacidad["NomEntidad"] == "") {      
    //   Swal.fire({
    //   title: 'No es posible realizar Incapacidad',
    //   text: 'El paciente no tiene aseguradora asignada, por favor avisar a la unidad de atencion al usuario (UAU)',
    //   icon: 'warning',
    //   showCancelButton: false,
    //   confirmButtonText: 'Consultar Incapacidad',
    //   allowOutsideClick: false,
    //   allowEscapeKey: false,
    //   iconColor: '#006941',
    //   customClass: {
    //       title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
    //       popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
    //       content: 'custom-swal-Incapacidad-Content',
    //       confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
    //   }
    // }).then((result) => {
    //     // Check if the user clicked the "Confirm" button
    //     if (result.isConfirmed) {
    //       // Redirect to another page
    //       window.location.href = 'ConsolidadoIncapacidad.php';
    //     } else {
    //       // Close the current tab
    //       window.close();
    //     }});
    // }
    

  });</script><script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<!-- <script src="../control/JS/controlInicial.js"></script> -->
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

