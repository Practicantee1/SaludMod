<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();
 include(".././../../config/Conexion.php");

if (!isset($_SESSION["nombre"]))
{
  $_SESSION["PrePage"] = "../Modulos/Programas_educativos/programa_educativo.php";
  header("Location: ../../../view/login.php");
}
else
{
    define('BASE_URL', '../../');
    $pageTitle = "Programa Educativo";
    $_SESSION['module_title'] = "ENCUESTA DE SATISFACCION";


require_once '../../../view/template/header.php';

if ($_SESSION['ProgramaEducativo']==1)
{

   $selectAnswer = "../image/colibriWhite.png";

       $query_consult = $conexion->prepare("SELECT episode, nombre_completo, cc_document, fecha FROM `satisfaccion` ORDER BY fecha DESC LIMIT 15;");

    // Ejecutar la consulta
    $query_consult->execute();
    
    // Obtener el resultado
    $resultado = $query_consult->get_result();
    $resultadoSatisfacion = $resultado->fetch_all(MYSQLI_ASSOC);
    
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="CSS/estilos.css">
 </head>
 <body>

 <div id="div-fondo" class="fondo-opaco" style="display: none;">
    <dialog id="modal-excel" style="box-sizing: border-box;">
            <div id="div_cerrarmodal">
                <i id="cerrar-modal" class="fas fa-times" style="padding: 5px;"></i>
            </div>
                <div class="div-input">
                    <label for="fecha-inicio">Fecha Inicial</label>
                    <input class="input-modal" id="fecha_inicial" type="date">
                </div>
                <div  class="div-input">
                    <label for="fecha-fin">Fecha Final</label>
                    <input class="input-modal" id="fecha_final" type="date">
                </div>
                <div class="div-input">   
                    <button id="btn-descargar_excel" class="btn-modal">Descargar Excel</button>
                </div>
    </dialog>
    </div>
 
 <div class="content-wrapper">
 <div id="alertContainer" class="alert" role="alert"></div>
    <div class="container">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8" >
                <div class="card-header">
                         
                       

                        <div class="row titles-UbiCita">
                            <div class="col">
                            <div class="well">
                                <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span  class="span">Datos Del Paciente</span></h4>
                            </div>
                            </div>
                        </div>
                    <form id="agregarLinea">                
                        <div class="row">
                            <div class="form-group col-md-3">
                                <center><label for="nroDoc">Número de documento:</label></center>
                                <input type="text" id="documento" name="nroDoc" class="form-control" >
                            </div>
                            <div class="form-group col-md-2">
                                <center><label for="episodio">Episodio:</label></center>
                                <input type="text" id="episodio" name="episodio" readonly class="form-control" >
                            </div>
                            <div class="form-group col-md-5">
                                <center><label for -="nombre">Nombre paciente:</label></center>
                                <input type="text" id="nombre" name="nombre" readonly class="form-control" >
                            </div>
                                <div class="col-md-2">
                                <center><label style="color:black " for="registro" class="form-label">Fecha</label></center>
                                <input type="date" class="form-control" id="registro" name="fecha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12" id="content-tabla">
                                <div id="cont-sugerencias">
                                    <center><label for="entidad">Sugerencias:</label></center>
                                    <br>
                                    <textarea name="surgerencias" class="form-control" id="surgerencias" rows="4" cols="40" style="width: 100%;resize:none;"></textarea>
                                    <div id="content">
                        <div id="selecciones">
                            <table id="table-answer">
                                <tr>
                                    <th id="th-tblsatisfaccion"></th>
                                    <th id="th-tblsatisfaccion" disabled style="border-radius:1%;">A</th>
                                    <th id="th-tblsatisfaccion" disabled style="border-radius:1%;">B</th>
                                    <th id="th-tblsatisfaccion" disabled style="border-radius:1%;">C</th>
                                    <th id="th-tblsatisfaccion" disabled style="border-radius:1%;">D</th>
                                    
                                </tr>
                                <tr data-question="1">
                                    <td disabled style="text-align:center; border: none;"><b>1</b></th>
                                    <!-- <td class="boton-con-imagen" ><a><img src="<?php echo $selectAnswer;?>" alt="Respuesta"></a></td> -->
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="EXCELENTE" title="EXCELENTE">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="BUENO" title="BUENO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="REGULAR" title="REGULAR">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="MALO" title="MALO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                </tr>
                                <tr  data data-question="2">
                                    <td disabled style="text-align:center; border: none;"><b>2</b></th>
                                    <!-- <td class="boton-con-imagen" ><a><img src="<?php echo $selectAnswer;?>" alt="Respuesta"></a></td> -->
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="EXCELENTE" title="EXCELENTE">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="BUENO" title="BUENO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="REGULAR" title="REGULAR">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="MALO" title="MALO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                </tr>
                                <tr data-question="3">
                                    <td disabled style="text-align:center; border: none;"><b>3</b></th>
                                    <!-- <td class="boton-con-imagen" ><a><img src="<?php echo $selectAnswer;?>" alt="Respuesta"></a></td> -->
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="EXCELENTE" title="EXCELENTE">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="BUENO" title="BUENO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="REGULAR" title="REGULAR">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="MALO" title="MALO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                </tr>
                                <tr data-question="4">
                                    <td disabled style="text-align:center; border: none;"><b>4</b></th>
                                    <!-- <td class="boton-con-imagen" ><a><img src="<?php echo $selectAnswer;?>" alt="Respuesta"></a></td> -->
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="EXCELENTE" title="EXCELENTE">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="BUENO" title="BUENO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="REGULAR" title="REGULAR">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="MALO" title="MALO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                </tr>
                                <tr data-question="5">
                                    <td disabled style="text-align:center; border: none;"><b>5</b></th>
                                    <!-- <td class="boton-con-imagen" ><a><img src="<?php echo $selectAnswer;?>" alt="Respuesta"></a></td> -->
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="EXCELENTE" title="EXCELENTE">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="BUENO" title="BUENO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="REGULAR" title="REGULAR">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                    <td class="item" >
                                        <a onclick="saveAnswer(this)" data-value="MALO" title="MALO">
                                            <img src="<?php echo $selectAnswer;?>" alt="Respuesta">
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        </div>
                        <div>
                            <button class="btn-modal" id="btn-borrar" >Borrar registro</button>
                            <input type="button" class="btn-modal" id="btn-guardar" onclick="saveAllData()" value="Guardar"><br><br>
                        </div>
                            </div>
                                <div id="tabla" class="col-md-7">
                                    <table id="customer-table">
                                        <tr>
                                            <th>Episodio</th>
                                            <th>Nombre</th>
                                            <th>CC</th>
                                            <th>Fecha</th>
                                        </tr>
                                            <?php 
                                            foreach ($resultadoSatisfacion as $key => $value) {?>
                                            <tr>
                                                <td alt="Respuesta"><?php echo ($value['episode']); ?></td>
                                                <td alt="Respuesta"><?php echo ucwords(strtolower($value['nombre_completo'])); ?></td>
                                                <td alt="Respuesta"><?php echo($value['cc_document']); ?></td>
                                                <td alt="Respuesta"><?php echo($value['fecha']); ?></td>
                                            </tr>
                                            <?php } ?>
                                    </table>
                                </div>
                            </div>
                            <button class="btn-modal" id="btn-excel" >Descargar Excel</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <table style="display: none;" id="tabla-excel">
    <thead>
        <tr id="titulo-fila">
        <th colspan="10">DATOS SATISFACCIÓN PACIENTES</th>
        <tr>
            <th>Episodio</th>
            <th>Nombre</th>
            <th>CC</th>            
            <th>Fecha</th>
            <th>Amabilidad y trato</th>
            <th>Informacion</th>
            <th>Puntualidad</th>
            <th>Ambiente Hospitalario?</th>
            <th>Metodologia</th>
            <th>Sugerencias</th>
            <th>Usuario que Registra</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
 </body>
 <?php $usuario = $_SESSION['nombre']; ?>
<script>
    var usuario = "<?php echo $usuario; ?>";
    console.log(usuario);
      // Obtener la fecha actual
    const today = new Date().toISOString().split('T')[0];

// Establecer el atributo max del campo de fecha al día de hoy
    document.getElementById('fecha_inicial').setAttribute('max', today);
    document.getElementById('fecha_final').setAttribute('max', today);
    document.getElementById('registro').setAttribute('max', today);
    
  $("#btn-borrar").click(function(e){
    e.preventDefault()
    Swal.fire({
        title: "Estas seguro de que quieres borrar la consulta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si"
        }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
            title: "Consulta limpiada!",
            text: "Puedes realizar otra consulta.",
            icon: "success"
            });
            $("#episodio").val("");
            $("#nombre").val("");
            $("#registro").val("");
            $("#documento").val("");
            $("#surgerencias").val("");
            $("#documento").removeAttr("readonly");
        }
    });
  });
  
  $("#btn-excel").on("click", function(e) {
    e.preventDefault();
  // Alternar la visibilidad del modal
  $("#modal-excel").toggle();
  $("#div-fondo").toggle();
});

