$(document).ready(function() {
  
    const urlParams = new URLSearchParams(window.location.search);
    let paciente = urlParams.get("id_paciente"); // Obtiene el valor del parámetro 'name'



    $('#guardarFirmaEntrada').on('click', function(event) {
        event.preventDefault();
        if(paciente == null){
            paciente = window.paciente;
        }
	console.log("Al menos llega aqui");
        $.ajax({
            type: "POST",
            data: {paciente: paciente, tipo_Firma: "INICIO"},
            url: '../logica/actualizarFirmas.php',
            success: function(response){
                response = JSON.parse(response);
                console.log("Actualizar", response);
                Swal.fire({
                    icon: response.success ? "success" : "error",
                    title: response.success ? "Proceso éxitoso" : "Error en el proceso",
                    text: response.message,
                    confirmButtonColor: "#006941",
                    confirmButtonText: "Finalizar"
                });
                
            }
        });
        console.log("Devuelve la respuesta");
        //$('#guardarFirmaEntrada').prop("disabled", true);
        //$('.add-row').prop("disabled", true);
        //$(".remove-row ").prop("disabled", true);
	$('#guardarFirmaEntrada').prop("disabled", true);
        $('#agregarInicio').prop("disabled", true);
        $(".firma-item .remove-row ").prop("disabled", true);
    });
});







