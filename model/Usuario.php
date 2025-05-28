<?php 
//Incluímos inicialmente la conexión a la base de datos
//require "../config/Conexion.php";
require __DIR__ . "/../config/Conexion.php";

Class Usuario
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$permisos)
	{

		$sw=true;

		$sql="CALL SP_InsertarUsuario('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave',@LastId)";
		
		// return ejecutarConsulta($sql);
		$row=ejecutarConsulta($sql);

		if ($row !== false && $row->num_rows > 0) {
		$ASSOC = mysqli_fetch_assoc($row);
		}

		$idusuarionew = $ASSOC["LastId"];
		$num_elementos=0;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "CALL SP_InsertarPermiso('$idusuarionew', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	public function RegistrarGoogle($email,$roles)
	{
		$sw=true;
		$num_elementos=0;
		

		while ($num_elementos < count($roles))
		{
			$sql_detalle = "CALL SPGoogle_InsertarUsuario('$email', '$roles[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para editar registros
	public function editar($idusuario,$nombre,$telefono,$email,$cargo,$login,$clave,$permisos)
	{
		$sql1="CALL SP_PUser('$idusuario')";
		$select_contrasenia = ejecutarConsulta($sql1);
		if ($select_contrasenia->num_rows > 0) {
			$row = $select_contrasenia->fetch_assoc();
			$clave_bd = $row['clave'];
		
			if ($clave_bd == $clave) {
				$clavea = $clave;
			} else {
				$clavea = hash("SHA256", $clave);
			}
		}
		$sql="CALL SP_ActualizarUsuario('$nombre','$telefono','$email','$cargo','$login','$clavea','$idusuario')";
		ejecutarConsulta($sql);		

		//Eliminamos todos los permisos asignados para volverlos a registrar
		$sqldel="CALL SP_BorrarPermisos('$idusuario')";
		ejecutarConsulta($sqldel);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($permisos))
		{
			$sql_detalle = "CALL SP_InsertarPermiso('$idusuario', '$permisos[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;

	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idusuario)
	{
		$sql="CALL SP_CambiarCondicionUsuario('0','$idusuario')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idusuario)
	{
		$sql="CALL SP_CambiarCondicionUsuario('1','$idusuario')";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idusuario)
	{
		$sql="CALL SP_ObtenerUsuario('$idusuario')";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="CALL SP_ListarUsuarios()";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los permisos marcados
	public function listarmarcados($idusuario)
	{
		$sql="CALL SP_ListarPermisosUsuario('$idusuario')";
		return ejecutarConsulta($sql);
	}

	public function listarRolePermisos($idusuario)
	{
		$sql="CALL SP_ListarPermisosRoles('$idusuario')";
		return ejecutarConsulta($sql);
	}

	//Función para verificar el acceso al sistema
	public function verificar($login,$clave)
    {
    	$sql="CALL SP_VerificarUsuario('$login','$clave')"; 
    	return ejecutarConsulta($sql);  
    }

	// public function googleVerificar($email)
    // {
    // 	$sql="CALL SPGoogle_VerificarUsuario('$email')"; 
    // 	return ejecutarConsulta($sql);  
    // } //Método anterior

	public function googleVerificar($email)
    {
    	$sql="CALL SP_VerificarUsuarioCorreo('$email')"; 
    	return ejecutarConsulta($sql);  
    }

	public function GoogleRoleVerificar($cod)
    {
    	$sql="CALL SPGoogle_ObtenerPermisosPorRol('$cod')"; 
    	return ejecutarConsulta($sql);  
    }

	public function directoryRoleVerificar($cod)
    {
    	$sql="CALL SPDirectorio_ObtenerPermisosPorRol('$cod')"; 
    	return ejecutarConsulta($sql);  
    }

	public function directoryVerificar($login)
    {
    	$sql="CALL SP_ObtenerUsuarioPorLogin('$login')"; 
    	return ejecutarConsulta($sql);  
    }

/* 	public function select()
	{
		$sql="SELECT idusuario, concat(nombre,' ',cargo) as nombres  FROM usuario where condicion=1;";
		return ejecutarConsulta($sql);		
	} */

}

?>