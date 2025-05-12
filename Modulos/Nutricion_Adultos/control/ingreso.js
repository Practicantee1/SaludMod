$(document).ready(function () {
    $('.clsInput').on('input', function () {
        // Reemplazar comas (,) por puntos (.)
        const value = $(this).val().replace(/,/g, '.');
        $(this).val(value);

        // Verificar si es un número válido
        if (isNaN(parseFloat(value))) {
            //console.log('El valor ingresado no es un número válido.');
        }
    });

});

$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: '../logica/consultarSelects.php',
        data: {lista: "fuentePeso"},
        dataType: "json",
        success: function(response) {
            //console.log(response);
            var select = $('#SelectFuenteDato');

            // Itera sobre la respuesta y crea las opciones
            $.each(response, function(index, item) {
                // Crea una opción para cada elemento de la respuesta
                select.append('<option value="' + item.id + '">' + item.nombre + '</option>');
            });
        },
        error: function(xhr, status, error) {
            //console.error("AJAX request failed:", error);
        }
    });
});

// $("#idEstaturaTrabajo").change(function(){
//     let estatura = $(this).val()
//     $("#idEstatura").val(estatura)
//     //console.log(estatura)
// })


$(document).ready(function() {
        //console.log("Entra")
        $('#idIMCMeta').on('input', function() {
            $("#pesoSaludable").slideUp();
            $("#idPesoSaludable").val("");
            $("#pesoObesidad").slideUp();
            $("#idPesoObesidad").val("");
            const categoriasIMC = [
                "Desnutricion severa",
                "Desnutricion moderada",
                "Desnutricion leve",
                "Peso insuficiente",
                "Eutrofico",
                "Sobrepeso"
            ];
            const categoriasObesidad = [
                "Obesidad grado I",
                "Obesidad grado II",
                "Obesidad grado III",
                "Obesidad grado IV"
            ];
            let clasifIMC = $("#idClasifIMC").val()
            if (categoriasIMC.includes(clasifIMC)) {
                calcularPesoSaludable();
            }else if (categoriasObesidad.includes(clasifIMC)) {
                calcularPesoAjustado();
            }
        });
        function calcularPesoSaludable(){
            let imc =  parseFloat($("#idIMCMeta").val());
            let estaturaTrabajo =  parseFloat($("#idEstaturaTrabajo").val());
            let estaturaDirecto =  parseFloat($("#idEstatura").val());
            let estatura = estaturaDirecto || estaturaTrabajo
            let resultado = imc *(estatura*estatura);
            resultado = resultado.toFixed(2);
            $("#pesoSaludable").slideDown();
            $("#idPesoSaludable").val(resultado);
        }
        function calcularPesoAjustado(){
            let imc =  $("#idClasifIMC").val();
            let resultado = ""
            if(imc == "Obesidad grado I" || imc == "Obesidad grado II"){
                resultado = "74.6"
            }else if(imc == "Obesidad grado III" || imc == "Obesidad grado IV"){
                resultado = "83.1"
            }
            $("#pesoObesidad").slideDown();
            $("#idPesoObesidad").val(resultado);
        }
    });

