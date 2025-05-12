$(document).ready(function() {
    // Al cargar, botón deshabilitado
    $("#Search-acompanante").prop("disabled", true);

    // Si el checkbox está marcado al cargar, habilitar botón
    if ($("#validacionCompletada").is(":checked")) {
        $("#Search-acompanante").prop("disabled", false);
    }

    // Al cambiar el checkbox, habilita o deshabilita el botón directamente
    $("#validacionCompletada").on("change", function() {
        if ($(this).is(":checked")) {
            $("#Search-acompanante").prop("disabled", false);
        } else {
            $("#Search-acompanante").prop("disabled", true);
        }
    });

    // Mantiene el flujo actual para verificación de documento
    $("#formVerificarAcceso").submit(function(e) {
        e.preventDefault();
        var documento = $("#documentoA").val().trim();

        if (documento === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Debe ingresar un número de documento.'
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "../Control/verificarAcceso.php",
            data: { documento: documento },
            dataType: "html",
            beforeSend: function() {
                Swal.fire({
                    title: 'Verificando...',
                    text: 'Por favor, espere.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.fire({
                    icon: response.includes("ACCESO DENEGADO") || response.includes("ADVERTENCIA") ? 'error' : 'success',
                    title: 'Resultado',
                    html: response
                });

                // Controlar botón según la respuesta si el checkbox NO está marcado
                if (!$("#validacionCompletada").is(":checked")) {
                    if (response.includes("ACCESO DENEGADO") || response.includes("ADVERTENCIA")) {
                        $("#Search-acompanante").prop("disabled", true);
                    } else {
                        $("#Search-acompanante").prop("disabled", false);
                    }
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud.'
                });

                // En caso de error, deshabilitar el botón si el checkbox no está marcado
                if (!$("#validacionCompletada").is(":checked")) {
                    $("#Search-acompanante").prop("disabled", true);
                }
            }
        });
    });
});
