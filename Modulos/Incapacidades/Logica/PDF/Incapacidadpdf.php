<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Certificado de Incapacidad</title>
    <!-- Bootstrap CSS -->
    <style>

        .subtitles{
            border: 2px solid #222;
            border-right: none;
        }

        .text{
            border: 2px solid #222;
        }
        
        *{
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
        }

        #logo{
            height: 15% !important;
            margin-left: 100px;
            margin-top: -25px;
        }

        table{
            border-bottom: 2px solid #333;
            border-collapse: collapse
        }

        .table-col{
            
            position: relative;
            border-right: 2px solid #333;
            border-left: 2px solid #333;
            
            padding: 4px;
        }

        .header{
            margin-bottom: 10vh;
        }

        .MainContainer{
            padding-left: 70px;
            padding-right: 70px;
            padding-top: 30px;
            padding-bottom: 30px;
        }

        .container {
            width: 90%;
        }

        .row {
            display:inline-block;
            width: 110%;
            position: relative  !important;
            flex-direction: row  !important; 
            justify-content: center  !important; 
            align-items: center  !important;
            list-style: none  !important;
        }

        .col-md-1{
            width: 8.32%;
        }
        .col-md-2{
            width: 16.65%;
        }
        .col-md-3{
            width: 24.9%;
        }
        .col-md-4{
            width: 33.32%;
        }
        .col-md-5{
            width: 41.65%;
        }
        .col-md-6{
            width: 49.9%;
        }
        .col-md-8{
            width: 66.65%;
        }
        .col-md-12{
            width: 99.9%;
        }

        .table-titles{
            font-size: 15px;
            background-color: #ccc;
            color: #000;
            font-weight: 600;
            width: 100%;
        }

        .table-subtitles{
            font-size: 13px;
            color: #000;
            font-weight: 600;
        }

        .table-text{
            font-size: 12px;
        }

        .signature-text{
            
        }

        .signature-line{
            margin-top: 50px;
            border-bottom: 2px solid #000;
        }

    </style>