$(document).ready(function () {

    $('#SelectPeriodoEvaluado,#idPesoActual , #idPesoTrabajo,#idPesoUsual').on('input', function () {
        calcularCambioPeso();
    });
    
    function calcularCambioPeso() {
            let periodoEvaluado = $("#SelectPeriodoEvaluado option:selected").val();
            let porcentajeCambio = "";
            let pesoUsual =  parseFloat($("#idPesoUsual").val());
            let pesoActual = parseFloat($('#idPesoActual').val());
            let pesoEstimado = parseFloat($('#idPesoTrabajo').val());
            let pesoSeco = parseFloat($('#idPesoSecoEstimado').val());
            let peso = pesoActual || pesoEstimado || pesoSeco
            porcentajeCambio = ((pesoUsual-peso)/(pesoUsual/100));
            if(periodoEvaluado == 1){
                //console.log("1")
                if(porcentajeCambio == 1){
                    //console.log("7.1")
                    $("#idClasifCambioPeso").val("PP significativa");
                }else if(porcentajeCambio >= 2){
                    $("#idClasifCambioPeso").val("PP severa");
                    //console.log("7.2")
                }else if(porcentajeCambio < 1 && porcentajeCambio > 0){
                    $("#idClasifCambioPeso").val("PP aceptable");
                    //console.log("7.3")
                }else if(porcentajeCambio < 0){
                    porcentajeCambio = porcentajeCambio * (-1);
                    $("#idClasifCambioPeso").val("Subio de peso");
                }
            }else if(periodoEvaluado == 2){
                //console.log("2")
                
                if(porcentajeCambio == 5 ){
                    $("#idClasifCambioPeso").val("PP significativa");
                }else if(porcentajeCambio > 5){
                    $("#idClasifCambioPeso").val("PP severa");
                }else if(porcentajeCambio < 5){
                    $("#idClasifCambioPeso").val("PP aceptable");
                }else if(porcentajeCambio < 0){
                    porcentajeCambio = porcentajeCambio * (-1);
                    $("#idClasifCambioPeso").val("Subio de peso");
                }
            }else if(periodoEvaluado == 3){
                //console.log("3")
                if(porcentajeCambio == 7 ){
                    $("#idClasifCambioPeso").val("PP significativa");
                }else if(porcentajeCambio > 7){
                    $("#idClasifCambioPeso").val("PP severa");
                }else if(porcentajeCambio < 7){
                    $("#idClasifCambioPeso").val("PP aceptable");
                }else if(porcentajeCambio < 0){
                    porcentajeCambio = porcentajeCambio * (-1);
                    $("#idClasifCambioPeso").val("Subio de peso");
                }
            }else if(periodoEvaluado == 4){
                //console.log("4")
                if(porcentajeCambio == 10 ){
                    $("#idClasifCambioPeso").val("PP significativa");
                }else if(porcentajeCambio > 10){
                    $("#idClasifCambioPeso").val("PP severa");
                }else if(porcentajeCambio < 10){
                    $("#idClasifCambioPeso").val("PP aceptable");
                }else if(porcentajeCambio < 0){
                    porcentajeCambio = porcentajeCambio * (-1);
                    $("#idClasifCambioPeso").val("Subio de peso");
                }
            }
            porcentajeCambio = porcentajeCambio.toFixed(0)
            //console.log(porcentajeCambio)
            $("#idCambioPeso").val(porcentajeCambio).trigger('input');
        // } else {
        // //console.log("No se ha seleccionado un rango válido.");
        // }
    }
});


$(document).ready(function() {
    // Escuchar los cambios en los dos inputs
    $('#idRodilla, #idBrazo').on('input', function() {
        calcularXmedidasAntropometricas();
    });

    function calcularXmedidasAntropometricas() {
        // Obtener los valores de los dos inputs
        let rodilla = parseFloat($('#idRodilla').val());
        let brazo = parseFloat($('#idBrazo').val());
        let genero = $('#genero').val();
        let edad = $('#edad').val();
        let resultado = ""
        let resultadoMaximo = ""
        let resultadoMinimo = ""
        // Verificar que ambos valores no estén vacíos
        if (rodilla && brazo) {
            if((edad >= "19" && edad < "60")&& (genero == "Femenino") ){
                resultado = (rodilla*1.01) + (brazo*2.81) - 66.04;  
                resultadoMaximo = resultado + 10.6;
                resultadoMinimo = resultado - 10.6;
            }else if((edad >= 60 && edad < 80)&& (genero == "Femenino") ){
                resultado = (rodilla*1.09) + (brazo*2.68) - 65.51;  
                resultadoMaximo = resultado + 11.42;
                resultadoMinimo = resultado - 11.42;
            }else if((edad >= 19 && edad < 60)&& (genero == "Masculino") ){
                resultado = (rodilla*1.19) + (brazo*3.21) - 86.82;  
                resultadoMaximo = resultado + 11.42;
                resultadoMinimo = resultado - 11.42;
            }else if((edad >= 60 && edad < 80)&& (genero == "Masculino") ){
                resultado = (rodilla*1.1) + (brazo*3.07) - 75.81;  
                resultadoMaximo = resultado + 11.46;
                resultadoMinimo = resultado - 11.46;
            }else{
                resultado="No se pudo calcular el peso estimado"
            }
            resultado = resultado.toFixed(2);
            resultadoMaximo = resultadoMaximo.toFixed(2);
            resultadoMinimo = resultadoMinimo.toFixed(2);
            $('#idPesoEstimado').val(resultado); // Mostrar el resultado
            //console.log(resultadoMaximo)
            $('#idPesoMinimoEstimado').text('Peso Minimo: ' + resultadoMinimo);
            $('#idPesoMaximoEstimado').text('Peso Maximo: ' + resultadoMaximo);
            // Realizar el cálculo con los dos valores
        }
    }
});

