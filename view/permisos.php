<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
  define('BASE_URL', '');
  $pageTitle = "Permisos";
  $_SESSION['module_title'] = "PERMISOS";

require 'template/header.php';
if ($_SESSION['acceso']==1)
{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cssAdicionales/permisos.css">
</head>
<body>
  <div class="content-wrapper">
    <div id="alertContainer" class="alert" role="alert">
    </div>
    <div class="container">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8" style="padding: 20px !important;">
                <div class="well" style="margin:0">
                    <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style="background-color:#F4F6F9 ; padding: .5em">GESTION DE PERMISOS</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
      <div class="col-md-15">
          <div class="card shadow p-3 mb-8">
            <div class="grid" id="content-modulos">
              <div class="grid-container">
                <h5 class="titulo-modulo">Permisos Especiales <i class="fa-solid fa-chevron-down"></i></h5>
                <div class="submodulos-container" style="display: none;">
                    <div class="sub-container">
                        <div class="permisos-submodulo">
                            <?php 
                              // Ejecutar el procedimiento almacenado
                              $sql = "CALL SP_permisosEspeciales()";
                              $query = $conexion->query($sql);

                              // Verificar si hay resultados y generar las opciones del select
                              if ($query && $query->num_rows > 0) {
                                  while ($row = $query->fetch_assoc()) {
                                      echo '<label>' . $row['nombre'] . '</label>';
                                  }
                              } 
                              
                              // Liberar los resultados
                              $query->free();
                              
                              // Cerrar la conexión si no se necesita más
                              $conexion->close();
                            ?>
                            <button id="agregarPermiso" class="btn">Agregar permiso</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <div hidden id="modal-permiso" class="fondo-oscuro">
    <div class="fondo-claro">
      <div class="contenido-modal">
        <h4>Crear nuevo permiso</h4>
        <div class="input-content">
          <div class="form-group col-md-6 flex input-field">
            <input type="text" id="nombrePermiso" name="nroDoc" class="input" style="width: 100%;" required>
            <label for="nombrePermiso">Nombre del permiso:</label>
          </div>
        </div>
        <div>
          <button id="guardarPermiso" class="btn">Guardar</button>
          <button id="cancelarPermiso" class="btn" style="background-color: #ff2e2e;">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="scripts/permisos.js"></script>
</body>
</html>
<?php
}
else
{
  require 'noacceso.php';
}
require 'template/footer.php';
?>
<script type="text/javascript" src="scripts/permiso.js"></script>
<?php 
}
ob_end_flush();
?>