</head>
<body>
<div class="container-fluid container MainContainer">

    <!-- LOGO HOSPITAL -->


    <table style="width: 100%; border: none">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-6" >
                    <h1 stule="margin-top: -30px;">CERTIFICADO DE INCAPACIDAD</h1>
                </td>
                <td>
                    <div class="row d-flex justify-content-center header">
                        <div class="col-md-6">
                            <img id="logo" src="LogoHospital.jpg">
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- TABLA DE INCAPACIDAD -->   
    <!-- Información general -->
    <table style="width: 100%; margin-top: 5px;">
        <tbody style="width: 100%">
            <tr>     
                <td class="col table-col table-titles" style="border-top: 2px solid #333;">
                    <div>
                        <label class="">Información general:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr >
                <td  class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Codigo Incapacidad:</label>
                        <label class="table-text">{{ CodIncapacidad }}</label>
                    </div>
                </td>
                <td  class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Fecha:</label>
                        <label class="table-text">{{ FechaExpedicion }}</label>
                    </div>
                </td>
                <td  class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Lugar:</label>
                        <label class="table-text">{{ Lugar }}</label>
                    </div>
                </td>
                <td  class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Duración:</label>
                        <label class="table-text">{{ TotalDias }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    
<!-- Información entidad prestadora de salud -->
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>     
                <td class="col table-col table-titles">
                    <div>
                        <label class="">Entidad prestadora de salud:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr >
                <td class="col-md-8 table-col">
                    <div>
                        <label class="table-subtitles">Razon social:</label>
                        <label class="table-text">{{ RazonSocial }}</label>
                    </div>
                </td>
                <td class="col-md-4 table-col">
                    <div>
                        <label class="table-subtitles">NIT:</label>
                        <label class="table-text">{{ NIT }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

<!-- Información del paciente -->

    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>     
                <td class="col table-col table-titles">
                    <div>
                        <label class="">Datos del paciente:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-6 table-col" style="width: 43%">
                    <div>
                        <label class="table-subtitles">Nombre:</label>
                        <label class="table-text">{{ NombreApellido }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col"  style="width: 22%">
                    <div>
                        <label class="table-subtitles">Tipo de documento:</label>
                        <label class="table-text">{{ TypeIdentification }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Numero de documento:</label>
                        <label class="table-text">{{ IdentificacionPaciente }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-4 table-col">
                    <div>
                        <label class="table-subtitles">Codigo de Aseguradora:</label>
                        <label class="table-text">{{ CodAseguradora }}</label>
                    </div>
                </td>
                <td class="col-md-8 table-col">
                    <div>
                        <label class="table-subtitles">Nombre de Aseguradora:</label>
                        <label class="table-text">{{ NomEntidad }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

<!-- Información de la incapacidad -->

    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>     
                <td class="col table-col table-titles">
                    <div>
                        <label class="">Detalles de la Incapacidad:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-4 table-col">
                    <div>
                        <label class="table-subtitles">Grupo de servicios:</label>
                        <label class="table-text">{{ GroupService }}</label>
                    </div>
                </td>
                <td class="col-md-8 table-col">
                    <div>
                        <label class="table-subtitles">Modalidad del servicio:</label>
                        <label class="table-text">{{ ModelService }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td colspan="2" class="col-md-12 table-col">
                    <div>
                        <label class="table-subtitles">Diagnostico Principal:</label>
                        <label class="table-text">{{ DiagnosticoP }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td colspan="2" class="col-md-12 table-col">
                    <div>
                        <label class="table-subtitles">Diagnostico Relacionado:</label>
                        <label class="table-text">{{ DiagnosticoR }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-4 table-col">
                    <div>
                        <label class="table-subtitles">Origen de la incapacidad:</label>
                        <label class="table-text">{{ OrigenIncapacidad }}</label>
                    </div>
                </td>
                <td class="col-md-8 table-col">
                    <div>
                        <label class="table-subtitles">Causa que motiva la atención:</label>
                        <label class="table-text">{{ CausaAtencion }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td colspan="3" class="col-md-12 table-col">
                    <div>
                        <label class="table-subtitles">Incapacidad retroactiva:</label>
                        <label class="table-text">{{ RetroActive }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-5 table-col">
                    <div>
                        <label class="table-subtitles">Fecha de inicio de la incapacidad:</label>
                        <label class="table-text">{{ FechaInicial }}</label>
                    </div>
                </td>
                <td class="col-md-5 table-col">
                    <div>
                        <label class="table-subtitles">Fecha terminación de la incapacidad:</label>
                        <label class="table-text">{{ FechaFinal }}</label>
                    </div>
                </td>
                <td class="col-md-2 table-col">
                    <div>
                        <label class="table-subtitles">Prórroga:</label>
                        <label class="table-text">{{ Prorroga }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

<!-- Información del medico -->
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>     
                <td class="col table-col table-titles">
                    <div>
                        <label class="">Medico que expide la incapacidad:</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td class="col-md-6 table-col" style="width: 43%">
                    <div>
                        <label class="table-subtitles">Nombre:</label>
                        <label class="table-text">{{ NombreMedico }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col" style="width: 22%">
                    <div>
                        <label class="table-subtitles">Tipo de documento:</label>
                        <label class="table-text">{{ TipoIDMedico }}</label>
                    </div>
                </td>
                <td class="col-md-3 table-col">
                    <div>
                        <label class="table-subtitles">Numero de documento:</label>
                        <label class="table-text">{{ IdentificacionMedico }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%">
        <tbody style="width: 100%">
            <tr>
                <td colspan="2" class="col-md-8 table-col">
                    <div>
                        <label class="table-subtitles">Especialidad:</label>
                        <label class="table-text">{{ Especialidad }}</label>
                    </div>
                </td>
                <td colspan="2" class="col-md-4 table-col">
                    <div>
                        <label class="table-subtitles">Registro:</label>
                        <label class="table-text">{{ Registro }}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>


    <!-- FINAL DE TABLA DE INCAPACIDAD -->

    <!-- FIRMAS -->
    <!--<table style="width: 100%; margin-top: 60px; border: none">
        <tbody style="width: 100%">
            <tr>
                <td>
                    <label class="table-subtitles">Firma del Paciente:</label>
                    <div class="col-md-8 signature-line"></div>
                </td>
                <td>
                    <label class="table-subtitles">Firma del Medico:</label>
                    <div class="col-md-8 signature-line"></div>
                </td>
            </tr>
        </tbody>
    </table>-->


</div>
</body>
</html>