$("#SelectFuenteDatoEstatura").change(function () {
    $("#idEstatura").val("")
    $("#idEstaturaTrabajo").val("")
    $("#longitudRodilla").slideUp();
    $("#estaturaMin").slideUp();
    $("#estaturaMax").slideUp();
    
    $("#EstaturaTrabajo").slideUp();
    // $("#estatura").slideUp();

    let option = $("#SelectFuenteDatoEstatura").find('option:selected');
    let idOpcion = option.val();
    //console.log(idOpcion);
    if(idOpcion == "2"){
        $("#longitudRodilla").slideDown();
        $("#idEstatura").attr("disabled", true);
        $("#estatura").slideDown();
        $("#EstaturaTrabajo").slideDown();
        $("#estatura label").text("Estatura estimada");
    }else if(idOpcion == "1"){
        $("#estatura").slideDown();
        $("#idEstatura").removeAttr("disabled");
        $("#estatura label").text("Estatura");
    }
})

$(document).ready(function() {
    // Escuchar los cambios en los dos inputs
    $('#idLongitudRodilla').on('input', function() {
        calcularEstatura();
    });
    function calcularEstatura(){
        let longitudRodilla = parseFloat($("#idLongitudRodilla").val());
        let resultado = ""
        let resultadoMax = ""
        let resultadoMin = ""
        let genero = $('#genero').val();
        let edad = parseFloat($('#edad').val());
        if(genero =="Femenino"){
            resultado = (((longitudRodilla * 1.263)-(0.159*edad))+107.7)/100
            resultado = resultado.toFixed(2);
            resultadoMax = resultado + 5.06
            resultadoMin = resultado - 5.06
        }else  if(genero =="Masculino"){
            resultado = ((longitudRodilla * 1.121)-(0.117*edad)+119.6)/100
            resultadoMax = resultado + 0.0457
            resultadoMin = resultado - 0.0457
            resultado = resultado.toFixed(2);
            resultadoMax = resultadoMax.toFixed(2);
            resultadoMin = resultadoMin.toFixed(2);
        }
        $("#idEstatura").val(resultado).trigger('input');
        $('#idEstaturaMin').text('Peso Minimo: ' + resultadoMin);
        $('#idEstaturaMax').text('Peso Maximo: ' + resultadoMax);
        $("#estaturaMin").slideDown();
        $("#estaturaMax").slideDown();

    }
});



$("#SelectEdemas").change(function () {
    $("#idPesoActual").val("");
    $("#idPesoSecoEstimado").val("");
})

$(document).ready(function() {
    // Escuchar los cambios en los dos inputs
    $('#idPesoActual, #idPesoSecoEstimado').on('input', function() {
        calcularEdema();
    });
    
    function calcularEdema() {
        // Obtener los valores de los dos inputs
        let option = $("#SelectEdemas").find('option:selected');
        let idEdema = option.val();
        let nombre = option.data('nombre');
        let porcentaje = parseFloat(option.attr('data-porcentaje'));
        let pesoActual = parseFloat($('#idPesoActual').val());
        //console.log(porcentaje)
        let resultado = ((100 - porcentaje)/100)*pesoActual;
        resultado = resultado.toFixed(2);
        $('#idPesoSecoEstimado').val(resultado); // Mostrar el resultado
    }
});

