<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

session_start();

$parameters = http_build_query($_GET);

foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
}

if (!isset($_SESSION["nombre"])) {

    $_SESSION["PrePage"] = "../Modulos/Cirugia_RH?CH=1";
    header("Location: ../../../view/login.php"."?".$parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Procedimiento cirugia";

    require_once '../../../view/template/header.php';

    if ($_SESSION['nuevo_procedimiento'] == 1) {

    if (isset($_GET["param"]) && $_GET["param"] !== "") {
        $_SESSION["param"] = $_GET["param"];
    }
    require '../../../logica/ApiURL.php';

    $_SESSION["param"] = "";

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la fecha enviada desde JavaScript
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';

    // Validar y procesar la fecha según tus necesidades
    if (!empty($fecha)) {
        // Ejemplo: Guardar la fecha en una base de datos, hacer alguna operación, etc.
        // Aquí simplemente la imprimimos para verificar
        echo 'Fecha recibida: ' . htmlspecialchars($fecha);
    } else {
        echo 'No se recibió una fecha.';
    }
} else {
    echo 'Método de solicitud no permitido.';
}

        
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Cirugia_RH/view/CSS/estilo.css">


    <div class="modal" id="Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Validar Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" class="form-control">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmarBtn">Confirmar</button>
                </div>
                <div id="mensaje" style="display:none;"></div>
            </div>
        </div>
    </div>


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
                                    <h2 class="text-success" style="margin-top: 15px;">Procedimiento para cirugia</h2>
                                </div>
                            </div>
                            <br>
                            <br>
                            <form method="POST" id="idProcedimientoDatos">
                                <h4 class="form-label text-divider-r"><span class="left-span" ></span><span>INFORMACIÓN GENERAL</span></h4>
                                <br>
                                <div class="well">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Número de episodio</label>
                                            <input readonly type="number" id="episodio" class="form-control rqr" name="episodio" required  value="<?php echo $Doc; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Número de documento</label>
                                            <input readonly type="text" id="idNumeroDocumento" class="form-control rqr" name="idNumeroDocumento" value="<?php echo isset($DatosIncapacidad['IDNumberPaciente']) && !empty($DatosIncapacidad['IDNumberPaciente']) ? $DatosIncapacidad['IDNumberPaciente'] : ''; ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Edad</label>
                                            <input readonly type="text" id="idEdad" class="form-control rqr" name="idEdad" value="<?php echo isset($DatosIncapacidad['Edad']) && !empty($DatosIncapacidad['Edad']) ? $DatosIncapacidad['Edad'] : ''; ?>">
                                        </div>
                                        <div class="col-md-2">
                                            <label>Sexo</label>
                                            <input readonly type="text" id="idSexo" class="form-control rqr" name="idSexo" value="<?php echo isset($DatosIncapacidad['Sexo']) && !empty($DatosIncapacidad['Sexo']) ? $DatosIncapacidad['Sexo'] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Nombres del paciente</label>
                                            <input readonly type="text" class="form-control rqr" id="idNombrePaciente" name="idNombrePaciente" value="<?php echo isset($DatosIncapacidad['NombreApellido']) && !empty($DatosIncapacidad['NombreApellido']) ? $DatosIncapacidad['NombreApellido'] : ''; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Aseguradora</label>
                                            <input readonly type="text" class="form-control rqr" id="idAsegurador" name="asegurador" value="<?php echo isset($DatosIncapacidad["NomEntidad"]) && !empty($DatosIncapacidad["NomEntidad"]) ? $DatosIncapacidad["NomEntidad"] : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Procedimiento</label>
                                            <input type="text" class="form-control rqr fechasDP" id="idProcedimiento" name="idProcedimiento" required>                                    
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Nombre del responsble</label>
                                            <input readonly type="text" class="form-control rqr fechasDP" id="idNombreCirujano" name="idNombreCirujano" required value="<?php echo $DatosIncapacidad['NombreMedico']; ?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label>Cargo del responsable</label>
                                            <input  readonly type="text" class="form-control" id="idEspecialidad" name="idEspecialidad" required value="<?php echo $DatosIncapacidad['Especialidad']; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Fecha de la cirugía</label>
                                            <input readonly type="DATE" class="form-control" id="Fecha" name="Fecha">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-8" hidden>
                                        <center><label for="centrosanitario">centrosanitario:</label></center>
                                        <input readonly type="text" id="centrosanitario" name="centrosanitario" class="form-control"
                                            value="<?php echo isset($DatosIncapacidad['CentroSanitario']) && !empty($DatosIncapacidad['CentroSanitario']) ? $DatosIncapacidad['CentroSanitario'] : ''; ?>">
                                    </div>
                                    <br>
                                    
                                </div>
                            </form>
                            
                            <br>
                            <br>
                            <h4 class="form-label text-divider-r"><span class="left-span"></span><span>FORMULARIOS</span></h4>
                            <br>
                            <!-- NAV TABS DE LOS FORMULARIOS ENTRADA PAUSA SALIDA -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active navs" id="entrada-tab" data-bs-toggle="tab" data-bs-target="#entrada" type="button" role="tab" aria-controls="entrada" aria-selected="true" style="color:#006b45; font-weight: bold; font-size: 16px;"><i class="fas fa-play	"></i> Primera Pausa</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link navs" id="pausa-tab" data-bs-toggle="tab" data-bs-target="#pausa" type="button" role="tab" aria-controls="pausa" aria-selected="false" style="color:#006b45; font-weight: bold; font-size: 16px;" disabled><i class="fas fa-play	"></i> Segunda Pausa</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link navs" id="salida-tab" data-bs-toggle="tab" data-bs-target="#salida" type="button" role="tab" aria-controls="salida" aria-selected="false" style="color:#006b45; font-weight: bold; font-size: 16px;" disabled><i class="fas fa-play	"></i> Tercera Pausa</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="entrada" role="tabpanel" aria-labelledby="entrada-tab">
                                    <form method="POST" id="idFormEntrada">
                                        <table class="table-responsive" id="entradaTable">
                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color:rgb(143, 137, 137);">
                                                    Antes de la inducción de la anestesia
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="left-align sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Se confirma con el Paciente</th>
                                                <th class="sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Respuesta</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">1. Nombre e identificación:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Nombre_identificacion" id="id_NombrIdentificacion" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">2. Consentimiento quirúrgico completo y firmado:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="intrumental" id="id_intrumental" required>
                                                        <option value=""disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">3. Alergias reportadas:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Alergia_reporta" id="id_AlergiaReporta" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <option value="N/A">N/A</option> 
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr hidden id="texto_alergia">
                                                <td colspan="2"><textarea style="width: 100%; padding: 5px; margin:0; border:0" placeholder="3.1. Indique las alergias reportadas" id="textoarea_alergia" maxlength="200"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">4. Consentimiento de anestesia completo y firmado</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Consentimiento" id="id_Consentimiento" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <option value="N/A">N/A</option> 

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">5.1 Marcación del sitio de la cirugía con SI :</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Marcacion" id="Marcacion" required>
                                                    <option value="" disabled selected>Seleccione</option>
                                                    <option value="si">Sí</option>
                                                     <option value="no">No</option>    
 						     <option value="N/A">N/A</option>                                                  
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr id="filaMarcacion">
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">5.2 Seleccione el lugar de la marcación :</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Seleccione" id="idSeleccione" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="Derecha">Derecha</option>
                                                        <option value="Izquierda">Izquierda</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">
                                                    Chequeo de equipos, insumos e imágenes</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">6. Verificación del funcionamiento de máquinas de anestesia y medicamento por anestesiólogo, se diligenció código QR</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Verificacion" id="id_Verificacion" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">7. Confirmación de instrumental, implantes, insumos, indicadores y equipos:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Confirmacion" id="id_Confirmacion" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">7.1. Confirmación de esterilidad:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="esterilidad" id="id_esterilidad" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">8. Monitoreo en funcionamiento:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Monitoreo" id="id_Monitoreo" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">9. Pérdida de sangre > 500ml (niños 7ml/kg):</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Perdida" id="id_Perdida" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <option value="N/A">N/A</option> 

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">10. Reserva de hemocomponentes:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Reserva" id="id_Reserva" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <option value="N/A">N/A</option> 

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">11. Disponibilidad de hemocomponentes en la sala:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Disponibilidad" id="id_Disponibilidad" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <option value="N/A">N/A</option> 

                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">12. Estudios diagnósticos disponibles, carasterísticas revisadas:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Estudios" id="id_Estudios" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">13. Vía área difícil gestionado:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Via" id="id_Via" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">14. Antibiótico profiláctico definido:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Antibiotico" id="id_Antibiotico" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <option value="N/A">N/A</option> 
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr hidden id="texto_antibiotico">
                                                <td colspan="2"><textarea placeholder="14.1. ¿Cuáles?" style="width: 100%; padding: 5px; margin:0; border:0" id="textoarea_antibiotico" maxlength="200"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">15. Suspensión de anticoagulantes y/o antiagregantes plaquetarios:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Suspension" id="id_Suspension" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">16. La casa comercial da Vo.Bo para iniciar el procedimiento:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="comercial" id="id_comercial" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">17. Se necesita cultivos:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="cultivos" id="id_cultivos" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">18. Se necesita patologías:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="patologias" id="id_patologias" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>


                                            <td colspan="2">
                                                <label for="idObservacionesEntrada" style="font-weight: bold; font-size: 14px; ">Observaciones:</label>
                                                <textarea class="form-control" id="idObservacionesEntrada" name="ObservacionesEntrada" rows="3" style="width: 100%;"></textarea>
                                            </td>
                                        </table>
                                        <br>
                                        <div id="contenedor-boton">
                                            <input type="button" id="guardarEntrada" name="agregarEntrada" class="btn" value="Guardar Primera Pausa">
                                        </div>
                                    </form>
                                    <br>
                                    <h4 class="form-label text-divider-rh"><span class="left-span"></span><span>FIRMAS ANTES DE LA INDUCCIÓN DE LA CIRUGÍA</span></h4>
                                    <br>
                                    <form id="firmas" method="POST" enctype="multipart/form-data">
                                        
                                        <div id="firmas-container">
                                        <div style="text-align: right;">
                                            <button type="button" class="btn btn-success add-row">+</button>
                                        </div>
                                            <div class="row firma-item">
                                                <div class="col-md-3">
                                                    <label>Cargo</label>
                                                    <input readonly type="text" class="form-control rqr" name="idCargoEntrada[]">
                                                    <!-- <select class="form-control rqr" name="idCargoEntrada[]" required>
                                                        <option value="" disabled selected>Seleccionar</option>
                                                    </select> -->
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Nombre Completo</label>
                                                    <input readonly type="text" class="form-control rqr" name="idNombreFirmaEntrada[]">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Número de documento</label>
                                                    <input readonly type="text" class="form-control rqr" name="idDocumentoFirmaEntrada[]">
                                                </div>
                                                <div class="col-md-3">
                                                    <br>
                                                    <button type="button" class="btn btn-primary validarBtn" data-bs-toggle="modal" data-bs-target="#Modal" >FIRMAR</button>
                                                    <button type="button" class="btn btn-danger remove-row">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="contenedor-boton-entrada">
                                            <input type="button" id="guardarFirmaEntrada" name="agregarEntrada" class="btn" value="Guardar Firma Entrada" disabled>
                                        </div>
                                    </form>
                                    <br>
                                </div>


                                <div class="tab-pane fade" id="pausa" role="tabpanel" aria-labelledby="pausa-tab" >
                                    <form method="POST" id="idFormPausa">
                                        <table class="table-responsive" id="entradaPausa">
                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color:rgb(143, 137, 137);">
                                                    Antes de la incisión
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="left-align sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Se confirma</th>
                                                <th class="sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Respuesta</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">1. Equipo humano completo:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="equipoHumano" id="id_equipoHumano" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>                                            
                                            <tr>
                                                <th class="left-align sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Se confirma con el Cirujano</th>
                                                <th class="sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Respuesta</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">2. Paciente, abordaje y procedimiento:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Nombre_abordaje" id="id_abordaje" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">3. Existen riesgos adicionales:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Existen" id="id_Existen" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">4. Administración de antibióticos en el tiempo correcto:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Administracion" id="id_Administracion" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">5. Plan para repetir dosis de antibiótico durante el procedimiento:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Plan" id="id_Plan" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr hidden id="texto_Plan">
                                                <td colspan="2"><textarea placeholder="5.1. ¿Cuáles antibióticos? ¿En qué momento?" style="width: 100%; padding: 5px; margin:0; border:0" id="textoarea_Plan"></textarea></td>
                                            </tr>

                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">
                                                    Se confirma con el Anestesiólogo</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">6. El anestesiólogo da Vo. Bo para iniciar el procedimiento quirúrgico:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="anestesiologo" id="id_anestesiologo" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">
                                                    Se confirma con Instrumentadora</th>
                                            </tr>
                                            
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">7. La instrumentadora da Vo. Bo para iniciar el procedimiento quirúrgico :</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Vo" id="id_Vo" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">
                                                    Se confirma con Perfusionista</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">8. Se validaron detalles relevantes respecto a la canulación:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Detalles_relevantes" id="id_Detalles_relevantes" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                        <!-- <option value="N/A">N/A</option>  -->
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">9. Se definió a qué temperatura llevar al paciente:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="T" id="id_T" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">10. Se validó la necesidad de perfusión selectiva y/o enfriamiento cerebral con hielo:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="perfusion" id="id_perfusion" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                                    </tr>
                                            <td colspan="2">
                                                <label for="idObservacionesPausa" style="font-weight: bold; font-size: 14px; ">Observaciones:</label>
                                                <textarea class="form-control" id="idObservacionesPausa" name="ObservacionesPausa" rows="3" style="width: 100%;"></textarea>
                                            </td>
                                        </table>
                                        <br>
                                        <div id="contenedor-boton" >
                                            <input type="button" id="guardarPausa" name="agregarPausa" class="btn" value="Guardar Segunda Pausa">
                                        </div>
                                    </form>
                                </div>


                                <div class="tab-pane fade" id="salida" role="tabpanel" aria-labelledby="salida-tab">
                                    <form method="POST" id="idFormSalida">
                                        <table class="table-responsive" id="entradaSalida">
                                            <tr>
                                                <th class="left-align sub-header" colspan="2" style="font-weight: bold; font-size: 16px;background-color:rgb(143, 137, 137);">
                                                    Antes de que el cirujano se retire de la sala
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="left-align sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Se confirma</th>
                                                <th class="sub-header" style="font-weight: bold; font-size: 16px;background-color: #cbcbcc;">Respuesta</th>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">1. La cirugía realizada fue la programada:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="programada" id="id_programada" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">2. Se revisó si se presentaron complicaciones:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="complicaciones" id="id_complicaciones" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">3. Se obtuvo conteo completo: cortante, agujas, algodones, cotonoides, gasas, compresas, instrumental:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Conteo" id="id_Conteo" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">4. Se despertó al paciente en una camilla con barandas:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Camilla" id="id_Camilla" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">5. Muestra para laboratorio y/o patologías marcadas, rotuladas y orientadas:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="Muestra" id="id_Muestra" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="left-align sub-header" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left;">6. Plan posoperatorio definido:</td>
                                                <td id="tds">
                                                    <select class="form-control" style="width: 100%; height: 50%;" name="posopetario" id="id_posopetario" required>
                                                        <option value="" disabled selected>Seleccione</option>
                                                        <option value="si">Sí</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <td colspan="2">
                                                <label for="idObservacionesSalida" style="font-weight: bold; font-size: 14px; ">Observaciones:</label>
                                                <textarea class="form-control" id="idObservacionesSalida" name="observaciones" rows="3" style="width: 100%;"></textarea>
                                            </td>
                                        </table>
                                        <br>
                                        <div id="contenedor-boton" >
                                            <input type="submit" id="guardarSalida" name="agregarSalida" class="btn" value="Guardar Tercera Pausa">
                                        </div>
                                    </form>
                                    <br>
                                    <br><br>
                                    <h4 class="form-label text-divider-rh"><span class="left-span"></span><span>FIRMAS AL TERMINAR LA CIRUGÍA</span></h4>
                                    <br>
                                    <form id="firmaSalida" method="POST" enctype="multipart/form-data">
                                        <div id="firmas-container-salida">
                                            <div style="text-align: right;"> 
                                                <button type="button" class="btn btn-success add-row">+</button>
                                            </div>
                                            <div class="row firmaSalida-item">
                                                <div class="col-md-3">
                                                    <label>Cargo</label>
                                                    <input readonly type="text" class="form-control rqr" name="idCargoSalida[]">
                                                    <!-- <select class="form-control rqr" name="idCargoSalida[]" required>
                                                        <option value="" disabled selected>Seleccionar</option>
                                                    </select> -->
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Nombre Completo</label>
                                                    <input readonly type="text" class="form-control rqr" name="idNombreFirmaSalida[]">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Número de documento</label>
                                                    <input readonly type="text" class="form-control rqr" name="idDocumentoFirmaSalida[]">
                                                </div>
                                                <div class="col-md-3">
                                                    <br>
                                                    <button type="button" class="btn btn-primary validarBtn" data-bs-toggle="modal" data-bs-target="#Modal" >FIRMAR</button>
                                                    <button type="button" class="btn btn-danger remove-row">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div id="contenedor-boton-salida">
                                            <input type="button" id="guardarFirmaSalida" name="agregarSalida" class="btn" value="Guardar Firma Salida" disabled>
                                        </div>
                                    </form>

                                </div>
                                
                            </div>
                                

                        </div>
                        <br>
                        <br>
                        
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

<script src="../control/JS/CirugiaRHControl.js"></script>
<script src="../control/JS/entradaForm.js"></script>
<script src="../control/JS/pausaForm.js"></script>
<script src="../control/JS/salidaForm.js"></script>
<script src="../control/JS/Reloj.js"></script>
<script src="../control/JS/validarUsuario.js"></script>
<!-- <script src="../control/JS/cargos.js"></script> -->
<script src="../control/JS/firmaEntrada.js"></script>
<script src="../control/JS/firmaSalida.js"></script>

<script src="../control/JS/control.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

