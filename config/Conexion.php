<?php
require_once "global.php";

$conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');


if(mysqli_connect_errno())
{
    printf("Falló la conexión a la base de datos: %s\n",mysqli_connect_error());
    exit();
}
if(! function_exists('ejecutarConsulta'))
{
    function ejecutarConsulta($sql)
    {
        global $conexion;
        if ($conexion->more_results()) {
            $conexion->next_result();
        }
        $query = $conexion->query($sql);
        return $query;
    }
    
    function ejecutarConsultaSimpleFila($sql)
    {
        global $conexion;
        if ($conexion->more_results()) {
            $conexion->next_result();
        }
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }
    function ejecutarConsulta_retornarID($sql)
    {
        global $conexion;
        if ($conexion->more_results()) {
            $conexion->next_result();
        }
        $query = $conexion->query($sql);
        $id = $conexion->insert_id;
        return $id;
      
    }
    function limpiarCadena($str)
    {
        global $conexion;
        if ($conexion->more_results()) {
            $conexion->next_result();
        }
        $str = mysqli_real_escape_string($conexion, trim($str));
        
        return htmlspecialchars($str);
        
    }
}

?>
