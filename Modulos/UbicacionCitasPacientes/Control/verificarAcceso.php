<?php
// //**
// *
// * Este script verifica el acceso de un visitante o acompañante basado en su documento.
// * 
// * Requiere el archivo de configuración de la base de datos.
// * 
// * @package SaludMod
// * @subpackage Modulos/UbicacionCitasPacientes/Control
// * 
// * @requires ../../../config/Conexion.php
// * 
// * @header Content-Type: text/html; charset=UTF-8
// * 
// * @method POST
// * @param string $_POST['documento'] El documento del visitante o acompañante.
// * 
// * @throws Exception Si el campo 'documento' está vacío.
// * 
// * @return void
// * 
// * @example
// * // Ejemplo de uso:
// * // Enviar una solicitud POST con el campo 'documento' para verificar el acceso.
// * 
// * @see Conexion.php
// * 
// * @version 1.0.0
// * @since 2023-10-01
// * 
// * @todo Mejorar la gestión de errores y excepciones.
// * 
// * @license MIT
// *//
require_once '../../../config/Conexion.php';

header("Content-Type: text/html; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['documento'])) {
    $documento = trim($_POST['documento']);

    // Verificar si el campo 'documento' está vacío
    if (empty($documento)) {
        echo "<p style='color: red;'>Error: El campo 'documento' es obligatorio.</p>";
        exit;
    }

    // Verificar restricciones de acompañantes
    $sqlRestricciones = "SELECT r.tipoRestriccion 
                         FROM tbl_restriccionesAcompananteVisitantes rp 
                         JOIN tbl_restricciones r ON rp.tipoRestriccion = r.id_restriccion 
                         WHERE rp.numeroDocumentoAcomVisi = ?";
    $stmt = $conexion->prepare($sqlRestricciones);
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Si se encuentra una restricción, se deniega el acceso
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<div style='color: red; font-size: 24px; font-weight: bold; text-align: center;'>
                 ACCESO DENEGADO 
              </div>
              <p style='color: red; font-size: 18px; text-align: center;'>
                Restriccion encontrada. <br>
                <strong>- Tipo de Restriccion: {$row['tipoRestriccion']}</strong>
              </p>";
        exit;
    }
    

    // Verificar en la tabla de riesgos del paciente
    $sqlRiesgos = "SELECT rp.numeroDocumentoRiesgos, r.tipoRiesgo, rp.observaciones
                   FROM tbl_riesgoPaciente rp
                   JOIN tbl_riesgo r ON rp.tipoRiesgo = r.id_Riesgos
                   WHERE rp.numeroDocumentoRiesgos = ?";
    $stmt = $conexion->prepare($sqlRiesgos);
    $stmt->bind_param("s", $documento);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si se encuentran riesgos, se muestra una advertencia
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<div style='color: red; font-size: 24px; font-weight: bold; text-align: center;'>
                 ADVERTENCIA: RIESGO ENCONTRADO 
              </div>
              <p style='color: red; font-size: 18px; text-align: center;'>
                <strong>- Tipo de Riesgo:</strong> {$row['tipoRiesgo']} <br>
                <strong>- Detalles:</strong> {$row['observaciones']}
              </p>";
    } else {
        // Si no se encuentran restricciones ni riesgos, se permite el acceso
        echo "<div style='color: green; font-size: 24px; font-weight: bold; text-align: center;'>
                 ACCESO PERMITIDO 
              </div>
              <p style='color: green; font-size: 18px; text-align: center;'>
                No se encontraron restricciones ni riesgos.
              </p>";
    }
    
}
?>
