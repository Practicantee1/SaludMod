<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

session_start();

foreach ($_GET as $key => $value) {
  $_SESSION[$key] = $value;
}

if (!isset($_SESSION["nombre"])) {

  $_SESSION["PrePage"] = "../Modulos/UbicacionCitasPacientes/View/UbicacionPacientes.php";
  header("Location: ../../../view/login.php");
} else {
  define('BASE_URL', '../../');
  $pageTitle = "Control de acceso";
  $_SESSION['module_title'] = "CONTROL DE ACCESO PACIENTES";

  require_once '../../../view/template/header.php';

  if ($_SESSION['Ubicacion del paciente'] == 1) {

    header('Content-Type: text/html; charset=UTF-8');


?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/UbicacionCitasPacientes/View/CSS/UbicacionCitasPacientes.css">

    <div class="content-wrapper">
      <div id="alertContainer" class="alert" role="alert"></div>
      <!-- -Content Header (Page header) -->
      <div class="container">
        <div class="col-md-15">
          <div class="card shadow p-1 mb-1">
            <div class="card-header" style="background-color: transparent !important;">
              <!-- <div class="row"  id="MainTittle-UbiCitas">
                <div class="col-20 text-center top: -15px;">
                  <h2 class="text-success " style="margin-top: 15px;">Control de acceso</h2>
                </div>  
              </div>  -->



            </div>

            <div class="card shadow p-4 mb-3">
              <div class="card-header bg-transparent text-center">
                <h4 class="text-success fw-bold">Buscar Riesgos - Restricciones</h4>
              </div>

              <div class="row justify-content-center mt-3">
                <div class="col-md-10">
                  <div class="alert alert-success text-center p-3">
                    <p class="mb-2">
                      Verificar si un <strong>paciente</strong> presenta algún
                      riesgo que impida su salida o si un <strong>acompañante</strong> tiene restricciones
                      para ingresar a ver al paciente.
                    </p>
                    <p class="mb-0">
                      Ingresa el número de documento en el campo correspondiente y presiona
                      <strong>"Verificar"</strong> para obtener la información necesaria.
                    </p>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center mt-2">
                <div class="col-md-5">
                  <div class="form-container p-4 border rounded shadow-sm">
                    <form id="formVerificarAcceso" class="needs-validation" novalidate>
                      <div class="mb-3">
                        <label for="documentoA" class="form-label fw-semibold">Número de Documento:</label>
                        <div class="input-group">
                          <input type="text" id="documentoA" name="documentoA" class="form-control" style="border-radius: 4px;" required pattern="\d*" title="Por favor, ingrese solo números." />
                          <button type="submit" class="btn verificar-btn ms-2" id="btn-verificar">Verificar</button>
                        </div>
                        <div class="invalid-feedback">
                          Ingrese un número de documento válido.
                        </div>
                      </div>
                    </form>
                  </div>
                </div>




                <div class="row titles-UbiCita">
                  <div class="col">
                    <div class="well">
                      <h4 class="form-label text-divider-UbiCita"><span class="left-span"></span><span>Buscar Paciente</span></h4>
                    </div>

                  </div>
                </div>
                <div class="div-botones">
                  <button id="btn-Documento" class="btn">Consulta por Documento</button>
                  <button id="btn-Nombre" class="btn">Consulta por Nombre</button>
                  <button id="limpiarCampos" class="btn btn-light" style="color:#000;margin-top:auto;">Buscar Nuevo</button>
                </div>

                <!-- ************************************************************************************************************* -->




                <form method="POST" id="ConsultaUbicacionForm" action="../../UbicacionCitasPacientes/Control/ControlAcceso.php" target="_blank">
                  <div id="consulta-nombres" hidden class="div-inputs">
                    <div class="div-input">
                      <label for="">Primer Nombre</label>
                      <input id="nombre" class="form-control input-ubi" type="text">
                    </div>
                    <div class="div-input">
                      <label for="">Primer Apellido</label>
                      <input id="primerApellido" class="form-control input-ubi" type="text">
                    </div>
                    <div class="div-input">
                      <label for="">Segundo Apellido</label>
                      <input id="segundoApellido" class="form-control input-ubi" type="text">
                    </div>
                    <div class="div-input">
                      <label for="">Tipo de documento</label>
                      <input id="TipoDocumento" class="form-control input-ubi" type="text">
                    </div>
                    <div class="div-input">
                      <label for="">Numero de documento</label>
                      <input id="documento" class="form-control input-ubi" type="text">
                    </div>
                    <div class="div-input">
                      <button id="buscar-nombre" type="button" class="btn btn-primary" style="width: 30%;">Buscar</button>
                    </div>
                  </div>
                  <div hidden id="modal-tabla" class="fondo">
                    <bu class="fondo-blanco">
                      <h3 style="margin-bottom:20px; text-align:center;">Datos de Pacientes Relacionados</h3>
                      <div style="width: 100%;" id="tabla-conter"></div>
                      <a id="cerrar" class="btn">Cerrar</a>
                  </div>
              </div>

              <div hidden id="consulta-Documento" class="row  row-UbiCita">
                <div class="col-12 col-md-4">
                  <label for="IDNumber" class="form-label text-center w-100" style="color:black; ">Documento del paciente:</label>
                  <input type="text" class="form-control" id="IDNumber" name="IDNumber">
                </div>



                <div class="col-md-4">
                  <center><label style="color:black" for="FullName" class="form-label" name="episodio">Nombre Completo:</label></center>
                  <div class="input-group">
                    <input type="text" class="form-control" id="FullName" name="FullName" readonly>
                  </div>
                </div>

                <div class="col-md-1"></div>

                <div class="col-sm-2 d-flex justify-content-center align-items-center">
                  <div class="tooltip-info">
                    <button id="Search-UbicacionPacientes" data-toggle="tooltip" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass-location"></i>&nbsp;&nbsp;Buscar</button>
                    <span class="tooltiptext">Buscar Paciente</span>
                  </div>
                </div>

                <div class="col-md-4"></div>
                <!-- Nuevo bot n para abrir el modal de acompa antes -->

              </div>
              </form>

              <div class="col-md-4 d-flex justify-content-center align-items-center">
                <button class="btn btn-primary" id="Search-acompanante" data-bs-toggle="modal" data-bs-target="#exampleModalToggle" style="top: 10px " onclick="rellenar()"><i class="fa-solid fa-user-group"></i>&nbsp;&nbsp;Acompañantes</button>
                <small id="motivoDeshabilitado" style="color:red; display:none;">Botón deshabilitado: Riesgo o acceso denegado.</small>
              </div>



              <!-- Modal para mostrar los acompa antes registrados -->
              <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                  <div class="modal-content">
                    <div class="modal-header" style="background-color:#006941;">
                      <h5 class="modal-title" id="exampleModalToggleLabel" style="color:#fff;">Listado de Visitantes</h5>
                      <div class="tooltip-info">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="Close"><i class="fa-solid fa-xmark"></i></button>
                        <span class="tooltiptext">Cerrar</span>
                      </div>
                    </div>

                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                      <div class="table-responsive">
                        <table id="TablaIncapacidades" class="table table-striped table-hover">
                          <thead class="thea" style="background-color:rgb(29, 151, 78);">
                            <tr class="text-center">
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Seleccionar</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Foto</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col" style="display:none">Id</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">N° Identificación Paciente</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo Documento Acompañante</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Identificación Acompañante</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Nombres</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Apellidos</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Género</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Teléfono</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Dirección</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Tipo de Ingreso</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Fecha Ingreso</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Hora Ingreso</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Estado</th>
                              <th class="text-center justify-content-center align-middle bg-success" scope="col">Código Cama</th>
                            </tr>
                          </thead>
                          <tbody id="table_body"></tbody>

                        </table>
                      </div>
                    </div>

                    <!-- Pie de Modal -->
                    <div class="modal-footer d-flex justify-content-between">
                      <!-- Botón para modificar salida -->
                      <button type="button" style="width: 150px ; height: 40px ;" id="modificar_<?php echo $row['Id_Ingreso'];
                                                                                                ?>" name="modificar" class="btn btn-outline-danger modificar-btn" onclick="modificarEstado()">
                        <i class="fa-solid fa-person-walking-arrow-right"></i> Dar salida
                      </button>

                      <!-- Botón para agregar nuevo acompañante -->
                      <button class="btn " style="background-color:#0d9b62;" id="abrirModal"
                        data-bs-toggle="modal" data-bs-target="#exampleModalToggle2" data-bs-dismiss="modal">
                        <i class="fa-solid fa-plus"></i> Agregar
                      </button>

                      <div id="imageModal" class="modal-img">
                        <span class="close-img" onclick="closeModal()">&times;</span>
                        <img class="modal-content-img" id="modalImage">
                        <div id="caption"></div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

              <!-- aqui termina el moda de la lista de visitantes -->
              <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                <form class="modal-dialog modal-dialog-centered modal-lg" id="evento-acom" method="POST">
                  <div class="modal-content rounded-4 shadow-lg">
                    <!-- Encabezado del modal -->
                    <div class="modal-header bg-success text-white rounded-top-4">
                      <h5 class="modal-title" id="exampleModalToggleLabel2">Ingreso De Visitantes</h5>
                      <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Cuerpo del modal -->
                    <div class="modal-body">
                      <input type="hidden" class="form-control" name="IdNumero" id="IdNumero" readonly>

                      <!-- Tipo de documento -->
                      <div class="mb-3">
                        <label class="form-label">Tipo de documento:</label>
                        <select id="tipoDocumentoAcompanante" name="tipoDocumentoAcompanante" class="form-select border-success">
                          <option value="#">Seleccione una opción</option>
                          <option value="TI">Tarjeta de identidad</option>
                          <option value="Cedula">Cédula</option>
                        </select>
                      </div>

                      <!-- Número de identificación -->
                      <div class="mb-3">
                        <label class="form-label">Número de Identificación:</label>
                        <input type="number" class="form-control border-success" name="Id" id="Id">
                      </div>

                      <!-- Nombre y Apellido -->
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Nombre Completo:</label>
                          <input type="text" class="form-control border-success" name="NombreAcompanante" id="NombreAcompanante">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Apellido Completo:</label>
                          <input type="text" class="form-control border-success" name="ApellidoAcompanante" id="ApellidoAcompanante">
                        </div>
                      </div>

                      <!-- Género -->
                      <div class="mb-3">
                        <label class="form-label">Género:</label>
                        <select id="Genero" name="Genero" class="form-select border-success" required>
                          <option value="#">Seleccione una opción</option>
                          <option value="Masculino">Masculino</option>
                          <option value="Femenino">Femenino</option>
                          <option value="Otro">Otro</option>
                        </select>
                      </div>

                      <!-- Teléfono y Dirección -->
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Teléfono:</label>
                          <input type="number" class="form-control border-success" name="Telefono" id="Telefono">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label">Dirección:</label>
                          <input type="text" class="form-control border-success" name="Direccion" id="Direccion">
                        </div>
                      </div>

                      <!-- Tipo de visitante -->
                      <div class="mb-3">
                        <label class="form-label">Eres:</label>
                        <select id="compania" name="compania" class="form-select border-success" required>
                          <option value="">Seleccione una opción</option>
                          <option value="Acompañante">Acompañante</option>
                          <option value="Visitante">Visitante</option>
                        </select>
                      </div>

                      <!-- Captura de foto -->
                      <div class="mb-3 text-center">
                        <video id="video" autoplay class="border rounded-3 shadow-sm" style="width: 100%;"></video>
                        <canvas id="canvas" style="display: none;"></canvas>
                        <br>
                        <button class="btn btn-outline-success mt-2" id="boton">Tomar foto</button>
                      </div>

                      <!-- Datos ocultos -->
                      <input type="hidden" class="form-control" name="Fecha" id="Fecha" readonly>
                      <input type="hidden" type="date" class="form-control" name="Hora" id="Hora" readonly>
                      <input type="hidden" class="form-control" name="estado" id="estado" value="Activo" readonly>
                      <input type="text" class="form-control border-success" id="Bed_code" name="Bed_code" readonly>
                    </div>

                    <!-- Pie del modal -->
                    <div class="modal-footer d-flex justify-content-between">
                      <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i> Cerrar</button>
                      <button type="submit" id="success" class="btn btn-success"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>
                    </div>
                  </div>
                </form>
              </div>

              <br>
              <br>
              <div class="row titles-UbiCita">
                <div class="col">
                  <div class="well">
                    <h4 class="form-label text-divider-UbiCita"><span class="left-span"></span><span>Datos Del Paciente</span></h4>
                  </div>
                </div>
              </div>
              <div class="row row-UbiCita">
                <!-- <div class="col-md-2"> -->
                <div class="col-md-4">
                  <center><label style="color:black" for="Status" class="form-label">Estado:</label></center>
                  <input type="text" class="form-control" id="Status" name="Status" readonly>
                </div>
                <!-- <div class="col-md-2"></div> -->
                <div class="col-md-4">
                  <center><label style="color:black" for="DateServiceStarted" class="form-label">Fecha Ingreso:</label></center>
                  <input type="text" class="form-control" id="DateServiceStarted" name="DateServiceStarted" readonly>
                </div>
                <!-- <div class="col-md-2"></div> -->
                <div class="col-md-4">
                  <center><label style="color:black" for="Age" class="form-label">Edad:</label></center>
                  <input type="text" class="form-control" id="Age" name="Age" readonly>
                </div>
              </div>

              <div class="row titles-UbiCita">
                <div class="col">
                  <div class="well">
                    <h4 class="form-label text-divider-UbiCita"><span class="left-span"></span><span>Ubicacion Paciente</span></h4>
                  </div>
                </div>
              </div>

              <div class="row row-UbiCita" style="margin-bottom: 40px">
                <div class="col-md-4">
                  <center><label style="color:black" for="Block" class="form-label">Modulo:</label></center>
                  <input type="text" class="form-control" id="Block" name="Block" readonly>
                </div>
                <div class="col-md-4">
                  <center><label style="color:black" for="Ward" class="form-label">Sala:</label></center>
                  <input type="text" class="form-control" id="Ward" name="Ward" readonly>
                </div>

                <div class="col-md-4">
                  <center><label style="color:black" for="Bed" class="form-label">Cama:</label></center>
                  <input type="text" class="form-control" id="Bed" name="Bed" readonly>
                </div>

                <div class="col-md-0.2"></div>
                <div class="col-md-4">
                  <center><label style="color:black" for="Bed-code" class="form-label"></label></center>
                  <input type="hidden" class="form-control" id="Bedcode" name="Bedcode" readonly>
                </div>
              </div>




            </div>
            </form>
          </div>
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







<script>
  function mostrarAlerta(mensaje, tipo = "success") {
    // Elimina cualquier alerta previa
    $(".mi-alerta").remove();

    // Crea una nueva alerta de Bootstrap
    let alerta = `
        <div class="alert alert-${tipo} mi-alerta fade show position-fixed top-0 end-0 m-3 shadow" role="alert" style="z-index: 1050;">
            ${mensaje}
        </div>
    `;

    // Agregar la alerta al body
    $("body").append(alerta);

    // Ocultar la alerta después de 3 segundos
    setTimeout(() => {
      $(".mi-alerta").fadeOut(500, function() {
        $(this).remove();
      });
    }, 3000);
  }
</script>




<!-- esto es un ensayo -->
<script>
  //esto restablece la pagina al cerrar el modal de acompanates 
  document.addEventListener("DOMContentLoaded", function() {
    // Escuchar el evento cuando el modal se oculta (se cierra)
    let modal = document.getElementById("exampleModalToggle");
    modal.addEventListener("hidden.bs.modal", function() {
      // location.reload(); // Recargar la página
    });
  });

  $(document).ready(function() {
    $(document).ready(function() {
      $("#limpiarCampos").click(function() {
        // Limpiar los valores de los campos antes de la recarga
        $("#IDNumber").val("");
        $("#FullName").val("");
        $("#Status").val("");
        $("#DateServiceStarted").val("");
        $("#Age").val("");
        $("#Block").val("");
        $("#Bed").val("");
        $("#Bedcode").val("");
        $("#Close").val("");

        // Restablecer selects
        $("#compania").prop("selectedIndex", 0);

        // Habilitar botones si estaban deshabilitados
        $("#Search-acompanante").prop("disabled", false);
        // $("#btn-Documento").prop("disabled", false)
        //   .text("Buscar Documento")
        //   .removeClass()
        //   .addClass("btn btn-primary");

        // Ocultar alertas si hay alguna visible
        $(".alert").hide();

        // Hacer un pequeño retraso y recargar la página suavemente
        setTimeout(function() {
          location.reload(); // Recarga la página
        }, -100); // 0.5 segundos de retraso para suavizar la transición
      });
    });
  })
</script>


// <!-- esto es un ensayo -->

<script>
  function deshabilitaRetroceso() {
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button" //chrome
    window.onhashchange = function() {
      window.location.hash = "";
    }
  }
</script>

<script>
  function rellenar() {
    let Id = document.getElementById("IDNumber").value;
    document.getElementById("IdNumero").value = Id;

  }
</script>


<script>
  document.getElementById("Search-acompanante").addEventListener("click", function(event) {
    event.preventDefault(); // Previene el comportamiento predeterminado del bot n
  });
</script>


<script>
  /**
   * Este script maneja el evento de click en el elemento con ID 'success'.
   * Cuando se hace clic en el elemento, previene la acción predeterminada y realiza lo siguiente:
   * 
   * 1. Recupera el valor del ID del paciente del elemento con ID 'IdNumero'.
   *    Si el valor está vacío, lo recupera del elemento con ID 'documento'.
   * 2. Recupera el valor del ID del acompañante del elemento con ID 'Id'.
   * 3. Recupera el valor del nombre del acompañante del elemento con ID 'NombreAcompanante'.
   */
  $(document).ready(function() {
    $('#success').click(function(e) {
      e.preventDefault();

      let formValido = true;
      let mensaje = "";

      // Recorrer todos los inputs y selects dentro del modal
      $('#evento-acom input, #evento-acom select').each(function() {
        let valor = $(this).val().trim();

        // Si es un input vacío o un select con opción inválida
        if (valor === "" || valor === "#" || valor.toLowerCase().includes("seleccione")) {
          formValido = false;
          $(this).addClass("is-invalid"); // Resaltar campo incorrecto
        } else {
          $(this).removeClass("is-invalid"); // Quitar resalte si es válido
        }
      });

      if (!formValido) {
        Swal.fire({
          title: "❌ Error",
          text: "Por favor, complete todos los campos obligatorios.",
          icon: "error",
          background: "#fff5f5", // Fondo rojo clarito
          color: "#721c24", // Texto rojo oscuro
          showConfirmButton: false,
          timer: 2500,
          toast: true, // Si lo quieres como notificación pequeña
          position: "top-end", // Arriba a la derecha (cambia si lo quieres centrado)
          customClass: {
            popup: 'swal2-border-red'
          }
        });

      } else {
        guardarDatos(); // Llama a la función si todo está correcto
      }
    });
  });
</script>



<script>
  $(document).ready(function() {
    $('#Search-acompanante').click(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: '../Control/LlenarAcompaniante.php', //Ruta del archivo php que manejara la consulta a la base de datos.
        data: $("#ConsultaUbicacionForm").serialize(), //Pasa los registros del formulario al archivo PHP para realizar la consulta
        success: function(data) {
          $('#table_body').html(data); // donde se van a mostrar los datos en la tabla
          $('#exampleModalToggle').modal('show'); // Abre la ventana modal donde se encuentra la tabla
        }
      });
    });
  });
