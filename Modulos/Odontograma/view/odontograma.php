<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

session_start();

$parameters = http_build_query($_GET);





if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/Odontograma/view/odontograma.php";
    header("Location: ../../../view/login.php" . "?" . $parameters);
} else {
    define('BASE_URL', '../../');
    $pageTitle = "odontograma";
    $_SESSION['module_title'] = "REGISTRAR ODONTOGRAMA";


    require_once '../../../view/template/header.php';

    if ($_SESSION['Odontograma'] == 1) {

        if (isset($_GET["param"]) && $_GET["param"] !== "") {
            $_SESSION["param"] = $_GET["param"];
        }
        require '../../../logica/ApiURL.php';

        $_SESSION["param"] = "";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilosDMD.css">
</head>

<body>
    <div class="content-wrapper">
        <div id="alertContainer" class="alert" role="alert"></div>
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card shadow p-3 mb-8">
                    <div class="card-header">
                        

                        <!-- Inicio contenido -->
                        <div class="row titles-UbiCita">
                            <div class="col">
                                <div class="well">
                                    <h4 class="form-label text-divider-Epid"><span
                                            class="left-span"></span><span class="span">Examenes</span></h4>
                                </div>
                            </div>
                        </div>


                        <form id="agregarLinea" method="POST">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <center><label for="episodio">Episodio:</label></center>
                                    <input type="text" id="episodio" name="episodio" class="form-control"
                                        value="<?php echo $Doc ?>" readonly>
                                </div>
                                <div class="form-group col-md-4" style="display:none;">
                                    <input readonly type="text" id="tipo" name="tipo" class="form-control"
                                        value="<?php echo $DatosIncapacidad['TypeIdentification']; ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <center><label for="nroDoc">Numero de documento:</label></center>
                                    <input type="text" id="nroDoc" name="nroDoc" class="form-control" readonly
                                        value="<?php echo isset($DatosIncapacidad['IDNumberPaciente']) && !empty($DatosIncapacidad['IDNumberPaciente']) ? $DatosIncapacidad['IDNumberPaciente'] : ''; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <center><label for -="nombrePaciente">Nombre paciente:</label></center>
                                    <input type="text" id="nombrePaciente" name="nombrePaciente" class="form-control" readonly
                                        value="<?php echo isset($DatosIncapacidad['NombreApellido']) && !empty($DatosIncapacidad['NombreApellido']) ? $DatosIncapacidad['NombreApellido'] : ''; ?>">
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <center><label for="edad">Edad:</label></center>
                                    <input readonly type="text" id="edad" name="edad" class="form-control" readonly
                                        value="<?php echo isset($DatosIncapacidad['Edad']) && !empty($DatosIncapacidad['Edad']) ? $DatosIncapacidad['Edad'] : ''; ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <center><label for="sexo">Genero:</label></center>
                                    <input readonly type="text" id="sexo" name="sexo" class="form-control" readonly
                                        value="<?php echo isset($DatosIncapacidad['Sexo']) && !empty($DatosIncapacidad['Sexo']) ? $DatosIncapacidad['Sexo'] : ''; ?>">
                                </div>
                                <div class="form-group col-md-7">
                                    <center><label for="ubicacion">Ubicacion:</label></center>
                                    <input type="text" id="ubicacion" name="ubicacion" class="form-control" readonly
                                        value="<?php echo isset($UbicacionPaciente["UbicacionEdificio"]) && !empty($UbicacionPaciente["UbicacionEdificio"]) ? $UbicacionPaciente["UbicacionEdificio"] : ''; ?>">
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <center><label for="cama">Cama:</label></center>
                                    <input type="text" id="cama" name="cama" class="form-control" readonly
                                        value="<?php echo isset($UbicacionPaciente["IdUbicacion_cama"]) && !empty($UbicacionPaciente["IdUbicacion_cama"]) ? $UbicacionPaciente["IdUbicacion_cama"] : ''; ?>">
                                </div>
                                <div class="form-group col-md-8">
                                    <center><label for="entidad">Aseguradora:</label></center>
                                    <input readonly type="text" id="entidad" name="entidad" class="form-control" readonly
                                        value="<?php echo isset($DatosIncapacidad['NomEntidad']) && !empty($DatosIncapacidad['NomEntidad']) ?$DatosIncapacidad['NomEntidad']:''; ?>">
                                </div>
                                <div class="form-group col-md-8" hidden>
                                    <center><label for="centrosanitario">centrosanitario:</label></center>
                                    <input readonly type="text" id="centrosanitario" name="centrosanitario" class="form-control" readonly
                                        value="<?php echo isset($DatosIncapacidad['CentroSanitario']) && !empty($DatosIncapacidad['CentroSanitario']) ? $DatosIncapacidad['CentroSanitario'] : ''; ?>">
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <center><label for="cedula">Identificacion:</label></center>
                                <input type="number" id="cedula" name="cedula" class="form-control" readonly
                                    value="<?php echo isset($DatosIncapacidad['IDNumberMedico']) && !empty($DatosIncapacidad['IDNumberMedico']) ? $DatosIncapacidad['IDNumberMedico'] : ''; ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <center><label for -="nombreMed">Nombre medico:</label></center>
                                <input type="text" id="nombreMed" readonly name="nombreMed" class="form-control" value="<?php echo isset($DatosIncapacidad['NombreMedico']) && !empty($DatosIncapacidad['NombreMedico']) ? $DatosIncapacidad['NombreMedico'] : ''; ?>"
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <center><label for="especialidad">Especialidad:</label></center>
                                <input type="text" id="especialidad" name="especialidad" class="form-control" readonly
                                    value="<?php echo isset($DatosIncapacidad['Especialidad']) && !empty($DatosIncapacidad['Especialidad']) ? $DatosIncapacidad['Especialidad'] : ''; ?>">
                            </div>
                            <div class="form-group col-md-8">
                                <center><label for -="registro">Registro:</label></center>
                                <input type="text" id="registro" name="registro" class="form-control" readonly
                                    value="<?php echo $DatosIncapacidad['Registro']; ?>">
                            </div>

                        </div>
                        <div class="row titles-UbiCita">
                            <div class="col">
                                <div class="well">
                                    <h4 class="form-label text-divider-Epid"><span
                                            class="left-span"></span><span class="span">Odontograma</span></h4>
                                </div>
                            </div>
                        </div>

                        <?php
                        $treatments = [
                            'Nothing' => ['color' => 'transparent', 'label' => 'Borrar', 'symbol' => ''],
                            'DienteAusente' => ['color' => '#007BFF', 'label' => 'Diente ausente', 'symbol' => 'X'],
                            'ExodonciaQuirurgica' => ['color' => 'red', 'label' => 'Exodoncia quirurgica', 'symbol' => 'X'],
                            'DienteSinErupcionar' => ['color' => '#000000', 'label' => 'Diente sin erupcionar', 'symbol' => '-']
                        ];

                        $teethPositions = [
                            [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28],
                            [55, 54, 53, 52, 51, 61, 62, 63, 64, 65],
                            [85, 84, 83, 82, 81, 71, 72, 73, 74, 75],
                            [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38]
                        ];
                        // $teethPositionsKids = [
                        //     [55,54,53,52,51,61,62,63,64,65], 
                        //     [85,84,83,82,81,71,72,73,74,75]
                        // ];
                        ?>

                        <head>
                            <link rel="stylesheet" href="css/odontograma.css">
                        </head>
                        <!-- Contenido -->
                        <div class="treatment-buttons text-center">
                            <?php foreach ($treatments as $key => $treatment): ?>
                                <div class="treatment-button" id="button-<?= $key ?>"
                                    onclick="selectTreatment('<?= $key ?>')">
                                    <span class="treatment-symbol" style="color: <?= $treatment['color'] ?>;">
                                        <?= $treatment['symbol'] ?>
                                    </span>
                                    <span><?= $treatment['label'] ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="odontogram text-center">
                            <?php foreach ($teethPositions as $row): ?>
                                <div class="tooth-row">
                                    <?php foreach ($row as $tooth): ?>
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


                        <div class="legend text-center">
                            <?php foreach (array_slice($treatments, 1) as $key => $treatment): ?>
                                <div class="legend-item">
                                    <div class="legend-symbol" style="color: <?= $treatment['color'] ?>;">
                                        <?= $treatment['symbol'] ?>
                                    </div>
                                    <div><?= $treatment['label'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>


                        <div class="text-center">
                            <button class="save-button" onclick="saveOdontogram()">Guardar odontograma</button>
                        </div>
                        <!-- FIN contenido -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function hideRazon() {
        document.getElementById("RazonContainer").hidden = true;
    }
</script>

<script>
    const treatments = <?php echo json_encode($treatments); ?>;
    let selectedTreatment = 'Nothing';
    let odontogramData = {};

    function selectTreatment(treatment) {
        selectedTreatment = treatment;
        document.querySelectorAll('.treatment-button').forEach(button => {
            button.classList.remove('active');
        });
        document.getElementById('button-' + treatment).classList.add('active');
    }

    function handleToothClick(toothNumber) {
        const toothSymbol = document.getElementById(`tooth-symbol-${toothNumber}`);
        const selected = treatments[selectedTreatment];
        toothSymbol.textContent = selected.symbol;
        toothSymbol.style.color = selected.color;

        if (selectedTreatment !== 'Nothing') {
            odontogramData[toothNumber] = selectedTreatment;
        } else {
            delete odontogramData[toothNumber];
        }
    }

    function saveOdontogram() {
        const dataToSend = Object.keys(odontogramData).length ? odontogramData : null;
        let episodio = $("#episodio").val();
        let documento = $("#nroDoc").val();
        let tipo_documento = $("#tipo").val();
        let nombre = $("#nombrePaciente").val();
        let edad = $("#edad").val();
        let genero = $("#sexo").val();
        let ubicacion = $("#ubicacion").val();
        let cama = $("#cama").val();
        let entidad = $("#entidad").val();
        let mensaje = `Episodio: ${episodio}\nDocumento: ${documento}\nTipo de documento: ${tipo_documento}\nNombre: ${nombre}\nEdad: ${edad}\nGï¿½nero: ${genero}\nUbicaciï¿½n: ${ubicacion}\nCama: ${cama}\nEntidad: ${entidad}`;
        let identificacionMed = $("#cedula").val();
        let nombreMedico = $("#nombreMed").val();
        let especialidad = $("#especialidad").val();
        let registro = $("#registro").val();
        let centrosanitario = $("#centrosanitario").val();
        console.log(identificacionMed + " " + nombreMedico + " " + especialidad + " " + registro);


        if (!dataToSend) {
            Swal.fire({
                text: "No hay procedimientos aplicados para guardar.!",
                icon: "info"
            });

            return;
        }

        fetch('../Logica/save_odontogram.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                odontogram: odontogramData,
                episodio: episodio,
                documento: documento,
                tipo_documento: tipo_documento,
                nombre: nombre,
                edad: edad,
                genero: genero,
                ubicacion: ubicacion,
                cama: cama,
                entidad: entidad,
                identificacionMed: identificacionMed,
                nombreMedico: nombreMedico,
                especialidad: especialidad,
                registro: registro,
                centrosanitario: centrosanitario
            })
        }).then(response => response.json()).then(result => {
            console.log(result);
            if (result.status === 'success') {
                Swal.fire({
                    title: "Good job!",
                    text: "Odontograma guardado correctamente!",
                    icon: "success"
                });
                window.location.href = "http://vmsrv-web2.hospital.com/SaludMod/Modulos/Odontograma/view/buscarOdontograma.php"
	     let episodio = $("#episodio").val('');
                let documento = $("#nroDoc").val('');
                let tipo_documento = $("#tipo").val('');
                let nombre = $("#nombrePaciente").val('');
                let edad = $("#edad").val('');
                let genero = $("#sexo").val('');
                let ubicacion = $("#ubicacion").val('');
                let cama = $("#cama").val('');
                let entidad = $("#entidad").val('');
                let identificacionMed = $("#cedula").val('');
                let nombreMedico = $("#nombreMed").val('');
                let especialidad = $("#especialidad").val('');
                let registro = $("#registro").val('');
                let centrosanitario = $("#centrosanitario").val('');	
                clearOdontogram();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Error al guardar el odontograma:!",
                });

            }
        }).catch(error => {
            console.log('Error al guardar el odontograma.');
            console.error('Error:', error);
        });
    }

    function clearOdontogram() {
        odontogramData = {};
        document.querySelectorAll('.tooth-symbol').forEach(symbol => {
            symbol.textContent = '';
            symbol.style.color = 'transparent';
        });
        selectTreatment('Nothing');
    }

    // Inicializar el primer botï¿½n como seleccionado
    document.getElementById('button-' + selectedTreatment).classList.add('active');
