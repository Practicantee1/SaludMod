<?php
include('../../../config/Conexion.php');


// Verificar la conexión
if ($conexion->connect_error) {
    echo json_encode(['error' => "Conexión fallida: " . $conexion->connect_error]);
    exit();
}

if (isset($_POST['episodio'])) {
    $episodio = $_POST['episodio'];
    
    // Validar si el episodio ya existe
    $checkEpisodioQuery = "SELECT COUNT(*) as count 
                        FROM tbl_paciente_formulario_cirugia 
                           WHERE (episodio = '$episodio' OR  episodio = SUBSTRING('$episodio', 4)) 
                           AND (entrada = 'PENDIENTE' 
                           OR pausa = 'PENDIENTE' 
                           OR salida = 'PENDIENTE' 
                           OR firmaEntrada = 'PENDIENTE' 
                           OR firmaSalida = 'PENDIENTE')";
    $checkResult = $conexion->query($checkEpisodioQuery);
    $checkRow = $checkResult->fetch_assoc();

    if ($checkRow['count'] > 0) {
        // Si el episodio ya existe, envía un mensaje de error
        echo json_encode(['error' => "No se puede guardar, el episodio $episodio tiene un formulario anterior pendiente"]);
        exit; // Asegúrate de salir después de enviar la respuesta
    }else {
        $num_documento = $_POST['num_documento'];
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];
        $nombre = $_POST['nombre'];
        $asegurador = $_POST['asegurador'];
        $procedimiento = $_POST['procedimiento'];
        $cirujano = $_POST['cirujano'];
        $especialidad = $_POST['especialidad'];
        $fecha = $_POST['fecha'];
        $centrosanitario = $_POST['centrosanitario'];

        //Ejecutar el primer procedimiento almacenado
        if ($result = $conexion->query("CALL sp_insertar_formulario_cirugia('$episodio', 
                                                        '$num_documento', 
                                                        '$edad', 
                                                        '$sexo', 
                                                        '$nombre', 
                                                        '$asegurador',
                                                        '$cirujano', 
                                                        '$especialidad', 
                                                        '$fecha','$centrosanitario')")) {

        // if ($result = $conexion->query("CALL sp_insertar_formulario_cirugia('$episodio', 
        //                                                     '$num_documento', 
        //                                                     '$edad', 
        //                                                     '$sexo', 
        //                                                     '$nombre', 
        //                                                     '$asegurador',
        //                                                     '$cirujano', 
        //                                                     '$especialidad', 
        //                                                     '$fecha')")) {                                                    
            // Recuperar el ID del paciente insertado
            if ($row = $result->fetch_assoc()) {
                $idPaciente = $row['id_paciente'];
                
                // Liberar el conjunto de resultados
                $result->free();

                // Avanzar a los siguientes resultados de la consulta
                while ($conexion->more_results() && $conexion->next_result()) {
                    // Procesar resultados adicionales si es necesario
                }

                // Datos adicionales
                $nombreIdentificacion = $_POST['nombreIdentificacion'];
                $instrumental = $_POST['instrumental'];
                $alergiaReporta = $_POST['alergiaReporta'];
                $IndicacionAlergiaReport = $_POST['IndicacionAlergia'];
                $consentimiento = $_POST['consentimiento'];
                $marcacion = $_POST['marcacion'];
                $seleccione = $_POST['seleccione'];
                $verificacion = $_POST['verificacion'];
                $confirmacion = $_POST['confirmacion'];
                $esterilidad = $_POST['esterilidad'];
                $monitoreo = $_POST['monitoreo'];
                $perdida = $_POST['perdida'];
                $reserva = $_POST['reserva'];
                $disponibilidad = $_POST['disponibilidad'];
                $estudios = $_POST['estudios'];
                $via = $_POST['via'];
                $antibiotico = $_POST['antibiotico'];
                $IndicacionAntibiotico = $_POST['IndicacionAntibiotico'];
                $suspension = $_POST['suspension'];
                $comercial = $_POST['comercial'];
                $cultivos = $_POST['cultivos'];
                $patologias = $_POST['patologias'];

                $observaciones = $_POST['observaciones'];
                

                // Ejecutar el segundo procedimiento almacenado
                $query_entrada = "CALL sp_entrada_formulario_cirugia('$idPaciente', 
                                                    '$nombreIdentificacion', 
                                                    '$instrumental', 
                                                    '$alergiaReporta', 
                                                    '$consentimiento', 
                                                    '$marcacion',
                                                    '$seleccione',
                                                    '$verificacion', 
                                                    '$confirmacion', 
                                                    '$monitoreo', 
                                                    '$perdida', 
                                                    '$reserva', 
                                                    '$disponibilidad', 
                                                    '$estudios', 
                                                    '$via', 
                                                    '$antibiotico', 
                                                    '$suspension', 
                                                    '$comercial', 
                                                    '$cultivos',
                                                    '$patologias',
                                                    '$observaciones',
                                                    '$IndicacionAlergiaReport',
                                                    '$IndicacionAntibiotico',
                                                    '$esterilidad')";

                // Verificar y ejecutar el procedimiento de entrada
                if ($conexion->query($query_entrada)) {
                    // Ejecutar el procedimiento almacenado para diagnóstico
                    $procedimiento = $_POST['procedimiento'];
                    
                    $query_procedimiento = "CALL sp_procedimiento_formulario_cirugia('$idPaciente',                                                              
                                                                  '$procedimiento')"; 
                    
                    if ($conexion->query($query_procedimiento)) {
                        echo json_encode(['success' => 'Datos guardados correctamente.']);
                    } else {
                        echo json_encode(['error' => "Error en la ejecución de la consulta de diagnóstico: " . $conexion->error]);
                    }
                } else {
                    echo json_encode(['error' => "Error en la ejecución de la consulta de entrada: " . $conexion->error]);
                }

            } else {
                echo json_encode(['error' => "No se pudo recuperar el ID del paciente."]);
            }
        } else {
            echo json_encode(['error' => "Error en la ejecución de la consulta: " . $conexion->error]);
        }
    }
} else {
    echo json_encode(['error' => "No se recibieron datos."]);
}

$conexion->close();
?>