</script>

<script>
  function modificarEstado() {
    let selectedIds = [];

    $("#TablaIncapacidades input[type=checkbox]:checked").each(function() {
      let IdIngreso = $(this).closest("tr").find("td:eq(1)").text();
      selectedIds.push(IdIngreso);
    })

    if (selectedIds.length > 0) {
      Swal.fire({
        title: "¿Está seguro que desea cambiar el estado?",
        icon: "question",
        background: "#FFFFF", // Un verde muy suave
        color: "#155724", // Verde oscuro (texto)
        confirmButtonColor: "#28a745", // Botón verde
        confirmButtonText: "✅ Sí, cambiar",
        cancelButtonText: " ❌ Cancelar",
        showCancelButton: true,
        allowOutsideClick: false,
        customClass: {
          popup: 'swal2-border-green' // Clase personalizada para bordes o estilos extra
        }
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: "../Control/ActualizarEstado.php",
            data: {
              selectedIds: selectedIds
            }, // Manda los IDs almacenador al archivo php d nde se le va a ejecutar la inyecci n SQL
            success: function(response) {
              console.log(response);
              Swal.fire({
                icon: "success",
                title: "✅ El acompañante puede salir",
                background: "#ffffff", // Verde claro de fondo
                color: "#155724", // Texto verde oscuro
                toast: true,
                position: "top-end", // Arriba a la derecha
                showConfirmButton: false,
                timer: 3000, // Un poco más de tiempo para que se vea
                customClass: {
                  popup: 'swal2-border-green' // Si quieres darle un borde verde adicional
                }
              });
              setTimeout(function() {
                window.location.href = "UbicacionPacientes.php";
              }, 2000);
            }
          });
        }
      });
    } else {
      Swal.fire({
        icon: "warning",
        title: "No se han seleccionado acompañantes",
        showConfirmButton: false,
        timer: 2000
      });
    }
  }