$(document).ready(function () {
    $('#idPesoActual, #idPesoEstimado, #idPesoSecoEstimado, #idEstaturaTrabajo,#idEstatura,#idLongitudRodilla, #idPesoTrabajo').on('input', calcularIMC);
});

function calcularIMC(){
    // //console.log("SD")
    let estaturaTrabajo = parseFloat($('#idEstaturaTrabajo').val());
    let estaturaDirecto = parseFloat($('#idEstatura').val());
    let estatura = estaturaTrabajo || estaturaDirecto
    let pesoActual = parseFloat($('#idPesoActual').val());
    let pesoTrabajo = parseFloat($('#idPesoTrabajo').val());
    let pesoSeco = parseFloat($('#idPesoSecoEstimado').val());
    let peso = pesoTrabajo || pesoSeco || pesoActual;
    console.log(peso)
    console.log(estatura)
    //console.log(estatura*estatura)
    if (peso && estatura && estatura > 0) {
        let imc = (peso / (estatura * estatura)).toFixed(1); 
        $('#idIMCActual').val(imc).trigger('input'); 
    } else {
        $('#idIMCActual').val(''); 
    }
}

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

$("#SelectFuenteDato").change(function () {
    $("#idPesoActual").val("");
    $("#idPesoSecoEstimado").val("");
    var opcion = $("#SelectFuenteDato option:selected").val();
    //console.log(opcion);
    $("#rodilla, #brazo, #PesoActual,#pesoEstimado,#pesoSecoEstimado, #ld-edemas, #pesoMinimoEstimado, #pesoMaximoEstimado, #pesoTrabajo").slideUp();
    if (opcion === "1" || opcion === "2") {
        $("#PesoActual").slideDown();
    } else if (opcion === "3") {
        $("#brazo, #rodilla, #pesoEstimado, #pesoMinimoEstimado, #pesoMaximoEstimado, #pesoTrabajo").slideDown();
    } else if (opcion === "4") {
        $("#ld-edemas, #pesoSecoEstimado, #PesoActual").slideDown();
        $.ajax({
            type: "POST",
            url: '../logica/consultarSelects.php',
            data: {lista: "edemas"},
            dataType: "json",
            success: function(response) {
                //console.log(response);
                var select = $('#SelectEdemas');
    
                // Itera sobre la respuesta y crea las opciones
                $.each(response, function(index, item) {
                    // Crea una opción para cada elemento de la respuesta
                    select.append('<option data-porcentaje="'+ item.porcentaje +'" value="' + item.id + '">' + item.nombre_edema +' ('+ item.porcentaje +'%)' + '</option>');
                });
            },
            error: function(xhr, status, error) {
                //console.error("AJAX request failed:", error);
            }
        });
    }
});

$(document).ready(function () {
    $('#idIMCActual, #idPesoTrabajo').on('input', calcularClasificacionIMC);
});

function calcularClasificacionIMC(){
    let edad = $('#edad').val();
    let imc = $('#idIMCActual').val();
    if(edad >= 18 && edad <= 59){
        if(imc < 16.0){
            $("#idClasifIMC").val("Desnutricion severa");
        }else if(imc >= 16.0 && imc <= 16.9){
            $("#idClasifIMC").val("Desnutricion moderada");
        }else if(imc > 17.0 && imc <= 18.4){
            $("#idClasifIMC").val("Desnutricion leve");
        }else if(imc > 18.5 && imc <= 24.5){
            $("#idClasifIMC").val("Eutrofico");
        }else if(imc > 25.0 && imc <= 29.9){
            $("#idClasifIMC").val("Sobrepeso");
        }else if(imc > 30.0 && imc <= 34.9){
            $("#idClasifIMC").val("Obesidad grado I");
        }else if(imc > 35.0 && imc <= 39.9){
            $("#idClasifIMC").val("Obesidad grado II");
        }else if(imc > 40){
            $("#idClasifIMC").val("Obesidad grado III");
        }
    }else if(edad >= 60){
        if(imc < 16.0){
            $("#idClasifIMC").val("Desnutricion severa");
        }else if(imc >= 16.0 && imc <= 16.9){
            $("#idClasifIMC").val("Desnutricion moderada");
        }else if(imc > 17.0 && imc <= 18.4){
            $("#idClasifIMC").val("Desnutricion leve");
        }else if(imc > 18.5 && imc < 22.0){
            $("#idClasifIMC").val("Peso insuficiente");
        }else if(imc >= 22.0 && imc < 27.0){
            $("#idClasifIMC").val("Eutrofico");
        }else if(imc > 27.0 && imc <= 29.9){
            $("#idClasifIMC").val("Sobrepeso");
        }else if(imc > 30.0 && imc <= 34.9){
            $("#idClasifIMC").val("Obesidad grado I");
        }else if(imc > 35.0 && imc <= 39.9){
            $("#idClasifIMC").val("Obesidad grado II");
        }else if(imc > 40.0 && imc <= 49.9){
            $("#idClasifIMC").val("Obesidad grado III");
        }else if(imc > 50){
            $("#idClasifIMC").val("Obesidad grado IV");
        }
    }
}

