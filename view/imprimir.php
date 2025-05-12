<script>
  <?php
include('../config/Conexion.php');
require_once("ZplPrinter.php");
include('../logica/ApiSap.php');

//$impresora = 'ZDesigner ZD230-203dpi ZPL';
//$impresora = 'VirtualZPL';
$impresora = 'ZDesignerZD230-203dpiZPL';

// Recuperar los datos enviados por POST
$selectedIds = isset($_POST['selectedIds']) ? $_POST['selectedIds'] : array();
$selectedIds = array_filter($selectedIds);

/*$Observaciones = $_POST[''];
$fechaIngreso = $_POST[''];
$nombreCompleto = $_POST[''];
$fechaNacimiento = $_POST[''];
$formula = $_POST[''];
$identificacion = $_POST[''];
$sala = $_POST[''];*/

// Verificar si la lista de IDs seleccionados está vacía
if (!empty($selectedIds)) {

  $ii = 0;
  while(true){
    if(!isset($selectedIds[$ii])){break;}
    

    $sql =  "SELECT *, nombre_formula FROM `tabla_biberones` INNER JOIN tipo_formula WHERE id_tipo_formula = id AND Id_biberon ='".$selectedIds[$ii]."'";
    $result = $conexion->query($sql);

      $info = $result->fetch_assoc();

      if(strpos($info['nombre_formula'], "FORMULA") !== true){
        //$formula = "FORMULA ".$info['nombre_formula'];
        if($info['Especial'] == 1){
          $formula = "ESPECIAL ".$info['nombre_formula'];
        }
        else if ($info['Adicional'] == 1){
          $formula = "ADICIONAL ".$info['nombre_formula'];
        }else{
          $formula = $info['nombre_formula'];
        }
      }
      
      
      /*if($info['nombre_formula'] == 'FORMULA ESPECIAL'){

        $sql2 = "SELECT tipo_formula.nombre_formula as nf FROM tabla_biberones INNER JOIN solicitudes_especiales ON tabla_biberones.episodio = solicitudes_especiales.episodio INNER JOIN tipo_formula ON solicitudes_especiales.id_tipo_formula = tipo_formula.id WHERE DATE(tabla_biberones.fecha_ingreso) = CURDATE() AND  tabla_biberones.episodio = '".$info['episodio']."' AND DATE(solicitudes_especiales.fecha_modificacion) = CURDATE() ORDER BY solicitudes_especiales.id DESC LIMIT 1";

        $result2 = $conexion->query($sql2);
        $info2 = $result2->fetch_assoc();
        $formula = "FORMULA ESP. - ".$info2['nf'];
      }*/

      
    //Instanciamos de la clase ZplPrinter.php
    $sexo = "";
    $cama = "";
    $SAP = getApi($info['episodio']);
    if(!($SAP === null)){
      if(array_key_exists('DatosPaciente', $SAP)){
        $DatosPaciente = $SAP["DatosPaciente"];
        $sexo = $DatosPaciente["Sexo"];
      }
      if(array_key_exists('DatosUbicacionEpisodio', $SAP)){
        $data = $UbicacionPaciente = $SAP["DatosUbicacionEpisodio"];
        $cama = $data["IdUbicacion_cama"];
      }
    }

    $zepl = new ZplPrinter();

    $tandas = json_decode($_POST['TandaByID'], true);
    $amountAM = $tandas["Tanda_".$info['Id_biberon']];
    $amountPM = $info['numero_biberones'] - $tandas["Tanda_".$info['Id_biberon']];

    //FIRST, WE WILL CREATE AM LABELS THEN PM AND THEN CALL WINDOWS PRINTING
      $hora = "AM";

      
      ?>
        amountAM = <?php echo $amountAM?>;
        amountPM = <?php echo $amountPM?>;
        myWindow=window.open('','','');
        myWindow.document.write('<style>' +
            '@page { size: auto;  margin: 0mm; }' +
            'p {top: 120%; page-break-before: always;}'+ 
            'label {position: absolute; font-family: Andale Mono, monospace; font-size: 9px; font-weight: 600}'+  //real font size 10-9 for titles, and for text 9-8
            '.leftLbl{left: 90px;}'+
            '.rightLbl {left: 180px}'+
            ' {}'+
            '</style>');
        
          
        for(jj=0; jj < amountAM; jj++){
          
          myWindow.document.write('<p ></p>');
          myWindow.document.write('<label style="margin-top: -3px; font-size: 11px;" class="leftLbl" id="Name">' + '<?php echo $info['nombre_apellido']; ?>' + '</label><br>');
          myWindow.document.write('<label style="margin-top: -7px" class="leftLbl" id="RC">RC: ' + '<?php echo $info['identificacion']; ?>' + '</label>');

          myWindow.document.write('<label style="margin-top: -7px" class="rightLbl" id="Episodio">EPISODIO: ' + '<?php echo $info['episodio']; ?>' + '</label><br>');
          myWindow.document.write('<label style="margin-top: -11px" class="leftLbl" id="Sexo">SEXO: ' + '<?php echo $sexo; ?>' + '</label>');

          myWindow.document.write('<label style="margin-top: -11px" class="rightLbl" id="Sala">SALA: ' + '<?php echo $cama; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -15px" class="leftLbl" id="date">FECHA DE NACIMIENTO: ' + '<?php echo $info['fecha_nacimiento']; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -19px" class="leftLbl" id="formula">FORMULA: ' + '<?php echo $formula; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -23px" class="leftLbl" id="dateProduccion">FECHA - TANDA PRODUCCION: ' + '<?php echo $info['fecha_ingreso'].' | '.$hora; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -27px" class="leftLbl" id="observacion">OBSERVACION: ' + '<?php echo $info['observaciones']; ?>' + '</label><br>');
        }

        <?php
          $hora = "PM";
        ?>
        
        for(xx=0; xx < amountPM; xx++){
          myWindow.document.write('<p ></p>');
          myWindow.document.write('<label style="margin-top: -3px; font-size: 11px;" class="leftLbl" id="Name">' + '<?php echo $info['nombre_apellido']; ?>' + '</label><br>');
          myWindow.document.write('<label style="margin-top: -7px" class="leftLbl" id="RC">RC: ' + '<?php echo $info['identificacion']; ?>' + '</label>');

          myWindow.document.write('<label style="margin-top: -7px" class="rightLbl" id="Episodio">EPISODIO: ' + '<?php echo $info['episodio']; ?>' + '</label><br>');
          myWindow.document.write('<label style="margin-top: -11px" class="leftLbl" id="Sexo">SEXO: ' + '<?php echo $sexo; ?>' + '</label>');

          myWindow.document.write('<label style="margin-top: -11px" class="rightLbl" id="Sala">SALA: ' + '<?php echo $cama; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -15px" class="leftLbl" id="date">FECHA DE NACIMIENTO: ' + '<?php echo $info['fecha_nacimiento']; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -19px" class="leftLbl" id="formula">FORMULA: ' + '<?php echo $formula; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -23px" class="leftLbl" id="dateProduccion">FECHA - TANDA PRODUCCION: ' + '<?php echo $info['fecha_ingreso'].' | '.$hora; ?>' + '</label><br>');

          myWindow.document.write('<label style="margin-top: -27px" class="leftLbl" id="observacion">OBSERVACION: ' + '<?php echo $info['observaciones']; ?>' + '</label><br>');
          
        }

        //myWindow.document.close(); //missing code

        myWindow.focus();
        myWindow.print(); 
        myWindow.close();
        <?php

    //Función que imprime desde CMD

      $info['NumImpresiones'] = $info['NumImpresiones'] + 1;

      $sql3 = "UPDATE `tabla_biberones` SET `NumImpresiones` = '".$info['NumImpresiones']."' WHERE `Id_biberon` = '".$info['Id_biberon']."'";

      $r = $conexion->query($sql3);


      $ii++;
  }

  // Resto del código para generar el PDF...
} else {
  ?>

    Swal.fire({
        icon: 'warning',
        title: 'No se selecciono ningun registro' ,
        showConfirmButton: false,
        timer: 1500  
    });
    

  <?php
}

?>
12
</script>
