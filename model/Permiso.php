<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	
	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="CALL SP_ListarPermisos()";
		return ejecutarConsulta($sql);		
	}

	public function listarRoles()
	{
		$sql="CALL SPGoogle_ListarRoles()";
		return ejecutarConsulta($sql);		
	}
	public function listarPermisos()
	{
		$sql="CALL SP_ListarPermisos()";
		return ejecutarConsulta($sql);		
	}

}

?>