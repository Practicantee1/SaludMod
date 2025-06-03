$(document).ready(function() {
  
        const urlParams = new URLSearchParams(window.location.search);
        let paciente = urlParams.get("id_paciente"); // Obtiene el valor del parámetro 'name'



    $('#guardarFirmaSalida').on('click',async function(event) {

        let firmasAcumulado = 0;
        let cantidadFirmas = document.querySelectorAll(".validarBtn");
        cantidadFirmas.forEach(element => {     
            if(element.dataset.firmado == "Si"){
                firmasAcumulado++;
            }
        });

        if(firmasAcumulado < 4){
            Swal.fire({
                icon: "error",
                title: "No se pueden guardar las firmas",
                text: "Deben firmar mínimo 4 personas para completar esta acción",
                confirmButtonText: "¡Entendido!",
                confirmButtonColor: "#006941",
            });
            return;
        }

        let resultado = await Swal.fire({
            icon: "info",
            title: "¿Estás seguro que quieres completar las firmas de esta pausa?",
            text: "Esta acción no se puede revertir",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#006941",
            confirmButtonText: "Confirmar"
        });

        if(!resultado.isConfirmed){
            return;
        }

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

