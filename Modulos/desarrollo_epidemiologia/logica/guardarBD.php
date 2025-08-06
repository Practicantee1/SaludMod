<?php
include('../../../config/Conexion.php');

// Conectar a la base de datos usando mysqli
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
// Comprobar la conexi n
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}
$conexion->set_charset("utf8mb4"); 

// Verificar la conexi n
if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conexion->connect_error]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
file_put_contents('php://stderr', print_r($data, true));

// Obtener los datos enviados
$data = json_decode(file_get_contents("php://input"), true);


$tipo_documento = $data['tipo_documento'] ?? '';
$documento = $data['documento'] ?? '';
$nombre = $data['nombre'] ?? '';
$Fecha_nacimiento =$data['Fecha_nacimiento'] ?? '';
$genero = $data['genero'] ?? '';
$Email =$data['Email'] ?? '';
$Telefono =$data['Telefono'] ?? '';
$episodio = $data['episodio'] ?? '';
$Clase_Episodio =$data['Clase_Episodio'] ?? '';
$F_Inicio_atencion =$data['F_Inicio_atencion'] ?? '';
$Id_aseguradora =$data['Id_aseguradora'] ?? '';
$entidad = $data['entidad'] ?? '';
$F_Ini_realcion_aseguradora =$data['F_Ini_realcion_aseguradora'] ?? '';
$F_Fin_realcion_aseguradora =$data['F_Fin_realcion_aseguradora'] ?? '';

$evaluacionesnav = $data['evaluacionesnav'] ?? '';
$evaluacionesits = $data['evaluacionesits'] ?? '';
$evaluacionesistu = $data['evaluacionesistu'] ?? '';
$observaciones = $data['observaciones'] ?? '';
$estado = $data['estado'] ?? '';
$idProfesional = $data['id_usuario_registra'] ?? '';
$ubicacion = $data['ubicacion'] ?? '';
$cama = $data['cama'] ?? '';
$tipo_escala = $data['tipo_escala'] ?? '';
$centrosanitario = $data['centrosanitario'] ?? '';

$evaluacionesnav1 = json_encode($evaluacionesnav, JSON_UNESCAPED_UNICODE);
$evaluacionesits1 = json_encode($evaluacionesits, JSON_UNESCAPED_UNICODE);
$evaluacionesistu1 = json_encode($evaluacionesistu, JSON_UNESCAPED_UNICODE);




// Verificar si hay datos para guardar

try {
    

    $query = "CALL sp_guardar_paciente_episodio(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssssssssss",$tipo_documento,$documento,$nombre,$Fecha_nacimiento,$genero,$Email,$Telefono,$episodio,$Clase_Episodio,$F_Inicio_atencion,$Id_aseguradora,$entidad,$F_Ini_realcion_aseguradora,$F_Fin_realcion_aseguradora    );
    $stmt->execute();
    $stmt->close();

    $result = $conexion->query("SELECT id_paciente FROM tbl_pacientes WHERE numero_documento = '$documento' ORDER BY id_paciente DESC LIMIT 1");

    if ($result && $row = $result->fetch_assoc()) {
        $idPaciente = $row['id_paciente'];

        // Guardar evaluaciones
        $query = "CALL SP_guardar_evaluaciones_bundles(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssssssssssss", $idPaciente, $episodio, $evaluacionesnav1, $evaluacionesits1, $evaluacionesistu1, $observaciones, $estado, $idProfesional, $ubicacion, $cama, $tipo_escala, $centrosanitario);
        $stmt->execute();
        $stmt->close();
        ob_clean();
        echo json_encode(['status' => 'success', 'idPaciente' => $idPaciente]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se obtuvo el ID del paciente']);
    }

// } catch (mysqli_sql_exception $e) {
//     echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $e->getMessage()]);
// }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}

$conexion->close();
?>
