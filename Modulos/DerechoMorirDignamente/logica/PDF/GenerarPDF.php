<?php
// Incluye la conexión a la base de datos
include('../../../../config/Conexion.php');

// Carga las librerías necesarias de Dompdf
require "../../../../dompdf/vendor/autoload.php";

require "../../../../lib/PHPMailer/Exception.php";
require "../../../../lib/PHPMailer/PHPMailer.php";
require "../../../../lib/PHPMailer/SMTP.php";
use Dompdf\Dompdf;
use Dompdf\Options;


use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id = 0;


if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = $_GET["id"];
}
// Inicializa la variable de ID

//$dompdf = new Dompdf;   //crear objeto pdf comun
$options = new Options;
$options->setChroot(__DIR__);
$options->set('isRemoteEnabled', true);
$options->set('margin_left', 20);
$options->set('margin_right', 20);
$options->set('margin_top', 20);
$options->set('margin_bottom', 30);

$dompdf = new Dompdf($options);  //Crear objeto PDF, que, en caso de contener imagenes pueda acceder a ellas facilmente,

$dompdf->setPaper("letter","portrait");

//Captura todo el codigo html del archivo
$html = "<div style='margin: 0 20px;'>";
$html = file_get_contents("DerechoMDpdf.php");
$html .= "</div>";


// Verifica si la conexión a la base de datos es exitosa
if (!$conexion) {
    echo "Error de conexión a la base de datos.";
    exit;
}

// Consulta para obtener la información del paciente
$IDQuery = "SELECT * FROM `tbl_DMD_Paciente` WHERE `id` = '$id'";
$result = mysqli_query($conexion, $IDQuery);

// Verifica si la consulta se realizó correctamente
if ($result) {
    $Info = mysqli_fetch_assoc($result);

    // Verifica que se haya encontrado información
    if ($Info) {
        $InfoExtra = json_decode($Info['terminos'], true);

        // Reemplaza las variables en el HTML por los datos obtenidos
        $html = str_replace("{{ id }}", $Info["id"], $html);
        $html = str_replace("{{ fechaSolicitud }}", $Info["fechaSolicitud"], $html);
        $html = str_replace("{{ Ciudad }}", $Info["Ciudad"], $html);
        $html = str_replace("{{ nombrePaciente }}", $Info["nombrePaciente"], $html);
        $html = str_replace("{{ CedulaPaciente }}", $Info["CedulaPaciente"], $html);
        $html = str_replace("{{ p1 }}", $InfoExtra["Conozco el diagnóstico de la enfermedad grave o terminal que padece el paciente. ¿Cuál?"], $html);
        $html = str_replace("{{ p2 }}", $InfoExtra["El padecimiento de esta enfermedad terminal le produce intensos dolores y sufrimientos."], $html);
        $html = str_replace("{{ p3 }}", $InfoExtra["Se le ha ofrecido al paciente otras alternativas como las del cuidado paliativo para el tratamiento integral del dolor, el alivio del sufrimiento y otros síntomas."], $html);
        $html = str_replace("{{ p4 }}", $InfoExtra["Actualmente el paciente se encuentra recibiendo cuidados paliativos."], $html);
        $html = str_replace("{{ p5 }}", $InfoExtra["El consentimiento del paciente está libre de presiones de terceros y no es producto de episodios anímicos o momentos que puedan afectar el sentido de su decisión."], $html);
        $html = str_replace("{{ p6 }}", $InfoExtra["Se le han aclarado al paciente todas sus dudas, explicando el procedimiento y ha comprendido la naturaleza del mismo."], $html);
        $html = str_replace("{{ p7 }}", $InfoExtra["El consentimiento del paciente es producto de episodios anímicos o momentáneos que puedan afectar el sentido de su decisión."], $html);
        $html = str_replace("{{ p8 }}", $InfoExtra["Se le informo al paciente que en cualquier momento del proceso puedo desistir de la solicitud y optar por otras alternativas terapéuticas como los cuidados paliativos."], $html);
        

        function dividirObservaciones($observaciones, $maxCaracteres = 6000) {
            $partes = [];
            while (strlen($observaciones) > $maxCaracteres) {
                $pos = strrpos(substr($observaciones, 0, $maxCaracteres), " ");
                $partes[] = substr($observaciones, 0, $pos);
                $observaciones = substr($observaciones, $pos);
            }
            $partes[] = $observaciones;
            return $partes;
        }
        
        $observaciones = $Info['observaciones'];
        $partesObservaciones = dividirObservaciones($observaciones);
        $htmlObservaciones = "<div style='page-break-before: always; margin-top: 20px;'>";
        foreach ($partesObservaciones as $index => $parte) {
            if ($index === 0) {
                $htmlObservaciones .= "<div style='page-break-inside: avoid; margin-top: 20px;'>
                    <table style='width: 95%; margin: auto; margin-top:15px;'>
                        <tbody style='width: 100%; margin: auto;'>
                            <tr>     
                                <td class='col table-col table-titles' style='border:2px solid #333'>
                                    <div>
                                        <label>OBSERVACIONES:</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>     
                                <td class='col table-col'>
                                    <div style='page-break-before: auto; page-break-inside: avoid; margin-top: 15px;'>
                                        " . nl2br(trim($parte)) . "
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>";
            } else {
                $htmlObservaciones .= "<div style='page-break-before: always; margin-top: 20px;'>
                <table style='width: 95%; margin: auto; margin-top:50px;'>
                    <tbody style='width: 100%; margin: auto;'>
                        <tr>     
                            <td class='col table-col' style='border:2px solid #333'>
                                <div style='page-break-inside: avoid; margin-top: 15px;'>
                                     " . nl2br(trim($parte)) . "
                                <div>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                    
                </div>"
                ;
            }
        }
        
        $html = str_replace("{{ observaciones }}", $htmlObservaciones, $html);

        $html = str_replace("{{ nombreMedico }}", $Info["nombreMedico"], $html);
        $html = str_replace("{{ RegistroMedico }}", $Info["RegistroMedico"], $html);
        $html = str_replace("{{ tipoDocumentoMedico }}", $Info["tipoDocumentoMedico"], $html);
        $html = str_replace("{{ numeroDocumentoMedico }}", $Info["numeroDocumentoMedico"], $html);
        $html = str_replace("{{ Especialidad }}", $Info["Especialidad"], $html);
        $html = str_replace("{{ edad }}", $Info["Edad"], $html);
        $html = str_replace("{{ tipoDocumentop }}", $Info["TipoDocumentoPaciente"], $html);

        
    } else {
        echo "No se encontró información para el ID proporcionado.";
        exit;
    }
} else {
    echo "Error en la consulta a la base de datos.";
    exit;
}


