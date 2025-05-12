<?php

 $id = isset($_GET["id"]) ? intval($_GET["id"]) : 0; // Convierte a entero para mayor seguridad



 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <title>Solicitud de Derecho a Morir Dignamente</title>
    <!-- Bootstrap CSS -->
    <style>
        .subtitles {
            border: 2px solid #222;
            border-right: none;
        }

        .text {
            border: 2px solid #222;
        }
        
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            display: flex;
            justify-content: center;
        }

        #logo {
            height: 15% !important;
            margin-left: 100px;
            margin-top: -25px;
        }

        table {
            border-bottom: 2px solid #333;
            border-collapse: collapse;
        }

        .table-col {
            position: relative;
            border-right: 2px solid #333;
            border-left: 2px solid #333;
            padding: 4px;
        }

        .header {
            margin-bottom: 10vh;
        }

        .container {
            width: 100%;
            max-width: 800px; /* o el ancho que prefieras */
            margin: 0 auto !important;
            padding: 0 !important;
        }

        .MainContainer {
            width: 100%;
            padding: 30px ; /* Solo mantén el padding vertical */
            margin: 0 auto;
        }

        .row {
            display: inline-block;
            width: 110%;
            position: relative !important;
            flex-direction: row !important; 
            justify-content: center !important; 
            align-items: center !important;
            list-style: none !important;
        }

        .col-md-1 {
            width: 8.32%;
        }
        .col-md-2 {
            width: 16.65%;
        }
        .col-md-3 {
            width: 24.9%;
        }
        .col-md-4 {
            width: 33.32%;
        }
        .col-md-5 {
            width: 41.65%;
        }
        .col-md-6 {
            width: 49.9%;
        }
        .col-md-8 {
            width: 66.65%;
        }
        .col-md-12 {
            width: 99.9%;
        }

        .table-titles {
            font-size: 15px;
            background-color: #ccc;
            color: #000;
            font-weight: 600;
            width: 100%;
        }

        .table-subtitles {
            font-size: 13px;
            color: #000;
            font-weight: 600;
        }

        .table-text {
            font-size: 12px;
        }

        .signature-line {
            margin-top: 50px;
            border-bottom: 2px solid #000;
        }
    </style>
</head>
<body id="body">
<div class="container-fluid container MainContainer">

    <!-- LOGO HOSPITAL -->

<table style="width: 100%; margin: auto; border: none">
    <tbody style="width: 100%; margin: auto;">
        <tr>
            <td>
                <div class="row d-flex justify-content-center header">
                    <div class="col-md-6">
                        <img id="logo" src="LogoHospital.jpg" alt="Logo del Hospital">
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table style="width: 100%; margin: auto; margin: 25px 0; border: none; margin-top:20px;">
    <tbody style="width: 100%; margin: auto;">
        <tr>
            <td class="col-md-6">
                <h3 style="margin-top: -30px; text-align: center;">SOLICITUD DERECHO A MORIR DIGNAMENTE</h3>
            </td>
        </tr>
    </tbody>
