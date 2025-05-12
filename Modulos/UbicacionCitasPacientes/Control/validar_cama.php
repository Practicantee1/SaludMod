<?php
require_once '../../../config/Conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bedCode = isset($_POST["Bedcode"]) ? $_POST["Bedcode"] : '';
    $idPaciente = isset($_POST["IDNumber"]) ? $_POST["IDNumber"] : '';

    if (empty($bedCode) || empty($idPaciente)) {
        echo json_encode(["error" => "Faltan datos"]);
        exit();
    }

    if ($conexion->connect_error) {
        die("La conexión ha fallado: " . $conexion->connect_error);
    }

    // Obtener la hora actual del servidor
    date_default_timezone_set('America/Bogota'); // Ajusta según tu zona horaria
    $horaActual = date("H:i:s");

    // Obtener horarios de visita desde la tabla Maestro
    $sqlHorario = "SELECT hora_inicio, hora_final, cantidad_acompanantes, cantidad_visitantes
                   FROM tbl_Maestro_visitasAcompanante 
                   WHERE cama = ?";
    $stmt = $conexion->prepare($sqlHorario);
    $stmt->bind_param("s", $bedCode);
    $stmt->execute();
    $stmt->bind_result($horaInicio, $horaFin, $maxAcompanantes, $maxVisitantes);
    $stmt->fetch();
    $stmt->close();

    // Validar si la hora actual está dentro del rango permitido
    if ($horaInicio > $horaFin) {
        // Caso en el que el horario va de la noche a la mañana (ejemplo: 23:00 - 06:00)
        $puedeRegistrar = ($horaActual >= $horaInicio || $horaActual <= $horaFin);
    } else {
        // Caso normal cuando el horario está dentro del mismo día (ejemplo: 08:00 - 20:00)
        $puedeRegistrar = ($horaActual >= $horaInicio && $horaActual <= $horaFin);
    }

    if (!$puedeRegistrar) {
        echo json_encode([
            "error" => " 🕒Fuera del horario de visitas",
            "horaActual" => $horaActual,
            "horaInicio" => $horaInicio,
            "horaFin" => $horaFin
        ]);
        exit();
    }

    // Contar acompañantes y visitantes activos en la cama
    $sqlConteo = "SELECT SUM(CASE WHEN Tipo_Ingreso = 'Acompañante' AND Estado = 'Activo' THEN 1 ELSE 0 END) AS total_acompanantes,
                         SUM(CASE WHEN Tipo_Ingreso = 'Visitante' AND Estado = 'Activo' THEN 1 ELSE 0 END) AS total_visitantes
                  FROM tbl_pacientesAcompaVisit
                  WHERE id_cama = ?";

    $stmt = $conexion->prepare($sqlConteo);
    $stmt->bind_param("s", $bedCode);
    $stmt->execute();
    $stmt->bind_result($totalAcompanantes, $totalVisitantes);
    $stmt->fetch();
    $stmt->close();

    // Validar disponibilidad de cupos
    $canRegisterAcompanante = $totalAcompanantes < $maxAcompanantes;
    $canRegisterVisitante = $totalVisitantes < $maxVisitantes;

    echo json_encode([
        "canRegisterAcompanante" => $canRegisterAcompanante,
        "canRegisterVisitante" => $canRegisterVisitante
    ]);
}
?>
