<?php
require_once '../../../config/Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["IDNumber"])) {
        $numId = $_POST["IDNumber"];

        if ($conexion->connect_error) {
            die("La conexión ha fallado: " . $conexion->connect_error);
        }
        $sql = "SELECT * FROM tbl_pacientesAcompaVisit WHERE id_Paciente = '$numId' AND estado = 'Activo'";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            // Construir la tabla de registros de acompañantes
            $output = '';
            while ($row = $result->fetch_assoc()) {
                $output .= '<tr id="ingreso' . $row['id_number'] . '">';
                $output .= '<td><input type="checkbox" name="selectRows[]" class="select-checkbox" value="' . $row['id_number'] . '" id="registro_' . $row['id_number'] . '"></td>'; // esto sirve para seleccionar los registros, actualiza lel esdtado de los checkbox
                $output .= '<td style="display: none">' . $row['id_number'] . '</td>';

                // Convertir el BLOB a base64 y mostrarlo como imagen
                if ($row['img']) {
                    // Convertir el BLOB (contenido binario) a una cadena base64
                    $img_base64 = base64_encode($row['img']);

                    // Crear el código HTML para mostrar la imagen con un evento onClick
                    $output .= '<td><img src="data:image/jpeg;base64,' . $img_base64 . '" alt="Imagen" style="width: 100%; height: auto;" onclick="openModal(this.src)"></td>';
                } else {
                    // Si no hay imagen, mostrar un texto alternativo o dejar vacío
                    $output .= '<td>No disponible</td>';
                }


                $output .= '<td>' . $row['id_Paciente'] . '</td>';
                $output .= '<td>' . $row['tipo_documento'] . '</td>';
                $output .= '<td>' . $row['Numero_Identificacion'] . '</td>';
                $output .= '<td>' . $row['Nombre_Acompanante'] . '</td>';
                $output .= '<td>' . $row['apellidos_AcompaVisit'] . '</td>';
                $output .= '<td>' . $row['genero_AcompaVisit'] . '</td>';
                $output .= '<td>' . $row['telefono_AcompaVisit'] . '</td>';
                $output .= '<td>' . $row['direccion_AcompaVisit'] . '</td>';
                $output .= '<td>' . $row['Tipo_Ingreso'] . '</td>';
                $output .= '<td>' . $row['Fecha_Ingreso'] . '</td>';
                $output .= '<td>' . $row['Hora_Ingreso'] . '</td>';
                //$output .= '<td>' . $row['Fecha_Salida'] . '</td>';
                //$output .= '<td>' . $row['Hora_Salida'] . '</td>';
                $output .= '<td>' . $row['Estado'] . '</td>';
                $output .= '<td>' . $row['id_cama'] . '</td>';
                $output .= '</tr>';
            }

            echo $output;
        } else {
            echo "<tr><td colspan='15'> No se encontraron registros de acompañantes para este paciente. </td></tr>";
        }
        $conexion->close();
    } else {
        echo "No exíste el registro";
    }
} else {
    echo "No se ha realizado una solicitud POST.";
}