// Pie de p�gina din�mico
$footer1 = "ESTE ES UN REGISTRO REALIZADO EN FORMA ELECTRÓNICA";
$footer2 = ($Info["centrosanitario"] === "HSVM") ?
    "FUNDACIÓN HOSPITALARIA SAN VICENTE DE PAúL MEDELLÍN - 890900518-4 - Calle 64 No.51 D-154 - (57-4)4441333" :
    "FUNDACIÓN HOSPITAL SAN VICENTE DE PAúL RIONEGRO - 900261353-9 - Vereda la Convención KM 2.3 Vía Aeropuerto - Llano Grande - (+57)4448717";

$dompdf->loadHtml($html);
$dompdf->render();
$canvas = $dompdf->getCanvas();
$canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) use ($footer1, $footer2) {
    $width = $canvas->get_width();
    $y = $canvas->get_height() - 68;
    $font = $fontMetrics->get_font("helvetica", "normal");
    $textWidth1 = $fontMetrics->getTextWidth($footer1, $font, 8);
    $textWidth2 = $fontMetrics->getTextWidth($footer2, $font, 8);
    $canvas->text(($width - $textWidth1) / 2, $y, $footer1, $font, 8);
    $canvas->text(($width - $textWidth2) / 2, $y + 12, $footer2, $font, 8);
    // Agrega la paginaci�n
    $paginationText = "Página $pageNumber de $pageCount";
    $textWidthPagination = $fontMetrics->getTextWidth($paginationText, $font, 8);
    $canvas->text(($width - $textWidthPagination) / 2, $y + 24, $paginationText, $font, 8);
});
// Envía el PDF al navegador
$dompdf->stream("Solicitud-Derecho-Morir-Dignamente-" . $id, ["Attachment" => 0]);

$pdfOutput = $dompdf->output();

 $pdfFilePath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
 file_put_contents($pdfFilePath, $pdfOutput);
 $mail = new PHPMailer(true);

 // Agregar las opciones SMTP
 $mail->SMTPOptions = array(
     'ssl' => array(
         'verify_peer' => false,
         'verify_peer_name' => false,
         'allow_self_signed' => true,
     ),
 );
 
 try {
     // Server settings
     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = '172.28.77.34';                     //Set the SMTP server to send through
     $mail->SMTPAuth   = false;                                   //Enable SMTP authentication
     $mail->Username   = ''; //SMTP username
     $mail->Password   = '';                               //SMTP password
     $mail->SMTPSecure = '';            //Enable implicit TLS encryption
     $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 
     // Recipients
    $mail->setFrom('noreply@sanvicentefundacion.com', 'No Reply');
    if ($Info["centrosanitario"] === "HSVM") {
        $mail->addAddress('loren.benjumea@sanvicentefundacion.com', '');
        $mail->addAddress('isabel.betancur@sanvicentefundacion.com', '');
        $mail->addAddress('sara.perezg@sanvicentefundacion.com', '');

    } else {
        $mail->addAddress('sara.perezg@sanvicentefundacion.com', '');
        $mail->addAddress('marcela.castro@sanvicentefundacion.com', '');
        $mail->addAddress('juan.tamayo@sanvicentefundacion.com', '');

    }
    //$mail->addAddress('juan.bravo@sanvicentefundacion.com', ''); //Add a recipient
    //$mail->addAddress('juana.ospina@sanvicentefundacion.com', ''); //Add a recipient
    // //Add a recipient
    // //Add a recipient
    // //Add a recipient

    //$mail->addAddress('isabel.betancur@sanvicentefundacion.com', ''); //Add a recipient  
     // Attachments
     $mail->addAttachment($pdfFilePath, 'Solicitud-Derecho-Morir-Dignamente-' . $id . '.pdf');
 
     // Content
     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'Notificacion solicitud muerte digna';
     $cuerpoCorreo2 = "Cordial saludo,<br><br>Se notifica una nueva solicitud para el comite de muerte digna.; ver archivo adjunto.<br><br>Cordialmente,";

     $mail->Body = '<div style="text-align: left;" >' . nl2br($cuerpoCorreo2) . '</div>';
     $mail->AltBody = strip_tags($cuerpoCorreo2);

    //  $mail->Body = '<div style="text-align: center;">' . nl2br($cuerpoCorreo) . '</div>';
    
    //  $mail->AltBody = '<div style="text-align: center;">'.$cuerpoCorreo. '</div>';
 
     $mail->send();
     echo 'Message has been sent';
 } catch (Exception $e) {
     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
 }
 // Eliminar el archivo temporal
 unlink($pdfFilePath);
?>
