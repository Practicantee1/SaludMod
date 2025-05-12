<?php

// //Activamos el almacenamiento en el buffer
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_implantes";


// $conexion2 = new mysqli($servername, $username, $password, $dbname);

// if ($conexion2->connect_error) {
//   die("Conexión fallida: " . $conexion2->connect_error);
// }
// //include_once("../../../logica/ApiSapV2.php");


ob_start();

//if(session_id() === "") 
session_start();
$parameters = http_build_query($_GET);



foreach ($_GET as $key => $value) {
   $_SESSION[$key] = $value;
   }




if (!isset($_SESSION["nombre"])) {
  //la redireccion sea para el form_encuesta

  $_SESSION["PrePage"] = "../Implantes?CH=1";
  header("Location: ../../../view/login.php"."?".$parameters);
} else {
  define('BASE_URL', '../../');
  $pageTitle = "Registro de implantes";
  $_SESSION['module_title'] = "REGISTRO DE IMPLANTES";


  require_once '../../../view/template/header.php';

  if ($_SESSION['registro implantes'] == 1) {
    if (isset($_GET["param"]) && $_GET["param"] !== "") {
      $_SESSION["param"] = $_GET["param"];
  }
  require '../../../logica/ApiURL.php';

  $_SESSION["param"] = "";



?>
    <div class="content-wrapper">
      <div id="alertContainer" class="alert" role="alert"></div>
      <!--- Content Header (Page header) ----->
      <div class="container" style="overflow-y: hidden">
        <div class="col-md-15">
          <div class="card shadow p-3 mb-8">
            <div class="card-header">
                            <div class="container">
                <br>       
              

                <div class="content-div1">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="panel panel-success">
                          <div class="well">
                            <h4 class="form-label text-divider-r"><span class="left-span"></span><span class="span">INFORMACIÓN GENERAL</span></h4>
                          </div>


                          <div class="panel-body">
                            <!-- Fila 1 -->
                            <form id="agregarLinea" method="POST" action="form_encuestas.php"> <!-- en cuestiones de consumo de la API siempre implementar el atributo action para definir la ruta donde estoy trayendo la información -->
                              <div class="well">
                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Número de episodio</label>
                                    <input readonly type="number" id="episodio" class="form-control rqr" name="episodio" required value="<?php echo $Doc; ?>">
                                  </div>
                                  <div class="col-md-6">
                                    <label>Número de documento</label>
                                    <input readonly type="text" id="idNumeroDocumento" class="form-control rqr" name="idNumeroDocumento" required>
                                  </div>                                  
                                </div>
                                <br>                                
                                <div class="row">
                                  <div class="col-md-6">
                                    <label>Nombres del paciente</label>
                                    <input readonly type="text" class="form-control rqr" id="idNombrePaciente" name="idNombrePaciente" required>
                                  </div>
                                  <br>
                                  <div class="col-md-6">
                                    <label>Aseguradora</label>
                                    <input readonly type="text" class="form-control rqr" id="idAsegurador" name="idAsegurador" required>
                                  </div>
                                  <div class="form-group col-md-1" hidden>
                                      <center><label style="color:black" for="centrosanitario" class="form-label">centrosanitario:</label></center>
                                      <input type="text" class="form-control" id="centrosanitario" name="centrosanitario" value="<?php echo isset($DatosIncapacidad['CentroSanitario']) && !empty($DatosIncapacidad['CentroSanitario']) ?$DatosIncapacidad['CentroSanitario']:''; ?>">
                                  </div>
                                </div>
                                
                                <br>
                                <div class="row">
                                  <div class="col-md-4">
                                    <label>Nombre del cirujano</label>
                                    <input readonly type="text" class="form-control rqr fechasDP" id="idNombreCirujano" name="idNombreCirujano" required value="<?php echo $DatosIncapacidad['NombreMedico']; ?>"
                                    >
                                  </div>

                                  <div class="col-md-4">
                                    <label>Especialidad</label>
                                    <input readonly type="text" class="form-control" id="idEspecialidad" name="idEspecialidad" required value="<?php echo $DatosIncapacidad['Especialidad']; ?>"
                                    >
                                  </div>
                                  <div class="col-md-4">
                                    <label>Fecha de la cirugía</label>
                                    <input type="DATE" class="form-control" id="Fecha" name="Fecha" placeholder="dd/mm/yyyy" required>
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" id="idObservaciones" name="observaciones"></textarea>
                                  </div>
                                </div>
                              </div>

                              <div class="well">
                                <h4 class="form-label text-divider-r"><span class="left-span"></span><span class="span">INFORMACIÓN DEL IMPLANTE</span></h4>
                              </div>

                              <div class="container mt-5">
                                <div id="lineas-container">
                                  <div class="row form-section" style="border-bottom: 3px solid #306A42; margin: 5px 0;">
                                    <div class="row" style="margin-bottom: 20px">
                                    <div class="col-md-12" id="d1">
                                        <label>Diagnóstico</label>
                                        <select class="form-control" name="idDiagnostico" style="width: 100%; height: 50%;">
                                            <!-- Opciones del select -->
                                        </select>
                                    </div>

                                    <div class="col-md-12" id="d2" style="display: none;">
                                        <label>Diagnóstico</label>
                                        <input type="text" class="form-control" name="idDiagnosticoT" style="width: 100%; height: 50%;">
                                    </div>

                                    <div align="right">
                                        <label for="checkboxAmbulatoria">
                                            <input type="checkbox" id="checkboxAmbulatoria" name="ambulatoria" value="1"> Ambulatoria
                                        </label>
                                    </div>


                                      <div class="col-md-6">
                                        <label>Casa comercial</label>
                                        <select class="form-control" name="infCasaComercial" id="infCasaComercial" required>
                                        <option value="" disabled selected>Seleccione la Casa Comercial</option>
                                          <?php
                                          include('../../../config/Conexion.php');

                                          // Verificar la conexión
                                          if ($conexion->connect_error) {
                                              die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
                                          }
                                          $consultarsala = "SELECT id_casa_comer, nombre_casaComer FROM tbl_casa_comercial  WHERE estado = '1' ORDER BY nombre_casaComer";
                                          $ejecutar = mysqli_query($conexion, $consultarsala);

                                          foreach ($ejecutar as $opciones): ?>
                                            <option value="<?php echo $opciones['id_casa_comer'] ?>">
                                              <?php $opciones['id_casa_comer'];
                                              echo $opciones['nombre_casaComer'] ?>

                                            </option>
                                          <?php endforeach ?>
                                        </select>
                                      </div>
                                      <div class="col-md-6">
                                        <label>Tipo implante</label>
                                        <input type="text" class="form-control" id="tipoImplante" style="width: 100%; height: 50%;" name="infTipoImplante" required>                   
                                        </input>
                                      </div>

                                    </div>

                                    <div class="row" style="margin-bottom: 20px">

                                      <div class="col-md-4">
                                        <label>Entrenamiento del soporte</label>
                                        <select class="form-control" style="width: 100%; height: 50%;" name="infEntrenamientoSoporte" id="infEntrenamientoSoporte" required>
                                          <option value="" disabled selected>Seleccione una opcion</option>
                                          <option value="si">Sí</option>
                                          <option value="no">No</option>
                                        </select>
                                      </div>
                                      <div class="col-md-4">
                                        <label>Llega a tiempo soporte</label>
                                        <select class="form-control" style="width: 100%; height: 50%;" id="infLlegaTiempoSoporte" name="infLlegaTiempoSoporte" required>
                                          <option value="" disabled selected>Seleccione una opción</option>
                                          <option value="si">Sí</option>
                                          <option value="no">No</option>
                                        </select>
                                      </div>
                                      <div class="col-md-4">
                                        <label>Material completo</label>
                                        <select class="form-control" style="width: 100%; height: 50%;" id="infMaterialCompleto" name="infMaterialCompleto" required>
                                          <option value="" disabled selected>Seleccione una opción</option>
                                          <option value="si">Sí</option>
                                          <option value="no">No</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 20px">
                                      <div class="col-md-4">
                                        <label>Falla del impl. en cx</label>
                                        <select class="form-control" style="width: 100%; height: 50%;" id="infFallaImpl" name="infFallaImpl" required>
                                          <option value="" disabled selected>Seleccione una opción</option>
                                          <option value="si">Sí</option>
                                          <option value="no">No</option>
                                        </select>
                                      </div>
                                      <div class="col-md-4">
                                        <label>Impl. llega a tiempo (Fomenthum)</label>
                                        <select class="form-control" style="width: 100%;" id="infImplLlegaTiempo" name="infImplLlegaTiempo" required>
                                          <option value="" disabled selected>Seleccione una opción</option>
                                          <option value="si">Sí</option>
                                          <option value="no">No</option>
                                        </select>
                                      </div>
                                      <div class="col-md-4">
                                        <label>Impl. llega completo (Fomenthum)</label>
                                        <select class="form-control" style="width: 100%; " id="infImplLlegaCompleto" name="infImplLlegaCompleto" required>
                                          <option value="" disabled selected>Seleccione una opción</option>
                                          <option value="si">Sí</option>
                                          <option value="no">No</option>
                                        </select>
                                      </div>
                                    </div>
                                    <br>
                                    <div class="col-md-1" style="margin: auto; margin-right: 5%; margin-bottom: 10px">
                                      <input type="submit" id="Search-UbicacionPacientes" class="btn" value="Añadir">
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </form> <!-- Cerrando correctamente la etiqueta form -->
                          </div>
                          <form method="POST" id="tablaimplantes" action="form_encuestas.php" style="margin: auto;">
                            <div class="row mb-12" style="margin: auto; margin-top: 50px;">
                              <table hidden id="table" style="margin: 0 auto;" class="table rounded table-responsive table-striped text-center table-bordered-dark">
                                <thead class="thead-color">
                                  <tr>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Numero episodio</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Numero documento</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre del paciente</th>                                    
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Aseguradora</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombre del cirujano</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Especialidad</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha de la cirugia</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">observaciones</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Diagnostico</th>                                    
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">ID de Casa Comercial</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Casa Comercial</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo implante</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Entrenamiento del soporte</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Llega a tiempo Soporte</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Material Completo</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Falla de implante en cx</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Implante llega a tiempo</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Implante llega completo</th>
                                    <th class="text-center justify-content-center align-middle bg-success" scope="col">Acciones</th>
                                  </tr>
                                </thead>
                                <nav aria-label="...">
                                  <tbody id="table_body">
                                    <!-- Se llena al presionar Añadir, JS/ImplantesV2.js-->
                                  </tbody>
                              </table>
                            </div>

                            <br>
                            <div id="contenedor-boton" class="col-md-5" style="margin: auto; width: 50%;">
                                <input type="submit" id="guardar_implantes" 
                                      name="agregar" 
                                      class="btn" 
                                      value="Enviar" 
                                      style="background-color: #04bd58; 
                                              color: white; 
                                              border: white; 
                                              padding: 10px 20px; 
                                              font-size: 16px; 
                                              border-radius: 5px;">
                            </div>
                          </form>
                        </div>
                        <br>
                      </div>
                    </div>
                  </div>
                </div>
              </div>






            </div>

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

    <!-- <script src="../control/JS/Reloj.js"></script> -->
    <script src="../control/JS/ImplantesControl.js"></script>
    <script src="../control/JS/GuardarImplantesControl.js"></script>
    <script src="../control/JS/registroImplantes.js"></script>