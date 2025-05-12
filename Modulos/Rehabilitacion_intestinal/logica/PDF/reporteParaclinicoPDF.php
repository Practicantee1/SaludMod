<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <title>Reporte exámenes</title>
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
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e8e8e8;
        }

        .table-header {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .table-footer {
            margin-top: 20px;
            text-align: right;
            font-style: italic;
            font-size: 12px;
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

<table style="width: 100%; margin: auto; margin-top: 50px; border: none ">
    <tbody style="width: 100%; margin: auto; ">
        <tr>
            <!-- <td> -->
                <div class="row d-flex justify-content-center header">
                    <div class="col-md-6">
                        <img id="logo" src="http://localhost/SaludMod/Modulos/Rehabilitacion_intestinal/logica/PDF/LogoHospital.jpg" alt="Logo del Hospital">
                    </div>
                <!-- </div> -->
            </td>
        </tr>
    </tbody>
</table>
<table style="width: 100%; margin: auto; margin: 25px 0; border: none">
    <tbody style="width: 100%; margin: auto;">
        <tr class="col-md-6">
            <!-- <td > -->
                <h3 style="margin-top: -30px; text-align: center;">REPORTE PARACLINICO</h3>
            <!-- </td> -->
        </tr>
    </tbody>
</table>

    <!-- Información del paciente -->
    <table style="width: 90%; margin: auto;">
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
    <div>
        {{ patient_data }}
    </div>
    <table style="width: 90%; margin: auto; margin-top: 20px;">
        <tr>
            <td class="col table-col table-titles">EXÁMENES</td>
        </tr>
    </table>
    <table style="width: 90%; margin: auto;">
        <thead>
            <tr >
                <th>NOMBRE DEL EXAMEN</th>
                <!-- Columnas dinámicas para fechas y horas -->
                {{ headers }}
            </tr>
        </thead>
        <tbody >
            {{ examenes }}
        </tbody>
    </table>


</div>
</body>
</html>