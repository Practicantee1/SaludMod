<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  $_SESSION["PrePage"] = "../Modulos/Incapacidades/ConsolidadoIncapacidad.php";
  header("Location: ../../../view/login.php");
}
else
{
    define('BASE_URL', '../../');
    $pageTitle = "Incapacidades";
    $_SESSION['module_title'] = "CONSULTAR INCAPACIDADES";


require_once '../../../view/template/header.php';

if ($_SESSION['Observar Incapacidades']==1)
{

  
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="margin-top: 100px;" id="ConsolidadoIncapacidadesContainer"> 
  

  <div class="container-fluid" id="RazonContainer" hidden>
    <div class="row" id="BannerRazon">
      <div class="col">
      <center><h2>¿Desea cancelar esta incapacidad?</h2></center>
      </div>
    </div>
    <div class="row" id="TextRazon">
      <div class="col">
          <center><label style="color:black" for="Razon" class="form-label">Razon de cancelación</label></center>
          <textarea name="Razon" id="Razon" rows="3" cols="20" placeholder="Razon" class="form-control" value=""></textarea>
      </div>
    </div>
    <div class="row" id="ButtonsRazon">
      <div class="col-md-2"></div>
      <div class="col-md-3">
        <button id="BackRazon" class="btn btn-danger" onclick="hideRazon();">No</button>
      </div>
      <div class="col-md-2"></div>
      <div class="col-md-3">
        <button id="FowardRazon" class="btn btn-success">Si</button>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>



  <form id="actualizarEstado" method="POST">
    <div class="modal fade" id="modal_estado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_estadoLabel">Estado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>  
          </div>

          <div class="modal-body">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <input type="submit" disabled id="actualizar" name="actualizar" class="btn btn-success" value="Actualizar"> 
          </div>

        </div>
      </div>
    </div>
  </form>

<div class="card shadow p-3 mb-8">
<div class="card-header">
   
         
    <br>

  <div class="row">    
    <div class="col-md-1"></div>
    <div class="col-md-4">
      <label for="DocumentoIncapacidad" class="form-label">Documento del paciente</label>
      <input id="DocumentoIncapacidad" class="form-control" type="text" value="" placeholder="">
    </div>
    <div class="col"></div>
    <div class="col-md-4 justify-content-center ">
      <button id="BuscarIncapacidad" class="btn btn-primary" type="number" placeholder=""><i class="fa-solid fa-magnifying-glass-arrow-right"></i>&nbsp;&nbsp;Buscar Incapacidad</button>
    </div>
    <div class="col-md-1"></div>
  </div>
    <br>

<div class="row" id="AlertNoRecord-Row" hidden>
  <div class="col-8" style="margin: auto;  min-width: 90%;">
    <center><h1> No se encontraron Incapacidades referentes al documento solicitado </h1></center>
  </div>
</div>
<div class="row" id="Table-Row" hidden>
  <div class="col-8" style="margin: auto;  min-width: 90%;">
    <table id="TablaIncapacidades" style="margin: 0 auto;  width: 100%" class="table rounded table-responsive table-striped text-center table-bordered-dark">
      <thead class="thead-color">
        <tr>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Acciones</th>            
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha de expedición</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre afiliado</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Diagnostico principal</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha inicial</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha final </th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Estado</th>
          <th class="text-center justify-content-center align-middle bg-success" scope="col">Razon</th>

        </tr>
      </thead>          
      <nav aria-label="...">
      <tbody id="table_body">
      </tbody>
    </table>  
  </div>
</div> 


</div>       
</div>

</div><!-- /.content-wrapper -->

  <!--Fin-Contenido-->
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

<script>
  function hideRazon(){
    document.getElementById("RazonContainer").hidden = true;
  }
</script>

<script>
document.getElementById("DocumentoIncapacidad").addEventListener("input", function() {
  var inputValue = this.value;
  var newValue = inputValue.replace(/\s/g, ""); // Remove spaces using regex
  this.value = newValue; // Set the input field value to the one without spaces
});
</script>

<script src="../../../view/scripts/usuario.js"></script>
<script src="../Control/JS/BuscarIncapacidad.js"></script>

