<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/odontograma/odontograma.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Odontogramas";
    $_SESSION['module_title'] = "BUSCAR ODONTOGRAMA";


    require_once '../../../view/template/header.php';

    if ($_SESSION['Odontograma'] == 1) {
?>
    <!-- Incluir jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <!-- Incluir jsPDF-AutoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

        <div class="content-wrapper" >
            <div id="alertContainer" class="alert" role="alert"></div>
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card shadow p-3 mb-8"">
                        <div class="card-header">
                            
                        <!-- Inicio contenido -->
                        <div  class="row titles-UbiCita">
                            <div class="col">
                            <div class="well">
                                <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">Datos Del Paciente</span></h4>
                            </div>
                            </div>
                        </div>


                        <form id="agregarLinea"  method="POST" >                
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <center><label for="nroDoc">Numero de documento:</label></center>
                                    <input  type="text" id="nroDoc" name="nroDoc" class="form-control" >
                                </div>
                                <div hidden class="form-group col-md-2">
                                    <center><label for="episodio">Episodio:</label></center>
                                    <input readonly type="text" id="episodio" name="episodio" class="form-control" >
                                </div>
                                
                                <div hidden class="form-group col-md-0" style="display:none;">
                                    <input readonly type="text" id="tipo" name="tipo" class="form-control" >
                                </div>
                                <div class="form-group col-md-6">
                                    <center><label for -="nombrePaciente">Nombre paciente:</label></center>
                                    <input type="text" id="nombrePaciente" name="nombrePaciente" class="form-control" readonly>
                                </div>
                                
                            </div>

                            <div hidden class="row">
                                <div class="form-group col-md-2">
                                    <center><label for="edad">Edad:</label></center>
                                    <input readonly type="text" id="edad" name="edad" class="form-control" >
                                </div>
                                <div class="form-group col-md-3">
                                    <center><label for="sexo">G�nero:</label></center>
                                    <input readonly type="text" id="sexo" name="sexo" class="form-control">
                                </div>
                                <div class="form-group col-md-7">
                                    <center><label for="ubicacion">Ubicaci�n:</label></center>
                                    <input readonly  type="text" id="ubicacion" name="ubicacion" class="form-control" >
                                </div>
                                
                            </div>
                            
                            <div hidden class="row">
                                <div class="form-group col-md-4">
                                    <center><label for="cama">Cama:</label></center>
                                    <input readonly  type="text" id="cama" name="cama" class="form-control" >
                                </div>                             
                                <div class="form-group col-md-8">
                                    <center><label for="entidad">Aseguradora:</label></center>
                                    <input readonly  type="text" id="entidad" name="entidad" class="form-control" >
                                </div> 
                            </div>
                            <div hidden class="row">
                                <div class="form-group col-md-2">
                                    <center><label for="cedula">Identificacion:</label></center>
                                    <input readonly  type="text" id="cedula" name="cedula" class="form-control" >
                                </div>
                                <div class="form-group col-md-2">
                                    <center><label for="especialidad">Especialidad:</label></center>
                                    <input readonly  type="text" id="especialidad" name="especialidad" class="form-control" >
                                </div>
                                <div class="form-group col-md-6">
                                    <center><label for -="nombre">Nombre medico:</label></center>
                                    <input readonly  type="text" id="nombreMed" name="nombreMed" class="form-control" >
                                </div>
                                <div class="form-group col-md-2">
                                    <center><label for -="registro">Registro:</label></center>
                                    <input readonly  type="text" id="registro" name="registro" class="form-control" >
                                </div>
                                
                        </div>
                        </form>
                        <div hidden id="odonto">
                            <div  class="row titles-UbiCita">
                                <div class="col">
                                <div class="well">
                                    <h4 class="form-label text-divider-Epid" ><span class="left-span"></span><span class="span">Odontograma</span></h4>
                                </div>
                                </div>
                            </div>
                            
                            <?php
                            $treatments = [
                                'DienteAusente' => ['color' => '#007BFF', 'label' => 'Diente ausente', 'symbol' => 'X'],
                                'ExodonciaQuirurgica' => ['color' => 'red', 'label' => 'Exodoncia quirurgica', 'symbol' => 'x'],
                                'DienteSinErupcionar' => ['color' => '#000000', 'label' => 'Diente sin erupcionar', 'symbol' => '-']
                            ];

                            $teethPositions = [
                            	[18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28],
                                    [55,54,53,52,51,61,62,63,64,65], 
                            	[85,84,83,82,81,71,72,73,74,75],
                            	[48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38]
                       	    ];                            
		    ?>
                            <head>
                                <link rel="stylesheet" href="css/odontograma.css">
                            </head>
                            <!-- Contenido -->
                        
                            <div class="legend text-center">
                                <?php foreach ($treatments as $key => $treatment) : ?>
                                    <div class="legend-item">
                                        <div class="legend-symbol" style="color: <?= $treatment['color'] ?>;">
                                            <?= $treatment['symbol'] ?>
                                        </div>
                                        <div><?= $treatment['label'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="odontogram text-center">
                                <?php foreach ($teethPositions as $row) : ?>
                                    <div class="tooth-row">
                                        <?php foreach ($row as $tooth) : ?>
                                            <div class="tooth" id="tooth-<?= $tooth ?>" onclick="handleToothClick(<?= $tooth ?>)">
                                                <div class="tooth-content">
                                                    <div class="tooth-number"><?= $tooth ?></div>
                                                    <div class="tooth-symbol" id="tooth-symbol-<?= $tooth ?>"></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            

                            <div class="text-center">
                                <button id="generatePdfButton" class="save-button" type="button" >Generar PDF</button>
                            </div>
                        </div>
                        <!-- FIN contenido -->
                    </div>
                </div>
            </div>
            </div>
        </div>
<?php
    } else {
        require_once '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';
}
ob_end_flush();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="../Control/JS/guardarPDF.js"></script>
<!-- <script src="../Control/generarpdf.php" -->

<script>
    function hideRazon() {
        document.getElementById("RazonContainer").hidden = true;
    }
</script>

<script>
    
</script>

<!--B�squedad en la base de datos-->
<script>
$(document).ready(function() {
    $('#nroDoc').keydown(function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevenimos la recarga de la p�gina
            let numero_documento = $("#nroDoc").val();
            $("#nroDoc").attr("readonly", true);
            
            $.ajax({
                type: "POST",
                url: '../Logica/findOdontograma.php', // URL del archivo PHP
                data: {
                    numero_documento: numero_documento
                },
                dataType: "json", // Esperamos JSON como respuesta
                success: function(response) {
                    console.log(response); // Para depuraci�n
                    $("#episodio").val(response['informacionPaciente']['episodio']);
                    $("#nroDoc").val(response['informacionPaciente']['numero_documento']);
                    $("#tipo").val(response['informacionPaciente']['tipo_documento']);
                    $("#nombrePaciente").val(response['informacionPaciente']['nombre']);
                    $("#edad").val(response['informacionPaciente']['edad']);
                    $("#sexo").val(response['informacionPaciente']['genero']);
                    $("#ubicacion").val(response['informacionPaciente']['ubicacion']);
                    $("#cama").val(response['informacionPaciente']['cama']);
                    $("#entidad").val(response['informacionPaciente']['entidad']);
                    $("#cedula").val(response['informacionPaciente']['identificacion']);
                    $("#especialidad").val(response['informacionPaciente']['especialidad']);
                    $("#nombreMed").val(response['informacionPaciente']['nombreMedico']);
                    $("#registro").val(response['informacionPaciente']['registroMedico']);
                    // Limpiar los s�mbolos de los dientes
                    $('.tooth-symbol').empty();
                    $("#odonto").removeAttr('hidden',true);
                    // Aplicar tratamientos a los dientes
                    if (response['tratamientos']) {
                        for (let tooth in response['tratamientos']) {
                            let treatment = response['tratamientos'][tooth];
                            let treatmentDetails = {
                                'DienteAusente': ['#007BFF', 'Diente ausente', 'X'],
                                'ExodonciaQuirurgica': ['red', 'Exodoncia quirurgica', 'X'],
                                'DienteSinErupcionar': ['#000000', 'Diente sin erupcionar', '-']
                            };
                           

                            if (treatmentDetails[treatment]) {
                                let [color, label, symbol] = treatmentDetails[treatment];
                                $('#tooth-symbol-' + tooth).text(symbol).css('color', color);
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    console.log("Response Text:", xhr.responseText); // Mostrar la respuesta completa para depuraci�n
                }
            });
        }
    });
});
</script>

<script>
  
    function clearOdontogram() {
        odontogramData = {};
        document.querySelectorAll('.tooth-symbol').forEach(symbol => {
            symbol.textContent = '';
            symbol.style.color = 'transparent';
        });
        selectTreatment('Nothing');
    }

    // Inicializar el primer bot�n como seleccionado
    document.getElementById('button-' + selectedTreatment).classList.add('active');
</script>
<script src="../../../view/scripts/usuario.js"></script>
