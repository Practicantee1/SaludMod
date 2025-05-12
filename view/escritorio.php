<?php
//Activamos el almacenamiento en el buffer
include('../config/Conexion.php');
ob_start();

session_start();

$parameters = http_build_query($_GET);

if (!isset($_SESSION["nombre"]))
{
  $_SESSION["PrePage"] = "../view/escritorio.php";
  header("Location: login.php". "?" . $parameters);
}
else
{
  define('BASE_URL', '');
  $pageTitle = "Pagina Principal";
  $_SESSION['module_title'] = "Bienvenido a SaludMod";

require 'template/header.php';

if ($_SESSION['Escritorio']==1)
{

  $_SESSION["param"] = $_GET["param"];


?>

<br>
<style>
#card-escritorio {
    padding: 0;
    background-image: url("../view/public/images/fondo.png");
    background-size: 100%; 
    background-position: center;
    background-repeat: no-repeat;
    height: 512px;
    color: #fff;
    display: flex;
    align-items: center;
    width: 100%;
    overflow: hidden;   
    border-radius: 27px;
}

#bienvenida-escritorio {
    color: #fff; /* Color del texto */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombra del texto */
    font-size: 2em; /* Tamaño del texto (opcional) */
}

  #bienv-cont {
    margin-left: 10px;
    border-radius: 4px;
    padding:0 5px; 
}

#content-escritorio{
  height: 80vh;
  display: flex;
  align-items: center;
  overflow-y: hidden;
  background-color: #fff;
}

@media (max-width: 768px) { /* Ajusta según el tamaño de pantalla o condiciones que prefieras */
    #card-escritorio {
        background-image: url('../view/public/images/fondo-peq.png');
        background-size: cover; 
        background-position: center;
    }
}

</style>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
    <div id="content-escritorio" class="content-wrapper">        
      <div class="col-md-12">
        <div id="card-escritorio" >
          <div id="bienv-cont">
            <h2 id="bienvenida-escritorio">BIENVENID@ <?php echo $_SESSION['nombre']?></h2>     
            </div>
        </div>
      </div>
    </div>
<?php
}
else
{
  require 'noacceso.php';
}

require 'template/footer.php';
?>

<?php 
}
ob_end_flush();
?>

<script>
console.log("<?php echo $_SESSION["param"]?>")

  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>