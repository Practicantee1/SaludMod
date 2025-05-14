$(document).ready(function() {
  
        const urlParams = new URLSearchParams(window.location.search);
        let paciente = urlParams.get("id_paciente"); // Obtiene el valor del parámetro 'name'



    $('#guardarFirmaSalida').on('click', function(event) {
        event.preventDefault();
        if(paciente == null){
            paciente = window.paciente;
        }

        $.ajax({
            type: "POST",
            data: {paciente: paciente, tipo_Firma: "FINAL"},
            url: '../logica/actualizarFirmas.php',
            success: function(response){
                response = JSON.parse(response);
                Swal.fire({
                    icon: response.success ? "success" : "error",
                    title: response.success ? "Proceso éxitoso" : "Error en el proceso",
                    text: response.message,
                    confirmButtonColor: "#006941",
                    confirmButtonText: "Finalizar"
                });
                
            }
        });
        
        //$('#guardarFirmaSalida').prop("disabled", true);
        //$('.add-row').prop("disabled", true);
        //$(".remove-row ").prop("disabled", true);
	$('#guardarFirmaSalida').prop("disabled", true);
        $('#btnAgregarFinal').prop("disabled", true);
        $("firmaSalida-item .remove-row ").prop("disabled", true);
    });
});

