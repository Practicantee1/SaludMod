<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();
session_start();

$parameters = http_build_query($_GET); 

if (!isset($_SESSION["nombre"]))
{
  
  $_SESSION["PrePage"] = "../Modulos/Incapacidades?CH=1";
  header("Location: ../../../view/login.php"."?".$parameters);
}
else
{
    define('BASE_URL', '../../');
    $pageTitle = "Incapacidades";
    $_SESSION['module_title'] = "GENERAR INCAPACIDAD";



require_once '../../../view/template/header.php';


if ($_SESSION['Generar Incapacidades']==1)
{
  if (isset($_GET["param"]) && $_GET["param"] !== "") {
    $_SESSION["param"] = $_GET["param"];
  }
    
  require '../Control/Api.php';
  
  $_SESSION["param"] = "";

?>
<div class="content-wrapper">
  <div id="alertContainer" class="alert" role="alert"></div>
  <!---Content Header (Page header)----->
  <div class="container">
      <div class="col-md-15">
        <div id="card-inca" class="card shadow p-3 mb-8" >
          <div class="card-header">
               
            <form id="AgregarIncapacidad" method="POST" target="_blank">

            <div class="row titles-Incapacidad">
              <div class="col">
                <div class="well">
                  <h4 class="form-label text-divider-Incapacidad"><span class="left-span"></span><span class="span">Duración de la Incapacidad</span></h4>
                </div>
              </div>
            </div>

              <div class="row  row-Incapacidad">
                <div class="col-md-3">
                <center><label style="color:black" for="" class="form-label">Fecha inicio</label></center>
                  <input type="date" name="FechaInicial" id="FechaInicial" placeholder="Fecha inicio incapacidad" class="form-control" required>
                </div>

                <div class="col-md-1"></div>

                <div class="col-md-3">
                  <center><label style="color:black" for="" class="form-label">Fecha final</label></center>
                  <input type="date" name="FechaFinal" id="FechaFinal" placeholder="Fecha final incapacidad" class="form-control" required>
                </div>

                <div class="col-md-1"></div>

                <div class="col-md-3">
                  <center><label style="color:black" for="TotalDias" class="form-label">Duración Incapacidad</label></center>
                  <input type="text" name="TotalDias" id="TotalDias" placeholder="---" class="form-control bg-white" readonly>
                </div>
                
                
                
              </div>
              <br>
              <div class="row  row-Incapacidad">
                
                <div class="col-md-2"></div>
                <div class="col-md-8" id="RetroActive-Div" hidden> 
                  <center><label for="RetroActive" style="color: black;" class="form-label">Motivo de la Incapacidad retroactiva</label></center>
                  <select class="form-control select-Incapacidad" name="RetroActive" id="RetroActive" required>
                    <option class="option-Incapacidad" value="N/A" id="OptionRetroActive">No Aplica</option>
                    <option class="option-Incapacidad" value="Urgencias o internacion del paciente" selected>Urgencias o internacion del paciente</option>
                    <option class="option-Incapacidad" value="Trastorno de memoria, confusion mental, desorientacion en persona tiempo y lugar, otras alteraciones de la esfera psiquica, organica o funcional segun criterio medico u odontologo">Trastorno de memoria, confusion mental, desorientacion en persona tiempo y lugar, otras alteraciones de la esfera psiquica, organica o funcional segun criterio medico u odontologo</option>
                    <option class="option-Incapacidad" value="Evento catastrofico y terrorista">Evento catastrofico y terrorista</option>
                  </select>
                </div>
                <div class="col-md-2"></div>

              </div>
              <br>
              <div class="row titles-Incapacidad">
                <div class="col">
                  <div class="well">
                    <h4 class="form-label text-divider-Incapacidad"><span class="left-span"></span><span class="span">Datos Prestadoras de servicio</span></h4>
                  </div>
                </div>
              </div>
              
              <div class="row row-Incapacidad">
		<div class="col-md-1"></div>

                <div class="col-md-6">
                  <center><label style="color:black"  for="RazonSocial" class="form-label" name="episodio">Razón Social</label></center>
                      <?php
                      date_default_timezone_set('America/Bogota');
                      $fecha_actual = date("Y-m-d");
                      ?>
                  <div class="input-group">
                    <input type="text" name="RazonSocial" id="RazonSocial" class="form-control bg-white" placeholder="Razon social o apellidos y nombres del prestador social" required value="<?php echo $DatosIncapacidad['RazonSocial']; ?>" readonly> 
                  </div>
                </div>

		<div class="col-md-1"></div>

		<div class="col-md-3">
                  <center><label style="color:black"  for="CentroSanitario" class="form-label">Grupo Sanitario</label></center>
                    <input type="text" name="CentroSanitario" id="CentroSanitario"  class="form-control bg-white" placeholder="Centro Sanitario" required value="<?php echo $DatosIncapacidad['CentroSanitario']; ?>" readonly> 
                </div>

		<div class="col-md-1"></div>

                
                                
              </div>
              <br>
              <div class="row row-Incapacidad">
                <div class="col-md-2"></div>

                <div class="col-md-4">
                  <center><label style="color:black" for="CodAseguradora" class="form-label">Código REPS</label></center>
                  <input type="text" name="CodAseguradora" id="CodAseguradora" class="form-control  bg-white" placeholder="Codigo aseguradora" value="<?php echo $DatosIncapacidad['CodAseguradora']; ?>" readonly>
                </div>
                <div class="col-md-1"></div>

		<div class="col-md-3">
                    <center><label style="color:black" for="NIT" class="form-label">NIT</label></center>
                  <input type="text" name="NIT" id="NIT" class="form-control bg-white" placeholder="NIT Aseguradora" aria-describedby="helpId"value="<?php echo $DatosIncapacidad['NIT']; ?>" readonly>
                </div>

		<div class="col-md-2"></div>

              </div>


              
            
                <br>

                <div class="row titles-Incapacidad">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider-Incapacidad"><span class="left-span"></span><span class="span">Datos del Paciente</span></h4>
                    </div>
                  </div>
                </div>
                
                <div class="row row-Incapacidad">

                  <div class="col-md-6">
                    <center> <label style="color:black" for="NombreApellido" class="form-label">Nombres y Apellidos Del Afiliado</label></center>
                    <input type="text" onkeydown="return /[a-z, ]/i.test(event.key)" name="NombreApellido" id="NombreApellido" class="form-control bg-white" aria-describedby="helpId" required value="<?php echo $DatosIncapacidad['NombreApellido']; ?>" readonly>
                  </div>

		  <div class="col-md-6">
                    <center><label style="color:black" for="NomEntidad" class="form-label">Nombre Aseguradora</label></center>
                    <input type="text" name="NomEntidad" id="NomEntidad" class="form-control bg-white" placeholder="Nombre entidad promotora de salud" aria-describedby="helpId" value="<?php echo $DatosIncapacidad['NomEntidad']; ?>" readonly>
                  </div>
		</div>
		<br>

		<div class="row row-Incapacidad">

		  <div class="col-md-1"></div>
                  <div class="col-md-4">
                    <center><label style="color:black" for="TypeIdentification" class="form-label">Tipo De Identificación</label></center>
                    <input type="text" class="form-control bg-white" id="TypeIdentification" name="TypeIdentification"  value="<?php echo $DatosIncapacidad['TypeIdentification']; ?>"  readonly>
                    <!-- <select class="form-control select-Incapacidad" id="TypeIdentification">
                      <option class="option-Incapacidad" value="CC">Cedula Ciudadania</option>
                      <option class="option-Incapacidad" value="CE">Cedula Extranjera</option>
                      <option class="option-Incapacidad" value="TI">Tarjeta Identidad</option>
                    </select> -->
                  </div>

		  <div class="col-md-2"></div>

                  <div class="col-md-4">
                    <center><label style="color:black" for="IDNumberPaciente" class="form-label">Numero de identificación</label></center>
                    <input type="text" name="IDNumberPaciente" id="IDNumberPaciente" placeholder="" class="form-control bg-white" aria-describedby="helpId" min=0 required value="<?php echo $DatosIncapacidad['IDNumberPaciente']; ?>" readonly>
                  </div>

		  <div class="col-md-1"></div>

                </div>
                <br>

                <div class="row titles-Incapacidad">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider-Incapacidad"><span class="left-span"></span><span class="span">Datos de la Incapacidad</span></h4>
                    </div>
                  </div>
                </div>

                <div class="row row-Incapacidad"> 

                  <div class="col-md-2"></div>
                  <div class="col-md-3">
                      <center><label style="color:black" for="FechaExpedicion" class="form-label">Fecha expedición</label></center>
                      <input type="text" name="FechaExpedicion" id="FechaExpedicion" placeholder="Fecha expedicion" class="form-control bg-white" required value="<?php echo $fecha_actual?>" readonly>
                  </div>

                  <div class="col"></div>

                  <div class="col-md-3">
                      <center><label style="color:black" for="Lugar" class="form-label">Lugar De Expedición</label></center>
                      <input type="text" name="Lugar" id="Lugar" placeholder="Lugar" class="form-control bg-white" required value="<?php echo $DatosIncapacidad['Lugar']; ?>" readonly>
                  </div>
                  <div class="col-md-2"></div>

                </div>
		<br>

                <div class="row row-Incapacidad">
                  <div class="col-md-6">
                    <center><label style="color:black" for="GroupService" class="form-label">Grupos de servicios</label></center>
                    <select class="form-select select-Incapacidad" name="GroupService" id="GroupService" required>
                      <option class="option-Incapacidad" value="" hidden disabled selected>Seleccione un grupo</option>
                      <option class="option-Incapacidad" value="Consulta externa">Consulta externa</option>
                      <option class="option-Incapacidad" value="Apoyo diagnostico clinico y complementacion terapeutica">Apoyo diagnóstico clinico y complementacion terapeutica</option>
                      <option class="option-Incapacidad" value="Internacion">Internacion</option>
                      <option class="option-Incapacidad" value="Quirurgico">Quirurgico</option>
                      <option class="option-Incapacidad" value="Atencion Inmediata">Atencion Inmediata</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <center><label style="color:black" for="ModelService" class="form-label">Modalidad de la prestacion de servicio</label></center>
                    <select class="form-select select-Incapacidad" name="ModelService" id="ModelService" required>
                      <option class="option-Incapacidad" value="" hidden disabled selected>Seleccione una modalidad</option>
                      <option class="option-Incapacidad" value="Intramural">Intramural</option>
                      <option class="option-Incapacidad" value="Extramural unidad movil">Extramural unidad movil</option>
                      <option class="option-Incapacidad" value="Extramural domiciliaria">Extramural domiciliaria</option>
                      <option class="option-Incapacidad" value="Extramural jornada de salud">Extramural jornada de salud</option>
                      <option class="option-Incapacidad" value="Telemedicina interactiva">Telemedicina interactiva</option>
                      <option class="option-Incapacidad" value="Telemedicina no interactiva">Telemedicina no interactiva</option>
                      <option class="option-Incapacidad" value="Telemedicina telexperticia">Telemedicina telexperticia</option>
                      <option class="option-Incapacidad" value="Telemedicina telemonitoreo">Telemedicina telemonitoreo</option>
                    </select>
                  </div>
                  </div>
                  <br>

                  <div class="row row-Incapacidad">

                    <div class="col-md-6">
                      <center><label style="color:black" for="DiagnosticoP" class="form-label">Diagnostico Principal</label></center>
                      <select class="form-select select-Incapacidad" name="DiagnosticoP" id="DiagnosticoP" required>
                        <option class="option-Incapacidad" value="" disabled selected>Seleccione un diagnostico</option>
                        <?php 
                        if($Diagnosticos){
                          foreach($Diagnosticos as $Opt){
                            $CIE = $Opt['Cod_Diagnostico'] . ' - ' . $Opt['Diagnostico'];
                            echo '<option class="option-Incapacidad" value = "'.$CIE.'">'.$CIE.'</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                    
                    <div class="col-md-6">
                        <center><label style="color:black" for="DiagnosticoR" class="form-label">Diagnostico Relacionado</label></center>
                        <select class="form-select select-Incapacidad" name="DiagnosticoR" id="DiagnosticoR">
                          <option class="option-Incapacidad" value="Sin Diagnostico" selected>Seleccione un diagnostico</option>
                          <?php 
                          if($Diagnosticos){
                            foreach($Diagnosticos as $Opt){
                              $CIE = $Opt['Cod_Diagnostico'] . ' - ' . $Opt['Diagnostico'];
                              echo '<option class="option-Incapacidad" value = "'.$CIE.'">'.$CIE.'</option>';
                            }
                          }
                          ?>
                      </select>
                    </div> 

                  </div>
                  <br>

                <div class="row  row-Incapacidad">

                  <div class="col-md-4">
                    <center><label  style="color:black" for="OrigenIncapacidad" class="form-label">Presunto Origen de la incapacidad</label></center>
                    <div class="row">
                    <div class="col-md-6"  style="max-width: 50%">  
                    <label style="color:black; margin-left: 35%" for="Comun" class="form-label">Comun</label>
                      <input type="radio" style="margin-left: 15px" class="form-check-input" name="OrigenIncapacidad" id="Comun" value="Comun" checked> 
                    </div>

                    <div class="col-md-6"  style="max-width: 50%">  
                    <label style="color:black; margin-left: 25%" for="Laboral" class="form-label">Laboral</label>
                      <input type="radio" style="margin-left: 15px" class="form-check-input" name="OrigenIncapacidad" id="Laboral" value="Laboral"> 
                    </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <center><label style="color:black" for="CausaAtencion" class="form-label">Causa que motiva la atencion</label></center>
                    <input type="text" name="CausaAtencion" id="CausaAtencion" placeholder="Diligenciar segun presunto origen de incapacidad" class="form-control" required value="">
                  </div>

                  <div class="col-md-2" >
                    <center><label style="color:black" for="flexCheckChecked" class="form-label">Prorroga</label></center>
                    <div class="row flex-nowrap" id="prorroga">
                    
                      <div class="col-md-6" style="max-width: 50%">  
                       
                        <label style="color:black; margin-left: 40%" for="Si" class="">Si</label>
                        <input type="radio" style="margin-left: 15px" class="form-check-input" name="Prorroga" id="Si" value="Si">
                        
                      </div>
                      <div class="col-md-6" style="max-width: 50%">  
                        <label style="color:black; margin-left: 30%" for="No" class="form-label">No</label>
                        <input type="radio" style="margin-left: 15px" class="form-check-input" name="Prorroga" id="No" value="No" checked> 
                      </div>
                    </div>
                  </div>

                </div>
                <br>

                <br>

                <div class="row titles-Incapacidad">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider-Incapacidad"><span class="left-span"></span><span>Datos del Medico</span></h4>
                    </div>
                  </div>
                </div>

                  <div class="row  row-Incapacidad">

                    <div class="col-md-6">
                      <center> <label for="NombreMedico" style="color:black" class="form-label">Nombre completo del Medico que expide</label></center>
                      <input type="text" onkeydown="return /[a-z, ]/i.test(event.key)" name="NombreMedico" id="NombreMedico" placeholder="---" class="form-control bg-white" required value="<?php echo $DatosIncapacidad['NombreMedico']; ?>" readonly>
                    </div>

                    <div class="col-md-3">
                      <center><label for="TipoIDMedico" style="color:black" class="form-label">Tipo De Identificacion</label></center>
                      <input type="text" name="TipoIDMedico" id="TipoIDMedico" placeholder="---" class="form-control bg-white" required value="<?php echo $DatosIncapacidad['TipoIDMedico']; ?>" readonly>
                      <!-- <select class="form-control select-Incapacidad" id="TypeIdenticationM">
                        <option class="option-Incapacidad" value="NN" selected>Seleccione una opcion</option>
                        <option class="option-Incapacidad" value="CC">Cedula Ciudadania</option>
                        <option class="option-Incapacidad" value="CE">Cedula Extranjera</option>
                        <option class="option-Incapacidad" value="TI">Tarjeta Identidad</option>
                      </select> -->
                    </div>

                    <div class="col-md-3">
                      <center><label for="IDNumberMedico" style="color: black" class="form-label">Numero identificacion</label></center>
                      <input type="number" name="IDNumberMedico" id="IDNumberMedico" placeholder="Ingrese el numero de identificacion" class="form-control bg-white" aria-describedby="helpId" min=0 required value="<?php echo $DatosIncapacidad['IDNumberMedico']; ?>" readonly>
                    </div>

                  </div>
                  <br>          
                  
                <div class="row  row-Incapacidad">
                  <div class="col"></div>
                  <div class="col-md-4">
                    <center><label for="Registro" style="color: black" class="form-label">Registro</label></center>
                    <input type="text" name="Registro" id="Registro" class="form-control bg-white" aria-describedby="helpId" min=0 required value="<?php echo $DatosIncapacidad['Registro']; ?>" readonly>
                  </div>

                  <div class="col"></div>
                  <div class="col-md-4">
                    <center><label for="Especialidad" style="color: black" class="form-label">Especialidad</label></center>
                    <input type="text" name="Especialidad" id="Especialidad" class="form-control bg-white" aria-describedby="helpId" min=0 required value="<?php echo $DatosIncapacidad['Especialidad']; ?>" readonly>
                  </div>
                  <div class="col"></div>

                </div>

                  <br>

                  <div class="row row-Incapacidad">                    
                    <div>
                      <center><button type="submit" id="AgregarIncapacidadButton" name="AgregarIncapacidadButton"  class="btn" style="background-color: #428E3F; color:white" >Registrar Incapacidad</button></center> 
                    </div>
                    <div class="col-md-1"></div>
                  </form>
              </div>
            </div>
         </div>
        </div>
      </div>
</div>


<?php
}
else
{
  if($_SESSION['ObservarIncapacidades']==1){
    header("Location: ConsolidadoIncapacidad.php");
  }else{
    require '../../../view/noacceso.php';
  }
  
}
require_once '../../../view/template/footer.php';
?>


<?php 
}
ob_end_flush();
?>



<script>

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
        title: 'No es posible realizar Incapacidad',
        text: 'Para realizar una incapacidad, por favor ingrese desde el modulo de SAP',
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


  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="../Control/JS/CrearIncapacidadControl.js"></script>
