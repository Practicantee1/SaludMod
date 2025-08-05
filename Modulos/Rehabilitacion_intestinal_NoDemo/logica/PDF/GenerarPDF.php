<?php
// Incluye la conexión a la base de datos
include('../../../../config/Conexion.php');

// Carga las librerías necesarias de Dompdf
require "../../../../dompdf/vendor/autoload.php";
use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET["episodio"]) || empty($_GET["episodio"])) {
    echo "Por favor, proporciona un episodio válido.";
    exit;
}

$episodio = intval($_GET["episodio"]); // Validar el episodio como entero

// Consulta al procedimiento almacenado
$query = "CALL SP_consulta_ultimosDosExamenes_RI($episodio)";
$result = mysqli_query($conexion, $query);


if (!$result) {
    echo "Error al ejecutar el procedimiento almacenado: " . mysqli_error($conexion);
    exit;
}

// Procesar los resultados
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    if (array_filter($row)) { // Filtrar filas vacías
        $rows[] = $row;
    }
}


// Cerrar conexión y liberar resultados
mysqli_free_result($result);
mysqli_close($conexion);

// Verificar si hay datos para mostrar
if (empty($rows)) {
    echo "No hay exámenes disponibles para este episodio.";
    exit;
}


// Configuración de Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generar el contenido HTML
ob_start();
include 'reporteParaclinicoPDF.php';
$html = ob_get_clean();

// Generar encabezados (fechas y horas)
$headers_html = '';
$exam_data = [];

// Generar filas por parámetro
$parametros = array_keys($rows[0]); // Obtén las claves del primer resultado como parámetros
unset($parametros[0], $parametros[1]); // Excluir las columnas de fecha y hora

foreach ($rows as $index => $row) {
    $headers_html .= "<th>{$row['fecha']}<br>{$row['hora']}</th>";
    foreach ($parametros as $param) {
        $exam_data[$param][] = $row[$param];
    }
}

// Generar contenido de la tabla
$examenes_html = '';
foreach ($exam_data as $param => $values) {
    // Empieza a generar las filas desde el parámetro leucocitos (posición 5)
    $start_index = 5;
    $param_keys = array_keys($exam_data); // Obtén las claves del array de exámenes
    if (array_search($param, $param_keys) >= $start_index) {  // Filtrar los parámetros antes de leucocitos
        if (array_filter($values)) {
            $examenes_html .= "<tr><td>{$param}</td>";
            foreach ($values as $value) {
                $examenes_html .= "<td>{$value}</td>";
            }
            $examenes_html .= '</tr>';
        }
    }
}
$patient_data = $rows[0]; // Tomamos el primer registro para los datos del paciente
$patient_html = "
    <table style='width: 90%; margin: auto;'>
        <tbody>
            <tr>
                <td class='col-md-6 table-col' style='width: 43%'>
                    <div>
                        <label class='table-subtitles'>Nombre completo:</label>
                        <label class='table-text'>{$patient_data['nombre']}</label>
                    </div>
                </td>
                <td class='col-md-3 table-col' style='width: 22%'>
                    <div>
                        <label class='table-subtitles'>Edad:</label>
                        <label class='table-text'>{$patient_data['edad']}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <table style='width: 90%; margin: auto;'>
        <tbody>
            <tr>
                <td class='col-md-6 table-col' style='width: 43%'>
                    <div>
                        <label class='table-subtitles'>Tipo de documento:</label>
                        <label class='table-text'>{$patient_data['tipo_documento']}</label>
                    </div>
                </td>
                <td class='col-md-3 table-col' style='width: 22%'>
                    <div>
                        <label class='table-subtitles'>Número de Documento:</label>
                        <label class='table-text'>{$patient_data['numero_documento']}</label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
";

$html = str_replace('{{ headers }}', $headers_html, $html);
$html = str_replace('{{ examenes }}', $examenes_html, $html);
$html = str_replace('{{ patient_data }}', $patient_html, $html);



// Cargar y renderizar el HTML
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

// Enviar el PDF al navegador
$dompdf->stream("Reporte_Paraclinico_$episodio.pdf", ["Attachment" => false]);
?>

// Reemplazar marcadores con los datos obtenidos
// $examenes_html = '';
// foreach ($rows as $row) {
//     $examenes_html .= '<tr>';
//     $examenes_html .= "<td>{$row['fecha']}</td>";
//     $examenes_html .= "<td>{$row['hora']}</td>";
//     $examenes_html .= "<td>{$row['leucocitos']}</td>";
//     $examenes_html .= "<td>{$row['neutrofilos']}</td>";
//     $examenes_html .= "<td>{$row['linfocitos']}</td>";
//     $examenes_html .= "<td>{$row['eosinofilos']}</td>";
//     $examenes_html .= "<td>{$row['hemoglobina']}</td>";
//     $examenes_html .= "<td>{$row['hematocrito']}</td>";
//     $examenes_html .= "<td>{$row['plaquetas']}</td>";
//     $examenes_html .= "<td>{$row['vsg']}</td>";
//     $examenes_html .= "<td>{$row['pcr']}</td>";
//     $examenes_html .= "<td>{$row['tgo_ast']}</td>";
//     $examenes_html .= "<td>{$row['tgp_alt']}</td>";
//     $examenes_html .= "<td>{$row['bilirrubina_total']}</td>";
//     $examenes_html .= "<td>{$row['bilirrubina_directa']}</td>";
//     $examenes_html .= "<td>{$row['ggt']}</td>";
//     $examenes_html .= "<td>{$row['fosfatasa_alcalina']}</td>";
//     $examenes_html .= "<td>{$row['tp_inr']}</td>";
//     $examenes_html .= "<td>{$row['tpt']}</td>";
//     $examenes_html .= "<td>{$row['amilasa']}</td>";
//     $examenes_html .= "<td>{$row['sodio']}</td>";
//     $examenes_html .= "<td>{$row['fosforo']}</td>";
//     $examenes_html .= "<td>{$row['potasio']}</td>";
//     $examenes_html .= "<td>{$row['cloro']}</td>";
//     $examenes_html .= "<td>{$row['calcio']}</td>";
//     $examenes_html .= "<td>{$row['magnesio']}</td>";
//     $examenes_html .= "<td>{$row['colesterol_total']}</td>";
//     $examenes_html .= "<td>{$row['colesterol_hdl']}</td>";
//     $examenes_html .= "<td>{$row['trigliceridos']}</td>";
//     $examenes_html .= "<td>{$row['proteinas_totales']}</td>";
//     $examenes_html .= "<td>{$row['albumina']}</td>";
//     $examenes_html .= "<td>{$row['pre_albumina']}</td>";
//     $examenes_html .= "<td>{$row['electroforesis_proteinas']}</td>";
//     $examenes_html .= "<td>{$row['vitamina_b12']}</td>";
//     $examenes_html .= "<td>{$row['vitamina_d']}</td>";
//     $examenes_html .= "<td>{$row['creatinina']}</td>";
//     $examenes_html .= "<td>{$row['glicemia']}</td>";
//     $examenes_html .= "<td>{$row['gases_hco']}</td>";
//     $examenes_html .= "<td>{$row['gases_eb']}</td>";
//     $examenes_html .= "<td>{$row['gases_ph']}</td>";
//     $examenes_html .= "<td>{$row['aislamientos']}</td>";
//     $examenes_html .= "<td>{$row['examenes_complementarios']}</td>";
//     // Agrega más columnas según sea necesario
//     $examenes_html .= '</tr>';
// }
// $html = str_replace('{{ examenes }}', $examenes_html, $html);
