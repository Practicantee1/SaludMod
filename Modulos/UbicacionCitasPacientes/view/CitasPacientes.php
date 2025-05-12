<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

    session_start();

    foreach ($_GET as $key => $value) {
        $_SESSION[$key] = $value;
    }

if (!isset($_SESSION["nombre"]))
{
    
  $_SESSION["PrePage"] = "../Modulos/UbicacionCitasPacientes/View/CitasPacientes.php";
  header("Location: ../../../view/login.php");
}
else
{
    define('BASE_URL', '../../');
    $pageTitle = "Consulta de Citas";
    $_SESSION['module_title'] = "CONTROL DE ACCESO";

require_once '../../../view/template/header.php';

if ($_SESSION['Consulta de Citas']==1)
{

?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/UbicacionCitasPacientes/View/CSS/UbicacionCitasPacientes.css">

<div class="content-wrapper">
    <div id="alertContainer" class="alert" role="alert"></div>
    <!--- Content Header (Page header) ----->
    <div class="container" style="overflow-y: hidden">
        <div class="col-md-15">
            <div class="card shadow p-15 mb-15">
                <div class="card-header"  style="background-color: transparent !important;" >
                    <!-- <div class="row" id="MainTittle-UbiCitas">
                        <div class="col-20 text-center" style="top: -15px;">
                            <h2 class="text-success" style="margin-top: 15px;">Consulta de Citas</h2>
                        </div>
                    </div> -->
                    <form method="POST" id="ConsultaCitaForm" target="_blank">
                        <div class="row titles-UbiCita">
                            <div class="col">
                                <div class="well">
                                    <h4 class="form-label text-divider-UbiCita">
                                        <span class="left-span"></span>
                                        <span class="span">Buscar Paciente</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row row-UbiCita">
                            <div class="col-md-3">
                                <center><label style="color:black" for="IDNumber" class="form-label">Documento del paciente:</label></center>
                                <input type="number" class="form-control" id="IDNumber" name="IDNumber">
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <center><label style="color:black" for="FullName"  class="form-label" name="episodio">Nombre Completo:</label></center>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="FullName"  name="FullName"  readonly>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-3 d-flex justify-content-center align-items-center">
                                <div class="tooltip-info">

                                    <button type="submit" id="Search-UbicacionPacientes" style="position:relative; margin-right: 140px; width:220px" class="btn btn-primary">
                                        <i class="fa-solid fa-magnifying-glass-location i-Ubicacion"></i>
                                        Buscar Paciente
                                    </button>
                                    <span class="tooltiptext">Consulte Aqui</span>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row row-UbiCita">
                            <div class="col-md-8">
                                <center><label style="color:black" for="Status" class="form-label">Estado:</label></center>
                                <input type="text" class="form-control" id="Status" name="Status" readonly>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-3">
                                <center><label style="color:black" for="Age" class="form-label">Edad:</label></center>
                                <input type="text" class="form-control" id="Age" name="Age" readonly>
                            </div>
                        </div> -->
                        <br>
                        <div class="row titles-UbiCita">
                            <div class="col">
                                <div class="well">
                                    <h4 id="citas" class="form-label text-divider-UbiCita">
                                        <span class="left-span"></span>
                                        <span class="span">Datos Citas</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mx-10px" bordered="1">
                            <table id="TablaIncapacidades" style="width: 100%;margin-left: auto; margin-right:auto" border="1" class="table rounded table-responsive table-striped text-center table-bordered-dark">
                            <thead class="thead-color" style="font-family:Arial, Helvetica, sans-serif">
                                <tr>
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Cita</th>            
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Número identificación paciente</th>
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre especialista</th>
                                <!-- <th class="text-center justify-content-center align-middle bg-success" scope="col">Especialidad</th> -->
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha Cita</th>
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Hora Cita</th>
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Lugarr</th>
                                <th class="text-center justify-content-center align-middle bg-success" scope="col">Consultorio</th>
                                </tr>
                            </thead>          
                            <nav aria-label="...">
                            <tbody id="table_body" style="font-family:Arial, Helvetica, sans-serif; font-size: 10px">
                            </tbody>
                            </table>  
                        </div>
                        <!-- <div class="row titles-UbiCita">
                            <div class="col">
                                <div class="well">
                                    <h4 class="form-label text-divider-UbiCita">
                                        <span class="left-span"></span>
                                        <span>Ubicacion Paciente</span>
                                    </h4>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="row row-UbiCita" style="margin-bottom: 40px">
                            <div class="col-md-2">
                                <center><label style="color:black" for="DateServiceStarted" class="form-label">Fecha Ingreso:</label></center>
                                <input type="text" class="form-control" id="DateServiceStarted" name="DateServiceStarted" readonly>
                            </div>
                            <div class="col-md-6">
                                <center><label style="color:black" for="Ward" class="form-label">Sala:</label></center>
                                <input type="text" class="form-control" id="Ward" name="Ward" readonly>
                            </div>
                            <div class="col-md-4">
                                <center><label style="color:black" for="Bed" class="form-label">Cama:</label></center>
                                <input type="text" class="form-control" id="Bed" name="Bed" readonly>
                            </div>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
}
else
{
  require '../../../view/noacceso.php';
}

require_once '../../../view/template/footer.php';
?>

<?php 
}
ob_end_flush();
?>

<script>
  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>

<!-- Oculto la tabla con la única condición de que tiene que aparecer cuando doy click en el botón "Buscar Paciente", ahora si en dado caso
el usuario da click en el botón y no ingresó ningún documento, la tabla va a seguir siendo oculta y este le mostrará una advertencia para que
ingrese el número de documento. -->
<script>
  $(document).ready(function () {
    document.getElementById("TablaIncapacidades").style.display = 'none';
    document.getElementById("citas").style.display ='none';
    $("#Search-UbicacionPacientes").click(function(){
      let IDNumber = document.getElementById("IDNumber").value;

      if(IDNumber.trim()===''){                                                     
        Swal.fire({
          icon: "warning",
          text: "Debes ingresar un número de Identificación",
          showConfirmButton: false,
          timer: 2000
        });
      }else{
        document.getElementById("citas").style.display ='block';
        document.getElementById("TablaIncapacidades").style.display = 'block';
      }
    });
  });
</script>

<script src="../Control/JS/CitasControl.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>