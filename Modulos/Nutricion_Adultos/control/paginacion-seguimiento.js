$(document).ready(function () {
    $('a[href^="#"]').click(function (e) {
        e.preventDefault(); // Evita el comportamiento predeterminado del enlace
        let target = $($(this).attr('href')); // Obtén el destino
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top - 100 // Ajusta el desplazamiento (50 píxeles más arriba)
            }, 250); // Duración de la animación en milisegundos
        }
    });
});

$("#ocultar").click(function() {
    $("#DatosPaciente").slideToggle();
});

$("#SelectObjetivo").change(function () {
    var opcion = $("#SelectObjetivo option:selected").val();
    console.log(opcion);
    $("#idOtroObjetivo").slideUp();
    if (opcion === "Otro") {
        $("#idOtroObjetivo").slideDown();
    }
});

const li        = document.querySelectorAll('.li')
const bloque    = document.querySelectorAll('.bloque')
// CLICK en li
    // TODOS .li quitar la clase activo
    // TODOS .bloque quitar la clase activo
    // .li con la posicion se añadimos la clase activo
    // .bloque con la posicion se añadimos la clase activo
// Recorriendo todos los LI
li.forEach( ( cadaLi , i )=>{
    // Asignando un CLICK a CADALI
    li[i].addEventListener('click',()=>{
        // Recorrer TODOS los .li
        li.forEach( ( cadaLi , i )=>{
            // Quitando la clase activo de cada li
            li[i].classList.remove('activo')
            // Quitando la clase activo de cada bloque
            bloque[i].classList.remove('activo')
        })
        // En el li que hemos click le añadimos la clase activo
        li[i].classList.add('activo')
        // En el bloque con la misma posición le añadimos la clase activo
        bloque[i].classList.add('activo')
    })
})


document.addEventListener("click", function(e) {
    // miramos si el elemento clickeado tiene la clase desnutricionGlim
    if (e.target.classList.contains("riesgo")) {
        let botones = document.querySelectorAll(".riesgo");
        
        // les quitamos el gbc a los botones
        botones.forEach(btn => btn.style.backgroundColor = "");
        botones.forEach(btn => btn.style.color = "#000");
        
        // y le ponemos el bgc solo al clickeado (e.target) para saber cual fue el que se clickeó
        e.target.style.backgroundColor = "#066e45";
        e.target.style.color = "#fff";
    }
});
    
document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".Gastrointestinal-container");

    // Botón "Más"
    document.querySelector("#btn-mas").addEventListener("click", function (e) {
        e.preventDefault(); // Evitar que el enlace recargue la página

        // Clonar el elemento GastroIntestinal
        const original = document.querySelector(".GastrointestinalBotones");
        const clone = original.cloneNode(true);

        // Limpiar los valores del clon
        clone.querySelector("input[type='checkbox']").style.opacity = "0";
        clone.querySelector("select").selectedIndex = 0;
        clone.querySelector("input[type='text']").value = "";
        clone.querySelector(".buttons").style.display = "none";

        // Agregar el clon al contenedor
        container.appendChild(clone);
    });

    // Botón "Menos"
    document.querySelector("#btn-menos").addEventListener("click", function (e) {
        e.preventDefault(); // Evitar que el enlace recargue la página

        const elements = document.querySelectorAll(".GastrointestinalBotones");

        // Eliminar el último elemento si hay más de uno
        if (elements.length > 1) {
            container.removeChild(elements[elements.length - 1]);
        }
    });
});
