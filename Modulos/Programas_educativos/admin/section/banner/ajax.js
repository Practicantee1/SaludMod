$(document).ready(function() {
    $('#documento').on('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            $("#documento").attr("readonly", true);
            var documento = $("#documento").val();
            console.log(documento);

            if (documento) {
                $.ajax({
                    url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/Programas_educativos/admin/section/search.php',
                    type: 'POST',
                    data: { Documento: documento },
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data && data.DatosPaciente) {
                            $('#nombre').val(data.DatosPaciente.Nombre_completo);
                            let episodio = data.DatosUltimoEpisodio.Episodio;
                            let episodioSinCeros = parseInt(episodio, 10);  // Elimina los ceros a la izquierda
                            $('#episodio').val(episodioSinCeros);
                        } else {
                            $('#nombre').val('No disponible');
                            $('#documento').val('No disponible');
                            console.error('Error:', data.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus);
                        console.error('Error thrown:', errorThrown);
                        console.log('Full jqXHR object:', jqXHR);
                        console.log('Response text:', jqXHR.responseText);
                    }
                });
            } else {
                // alert('Por favor ingrese un número de episodio.');
            
            }
        }
    });
});
