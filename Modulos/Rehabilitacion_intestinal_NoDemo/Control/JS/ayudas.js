let imagenes
let estudios
function guardarRegistro() {
    Swal.fire({
        title: "Guardar registro",
        text: "¿Está seguro de guardar este registro?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, guardar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            savePaciente();
            // Obtener valores para la tabla de imágenes
            const fechaImagenes = document.getElementById("fecha").value || "N/A";
            const tipoEstudioImagenes = document.getElementById("tipoEstudio").value || "N/A";
            const especificacionImagenes = document.getElementById("otherInput").value || "N/A";
            const conclusionImagenes = document.getElementById("conclusionImagenes").value || "N/A";

            // Obtener valores para la tabla de estudios
            const fechaEstudios = document.getElementById("fecha2").value || "N/A";
            const tipoEstudioEstudios = document.getElementById("estudioEndoscopicos").value || "N/A";
            const conclusionEstudios = document.getElementById("conclusionEstudios").value || "N/A";

            // Verificar si ambos conjuntos de campos tienen datos
            if (
                (fechaImagenes !== "N/A" || tipoEstudioImagenes !== "N/A" || especificacionImagenes !== "N/A" || conclusionImagenes !== "N/A") &&
                (fechaEstudios !== "N/A" || tipoEstudioEstudios !== "N/A" || conclusionEstudios !== "N/A")
            ) {
                // Guardar en tabla de imágenes
                const tablaImagenes = document.getElementById("tablaImagenes").querySelector('tbody');
                const newRowImagenes = tablaImagenes.insertRow();
                newRowImagenes.insertCell(0).textContent = fechaImagenes;
                newRowImagenes.insertCell(1).textContent = tipoEstudioImagenes;
                newRowImagenes.insertCell(2).textContent = especificacionImagenes;
                newRowImagenes.insertCell(3).textContent = conclusionImagenes;

                // Guardar en tabla de estudios
                const tablaEstudios = document.getElementById("tabEstudiosEndoscopicos").querySelector('tbody');
                const newRowEstudios = tablaEstudios.insertRow();
                newRowEstudios.insertCell(0).textContent = fechaEstudios;
                newRowEstudios.insertCell(1).textContent = tipoEstudioEstudios;
                newRowEstudios.insertCell(2).textContent = conclusionEstudios;

                // Limpiar ambos conjuntos de campos
                document.getElementById("fecha").value = '';
                document.getElementById("tipoEstudio").value = '';
                document.getElementById("otherInput").value = '';
                document.getElementById("conclusionImagenes").value = '';
                document.getElementById("fecha2").value = '';
                document.getElementById("estudioEndoscopicos").value = '';
                document.getElementById("conclusionEstudios").value = '';

                Swal.fire("Guardado", "Los registros se han guardado exitosamente en ambas tablas", "success");
            }
            // Verificar si solo los campos de imágenes tienen datos
            else if (fechaImagenes !== "N/A" || tipoEstudioImagenes !== "N/A" || especificacionImagenes !== "N/A" || conclusionImagenes !== "N/A") {
                const tablaImagenes = document.getElementById("tablaImagenes").querySelector('tbody');
                const newRow = tablaImagenes.insertRow();
                newRow.insertCell(0).textContent = fechaImagenes;
                newRow.insertCell(1).textContent = tipoEstudioImagenes;
                newRow.insertCell(2).textContent = especificacionImagenes;
                newRow.insertCell(3).textContent = conclusionImagenes;

                document.getElementById("fecha").value = '';
                document.getElementById("tipoEstudio").value = '';
                document.getElementById("otherInput").value = '';
                document.getElementById("conclusionImagenes").value = '';

                Swal.fire("Guardado", "El registro de imágenes se ha guardado exitosamente", "success");
            }
            // Verificar si solo los campos de estudios tienen datos
            else if (fechaEstudios !== "N/A" || tipoEstudioEstudios !== "N/A" || conclusionEstudios !== "N/A") {
                const tablaEstudios = document.getElementById("tabEstudiosEndoscopicos").querySelector('tbody');
                const newRow = tablaEstudios.insertRow();
                newRow.insertCell(0).textContent = fechaEstudios;
                newRow.insertCell(1).textContent = tipoEstudioEstudios;
                newRow.insertCell(2).textContent = conclusionEstudios;

                document.getElementById("fecha2").value = '';
                document.getElementById("estudioEndoscopicos").value = '';
                document.getElementById("conclusionEstudios").value = '';

                Swal.fire("Guardado", "El registro de estudios se ha guardado exitosamente", "success");
            }
            // Si ningún conjunto de campos tiene datos, mostrar error
            else {
                Swal.fire("Error", "Debe completar al menos un campo para guardar el registro", "error");
            }
        }
    });
}


