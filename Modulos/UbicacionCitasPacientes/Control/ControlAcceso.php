<?php
include('../../../config/Conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["IDNumber"]) && isset($_POST["Status"])) {
        $idNumber = $_POST["IDNumber"];
        $status = $_POST["Status"];

        // Establecer la conexión a la base de datos
        if ($conexion->connect_error) {
            die("La conexión ha fallado: " . $conexion->connect_error);
        }

        // Consulta para contar acompañantes activos
        
        $sqlAcompanantes = "SELECT COUNT(*) AS Total_Acompaniantes FROM tbl_pacientesAcompaVisit WHERE Estado = 'Activo' AND id_Paciente = '$idNumber'";
        $resultAcompanantes = $conexion->query($sqlAcompanantes);

        if ($resultAcompanantes) {
            $rowAcompanantes = $resultAcompanantes->fetch_assoc();
            $totalAcompanantes = $rowAcompanantes['Total_Acompaniantes'];

            // Consulta para obtener capacidad máxima según el tipo de sala
            $sqlTipoSala = "SELECT Acompaniantes FROM Acompanante_por_paciente WHERE Tipo_Sala = '$status'";
            $resultTipoSala = $conexion->query($sqlTipoSala);

            if ($resultTipoSala && $resultTipoSala->num_rows > 0) {
                $rowTipoSala = $resultTipoSala->fetch_assoc();
                $capacidadMaxima = $rowTipoSala['Acompaniantes'];

                // Comparar la cantidad de acompañantes activos con la capacidad máxima
                if ($totalAcompanantes >= $capacidadMaxima) {
                    echo json_encode(array('status' => 'error', 'message' => 'No se pueden agregar más acompañantes. Capacidad máxima alcanzada.'));
                } else {
                    echo json_encode(array('status' => 'success', 'message' => 'Puede agregar más acompañantes.'));
                }
            }
        }

        $conexion->close();
        
    }
}
?>
