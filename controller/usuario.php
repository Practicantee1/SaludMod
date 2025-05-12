<?php
if(session_id() === "") session_start();

$PageToGo = isset($_SESSION["PrePage"]) ? $_SESSION["PrePage"] : 'escritorio.php';
require_once "../model/Usuario.php";


$usuario=new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$emailGoogle=isset($_POST["emailGoogle"])? limpiarCadena($_POST["emailGoogle"]):"";
$cargoGoogle=isset($_POST["rolGoogle"])? $_POST["rolGoogle"]:"";
// $imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!empty($idusuario)){
			
			$rspta=$usuario->editar($idusuario,$nombre,$telefono,$email,$cargo,$login,$clave,$_POST['permiso']);
			echo $rspta ? 3 : 4;
		}
		else if(!empty($emailGoogle)){
			$rspta=$usuario->RegistrarGoogle($emailGoogle,$cargoGoogle);
			echo $rspta ? 1 : 2;
		}
		else{

			//Hash SHA256 en la contraseña
			$clavehash=hash("SHA256",$clave);

			$rspta=$usuario->insertar($nombre,'','','',$telefono,$email,$cargo,$login,$clavehash,$_POST['permiso']);
			echo $rspta ? 1 : 2;
		}
		
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="far fa-times-circle"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fas fa-edit"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->telefono,
 				"3"=>$reg->email,
 				"4"=>$reg->login,
 				
 				"5"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../model/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//Almacenar los permisos asignados al usuario en el array
		if($marcados){
			while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->idpermiso);
			}
		}else{
			$valores=[];
		}
		

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
				{
					$sw=in_array($reg->idpermiso,$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.'  name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
				}
	break;

	case 'rolesGoogle':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../model/Permiso.php";
		$permiso = new Permiso();
		$rspta = $permiso->listarRoles();

		//Obtener los permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		//Declaramos el array para almacenar todos los permisos marcados
		$valores=array();

		//Almacenar los permisos asignados al usuario en el array
		if($marcados){
			while ($per = $marcados->fetch_object())
			{
				array_push($valores, $per->id_rol);
			}
		}else{
			$valores=[];
		}
		

		//Mostramos la lista de permisos en la vista y si están o no marcados
		while ($reg = $rspta->fetch_object())
				{
					$sw=in_array($reg->idpermiso,$valores)?'checked':'';
					echo '<li> <input type="checkbox" '.$sw.'  name="rolGoogle[]" value="'.$reg->id_rol.'">'.$reg->nombre_rol.'</li>';
				}
	break;

	case 'directorioactivo':

		require_once '../lib/Lib.php';

		$library = new Lib("lib");
		$library->ldap();

		$user = $_POST['logina'];

		$clave = $_POST['clavea'];

		
		try {
			$da = new adLDAP();
		} catch (Exception $ex) {
			
		}
		

		$validation = $da->authenticate($user, $clave);

		if ($validation) {

			$result = $da->user()->info($user);

			
			
			//VERIFICAR QUE SOLO PERSONAL ESPECIFICO DEL HOSPITAL PUEDA ENTRAR AL APLICATIVO
			//if($result[0]['department'][0] == 'GESTION TIC'){


				//VERIFICA EL ROL QUE TENDRA LA PERSONA SEGUN EL GRUPO AL QUE PERTENEZCA EN DIRECTORIO ACTIVO
				//PARA ESTE APLICATIVO EN PARTICULAR LOS NOMBRES DE GRUPO DEBEN EMPEZAR CON "biberones"
				$cod_directorio="";
				try{
					for($ii = 0; $ii < count($result[0]['memberof']); $ii++){
						if(!isset($result[0]['memberof'][$ii])){break;}
						$text = $result[0]['memberof'][$ii];
						$textArray = explode(",", $text);
						$nameArray = explode("=", $textArray[0]);
						if(!isset($nameArray[1])){break;}
						$cod = $nameArray[1];
						$cod = strtolower($cod);
	
						if (strpos($cod, 'colibri') !== false) {
							$cod_directorio = $cod;
							break;
						}
					}
				}catch(Exception $e){

				}
				
				if($cod_directorio != ""){
					//$user = 'holamundo';
					//

					$_SESSION['nombre']= $result[0]['displayname'][0];
					$_SESSION['login'] = $user;


					//$rspta=$usuario->directoryVerificar($user);
					$rspta=$usuario->directoryRoleVerificar($cod_directorio);


					$fetch=$rspta->fetch_object();


					//$marcados = $usuario->listarmarcados($fetch->idusuario);
					$marcados = $usuario->listarRolePermisos($fetch->idpermiso);
				
					$valores=array();
			
					while ($per = $marcados->fetch_object())
					{
						array_push($valores, $per->idpermiso);
					}
					
					$permisos = $permiso->listarPermisos();

					$valores = [/* valores de permisos asignados al usuario */]; // Define aquí los permisos que el usuario tiene

					foreach ($permisos as $permiso) {
						$id = $permiso['dpermiso'];
						$nombre = strtolower($permiso['nombre']); // Nombre en minúscula para usar como clave de sesión
					
						$_SESSION[$nombre] = in_array($id, $valores) ? 1 : 0;
					}
					// in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
					// //USUARIOS - PERMISOS
					// in_array(2,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
					// //CONSULTA DE CITAS
					// in_array(3,$valores)?$_SESSION['ConsultaCitas']=1:$_SESSION['ConsultaCitas']=0;
					// //UBICACION DEL PACIENTE
					// in_array(4,$valores)?$_SESSION['UbicacionPaciente']=1:$_SESSION['UbicacionPaciente']=0;
					// //GENERAR INCAPACIDADES
					// in_array(5,$valores)?$_SESSION['GenerarIncapacidades']=1:$_SESSION['GenerarIncapacidades']=0;
					// //CONSOLIDADO INCAPACIDADES
					// in_array(6,$valores)?$_SESSION['ObservarIncapacidades']=1:$_SESSION['ObservarIncapacidades']=0;
					// //ANULAR INCAPACIDADES
					// in_array(7,$valores)?$_SESSION['AnularIncapacidades']=1:$_SESSION['AnularIncapacidades']=0;
					// in_array(19,$valores)?$_SESSION['verificaciones_implantados']=1:$_SESSION['verificaciones_implantados']=0;
					// in_array(20,$valores)?$_SESSION['verificacion_epidemiologa']=1:$_SESSION['verificacion_epidemiologa']=0;
					// in_array(8,$valores)?$_SESSION['Odontograma']=1:$_SESSION['Odontograma']=0;
					// in_array(21,$valores)?$_SESSION['ProgramaEducativo']=1:$_SESSION['ProgramaEducativo']=0;
					// //ACCESO PARA REGISTRO DE IMPLANTES
					// in_array(18,$valores)?$_SESSION['implantes']=1:$_SESSION['implantes']=0;
					// //ACCESO PARA REGISTRO DE CIRUGIA RH
					// in_array(23,$valores)?$_SESSION['Cirugia_RH']=1:$_SESSION['Cirugia_RH']=0;
					// //ACCESO PARA DERECHO A MORIR DIGNAMENTE
					// in_array(26,$valores)?$_SESSION['Derecho_morir_dignamente']=1:$_SESSION['Derecho_morir_dignamente']=0;
					// in_array(28,$valores)?$_SESSION['ConsultarSolicitud_DMD']=1:$_SESSION['ConsultarSolicitud_DMD']=0;
					// in_array(29,$valores)?$_SESSION['Solicitud_DMD']=1:$_SESSION['Solicitud_DMD']=0;
					// in_array(30,$valores)?$_SESSION['Ubicacion y citas']=1:$_SESSION['Ubicacion y citas']=0;
					// in_array(31,$valores)?$_SESSION['RegistrarOdontograma']=1:$_SESSION['RegistrarOdontograma']=0;
					// in_array(32,$valores)?$_SESSION['BuscarOdontograma']=1:$_SESSION['BuscarOdontograma']=0;
					// in_array(33,$valores)?$_SESSION['Incapacidades']=1:$_SESSION['Incapacidades']=0;
					// in_array(34,$valores)?$_SESSION['EncuestaSatisfaccion']=1:$_SESSION['EncuestaSatisfaccion']=0;
					// in_array(63,$valores)?$_SESSION['prueba']=1:$_SESSION['prueba']=0;
					// in_array(64,$valores)?$_SESSION['prueba']=1:$_SESSION['prueba']=0;

					
					echo "1,".$PageToGo;
				}else{
					echo 4;
				}
			/*
			}
			else{
				
				echo 3;
			}*/

		} else{
			echo 5;
		}

	break;

	case 'verificar':
		$logina=$_POST['logina'];
	    $clavea=$_POST['clavea'];

	    // Hash SHA256 en la contraseña
		$clavehash=hash("SHA256",$clavea);

		

		$rspta=$usuario->verificar($logina, $clavehash);

		if($rspta){
			$fetch=$rspta->fetch_object();
		}

		if (isset($fetch)) {
			// Declaramos las variables de sesión
			$_SESSION['idusuario'] = $fetch->idusuario;
			$_SESSION['nombre'] = $fetch->nombre;
			$_SESSION['cargo'] = $fetch->cargo;
			$_SESSION['login'] = $fetch->login;
			$_SESSION['clave'] = $fetch->clave;
		
			// Obtenemos los permisos del usuario
			$marcados = $usuario->listarmarcados($fetch->idusuario);
		
			// Declaramos el array para almacenar todos los permisos marcados
			$valores = [];
		
			// Almacenamos los permisos marcados en el array
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idpermiso);
			}
		
			// Incluimos la conexión
			include("../config/Conexion.php");
		
			// Consultamos todos los permisos
			$sql = "SELECT `idpermiso`, `nombre` FROM `permiso`";
			$query = $conexion->query($sql);
		
			// Almacenamos los resultados de la consulta en el array $permisos
			$permisos = [];
			while ($row = $query->fetch_assoc()) {
				$permisos[] = $row;
			}
		
			// Configuramos los permisos en la sesión
			foreach ($permisos as $permiso) {
				$id = $permiso['idpermiso'];
				$nombre = $permiso['nombre'];
		
				// Asigna 1 o 0 en $_SESSION según si el permiso está en $valores
				$_SESSION[$nombre] = in_array($id, $valores) ? 1 : 0;
			}
		}
		

	    $respuestajson = json_encode($fetch);

		if($respuestajson == "null"){
			echo 2;
		}else{
			echo "1,".$PageToGo.",".$clavea;
		}


	break;

	case 'googleLogin':
		$email=$_SESSION['user_email_address'];
	
		$rspta=$usuario->googleVerificar($email);
		$fetch=$rspta->fetch_object();

		$rsptaPerm = $usuario->googleVerificar($email);
		$fetchPerm = $rsptaPerm->fetch_object();
			
		if (isset($fetch))
		{
			$_SESSION['idusuario']=$fetch->id_usuario_google;
			$_SESSION['cargo']= "";
			//Declaramos las variables de sesión
			$_SESSION['nombre']= $_SESSION['user_first_name'].' '.$_SESSION['user_last_name'];
			//Declaramos las variables de sesión
			$id_rol = '';
			do{
				$id_rol .= $fetch->id_rol;
				$id_rol .= ",";
				$fetch = $rspta->fetch_object();

			}while($fetch);
			$id_rol .= '0';
			//$id_rol = str_replace(" ", ",",$id_rol);
			//$id_rol = json_encode($id_rol);
			//$_SESSION['nombre'] = json_decode($id_rol);

			$rspta2=$usuario->GoogleRoleVerificar($id_rol);			
			$fetch2 = $rspta2->fetch_object();
			$ids ='';
			do{

				$idpermiso = $fetch2->idpermiso;
				$ids .= $idpermiso;
				$ids .= ',';
				
			
				$fetch2 = $rspta2->fetch_object();
			}while($fetch2);
			$ids .= '0';
			//$ids = str_replace(" ", ",",$ids);
			//$ids = json_encode($ids);
			//echo '<script> console.log('. $ids.') </script>';

			
	
			//Obtenemos los permisos del usuario
			$marcados = $usuario->listarRolePermisos($ids);
			$valores = [];
		
			//Almacenamos los permisos marrhhrcados en el array
			while ($per = $marcados->fetch_object())
				{
					array_push($valores, $per->idpermiso);
				}
	
				include("../config/Conexion.php");
		
			// Consultamos todos los permisos
			$sql = "SELECT `idpermiso`, `nombre` FROM `permiso`";
			$query = $conexion->query($sql);
		
			// Almacenamos los resultados de la consulta en el array $permisos
			$permisos = [];
			while ($row = $query->fetch_assoc()) {
				$permisos[] = $row;
			}
		
			// Configuramos los permisos en la sesi�n
			foreach ($permisos as $permiso) {
				$id = $permiso['idpermiso'];
				$nombre = $permiso['nombre'];
		
				// Asigna 1 o 0 en $_SESSION seg�n si el permiso est� en $valores
				$_SESSION[$nombre] = in_array($id, $valores) ? 1 : 0;
			}
			//Determinamos los accesos del usuario
	
					//ESCRITORIO
					// in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
					// //USUARIOS - PERMISOS
					// in_array(2,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
					// //CONSULTA DE CITAS
					// in_array(3,$valores)?$_SESSION['ConsultaCitas']=1:$_SESSION['ConsultaCitas']=0;
					// //UBICACION DEL PACIENTE
					// in_array(4,$valores)?$_SESSION['UbicacionPaciente']=1:$_SESSION['UbicacionPaciente']=0;
					// //GENERAR INCAPACIDADES
					// in_array(5,$valores)?$_SESSION['GenerarIncapacidades']=1:$_SESSION['GenerarIncapacidades']=0;
					// //CONSOLIDADO INCAPACIDADES
					// in_array(6,$valores)?$_SESSION['ObservarIncapacidades']=1:$_SESSION['ObservarIncapacidades']=0;
					// //ANULAR INCAPACIDADES
					// in_array(7,$valores)?$_SESSION['AnularIncapacidades']=1:$_SESSION['AnularIncapacidades']=0;
					// in_array(19,$valores)?$_SESSION['verificaciones_implantados']=1:$_SESSION['verificaciones_implantados']=0;
					// in_array(20,$valores)?$_SESSION['verificacion_epidemiologa']=1:$_SESSION['verificacion_epidemiologa']=0;
					// in_array(8,$valores)?$_SESSION['Odontograma']=1:$_SESSION['Odontograma']=0;
					// in_array(21,$valores)?$_SESSION['ProgramaEducativo']=1:$_SESSION['ProgramaEducativo']=0;
					// //ACCESO PARA REGISTRO DE IMPLANTES
					// in_array(18,$valores)?$_SESSION['implantes']=1:$_SESSION['implantes']=0;
					// //ACCESO PARA REGISTRO DE CIRUGIA RH
					// in_array(23,$valores)?$_SESSION['Cirugia_RH']=1:$_SESSION['Cirugia_RH']=0;
					// //ACCESO PARA DERECHO A MORIR DIGNAMENTE
					// in_array(26,$valores)?$_SESSION['Derecho_morir_dignamente']=1:$_SESSION['Derecho_morir_dignamente']=0;
					// in_array(28,$valores)?$_SESSION['ConsultarSolicitud_DMD']=1:$_SESSION['ConsultarSolicitud_DMD']=0;
					// in_array(29,$valores)?$_SESSION['Solicitud_DMD']=1:$_SESSION['Solicitud_DMD']=0;
					// in_array(30,$valores)?$_SESSION['Ubicacion y citas']=1:$_SESSION['Ubicacion y citas']=0;
					// in_array(31,$valores)?$_SESSION['RegistrarOdontograma']=1:$_SESSION['RegistrarOdontograma']=0;
					// in_array(32,$valores)?$_SESSION['BuscarOdontograma']=1:$_SESSION['BuscarOdontograma']=0;
					// in_array(33,$valores)?$_SESSION['Incapacidades']=1:$_SESSION['Incapacidades']=0;
					// in_array(34,$valores)?$_SESSION['Encuesta de satisfaccion']=1:$_SESSION['Encuesta de satisfaccion']=0;
					// in_array(63,$valores)?$_SESSION['prueba']=1:$_SESSION['prueba']=0;
					// in_array(64,$valores)?$_SESSION['prueba']=1:$_SESSION['prueba']=0;
		}
		$respuestajson = json_encode($fetchPerm);
	
		if(!($respuestajson == "null")){
			header('location:'.$PageToGo);
		}
	
	
	break;

	case 'salir':

		if(isset($_SESSION['access_token'])){

			include('../googleConfig.php');

			//Reset OAuth access token
			$client->revokeToken();
		}

		//Limpiamos las variables de sesión   
        session_unset();
        //Destruìmos la sesión
        session_destroy();
        //Redireccionamos al login
        header("Location: ../index.php");

	break;

	case 'cambiar contrasena':
		$login = isset($_SESSION['login']) ? $_SESSION['login'] : '';
		header("Location: ../view/cambiar_contrasena.php?log=" . urlencode($login));
	break;
}




?>

	