</table>
    <!-- Información general -->
    <table style="width: 95%; margin: auto;;">
        <tbody style="width: 100%; margin: auto;">
            <tr>     
                <td class="col table-col table-titles" style="border-top: 2px solid #333; text-align: center;">
                    <div>
                        <label>INFORMACIÓN GENERAL:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Código de solicitud:</label>
                        <label id="id" class="table-text">{{ id }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Fecha de solicitud:</label>
                        <label id="fechaSolicitud" class="table-text">{{ fechaSolicitud }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Ciudad:</label>
                        <label id="Ciudad" class="table-text">{{ Ciudad }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Información del paciente -->
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>     
                <td class="col table-col table-titles">
                    <div>
                        <label>DATOS DEL PACIENTE:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-6 table-col" style="width: 43%">
                    <div>
                        <label class="table-subtitles">Nombre completo:</label>
                        <label id="nombrePaciente" class="table-text">{{ nombrePaciente }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Edad:</label>
                        <label id="edad" class="table-text">{{ edad }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-6 table-col" style="width: 43%">
                    <div>
                        <label class="table-subtitles">Tipo de documento:</label>
                        <label id="tipoDocumentop" class="table-text">{{ tipoDocumentop }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Número de Documento:</label>
                        <label id="tipoDocumentop" class="table-text">{{ CedulaPaciente }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Información de la incapacidad -->
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>     
                <td class="col table-col table-titles">
                    <div>
                        <label>TÉRMINOS DE LA SOLICITUD:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>     
                <td class="col table-col ">
                    <div>
                        <label>En uso del derecho a morir con dignidad, el paciente arriba en mención elevo la solicitud para dar inicio al
                            procedimiento de muerte anticipada a través de la eutanasia, por lo cual dando cumplimiento a las
                            disposiciones contempladas en la Resolución 1216/2015 expedida por el Ministerio de Salud y Protección
                            Social, me permito convocar formalmente al Comité de Muerte Digna de la Fundación Hospitalaria San
                            Vicente de Paul para verificar la existencia de los presupuestos de la solicitud y dar inicio al trámite para
                            hacer efectivo el derecho a morir con dignidad.
                            Por lo anterior expuesto y en consideración con las atenciones médicas realizadas al paciente, procedo a
                            emitir informe en los siguientes términos
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">Términos:</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles" style="text-align: center;">Respuesta</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">1. Conozco el diagnóstico de la enfermedad grave o terminal que padece el paciente. ¿Cuál?:</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p1" class="table-text" style="text-align: center;">{{ p1 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">2. El padecimiento de esta enfermedad terminal le produce intensos dolores y sufrimientos:</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p2" class="table-text" style="text-align: center;">{{ p2 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">3. Se le ha ofrecido al paciente otras alternativas como las del cuidado paliativo para el tratamiento integral del dolor, el alivio del sufrimiento y otros síntomas:</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p3" class="table-text" style="text-align: center;">{{ p3 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">4. Actualmente el paciente se encuentra recibiendo cuidados paliativos:</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p4" class="table-text" style="text-align: center;">{{ p4 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">5. El consentimiento del paciente está libre de presiones de terceros y no es producto de
                        episodios anímicos o momentos que puedan afectar el sentido de su decisión.</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p5" class="table-text" style="text-align: center;">{{ p5 }}</label>
                    </div>
                </td>
                </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">6. 
                        Se le han aclarado al paciente todas sus dudas, explicando el procedimiento y ha
                        comprendido la naturaleza del mismo.
                        </label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p6" class="table-text" style="text-align: center;">{{ p6 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">7. 
                        El consentimiento del paciente es producto de episodios anímicos o momentáneos que
                        puedan afectar el sentido de su decisión.
                        </label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p7" class="table-text" style="text-align: center;">{{ p7 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-7 table-col">
                    <div>
                        <label class="table-subtitles">8. 
                        Se le informo al paciente que en cualquier momento del proceso puedo desistir de la solicitud y optar por otras alternativas terapéuticas como los cuidados paliativos.
                        </label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label id="p8" class="table-text" style="text-align: center;">{{ p8 }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
	
    <div>
         <label id="observaciones">{{ observaciones }}</label>
    </div>
    
    <table style="width: 95%; margin: auto; margin-top:15px;">
        <tbody style="width: 100%; margin: auto; margin-top:15px;">
            <tr>     
                <td class="col table-col table-titles" style="border-top:2px solid #333">
                    <div>
                        <label>DATOS DEL MEDICO:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Datos del medico -->

    <table style="width: 95%; margin: auto;">
        <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-8 table-col" style="width: 44%">
                    <div>
                        <label class="table-subtitles">Nombre completo:</label>
                        <label id="nombreMedico" class="table-text">{{ nombreMedico }}</label>
                    </div>
                </td>
                <td class="col-md-4 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Registro:</label>
                        <label id="RegistroMedico" class="table-text">{{ RegistroMedico }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
</table>

<table style="width: 95%; margin: auto;;">
    <tbody style="width: 100%; margin: auto;">
            <tr>
                <td class="col-md-4 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Tipo de documento:</label>
                        <label id="idTipoDocumento" class="table-text">{{ tipoDocumentoMedico }}</label>
                    </div>
                </td>
                <td class="col-md-4 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Numero de documento:</label>
                        <label id="idDocumento" class="table-text">{{ numeroDocumentoMedico }}</label>
                    </div>
                </td>
                <td class="col-md-4 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Especialidad:</label>
                        <label id="Especialidad" class="table-text">{{ Especialidad }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>


</div>
</body>
</html>
