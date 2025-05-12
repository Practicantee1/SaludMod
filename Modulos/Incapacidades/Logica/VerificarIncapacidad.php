<script>
<?php
include('../../../config/Conexion.php');


$IDNumberPaciente = $_POST["IDPaciente"];
$FechaInicial = $_POST["FechaIni"];
$FechaExpedicion = $_POST["FechaExpedicion"];

$IDQuery = "CALL SPIncap_VerificarIncapacidad('$IDNumberPaciente')";
        
$result = mysqli_query($conexion, $IDQuery);

$Available = true;
if($result && mysqli_num_rows($result) > 0){

  while($Incap = mysqli_fetch_assoc($result)){

    $Datos = json_decode($Incap["Datos_Incapacidad"], true);

    $FechaFin = $Datos["FechaFinal"];

    if($FechaInicial <= $FechaFin && $FechaInicial >= $Datos["FechaInicial"]){
      ?>
      document.getElementById("FechaInicial").value = "";
      Swal.fire({
        icon: 'error',
        title: 'El paciente ya cuenta con una incapacidad activa',
        text: 'desde <?php echo $Datos["FechaInicial"] ?> hasta <?php echo $FechaFin?>',
      });
      <?php
      $Available = false;
      break;
    }

  }
  
}
  
if($Available){
  
  if($FechaInicial < $FechaExpedicion){
    ?>
    document.getElementById("RetroActive-Div").removeAttribute("hidden");
    OptionRetro = document.getElementById("OptionRetroActive");
    OptionRetro.setAttribute("hidden", true);
    document.getElementById("RetroActive").value = "Urgencias o internacion del paciente";
    <?php
  }else{
    ?>
    divRetro = document.getElementById("RetroActive-Div");
    OptionRetro = document.getElementById("OptionRetroActive");
    OptionRetro.removeAttribute("hidden");
    document.getElementById("RetroActive").value = "N/A";
    divRetro.setAttribute("hidden", true);
    <?php
  }   
}





?>
</script>