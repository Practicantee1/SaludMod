$(document).ready(() => {
    function decodeBase64Utf8(base64) {
        return decodeURIComponent(escape(atob(base64)));
    }

    let datos = JSON.parse(decodeBase64Utf8(DatosPaciente))["parametros"];
    let nuevo_array = datos.map(elemento => Object.values(elemento)).filter(([nombre, valor]) => nombre == "Episodio"
                                                                                            || nombre == "NUIP");
    let informacion = nuevo_array.map(([_, valor]) => valor);

    MostrarMensaje();

    async function MostrarMensaje(){
        let episodio = limpiarCampos(informacion[0], "0");

        let documento = await consultarAPIPaciente(episodio);
        
        if(!documento){
            return;
        }

        Swal.fire({
            title: 'No tienes el permiso para registrar una incapacidad',
            text: 'Puedes revisar las incapacidades registradas del paciente mediante el botón "Consultar Incapacidades".',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Consultar Incapacidades',
            allowOutsideClick: false,
            allowEscapeKey: false,
            iconColor: '#006941',
            customClass: {
                title: 'custom-swal-Incapacidad-Tittle', // Custom class for title
                popup: 'custom-swal-Incapacidad-popup', // Custom class for dialog popup
                content: 'custom-swal-Incapacidad-Content',
                confirmButton: 'btn custom-swal-Incapacidad-ConfirmBtn',
                htmlContainer: "texto"
            }
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = `./ConsolidadoIncapacidad.php?documento=${documento}`;
            }
        });
    }

    function consultarAPIPaciente(episodio){
        return new Promise(resolve => {
            $.ajax({
                type: "POST",
                url: "../Logica/ConsultarDatosPaciente.php",
                data: {episodio : episodio},
                success: function(response){
                    response = JSON.parse(response);

                    if(!response.success){
                        resolve(false);
                        return;
                    }
                    console.log(response.message)
                    resolve(response.message["Numero_documento"]);
                }
            });
        });
    }


    function limpiarCampos(texto, caracter){
        for(let i = 0; i <= texto.length; i++){
            if(texto[0] == caracter){
                texto = texto.slice(1)
            }
        }
        return texto;
    }
});