function savePaciente() {
    let episodio = $("#episodio").val();
    let documento = $("#nroDoc").val();
    let tipo_documento = $("#tipo").val();
    let nombre = $("#nombre").val();
    let edad = $("#edad").val();
    let genero = $("#sexo").val();
    let ubicacion = $("#ubicacion").val();
    let cama = $("#cama").val();
    let entidad = $("#entidad").val();
    let nombreMed =  $("#nombreMed").val();
    let especialidadMedico = $("#especialidad").val();
    let fechaImagenes = $("#fecha").val() 
    let tipoEstudioImagenes = $("#tipoEstudio").val()
    let especificacionImagenes = $("#otherInput").val()
    let conclusionImagenes = $("#conclusionImagenes").val()
    let fechaEstudios = $("#fecha2").val()
    let tipoEstudioEstudios = $("#estudioEndoscopicos").val()
    let conclusionEstudios = $("#conclusionEstudios").val()
    let centrosanitario = $("#centrosanitario").val();

    // console.log("Imagenes",fechaImagenes,
    //     tipoEstudioImagenes,
    //     especificacionImagenes,
    //     conclusionImagenes,"Estudios",
    //     fechaEstudios,
    //     tipoEstudioEstudios,
    //     conclusionEstudios)
    $.ajax({
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/guardarAyudas.php',
        type: 'POST',
        data:{
            episodio: episodio,
            tipo_documento: tipo_documento,
            documento: documento,
            nombre: nombre,
            edad: edad,
            genero: genero,
            ubicacion: ubicacion,
            cama: cama,
            entidad: entidad,
            nombreMedico: nombreMed,
            especialidadMedico: especialidadMedico,
            fechaImagenes:fechaImagenes,
            tipoEstudioImagenes:tipoEstudioImagenes,
            especificacionImagenes:especificacionImagenes,
            conclusionImagenes:conclusionImagenes,
            fechaEstudios:fechaEstudios,
            tipoEstudioEstudios:tipoEstudioEstudios,
            conclusionEstudios:conclusionEstudios,
            centrosanitario:centrosanitario
        },
        success: function(result) {
            console.log(result);  
            try {
                if (result.status === 'success') {
                    console.log("Se guardó en la BD");
                    
                } else {
                    console.error("Error del servidor:", result.message || "Unknown error");
                }
            } catch (e) {
                console.error("Error parsing response:", e);
            }
        },
        
        error: function(xhr, status, error) {
            console.error("Error:", status, error);
            Swal.fire({
                title: "Error",
                text: "Hubo un problema al guardar los datos. Intente nuevamente.",
                icon: "error"
            });
        }
    });
    

}

$(document).ready(function() {
    
    $('#episodio').change(function() {
        episodio = document.getElementById("episodio").value || "N/A";  
        llenarHistoricoImagenes(episodio); 
        llenarHistoricoEstudios(episodio);
    });

    $('#episodio').trigger('change');
});

function llenarHistoricoImagenes(episodio) {
    if (!episodio) {
        console.error("Error: El parámetro 'episodio' no está definido");
        return;
    }

    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/llenarHistoricoAyudas.php',
        data: { episodio: episodio },
        dataType: "json",
        success: function (response) {
            if (response.error) {
                console.error("Error del servidor:", response.error);
                return;
            }

            if (response && response.imagenes && response.imagenes.length > 0) {
                response.imagenes.forEach(function (imagen) {

                    let newRow = `
                        <tr>
                            <td>${imagen.fecha || ''}</td>
                            <td>${imagen.tipoEstudio || ''}</td>
                            <td>${imagen.otroEstudio || ''}</td>
                            <td>${imagen.conclusion || ''}</td>
                        </tr>`;
                    $('#tablaImagenes').append(newRow);
                });
            } else {
                console.warn("No se encontraron imágenes para el episodio especificado.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function llenarHistoricoEstudios(episodio) {
    if (!episodio) {
        console.error("Error: El parámetro 'episodio' no está definido");
        return;
    }

    $.ajax({
        type: "POST",
        url: '/SaludMod/Modulos/Rehabilitacion_intestinal/logica/llenarHistoricoEstudios.php',
        data: { episodio: episodio },
        dataType: "json",
        success: function (response) {
            if (response.error) {
                console.error("Error del servidor:", response.error);
                return;
            }

            if (response && response.imagenes && response.imagenes.length > 0) {
                response.imagenes.forEach(function (imagen) {

                    let newRow = `
                        <tr>
                            <td>${imagen.fecha || ''}</td>
                            <td>${imagen.tipoEstudio || ''}</td>
                            <td>${imagen.conclusion || ''}</td>
                        </tr>`;
                    $('#tablaEstudiosEndoscopicos').append(newRow);
                });
            } else {
                console.warn("No se encontraron imágenes para el episodio especificado.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}