</script>
<script src="../../../view/scripts/usuario.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener los parámetros de la URL
        const params = new URLSearchParams(window.location.search);

        // Suponiendo que 'param' es el parámetro que quieres decodificar
        const encodedParam = params.get('param');

        if (encodedParam) {
            // Decodificar el parámetro en base64
            let parametros = window.atob(encodedParam);

            // Parsear el JSON
            const data = JSON.parse(parametros);

            // Obtener el último objeto del array `parametros`
            const lastParam = data.parametros[data.parametros.length - 1];

            // Obtener el valor del campo
            const lastValue = lastParam.valor;

            // Actualizar el valor en el elemento con id `idRegistro`
            $("#registro").val(lastValue);

        } else {
            console.log("Encoded parameter 'param' not found in URL");
        }
        
        let medico = $("#nombreMed").val();
        let Documento = $("#cedula").val();
        let Registro = $("#registro").val();
        let Especialidad = $("#especialidad").val();
        let NombrePaciente = $("#nombrePaciente").val();
        let NumeroIdentificacion = $("#nroDoc").val();

    if (medico == "" && Documento == "" && Registro == "" && Especialidad == "" && NombrePaciente == "" && NumeroIdentificacion == "" ) {      
        Swal.fire({
        title: 'No es posible realizar Solicitud',
        text: 'Para realizar una solicitud, por favor ingrese desde el modulo de SAP',
        icon: 'warning',
        showCancelButton: false,
        confirmButtonText: 'Consultar Solicitudes',
        allowOutsideClick: false,
        allowEscapeKey: false,
        iconColor: '#006941',
        customClass: {
            title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
            popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
            content: 'custom-swal-Incapacidad-Content',
            confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
        }
    }).then((result) => {
        // Check if the user clicked the "Confirm" button
        if (result.isConfirmed) {
          // Redirect to another page
          window.location.href = 'ConsultarSolicitud.php';
        } else {
          // Close the current tab
          window.close();
        }});
    }
});
</script>

<script src="../Control/JS/controlOdonto.js"></script>

</html>
        <?php
    } else {
        require_once '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';



}
ob_end_flush();
?>