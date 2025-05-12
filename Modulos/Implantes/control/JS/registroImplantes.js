$(document).ready(function() {
    $('#botonHistorial').click(function(e) {
            
            e.preventDefault();
            var documento = $("#idNumeroDocumento").val();
            
            //if(documento != 0){
                consultar(documento); 
            //}
        
     });
       
 })


 function consultar(documento) {
    $.ajax({
        type: "POST",
        url: '../Logica/registrosSQL.php',
        data: { Documento: documento },
        dataType: "json",
        success: function(response) {
            if (Array.isArray(response)) {
                if (response.length > 0) {
                    console.log("Data:", response);

                    var tableBody = $('#registroModal table tbody');
                    tableBody.empty(); // Limpiar cualquier fila existente

                    // Asegúrate de que 'response' es un array de objetos
                    response.forEach(function(item) {
                        // Usa 'item' en lugar de 'data'
                        var row = '<tr>' +
                            '<td class="text-center">' + item.Episodio + '</td>' +
                            '<td class="text-center">' + item.Numero_identificacion + '</td>' +
                            // '<td class="text-center">' + item.Numero_interno_paciente + '</td>' +
                            '<td class="text-center">' + item.Nombre_paciente + '</td>' +
                            '<td class="text-center">' + item.cod_diagnostico + '</td>' +
                            '<td class="text-center">' + item.Aseguradora + '</td>' +
                            '<td class="text-center">' + item.Nombre_cirujano + '</td>' +
                            '<td class="text-center">' + item.Especialidad + '</td>' +
                            '<td class="text-center">' + item.fecha_cirugía + '</td>' +
                            '<td class="text-center">' + item.Observaciones + '</td>' +
                            '<td class="text-center">' + item.nombre_casaComer + '</td>' +
                            '<td class="text-center">' + item.nombre_implante + '</td>' +
                            '<td class="text-center">' + item.entrenamiento_Soport + '</td>' +
                            '<td class="text-center">' + item.tiempo_Soporte + '</td>' +
                            '<td class="text-center">' + item.material_complet+ '</td>' +
                            '<td class="text-center">' + item.falla_implant_cx + '</td>' +
                            '<td class="text-center">' + item.impl_completo_corpaul + '</td>' +
                            '<td class="text-center">' + item.impl_tiempo_corpaul + '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });

                    // Mostrar el modal
                    $('#registroModal').modal('show');

                } else {
                    Swal.fire({
                        icon: "error",
                        title: "No se encontró información...",
                        text: "Este paciente no tiene registros",
                    });
                }
            } else {
                console.error("Invalid response format:", response);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salió mal, intenta de nuevo!",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log("Response Text:", xhr.responseText); // Muestra el texto completo de la respuesta
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Error en la solicitud AJAX.",
            });
        }
    });
}

// script2.js (o el nombre que tengas)
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('checkboxAmbulatoria');
    const div1 = document.getElementById('d1');
    const div2 = document.getElementById('d2');
    const selectDiagnostico = div1.querySelector('select');
    const inputDiagnostico = div2.querySelector('input');

    // Asignar ID y atributo required al cargar la página según el estado inicial del checkbox
    function setInitialState() {
        if (checkbox.checked) {
            assignAttributes(inputDiagnostico, selectDiagnostico);
        } else {
            assignAttributes(selectDiagnostico, inputDiagnostico);
        }
    }

    // Función para asignar ID y required al elemento activo
    function assignAttributes(activeElement, inactiveElement) {
        activeElement.id = 'Diagnostico';
        activeElement.setAttribute('required', 'required');
        inactiveElement.removeAttribute('id');
        inactiveElement.removeAttribute('required');
    }

    // Alternar entre select e input cuando cambia el checkbox
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            div1.style.display = 'none';
            div2.style.display = 'block';
            assignAttributes(inputDiagnostico, selectDiagnostico);
        } else {
            div1.style.display = 'block';
            div2.style.display = 'none';
            assignAttributes(selectDiagnostico, inputDiagnostico);
        }
    });

    // Escuchar el evento personalizado
    checkbox.addEventListener('checkboxChanged', function () {
        // Esto se ejecutará cuando el checkbox sea desmarcado
        div1.style.display = 'block'; // Mostrar el div original
        div2.style.display = 'none';   // Ocultar el div de entrada
        assignAttributes(selectDiagnostico, inputDiagnostico); // Restablecer atributos
    });

    // Establecer el estado inicial al cargar la página
    setInitialState();
});