$("#cerrar-modal").on("click", function() {
  // Alternar la visibilidad del modal
  $("#modal-excel").toggle();
  $("#div-fondo").toggle();
});

$("#btn-descargar_excel").click(function(e){
    e.preventDefault();
    let F_inicial = $("#fecha_inicial").val();
    let F_final = $("#fecha_final").val();
    let fechaInicial = new Date(F_inicial);
    let fechaFinal = new Date(F_final);
    if (!F_inicial || !F_final) {
            // alert('Por favor, selecciona las fechas.');
            Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Por favor, Seleccione ambas fechas.",
          });
            return;
    }
    if (fechaFinal < fechaInicial) {
            // alert('Por favor, selecciona las fechas.');
            Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "La fecha final debe ser mas reciente que la fecha inicial",
          });
            return;
    }
  
    $.ajax({
        url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/Programas_educativos/admin//section/banner/consulta-excel.php',
        type: 'POST',
        data: {
            F_inicial: F_inicial,
            F_final: F_final
        },
        success: function(response) {
            console.log(response); // Verifica el contenido de la respuesta
            try {
            // Si la respuesta ya es un objeto, no necesitas usar JSON.parse
            var data = typeof response === 'string' ? JSON.parse(response) : response;

            // Vaciar la tabla antes de llenarla
            $('#tabla-excel tbody').empty();

            // Función para sumar un día a una fecha en formato yyyy-mm-dd
            function addOneDay(dateString) {
                const date = new Date(dateString);
                date.setDate(date.getDate() + 1); // Sumar un día
                return date.toISOString().split('T')[0]; // Formato yyyy-mm-dd
            }

            // Llenar la tabla con los datos recibidos
            data.forEach(function(item) {
                $('#tabla-excel tbody').append(
                    `<tr>
                        <td>${item.episode}</td>
                        <td>${item.nombre_completo}</td>
                        <td>${item.cc_document}</td>
                        <td>${addOneDay(item.fecha)}</td> <!-- Aplicar suma de día -->
                        <td>${item.pregunta_1}</td>
                        <td>${item.pregunta_2}</td>
                        <td>${item.pregunta_3}</td>
                        <td>${item.pregunta_4}</td>
                        <td>${item.pregunta_5}</td>
                        <td>${item.pregunta_8}</td>
                        <td>${item.usuarioRegistra}</td>
                    </tr>`
                );
            });

            // Generar el archivo Excel utilizando la tabla #tabla-excel
            var wb = XLSX.utils.table_to_book($('#tabla-excel')[0], {sheet: "Sheet1"});
            let nombreArchivo = `datos_DESDE__${F_inicial}__HASTA__${F_final}.xlsx`;
            XLSX.writeFile(wb, nombreArchivo);
        } catch (e) {
            console.error('Error al procesar los datos:', e);
        }
    },
        error: function() {
            alert('Error al obtener los datos.');
        }
    });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
 <script src="../admin/section/banner/saveAnwer.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="../admin/section/banner/ajax.js"></script>
</html>













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

