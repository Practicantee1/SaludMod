
$(document).ready(function() {
    $('#agregarCasaBtn').click(function() {
        window.location.href = '../View/agregar_casa.php';
    });
});

$(document).ready(function() {
    $('#inhabilitarCasaBtn').click(function() {
        window.location.href = '../View/inhabilitar_casa.php';
    });
});
$(document).ready(function() {
    $('#habilitarCasaBtn').click(function() {
        window.location.href = '../View/habilitar_casa.php';
    });
});

$(document).ready(function () {
    $('#inhabilitarbtn').on('click', function () {
        const idCasaComercial = $('#bloqueo_casa').val(); // Asegúrate de que este input existe.

        if (!idCasaComercial) {
            
            Swal.fire({
                icon: 'warning',
                text: 'Por favor, seleccione una casa comercial.',
                showConfirmButton: true
            });
            return;
        }

        console.log('Datos enviados al Ajax:', { id: idCasaComercial });

        $.ajax({
            url: '../Logica/inhabiliar.php',
            type: 'POST',
            data: { id: idCasaComercial },
            dataType: 'json',
            cache: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se guardó el cambio correctamente',                        
                        showConfirmButton: true
                    }).then(() => {
                        location.reload(); // Recarga la página después del mensaje.
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Hubo un error  al inhabilitar la casa comercial.',
                        showConfirmButton: true
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
                Swal.fire({
                    icon: 'warning',
                    text: 'Error en la solicitud. Intente nuevamente.',
                    showConfirmButton: true
                });
            }
        });
    });
});

$(document).ready(function () {
    $('#habilitarbtn').on('click', function () {
        const idCasaComercial = $('#desbloqueo_casa').val(); // Asegúrate de que este input existe.

        if (!idCasaComercial) {
            Swal.fire({
                icon: 'warning',
                text: 'Por favor, seleccione una casa comercial.',
                showConfirmButton: true
            });;
            return;
        }

        console.log('Datos enviados al Ajax:', { id: idCasaComercial });

        $.ajax({
            url: '../Logica/habilitar.php',
            type: 'POST',
            data: { id: idCasaComercial },
            dataType: 'json',
            cache: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se guardó el cambio correctamente',                        
                        showConfirmButton: true
                    }).then(() => {
                        location.reload(); // Recarga la página después del mensaje.
                    });
                } else {
                    alert('Hubo un error al inhabilitar la casa comercial.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
                alert('Error en la solicitud. Intente nuevamente.');
            }
        });
    });
});

$(document).ready(function () {
    $('#guardarbtn').on('click', function () {
        const CasaComercial = $('#agregar_casa').val(); // Obtener el valor del input

        if (!CasaComercial) {
            Swal.fire({
                icon: 'warning',
                text: 'Por favor, escriba una casa comercial.',
                showConfirmButton: true
            });
            return;
        }

        console.log('Datos enviados al Ajax:', { casaComercial: CasaComercial });

        $.ajax({
            url: '../Logica/agregar.php',
            type: 'POST',
            data: { casaComercial: CasaComercial },
            dataType: 'json',
            cache: false,
            success: function (response) {
                console.log('Respuesta del servidor:', response); // Para depuración
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Se guardó el cambio correctamente',
                        showConfirmButton: true
                    }).then(() => {
                        location.reload(); // Recarga la página después del mensaje.
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error || 'Hubo un error al agregar la casa comercial.'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud:', error);
                let errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'Error en la solicitud. Intente nuevamente.';
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage
                });
            }
        });
    });
});