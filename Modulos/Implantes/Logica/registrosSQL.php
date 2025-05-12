<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_implantes";

// // Crear conexión
// $conexion = new mysqli($servername, $username, $password, $dbname);

// // Verificar conexión
// if ($conexion->connect_error) {
//     die("Conexión fallida: " . $conexion->connect_error);
// }
include('../../../config/Conexion.php');

// Verificar la conexión
if ($conexion->connect_error) {
    die(json_encode(array("error" => "Conexión fallida: " . $conexion->connect_error)));
}


header('Content-Type: application/json'); // Especificamos que queremos retornar JSON

if (isset($_POST['valor'])) {
    $episodio = trim($_POST['valor']); // Recuperamos el valor del episodio que manda AJAX
    $numero_identificacion = trim($_POST['valor']); // Recuperamos el número de identificación

    // Validar si los valores son nulos o vacíos
    if (empty($episodio) || empty($numero_identificacion)) {
        echo json_encode(array("error" => "Los valores de episodio o número de identificación no pueden estar vacíos."));
        exit; // Detenemos la ejecución del script
    }

    $sql = "SELECT DISTINCT
                Episodio,
                Numero_identificacion,
                Nombre_paciente,
                Aseguradora,
                Nombre_cirujano, 
                Especialidad,
                fecha_cirugía, 
                Observaciones, 
                tid.diagnosticoNombre,
                tbl_casa_comercial.nombre_casaComer,
                tid.tipoImplante,
                tid.entrenamiento_Soport,
                tid.tiempo_Soporte,
                tid.material_complet,
                tid.falla_implant_cx,
                tid.impl_tiempo_corpaul,
                tid.impl_completo_corpaul
            FROM tbl_implantes ti
            INNER JOIN tbl_implantes_detalles tid ON ti.Id_paciente = tid.Id_paciente
            INNER JOIN tbl_casa_comercial ON tid.Id_casa_Comercial = tbl_casa_comercial.id_casa_comer
            WHERE (Episodio = ? OR Numero_identificacion = ?)
            ORDER BY fecha_cirugía ASC;";

            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("ss", $episodio, $numero_identificacion); // Ajustamos los parámetros para incluir ambos valores

                if ($stmt->execute()) {
                    $result = $stmt->get_result(); // Obtenemos los resultados de la consulta
                    $data = array(); // Creamos un array
                    if ($result->num_rows > 0) {
                        while ($fila = $result->fetch_assoc()) { // Convertimos el resultado en un array asociativo y lo guardamos en $fila
                            $data[] = $fila;
                        }
                    } 
                    echo json_encode($data);
                } else {
                    echo json_encode(array("error" => "Error en la ejecución de la consulta: " . $stmt->error));
                }

                $stmt->close();
            } else {
                echo json_encode(array("error" => "Error en la preparación de la consulta: " . $conexion->error));
            }
            } else {
            echo json_encode(array("error" => "No se recibieron los datos necesarios."));
            }

            $conexion->close();
            ?>
