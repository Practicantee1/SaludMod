<?php
include('../../../config/Conexion.php');

$CentroSanitario = $_POST["CentroSanitario"];
$RazonSocial = $_POST["RazonSocial"];
$NIT = $_POST["NIT"];
$CodAseguradora = $_POST["CodAseguradora"];
$NomEntidad = $_POST["NomEntidad"];
$FechaExpedicion = $_POST["FechaExpedicion"];
$Lugar = $_POST["Lugar"];
$NombreApellido = $_POST["NombreApellido"];
$TypeIdentification = $_POST["TypeIdentification"];
$IDNumberPaciente = $_POST["IDNumberPaciente"];
$GroupService = $_POST["GroupService"];
$ModelService = $_POST["ModelService"];
$DiagnosticoP = $_POST["DiagnosticoP"];
$DiagnosticoR = $_POST["DiagnosticoR"];
$OrigenIncapacidad = $_POST["OrigenIncapacidad"];
$CausaAtencion = $_POST["CausaAtencion"];
$FechaInicial = $_POST["FechaInicial"];
$FechaFinal = $_POST["FechaFinal"];
$Prorroga = $_POST["Prorroga"];
$RetroActive = $_POST["RetroActive"];
$NombreMedico = $_POST["NombreMedico"];
$TipoIDMedico = $_POST["TipoIDMedico"];
$IDNumberMedico = $_POST["IDNumberMedico"];

unset($_POST["FechaExpedicion"]);
unset($_POST["IDNumberPaciente"]);
unset($_POST["IDNumberMedico"]);


//JSON encoding se salta los caracteres especiales como ó o ñ para garantizar que el JSON se guarde correctamente, JSON_UNESCAPED_UNICODE se asegura que esto no pase
$DatosIncapacidad = json_encode($_POST, JSON_UNESCAPED_UNICODE);

$IDQuery = "CALL SPIncap_ListarIds('$IDNumberPaciente')";
      
$result = $conexion->query($IDQuery); 

if ($result !== false && $result->num_rows > 0) {
  $Incap= mysqli_fetch_assoc($result);
}
else{
  $Incap = [];
}

$Id_Incapacidad = $IDNumberPaciente;

if(!isset($Incap["Id_Incapacidad"]) || $Incap["Id_Incapacidad"] == "" || $Incap["Id_Incapacidad"] == 0){
  $Id_Incapacidad .= "-1";
}else{
  $ID = explode("-", $Incap["Id_Incapacidad"]);
  $num = $ID[1];
  $num++; 
  $Id_Incapacidad .= "-".$num;
}


// Esta linea es necesaria en caso de que el objeto Mysqli ($conexion) este siendo utilizado para realizar un llamado a un procedimiento almacenado que retorne un SELECT (Si dicho SELECT no es un SELECT ... INTO ...)
if ($conexion->more_results()) {
  $conexion->next_result();
}


$query = "CALL SPIncap_InsertarIncapacidad('$Id_Incapacidad','$FechaExpedicion','$IDNumberPaciente','$IDNumberMedico','$DatosIncapacidad')";

$result2 = $conexion->query($query);

if($result2){
  ?>
  <script>

  Swal.fire({
    icon: 'success',
    title: 'La incapacidad ha sido registrada',
    showConfirmButton: false,
    timer: 1500  
  });
  setTimeout(function(){
    window.open("../../../Modulos/Incapacidades/Logica/PDF/GenerarPDF.php?Id_Incapacidad=<?php echo $Id_Incapacidad?>", "_blank");
    window.location.href = '../view/ConsolidadoIncapacidad.php';
    }, 2000);
  </script>
  <?php
}else{
  ?>
  <script>
  Swal.fire({
    icon: 'error',
    title: 'Ocurrio un error al ingresar la incapacidad, verifique los datos',
    showConfirmButton: false,
    timer: 1500  
  });
  </script>
  <?php
}




?>