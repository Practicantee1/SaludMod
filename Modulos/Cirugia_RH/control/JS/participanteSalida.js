$(document).ready(function() {
    // Función para obtener parámetros de la URL
    function obtenerParametroUrl(nombre) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(nombre);
    }

    // Obtener el valor de id_paciente desde la URL
    const id_paciente = obtenerParametroUrl('id_paciente');

    console.log("Valor del parámetro id_paciente:", id_paciente); // Verificar el valor

    if (id_paciente) {
        $('#id_paciente').val(id_paciente); // Rellenar el campo del formulario
        console.log("ID Paciente:", id_paciente);
        consultarFirmaSalidaIncompleta(id_paciente);
        consultarFS(id_paciente); // Llamar a la función con el ID
    } else {
        console.log("id_paciente es null o vacío");
    }
});

function crearFirmas(numero){
    for(let i = 0; i < numero - 1; i++){
        const filaParaClonar = document.querySelector('.firmaSalida-item');

        if (filaParaClonar) {
            const nuevaFila = filaParaClonar.cloneNode(true);

             const validarBtn = nuevaFila.querySelector('.validarBtn');
             if (validarBtn) {
                 validarBtn.disabled = false; // Deshabilitar el botón
             }

            // Agregar la nueva fila al contenedor específico
            const contenedor = document.getElementById('firmas-container-salida');
            contenedor.appendChild(nuevaFila);
        }
    }
}

function llenarFirmas(mensaje){
    let indice = 0;
    
    const inputsFirmas = document.querySelectorAll(".firmaSalida-item");
    inputsFirmas.forEach(inputsFirmas => {

        inputsFirmas.querySelector(".cargo").value = mensaje[indice].cargo;
        inputsFirmas.querySelector(".nombre").value = mensaje[indice].nombre;
        inputsFirmas.querySelector(".documento").value = mensaje[indice].num_documento;

        inputsFirmas.querySelector(".validarBtn").disabled = true;
        inputsFirmas.querySelector(".validarBtn").dataset.firmado = "Si";

        inputsFirmas.querySelector(".documento").dataset.id = mensaje[indice].idusuario;
        
        indice++;
    });
}


function consultarFirmaSalidaIncompleta(id_paciente){
    $.ajax({
        type: "POST",
        url: "../logica/participanteSalidaSQL.php",
        data: { id_paciente: id_paciente, completado: 0 },
        dataType: "json",
        success: function(response){
            console.log("Longitud no completados", response.message.length);
            console.log("Informacion del array", response.message);
            if(response.message.length > 0){
                
                console.log("Este es el tipo: ", typeof response.message)
                if((response.message.length > 0 || response.message.length == "undefined") && typeof response.message != "string"){
                    
                    crearFirmas(response.message.length);
                    llenarFirmas(response.message);
                }
                
            }
        }
    });

    
}


function consultarFS(id_paciente) {
    $.ajax({
        type: "POST",
        url: '../logica/participanteSalidaSQL.php',
        data: { id_paciente: id_paciente, completado: 1 },
        dataType: "json",
        success: function(response) {
            if(response.success){
                if (response.message.length > 0) {

                    var tableBody = $('.table-salida tbody'); // Selecciona específicamente la tabla de salida
                    $('.table-salida').removeAttr("hidden"); //Eliminar atributo hidden en caso de que lo tenga
                    tableBody.empty(); // Limpiar cualquier fila existente

                    // Asegúrate de que 'response' es un array de objetos
                    response.message.forEach(function(item) {
                        // Asegúrate de que las claves existen en 'item'
                        var row = '<tr>' +
                            '<td class="text-center">' + (item.cargo || '') + '</td>' +
                            '<td class="text-center">' + (item.nombre || '') + '</td>' +
                            '<td class="text-center">' + (item.num_documento || '') + '</td>' +
                            '</tr>';
                        tableBody.append(row);

                        $(document).ready(function() {
                            $('#firmaSalida').hide(); // Oculta el formulario al cargar la página
                            $('#firmas-container-salida').hide(); // Oculta el contenedor de firmas al cargar la página
                        });                    
                    });
                } else {
                    $(document).ready(function() {
                        $('.table-salida').hide(); // Oculta la tabla al cargar la página
                    });
                }
            }else{
                $('.table-salida').attr("hidden", true);
                console.log("Esta es la respuesta que puse xD: " , response.message)
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
