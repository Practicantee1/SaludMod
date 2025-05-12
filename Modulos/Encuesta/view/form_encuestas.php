<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

if(session_id() === "") session_start();

foreach ($_GET as $key => $value) {
   $_SESSION[$key] = $value;
}

include("../control/ImplantesV2.php");

if (!isset($_SESSION["nombre"])) {

  $_SESSION["PrePage"] = "../../Encuesta/view/form_encuestas.php";
  header("Location: ../../../view/login.php");
} else {
  define('BASE_URL', '../../');
  $pageTitle = "Registro de implantes";

  require_once '../../../view/template/header.php';

  if ($_SESSION['implantes'] == 1) {

?>
    <div class="content-wrapper">
      <div id="alertContainer" class="alert" role="alert"></div>
      <!--- Content Header (Page header) ----->
      <div class="container" style="overflow-y: hidden">
        <div class="col-md-15">
          <div class="card shadow p-3 mb-8">
            <div class="card-header">
              <div class="row" id="MainTittle-UbiCitas">
                <div class="col-20 text-center" style="top: -15px;">
                  <h2 class="text-success" style="margin-top: 15px;">Evaluación continua de implantes</h2>
                </div>
              </div>
              <div class="container">
                <br>
                <button type="button" class="btn btn-primary" id="loadModalButton" data-bs-toggle="modal" data-bs-target="#registroModal">
                  <i class="fa-solid fa-circle-info"></i> Ver registros de este episodio
                </button>

                <!-- Modal -->
                <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Registros de este episodio
                        </h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                      </div>
                      <div class="modal-body">
                        <div style="margin-top: 6%">

                          <h1 class="page-header">Evaluación continua de implantes
                            <small>Reportes</small>
                          </h1>

                          <div class="row">
                            <div class="col-md-12">
                              <div class="panel panel-primary">
                                <div class="panel-heading"> <b><span class="glyphicon glyphicon-list-alt"></span>
                                    Resultados por episodio </b></div>
                                <div class="panel-body">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <table class="table table-responsive table-stripped">
                                        <thead>
                                          <tr>
                                            <th>Número de episodio</th>
                                            <th>Número único paciente</th>
                                            <th>Nombres del paciente</th>
                                            <th>Fecha de registro</th>
                                            <th>Médico cirujano responsable</th>
                                            <th>Detalles</th>
                                          </tr>
                                          <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                          </tr>

                                        </thead>

                                        <body>

                                        </body>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="loadModalButtonCerrar" data-bs-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                      </div>
                    </div>
                  </div>
                </div>

                <br>

                <div class="content-div1">

                  <div class="col-md-12">

                    <div class="row">
                      <div class="col-md-12">
                        <div class="panel panel-success">
                          <div class="well">
                            <h4 class="form-label text-divider-UbiCita"><span class="left-span"></span><span>INFOMRACIÓN GENERAL</span></h4>
                          </div>

                          <br>
                          <div class="panel-body">
                            <!--Fila 1-->
                            <form id="formulario_implantes" method="POST" action="../../Encuesta/control/ControlInicial.php" target="_blank"> <!-- en cuestiones de consumo de la API siempre implementar el atributo action para definir la ruta donde estoy trayendo la informació -->
                              <div class="well">
                                <div class="row">
                                  <div class="col-md-4">
                                    <label>Número de episodio</label>
                                    <input type="number" id="episodio" class="form-control rqr" name="episodio" value="<?php echo $PersonalData['Episodio']; ?>" required readonly>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Número de documento</label>
                                    <input readonly type="text" id="idNumeroDocumento" class="form-control rqr" name="idNumeroDocumento" value="<?php echo $PersonalData['Documento']; ?>" required>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Número interno del paciente</label>
                                    <input readonly type="text" id="idNumeroInterno" class="form-control rqr" name="idNumeroInterno" value="<?php echo $PersonalData['Episodio']; ?>">
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-4">
                                    <label>Nombres del paciente</label>
                                    <input readonly type="text" class="form-control rqr" id="idNombrePaciente" name="idNombrePaciente" value="<?php echo $PersonalData['Nombre']; ?>">
                                  </div>
                                  <div class="col-md-4">
                                    <label>Diagnóstico</label>
                                    <select id="Diagnostico" class="form-control" id="idDiagnostico" style="width: 100%; height: 50%;" name="idDiagnostico">
                                    <?php 
                                      if($Diagnosticos){
                                        foreach($Diagnosticos as $Opt){
                                        $CIE = $Opt['Cod_Diagnostico'] . ' - ' . $Opt['Diagnostico'];
                                        echo '<option value = "'.$CIE.'">'.$CIE.'</option>';
                                        }
                                      }
                                    ?>
                                    </select>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Aseguradora</label>
                                    <input readonly type="text" class="form-control rqr" id="idAsegurador" name="asegurador" value="<?php echo $PersonalData["Aseguradora"] ?>">
                                  </div>
                                </div>
                                <br>
                                <div class="row">
                                  <div class="col-md-4">
                                    <label>Nombre del cirujano</label>
                                    <input type="text" class="form-control rqr fechasDP" id="idNombreCirujano" name="idNombreCirujano" value="<?php echo $PersonalData["NombreMedico"]?>" readonly required>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Especialidad</label>
                                    <input readonly type="text" class="form-control" id="idEspecialidad" name="idEspecialidad" value="<?php echo $PersonalData["Especialidad"] ?>" required>
                                  </div>
                                  <div class="col-md-4">
                                    <label>Fecha de la cirugía</label>
                                    <input type="text" class="form-control" id="fecha" name="Fecha" placeholder="dd/mm/yyyy" readonly required>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" id="idObservaciones" name="observaciones"></textarea>
                                  </div>
                                </div>
                                <input type="hidden" name="EpisodioInicial" id="EpisodioInicial" value="<?php echo $PersonalData["Episodio"] ?>">
                              </div>
                            </form>
                          </div>
                        </div>

                      </div>
                    </div>





                  </div>

                  <div class="well">
                    <h4 class="form-label text-divider-UbiCita"><span class="left-span"></span><span>INFOMRACIÓN DEL IMPLANTE</span></h4>
                  </div>
                  <br>




                  <div class="container mt-5">
                    <!-- <button style="float: right;" class="btn btn-success" onclick="duplicarLinea()">Añadir</button> -->

                    <form id="miFormulario">
                      <div id="lineas-container">
                        <div class="row form-section" style="border-bottom: 3px solid #306A42; margin: 5px 0;">
                          <div class="row">
                            <div class="col-md-4">

                              <label>Tipo.implante</label>
                              <select class="form-control" style="width: 100% ; height: 50%;" name="infTipoImplante" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>



                              </select>
                            </div>

                            <div class="col-md-4">
                              <label>Casa comercial</label>
                              <select class="form-control" style="width: 100% ; height: 50%;" name="infCasaComercial" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="1">AMAREY NOVA MEDICAL S.A.</option>
                                <option value="2">AVALON PHARMACEUTICAL S.A.</option>
                                <option value="3">B.BRAUN MEDICAL S.A.</option>
                                <option value="4">B.H. SALUD S.A.</option>
                                <option value="5">BIOART S.A</option>
                                <option value="6">BONETECH S.A.S</option>
                                <option value="7">DISORTHO SA</option>
                                <option value="8">DISTRIBUCIONES P&amp;T SAS</option>
                                <option value="9">DIVERQUIN S.A.S.</option>
                                <option value="10">EDM EQUIPOS Y DISPOSITIVOS MEDICOS SAS
                                </option>
                                <option value="11">FUNDACION ORGANIZACION VID</option>
                                <option value="12">GIL MEDICA S.A.</option>
                                <option value="13">HOSPIMPORT S.A.</option>
                                <option value="14">IDEAS MEDICAS S.A.S</option>
                                <option value="15">IMPLANTECH LTDA</option>
                                <option value="16">IMPLANTES Y SISTEMAS ORTOPEDICOS S.</option>
                                <option value="17">INBIOS SAS</option>
                                <option value="18">INDUSTRIAS MEDICAS SAMPEDRO S.A.S.</option>
                                <option value="19">IVAN PADILLA DENTAL CORPORATION SAS</option>
                                <option value="20">JOHNSON &amp; JOHNSON DE COLOMBIA S.A
                                </option>
                                <option value="21">LA INSTRUMENTADORA SAS</option>
                                <option value="22">LH S.A.S</option>
                                <option value="23">MEDIHUMANA COLOMBIA S.A.</option>
                                <option value="24">MEDINISTROS S.A.S</option>
                                <option value="25">MEDIREX S.A.S</option>
                                <option value="26">MEDITECX SAS</option>
                                <option value="27">MEDTRONIC COLOMBIA SA</option>
                                <option value="28">OSEOMED S A S</option>
                                <option value="29">OSTEOMEDICAL S.A.S</option>
                                <option value="30">QUIRURGICOS LTDA.</option>
                                <option value="31">R.P. DENTAL S.A</option>
                                <option value="32">SMITH &amp; NEPHEW COLOMBIA S.A.S</option>
                                <option value="33">SUMINEURO S.A.S</option>
                                <option value="34">SUPLEMEDICOS S.A.S.</option>
                                <option value="35">W LORENZ S.A.S</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label>Entrenamiento del soporte</label>
                              <select class="form-control" style="width: 100% ; height: 50%;" name="infEntrenamientoSoporte" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <br>
                            <br>
                          </div>
                          <br>
                          <br>

                          <div class="row">
                            <div class="col-md-4">
                              <label>Llega a tiempo soporte</label>
                              <select class="form-control" style="width: 100% ; height: 50%;" name="infLlegaTiempoSoporte" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label>Material completo</label>
                              <select class="form-control" style="width: 100% ; height: 50%;" name="infMaterialCompleto" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label>Falla del impl. en cx</label>
                              <select class="form-control" style="width: 100% ; height: 50%;" name="infFallaImpl" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <br>
                            <br>

                          </div>
                          <br>
                          <br>
                          <div class="row">
                            <div class="col-md-4">
                              <label>Impl. llega a tiempo (Corpaul)</label>
                              <select class="form-control" style="width: 100%; height: 50%;" name="infImplLlegaTiempo" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label>Impl. llega completo (Corpaul)</label>
                              <select class="form-control" style="width: 100%; height: 50%;" name="infImplLlegaCompleto" onchange="evaluarSeleccion(this)">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                              </select>
                            </div>

                          </div>
                          <div class="col-md-4">
                            <button style="float: right 100%;" type="button" class="btn btn-danger mt-4" onclick="eliminarLinea(this)"><i class="fa-solid fa-trash"></i></button>


                          </div>
                          <div>
                            <br>
                            <br>
                          </div>



                        </div>
                      </div>
                    </form>
                    <div style="display: flex; justify-content: flex-end;">
                      <button class="btn btn-success" onclick="duplicarLinea()"><i class="fa-solid fa-plus"></i> Añadir</button>
                    </div>


                  </div>

                  <script>
                    function duplicarLinea() {
                      // Clonar el primer nodo dentro de lineas-container
                      var container = document.getElementById('lineas-container');
                      var lineaOriginal = container.firstElementChild;
                      var nuevaLinea = lineaOriginal.cloneNode(true);

                      // Limpiar valores seleccionados de los nuevos selects
                      var selects = nuevaLinea.getElementsByTagName('select');
                      for (var i = 0; i < selects.length; i++) {
                        selects[i].selectedIndex = 0; // Restablecer a la opción por defecto
                      }

                      // Agregar la nueva línea al contenedor
                      container.appendChild(nuevaLinea);
                    }

                    function eliminarLinea(button) {
                      // Eliminar la línea que contiene el botón
                      var linea = button.parentNode.parentNode;
                      linea.parentNode.removeChild(linea);
                    }
                  </script>





                  <br>

                  <br>
                  <br>


                  <div style="display: flex; justify-content: center;">
                    <button type="button" class="btn btn-primary" id="Search-UbicacionPacientes" style="width: 20%;">Guardar información</button>
                  </div>
                  </>





                </div>
              </div>
            </div>
          </div>
        </div>





        <!--Acá va el modal-->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div id="barraTituloModal" style="color: white; font-weight: bold;" class="modal-header ">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="cabeceraModal" class="modal-title"></h4>
              </div>
              <div id="contenidoModal" class="modal-body">

              </div>
              <div class="modal-footer">
                <button type="button" id="botonclose" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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

    <!--<script src="../control/JS/Reloj.js"></script>-->
    <script src="../control/JS/ImplantesControl.js"></script>