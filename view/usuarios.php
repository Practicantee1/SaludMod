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
$pageTitle = "Usuarios";
$_SESSION['module_title'] = "USUARIOS";
include '../config/Conexion.php';
require 'template/header.php';
if ($_SESSION['acceso']==1)
{
?>
<br>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">        
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h1 class="box-title">Usuarios 
                <button class="btn btn-success" id="btnagregar" onclick="mostrarform('Manual')"><i class="fa fa-plus-circle"></i> Agregar</button>
                <button class="btn btn-primary" id="btnAddGoogle" onclick="mostrarform('Google')"><i class="fa-brands fa-google-plus-g"></i>  Registrar</button>
              </h1>
            <div class="box-tools pull-right">
            </div>
            <br>
            </div>
                    <!-- /.box-header -->
                    <!-- centro -->
            <div class="panel-body table-responsive" id="listadoregistros">
              <table id="tbllistado" class="table table-bordered table-hover">
                <thead>
                  <th>Opciones</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th>Login</th>
                  
                  <th>Estado</th>
                </thead>
                <tbody>                            
                </tbody>
                <tfoot>
                  <th>Opciones</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Email</th>
                  <th>Login</th>
                  <th>Estado</th>
                </tfoot>
              </table>
            </div>
            <div class="panel-body" id="formularioregistros">
              <form name="formulario" id="formulario" method="POST">
                <div class="container">
                  <div class="row">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-6">
                      <label>Nombre(*):</label>
                      <input type="hidden" name="idusuario" id="idusuario">
                      <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Teléfono:</label>
                      <input type="number" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono" min=0>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Email:</label>
                      <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Cargo:</label>
                      <select  class="form-control" id="idCargos" name="cargo">
                        <?php 
                          // Verifica conexi�n
                          if ($conexion->connect_error) {
                            die("Conexi�n fallida: " . $conexion->connect_error);
                          }

                          // Ejecuta el procedimiento almacenado
                          $sql = "CALL SP_Cargos()";
                          $resultado = $conexion->query($sql);

                          // Verifica si hay resultados
                          if ($resultado->num_rows > 0) {
                              // Itera sobre los resultados
                              while ($fila = $resultado->fetch_assoc()) {
                                  echo '<option value="' . $fila['id'] . '">' . $fila['cargo'] . '</option>';
                              }
                          } else {
                              echo '<option value="">No hay cargos disponibles</option>';
                          }

                          // Cierra conexi�n
                          $conexion->close();
                          ?>
                      </select>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Usuario (*):</label>
                      <input type="text" class="form-control" name="login" id="login" maxlength="250" placeholder="Usuario" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Contraseña (*):</label>
                      <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Contraseña" required>
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Permisos:</label>
                      <ul style="list-style: none;" id="permisos">
                      </ul>
                    </div>

                          
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>        <!--Fin centro -->
            <div class="panel-body" id="formulariogoogle">
              <form name="formGoogle" id="formGoogle" method="POST">
                <div class="container">
                  <div class="row">
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Email:</label>
                      <input type="email" class="form-control" name="emailGoogle" id="emailGoogle" maxlength="50" placeholder="Email">
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                      <label>Permisos:</label>
                      <ul style="list-style: none;" id="rolesGoogle">
                      </ul>
                    </div>

                          
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <button class="btn btn-primary" type="submit" id="btnRegistrar"><i class="fa fa-save"></i>  Registrar</button>

                      <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div> 
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->

  </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}
require 'template/footer.php';
?>

<script type="text/javascript" src="scripts/usuario.js"></script>

<?php 
}
ob_end_flush();
?>