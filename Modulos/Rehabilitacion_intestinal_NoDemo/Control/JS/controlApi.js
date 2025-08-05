var pesoEdadContainer = document.getElementById("pesoEdadContainer");
var pesoTallaContainer = document.getElementById("pesoTallaContainer");
var imcContainer = document.getElementById("imcContainer");


$(document).ready(function() {
    if (pesoEdadContainer) { pesoEdadContainer.style.display = "none"; }
    if (pesoTallaContainer) { pesoTallaContainer.style.display = "none"; }
    if (imcContainer) { imcContainer.style.display = "none"; }
    
    const intervalo = setInterval(() => {
        const episodio = $('#episodio').val(); // Obtener el valor de 'episodio'
        if (episodio && episodio.trim() !== '') {
            clearInterval(intervalo); // Detener la observación
            verificacion($('#agregarLinea')); // Llamar a verificación
        }
    }, 500);
    $('#agregarLinea').on('change', function(e) {
        e.preventDefault();
        verificacion(this);
    });
});

function verificacion(form) {
    $.ajax({
        type: "POST",
        url: '../Control/controlApi.php', 
        data: $(form).serialize(),
        success: function(response) {
            // console.log("Respuesta cruda del servidor:", response);
            try {
                var quickScript = new Function(response);
                quickScript(); // Evalúa el código recibido como respuesta
        
                var edadTexto = document.getElementById('edad').value;
                // console.log("Edad recibida:", edadTexto);
        
                var edad = obtenerEdadEnAnios(edadTexto);
                // console.log("Edad numérica en años:", edad);
        
                activarCamposSegunEdad(edad);
            } catch (error) {
                console.error("Error ejecutando el script de la respuesta:", error);
            }
        }
    });
}

function obtenerEdadEnAnios(edadTexto) {
    let edad = 0;
    if (edadTexto.includes('mes')) {
        let meses = parseInt(edadTexto, 10);
        edad = meses / 12; 
    } else if (edadTexto.includes('año') || edadTexto.includes('años')) {
        edad = parseInt(edadTexto, 10);
    }

    return edad;
}

function activarCamposSegunEdad(edad) {
    console.log("Activando campos para la edad:", edad);

    const pesoParaTallaHeader = document.getElementById("pesoParaTallaHeader");
    const pesoParaEdadHeader = document.getElementById("pesoParaEdadHeader");
    const imcHeader = document.getElementById("imcHeader");

    if (pesoEdadContainer && pesoTallaContainer && imcContainer && pesoParaTallaHeader && pesoParaEdadHeader && imcHeader) {
        pesoEdadContainer.style.display = "none";
        pesoTallaContainer.style.display = "none";
        imcContainer.style.display = "none";

        pesoParaTallaHeader.style.display = "none";
        pesoParaEdadHeader.style.display = "none";
        imcHeader.style.display = "none";

        if (!isNaN(edad)) {
            if (edad < 5) {
                pesoEdadContainer.style.display = "block";
                pesoTallaContainer.style.display = "block";

                pesoParaTallaHeader.style.display = "table-cell";
                pesoParaEdadHeader.style.display = "table-cell";
            } else if (edad >= 5) {
                imcContainer.style.display = "block";
                imcHeader.style.display = "table-cell";
            }
        }
    } else {
        console.error("Uno o más contenedores o columnas no se encontraron en el DOM.");
    }
}

