<script>
<?php
session_start();
include('../../../config/Conexion.php');

$DocumentoIncapacidad = $_POST["DocumentoIncapacidad"];

?>
DataTable = document.getElementById("table_body");
while (DataTable.firstChild) {
    DataTable.removeChild(DataTable.firstChild);
} 


<?php


$IDQuery = "CALL SPIncap_ConsultarIncapacidades('$DocumentoIncapacidad')";   
  
$result = mysqli_query($conexion, $IDQuery);
if($result && mysqli_num_rows($result) > 0){

    ?>
    document.getElementById("Table-Row").removeAttribute("hidden");
    document.getElementById("AlertNoRecord-Row").hidden = true;
    

    <?php
    while($row = mysqli_fetch_array($result)){

            $rowExtra = json_decode($row['Datos_Incapacidad'], true);
        ?>
            var estado = <?php echo $row["Estado"] ?>;

            var row = document.createElement("tr");


            var Buttons = document.createElement("td");
            var containerButtons = document.createElement("div");
            containerButtons.style=" padding-top: 10%; min-height: 100%; justify-content: center";

            var PDFButton = document.createElement('button');
            PDFButton.className = "btn btn-success";
            PDFButton.onclick = function(){
                window.open("../../../Modulos/Incapacidades/Logica/PDF/GenerarPDF.php?Id_Incapacidad=<?php echo $row["Id_Incapacidad"]?>", "_blank");
            };

            PDFIcon = document.createElement('i');
            PDFIcon.className = "fa-solid fa-file-pdf";
            PDFButton.appendChild(PDFIcon);

            var PDFTooltip = document.createElement('div');
            PDFTooltip.className = 'tooltip-info';
            PDFTooltip.style="height: 30%; display: flex; justify-content: center";
            
            var PDFInfo = document.createElement('span');
            PDFInfo.className = 'tooltiptext';
            PDFInfo.textContent = 'Certificado de Incapacidad';

            PDFTooltip.appendChild(PDFButton);

            if(estado === 3){
                PDFButton.disabled = true;
                PDFButton.style="color: #DEDEDE";
            }
            else{
                PDFButton.style="border: 3px solid #000; color: #000";
                PDFTooltip.appendChild(PDFInfo);                
            }
            
            containerButtons.appendChild(PDFTooltip);


            <?php
            if(isset($_SESSION["Anular Incapacidades"]) && $_SESSION["Anular Incapacidades"] == 1){
            ?>
            var CancelButton = document.createElement('button');
            CancelButton.className = "btn btn-danger";
            CancelButton.id = "CancelButton";
            CancelButton.onclick = function() {
                RazonContainer = document.getElementById("RazonContainer");
                RazonContainer.removeAttribute("hidden");
                FowardRazon = document.getElementById("FowardRazon");
                FowardRazon.onclick = function(){
                    IdIncapacidad = "<?php echo $row["Id_Incapacidad"]?>";
                    DocumentoIncapacidad = "<?php echo $DocumentoIncapacidad?>";
                    cancelarIncapacidad(IdIncapacidad, DocumentoIncapacidad);
                }  
            };

            CancelIcon = document.createElement('i');
            CancelIcon.className = "fa-solid fa-file-circle-xmark";
            CancelButton.appendChild(CancelIcon);
            
            var CancelTooltip = document.createElement('div');
            CancelTooltip.className = 'tooltip-info';
            CancelTooltip.style="height: 30%; display: flex; justify-content: center";
            
            var CancelInfo = document.createElement('span');
            CancelInfo.className = 'tooltiptext';
            CancelInfo.textContent = 'Cancelar Incapacidad';

            CancelTooltip.appendChild(CancelButton);
            


            if(estado !== 1){
                CancelButton.style="color: #DEDEDE";
                CancelButton.disabled = true;
            }
            else{
                CancelButton.style="border: 3px solid #000; color: #000";
                CancelTooltip.appendChild(CancelInfo);
            }
            

            containerButtons.appendChild(CancelTooltip);

            <?php
            }
            ?>

            /* var DetailButton = document.createElement('a');
            DetailButton.className = "btn btn-info";
            DetailButton.target = '_blank';
            DetailIcon = document.createElement('i');
            DetailIcon.className = "fa-solid fa-eye";
            DetailButton.appendChild(DetailIcon);
            DetailButton.href = "";
            Buttons.appendChild(DetailButton); */

            Buttons.appendChild(containerButtons);
            row.appendChild(Buttons);


            var FechaExpedicion = document.createElement("td");
            text = document.createTextNode("<?php echo $row["FechaExpedicion"] ?>");
            FechaExpedicion.appendChild(text);
            row.appendChild(FechaExpedicion);

            var NombreAfiliado = document.createElement("td");
            <?php $rowExtra["DiagnosticoP"] = isset($rowExtra["DiagnosticoP"]) ? $rowExtra["DiagnosticoP"] : "" ?>
            text = document.createTextNode("<?php echo $rowExtra["NombreApellido"] ?>");
            NombreAfiliado.appendChild(text);
            row.appendChild(NombreAfiliado);

            var DiagnosticoP = document.createElement("td");
            text = document.createTextNode("<?php echo $rowExtra["DiagnosticoP"] ?>");
            DiagnosticoP.appendChild(text);
            row.appendChild(DiagnosticoP);

            var FechaInicial = document.createElement("td");
            text = document.createTextNode("<?php echo $rowExtra["FechaInicial"] ?>");
            FechaInicial.appendChild(text);
            row.appendChild(FechaInicial);

            var FechaFinal = document.createElement("td");
            text = document.createTextNode("<?php echo $rowExtra["FechaFinal"] ?>");
            FechaFinal.appendChild(text);
            row.appendChild(FechaFinal);

            var Estado = document.createElement("td");
            text = document.createTextNode("<?php echo $row["Descripcion"] ?>");
            Estado.appendChild(text);
            row.appendChild(Estado);


            <?php 
            $motivoQuitarEnter = str_replace(array("\r", "\n"), ' ', $row["Motivo"]);
            ?>

            var Motivo = document.createElement("td");
            Motivo.style = "width: 100%;";
            text = document.createTextNode("<?php echo $motivoQuitarEnter; ?>");
            Motivo.appendChild(text);
            row.appendChild(Motivo);    
            
            DataTable.appendChild(row);
        <?php

    }
}
else{
    ?>
    document.getElementById("AlertNoRecord-Row").removeAttribute("hidden");
    document.getElementById("Table-Row").hidden = true;


    <?php
}

$conexion->next_result();

?>

function cancelarIncapacidad(IdIncapacidad, DocumentoIncapacidad){
    Razon = document.getElementById("Razon").value;
    var deleted = false;
    $.ajax({
    type: "POST",
    url: '../../../Modulos/Incapacidades/Logica/CancelarIncapacidad.php',
    data: {"IdIncapacidad" : IdIncapacidad, "Razon" : Razon},
    success: function(response){
        
        RazonContainer = document.getElementById("RazonContainer");
        Razon = document.getElementById("Razon");
        Razon.value ="";
        RazonContainer.hidden = true;

        if(response == "1"){
            deleted = true;
            restartTable(deleted);   
        }
        
    }
    });

    
}

function restartTable(deleted){
    if(deleted){
        
        $.ajax({
            type: "POST",
            url: '../../../Modulos/Incapacidades/Logica/ConsultarIncapacidades.php',
            data: {"DocumentoIncapacidad" : DocumentoIncapacidad},
            success: function(response){
                var quickScript = new Function($(response).text());
                quickScript();
                Swal.fire({
                    icon: 'error',
                    title: 'La incapacidad ha sido cancelada',
                    showConfirmButton: false,
                    timer: 2000  
                });
                
            }
        });
    }
}
</script>




