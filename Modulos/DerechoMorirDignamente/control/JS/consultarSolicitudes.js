
$("#idDocumento").keypress(function(e){
    if (e.keyCode == 13) {        
        consultarRegistros();
    }
})

$("#btn-Consultar").click(function(){
    consultarRegistros();
})

function consultarRegistros(){
    let documento = $("#idDocumento").val();
    $.ajax({
        type: "POST",
        url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/DerechoMorirDignamente/logica/consultarSolicitudes.php',
        // url: 'http://localhost/SaludMod/Modulos/DerechoMorirDignamente/logica/consultarSolicitudes.php',
        data: { documento: documento },
        dataType: "json",
        success: function(response) {
            console.log(response);
            $('#tbl_DMD_tbody').empty();
            $("#tbl_DMD").removeAttr("hidden");

            // Iteramos sobre la respuesta y añadimos cada fila a la tabla
            response.forEach(function(item) {
                // Procesamos los términos si están en formato JSON
                let terminosHTML = '';
                if (item.terminos) {
                    const terminos = JSON.parse(item.terminos);
                    terminosHTML = Object.entries(terminos)
                        .map(([key, value]) => `<strong>${key}</strong>: ${value}`)
                        .join('<br>');
                }

                const fila = `<tr>
                    <td>
                        <div id="pdf" onclick="window.open('../../../Modulos/DerechoMorirDignamente/logica/PDF/GenerarPDF.php?id=${item.id}', '_blank')" style="cursor: pointer;">
                            <i class="fa-solid fa-file-pdf fa-2x" ></i>
                        </div>
                    </td>
                    <td>${item.nombrePaciente}</td>
                    <td>${item.CedulaPaciente}</td>
                    <td>${item.nombreMedico}</td>
                    <td>${item.Especialidad}</td>
                    <td>${item.fechaSolicitud}</td>
                    <td>${item.observaciones}</td>
                </tr>`;
                $('#tbl_DMD_tbody').append(fila);

            });
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", error);
        }
    });
}