</script>

<script>
  $(document).ready(function() {
    $("#Search-acompanante").hide();
    $("#Search-UbicacionPacientes").click(function() {


      Swal.fire({
        text: "¿Estas seguro de que este sea el número de identificación del paciente?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#006941",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
      }).then((result) => {
        if (result.isConfirmed) {
          $("#Search-acompanante").show();
        }
      });

    });
  });
</script>

<script>
  // <!-- Con estas funciones que le damos a los botones, empezamos a darle una funci n a cada bot n cuando se
  // ejecuta por dispositivos m viles-->
  // <!--Ajustando las ventanas modales a pantanllas m viles 23/05/2024-->
  let modal1 = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
  let modal2 = new bootstrap.Modal(document.getElementById('exampleModalToggle2'));


  $('#Search-acompanante').on('click', function() {
    modal1.show();
  });

  $('#cerrar').on('click', function() {
    modal1.hide();
  });
  $('#abrirModal').on('click', function() {
    modal1.hide();
    modal2.show();
  });
</script>





<!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css" rel="stylesheet">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
<script src="controlAcceso.js"></script>
<script src="../Control/JS/Reloj.js"></script>
<script src="../Control/JS/UbicacionControl.js"></script>
<script src="../Control/JS/ControlAcceso.js"></script>
<script src="../Control/JS/UbicacionPacientes.js"></script>
<script src="../Control/JS/tomarfoto.js"></script>
<script src="../Control/JS/verificarAcceso.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>