<?php
// Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();
session_start();

foreach ($_GET as $key => $value) {
  $_SESSION[$key] = $value;
}

if (!isset($_SESSION["nombre"])) {
  $_SESSION["PrePage"] = "../Modulos/UbicacionCitasPacientes/View/Modulos/UbicacionCitasPacientes/view/agregarRestriccionesRiesgos.php";
  header("Location: ../../../view/login.php");
} else {
  define('BASE_URL', '../../');
  $pageTitle = "Registro de Restricciones y Riesgos";
  $_SESSION['module_title'] = "CONTROL DE ACCESO";
  require_once '../../../view/template/header.php';

  if ($_SESSION['ubi_AgregarRestriccion'] == 0) {
?>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/UbicacionCitasPacientes/View/CSS/agregarRestriccionesRiesgos.css">



    <div class="content-wrapper">
      <div id="alertContainer" class="alert" role="alert"></div>
      <!---Content Header (Page header)----->
      <div class="container">
        <div class="col-md-15">
          <div class="card shadow p-3 mb-8">
            <div class="card-header" style="background-color: transparent !important;">
              <div class="modal-header">
                <h2 class="card-title text-center text-white bg-success py-3 rounded shadow w-100">
                  <i class="bi bi-file-earmark-text"></i> Registro de Restricciones y Riesgos por Paciente
                </h2>
              </div>


              <!-- Modal para Restricciones -->
              <form action="fromPersonas" class="formRestricciones">
                <div class="modal fade" id="modalRestricciones" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
                  <input type="hidden" name="action" value="addRestriction">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content border-success custom-modal">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="modalTitulo">Restricciones Por Paciente</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <form id="formRestricciones" name="formRestricciones">
                          <div class="row titles-UbiCita">
                            <div class="col">
                              <div class="well">
                                <h4 class="form-label text-divider-UbiCita">
                                  <span class="left-span"></span><span>Buscar Paciente por Episodio</span>
                                </h4>
                              </div>
                            </div>
                          </div>

                          <br>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="episodioPaciente" class="form-label">Episodio Paciente</label>
                              <input type="text" class="form-control border-success" id="episodioPaciente" name="episodioPaciente" required>
                            </div>

                            <div class="col-md-6">
                              <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                              <input type="text" readonly class="form-control border-success" id="tipoDocumento" name="tipoDocumento" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="numeroDocumento" class="form-label">Número de Documento</label>
                              <input type="text" readonly class="form-control border-success" id="numeroDocumento" name="numeroDocumento" required>
                            </div>

                            <div class="col-md-6">
                              <label for="nombresCompletos" class="form-label">Nombres Completos</label>
                              <input type="text" readonly class="form-control border-success" id="nombresCompletos" name="nombresCompletos" required>
                            </div>
                          </div>

                          <div class="row titles-UbiCita">
                            <div class="col">
                              <div class="well">
                                <h4 class="form-label text-divider-UbiCita">
                                  <span class="left-span"></span><span>Datos del Usuario a Restringir</span>
                                </h4>
                              </div>
                            </div>
                          </div>

                          <br>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="tipoDocumentoAcomp" class="form-label">Tipo de Documento</label>
                              <select class="form-select border-success" id="tipoDocumentoAcomp" name="tipoDocumentoAcomp" required>
                                <option value="">Seleccione...</option>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="TI">Tarjeta de Identidad</option>
                                <option value="CE">Cédula de Extranjería</option>
                              </select>
                            </div>

                           
                            <div class="col-md-6">
                              <label for="numeroDocumentoAcompanate" class="form-label">Número de Documento Acompañante</label>
                              <input type="text" class="form-control border-success" id="numeroDocumentoAcompanate" name="numeroDocumentoAcompanate" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="nombresCompletosAcomp" class="form-label">Nombres Completos Acompañante</label>
                              <input type="text" class="form-control border-success" id="nombresCompletosAcomp" name="nombresCompletosAcomp" required>
                            </div>

                            <div class="col-md-6">
                              <label for="tipoRestriccion" class="form-label">Tipo de Restricción</label>
                              <select class="form-select border-success" id="tipoRestriccion" name="tipoRestriccion" required>
                                <option value="">Seleccione...</option>
                                <option value="1">Acceso Restringido</option>
                                <option value="2">Acceso Permitido</option>
                                <option value="3">Acceso Condicional</option>
                              </select>
                            </div>
                          </div>

                          <div class="text-center">
                            <button class="btn btn-success" id="btn-guardar-rs"><i class="bi bi-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </form>


              <!-- Modal para Riesgos -->
              <!-- Modal para Riesgos -->
              <form action="fromPersonas" class="formRiesgos">
                <div class="modal fade" id="modalRiesgos" tabindex="-1" aria-labelledby="modalTitulo" aria-hidden="true">
                  <input type="hidden" name="action" value="addRisk">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content border-success custom-modal">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="modalTitulo">Riesgos Por Paciente</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>

                      <div class="modal-body">
                        <form id="formRiesgos" name="formRiesgos">
                          <div class="row titles-UbiCita">
                            <div class="col">
                              <div class="well">
                                <h4 class="form-label text-divider-UbiCita">
                                  <span class="left-span"></span><span>Buscar Paciente por Episodio</span>
                                </h4>
                              </div>
                            </div>
                          </div>

                          <br>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="episodioPacienteRiesgos" class="form-label">Episodio Paciente</label>
                              <input type="text" class="form-control border-success" id="episodioPacienteRiesgos" name="episodioPacienteRiesgos" required>
                            </div>

                            <div class="col-md-6">
                              <label for="tipoDocumentoRiesgos" class="form-label">Tipo de Documento</label>
                              <input type="text" readonly class="form-control border-success" id="tipoDocumentoRiesgos" name="tipoDocumentoRiesgos" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="numeroDocumentoRiesgos" class="form-label">Número de Documento</label>
                              <input type="text" readonly class="form-control border-success" id="numeroDocumentoRiesgos" name="numeroDocumentoRiesgos" required>
                            </div>

                            <div class="col-md-6">
                              <label for="nombresCompletosRiesgos" class="form-label">Nombres Completos</label>
                              <input type="text" readonly class="form-control border-success" id="nombresCompletosRiesgos" name="nombresCompletosRiesgos" required>
                            </div>
                          </div>

                          <div class="row titles-UbiCita">
                            <div class="col">
                              <div class="well">
                                <h4 class="form-label text-divider-UbiCita">
                                  <span class="left-span"></span><span>Datos del Paciente - Riesgo</span>
                                </h4>
                              </div>
                            </div>
                          </div>

                          <br>
                          <div class="row mb-3">
                            <div class="col-md-12">
                              <label for="tipoRiesgo" class="form-label">Tipo de Riesgo</label>
                              <select class="form-select border-success" id="tipoRiesgo" name="tipoRiesgo" required>
                                <option value="">Seleccione...</option>
                                <option value="1">Riesgo de fuga</option>
                                <option value="2">Paciente con trastorno del desarrollo intelectual</option>
                                <option value="3">Paciente de custodia</option>
                                <option value="4">Paciente con riesgo de agresión</option>
                              </select>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-12">
                              <label for="observacionRiesgo" class="form-label">Observaciones</label>
                              <textarea class="form-control border-success" id="observacionRiesgo" name="observacionRiesgo" rows="3" required></textarea>
                            </div>
                          </div>

                          <div class="text-center">
                            <button class="btn btn-success" id="btn-guardar-rg"><i class="bi bi-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i> Cancelar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </form>


              <!-- Botones para abrir los modales -->
           
              <div class="d-flex justify-content-around mt-4">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRestricciones">
                  Registrar Restricción
               </button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRiesgos">
                  Registrar Riesgo
                </button>
              </div>


              <!-- Bootstrap CSS -->
              <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
              <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

              <!-- Bootstrap JS -->
              <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



            </div>
            </form>
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
















<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" rel="stylesheet">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<script src="../Control/JS/registroRestricciones.js"></script>
<script src="../Control/JS/UbicacionControl.js"></script>
<script src="../Control/JS/ControlAcceso.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>