$("#SelectObjetivo").change(function () {
    var opcion = $("#SelectObjetivo option:selected").val();
    //console.log(opcion);
    $("#idOtroObjetivo").slideUp();
    if (opcion === "Otro") {
        $("#idOtroObjetivo").slideDown();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#idPeriodoEvaluado", {
      mode: "range",
      dateFormat: "Y-m-d",
      locale: "es",
      onClose: function (selectedDates) {
        if (selectedDates.length === 2) { // Asegúrate de que hay dos fechas seleccionadas
          const startDate = selectedDates[0]; // Primera fecha
          const endDate = selectedDates[1];   // Segunda fecha
          const diffInTime = endDate - startDate; // Diferencia en milisegundos
          var periodoEvaluado = diffInTime / (1000 * 60 * 60 * 24); // Convertir a días 
          //console.log(periodoEvaluado + " dias")
          calcularCambioPeso(periodoEvaluado)
        }
      }
    });
  });

document.addEventListener("click", function(e) {
    // miramos si el elemento clickeado tiene la clase desnutricionGlim
    if (e.target.classList.contains("desnutricionGLIM")) {
        let botones = document.querySelectorAll(".desnutricionGLIM");
        
        // les quitamos el gbc a los botones
        botones.forEach(btn => btn.style.backgroundColor = "");
        botones.forEach(btn => btn.style.color = "#000");
        
        // y le ponemos el bgc solo al clickeado (e.target) para saber cual fue el que se clickeó
        e.target.style.backgroundColor = "#066e45";
        e.target.style.color = "#fff";
    }
});

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

document.querySelector("#btn-AgregarLinea").addEventListener("click", function () {
    const tbody = document.querySelector("#tblOtros tbody");

    // Seleccionar el último <tr> de la tabla
    const lastRow = tbody.querySelector("tr:last-child");

    // Clonar el último <tr>
    const newRow = lastRow.cloneNode(true);

    // Limpiar los valores de los inputs en el nuevo <tr>
    const inputs = newRow.querySelectorAll("input");
    inputs.forEach(input => input.value = "");

    // Verificar si el último <td> contiene un botón, y si no lo tiene, agregarlo
    let btn_eliminar = newRow.querySelector("td:last-child button");
    // //console.log(btn_eliminar)
    if (btn_eliminar.hasAttribute("hidden")) {
        btn_eliminar.removeAttribute("hidden");
    }

    // Agregar la nueva fila al final del <tbody>
    tbody.appendChild(newRow);

    // Asignar evento al botón de eliminar
    asignarEventosEliminar();
});

// Función para asignar eventos al botón de eliminar
function asignarEventosEliminar() {
    const botonesEliminar = document.querySelectorAll(".btn-eliminar");

    botonesEliminar.forEach(boton => {
        boton.addEventListener("click", function () {
            const fila = boton.closest("tr"); // Encuentra la fila más cercana al botón
            fila.remove(); // Elimina la fila
        });
    });
}

// Inicializar eventos para filas existentes
asignarEventosEliminar();


// const pesoTrabajo = document.getElementById('idPesoTrabajo');
// const mensajePeso = document.querySelector('.mostrarMINMAX');

// Cuando el elemento recibe el foco
$("#idPesoTrabajo").focus(function(){
    $("#minmaxPeso").slideDown();
})
$("#idPesoTrabajo").blur(function(){
    $("#minmaxPeso").slideUp();
})

// pesoTrabajo.addEventListener('focus', () => {
//     mensajePeso.style.display = 'block';
// });

// // Cuando el elemento pierde el foco
// pesoTrabajo.addEventListener('blur', () => {
//     mensajePeso.style.display = 'none';
// });


// Cuando el elemento recibe el foco
$("#idEstaturaTrabajo").focus(function(){
    $("#minmaxEstatura").slideDown();
})
$("#idEstaturaTrabajo").blur(function(){
    $("#minmaxEstatura").slideUp();
})



// ################ CRITERIOS GLIM #########################

$(document).ready(function(){

    $('#idCambioPeso,#idPesoActual,  #idPesoTrabajo, #SelectPeriodoEvaluado').on('input', function () {
        // $("#idPerdidaPeso").val($(this).val());

        let pPeso =$("#idCambioPeso").val();
        let pEvaluado = $("#SelectPeriodoEvaluado").val();
        console.log("periodo" + pEvaluado + "peso"+ pPeso)
        if((pPeso >= 5 && pPeso <= 10) && (pEvaluado == 1 || pEvaluado == 2 || pEvaluado == 3 || pEvaluado == 5)){
            $("#idPerdidaPeso").val("DNT moderada")
        }
        else if((pPeso > 10) && (pEvaluado == 1 || pEvaluado == 2 || pEvaluado == 3 || pEvaluado == 5)){
            $("#idPerdidaPeso").val("DNT grave")
        }

        else if((pPeso >= 10 && pPeso <= 20) && (pEvaluado == 4)){
            $("#idPerdidaPeso").val("DNT moderada")
        }
        else if((pPeso > 20) && (pEvaluado == 4)){
            $("#idPerdidaPeso").val("DNT grave")
        }
        else {
            $("#idPerdidaPeso").val("No hay desnutricion por CG")
        }

    });


    $('#idIMCActual, #edad').on('input', function () {
        let imcActual = parseFloat($("#idIMCActual").val()); // IMC actual
        let edad = parseInt($("#edad").val()); // Edad del paciente
        console.log("IMC Actual:", imcActual, "Edad:", edad);

        if ((imcActual < 18.5 && edad < 70) || (imcActual < 20 && edad >= 70)) {
            $("#idIMCBajo").val("DNT grave");

        } else if ((imcActual < 20 && edad < 70) || (imcActual < 22 && edad >= 70)) {
            $("#idIMCBajo").val("DNT moderada");
        } else {
            $("#idIMCBajo").val("IMC normal");
        }
    });

    $('#idIngesta, #idDuracion, #idEnfermedadCronica').on('input change', function () {
        let ingesta = parseFloat($("#idIngesta").val()); // Porcentaje de ingesta (ej. 40%)
        let duracion = parseInt($("#idDuracion").val()); // Duración en semanas
        let enfermedadCronica = $("#idEnfermedadCronica").val(); // "sí" o "no"
    
        let etiologia = "";
    
        // Evaluar ingesta reducida
        if (ingesta < 50 && duracion > 1) {
            etiologia = "Reducción grave de la ingesta durante más de 1 semana (<50% de la ingesta recomendada)";
        } else if (ingesta >= 50 && ingesta < 100 && duracion > 2) {
            etiologia = "Reducción moderada de la ingesta durante más de 2 semanas (50-100% de la ingesta recomendada)";
        } 
        
    
        // Evaluar enfermedad crónica digestiva
        if (enfermedadCronica === "sí") {
            etiologia = "Enfermedad crónica digestiva con impacto adverso en asimilación o absorción";
        }
    
        // Validación final
        if (etiologia === "") {
            etiologia = "No se identificaron causas etiológicas significativas";
        }
    
        // Mostrar el resultado
        $("#idEtiologia").val(etiologia);
    });
    
    


})

