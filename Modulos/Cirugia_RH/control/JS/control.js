const alergia = document.getElementById("id_AlergiaReporta");
alergia.addEventListener("change", function(e){

    const texto = document.getElementById("textoarea_alergia");
    const texto_alergia = document.getElementById("texto_alergia");
    if(e.target.value === "si"){
        texto_alergia.removeAttribute("hidden");
    }else{
        texto_alergia.setAttribute("hidden", true);
        texto.value = "";
    }
});


const antibiotico = document.getElementById("id_Antibiotico");
antibiotico.addEventListener("change", function(e){
    textoarea_Plan
    const texto = document.getElementById("textoarea_antibiotico");
    const texto_antibiotico = document.getElementById("texto_antibiotico");
    if(e.target.value === "si"){
        texto_antibiotico.removeAttribute("hidden");
    }else{
        texto_antibiotico.setAttribute("hidden", true);
        texto.value = "";
    }
});

const plan = document.getElementById("id_Plan");
plan.addEventListener("change", function(e){

    const texto = document.getElementById("textoarea_Plan");
    const texto_plan = document.getElementById("texto_Plan");
    if(e.target.value === "si"){
        texto_plan.removeAttribute("hidden");
    }else{
        texto_plan.setAttribute("hidden", true);
        texto.value = "";
    }
});


const select = document.querySelectorAll(".form-control");
select.forEach(select => {
    select.style.fontSize = "0.8rem"


    select.addEventListener("change", function(){
        this.classList.add("opcionSeleccionada");
        this.blur();
    });
});

$(document).on("click", ".validarBtn", function(e){
    $("#confirmarBtn").attr("data-firma", $(e.target).data("tipo"));
});

$(document).ready(function () {
    $("#confirmacion_perfusionista").on("change", function(e){
        let valor = e.target.value;
        console.log("Cambio detectado, valor:", valor);

        if(valor === "si"){
            $("#id_Detalles_relevantes").prop("disabled", false).val("");
            $("#id_T").prop("disabled", false).val("");
            $("#id_perfusion").prop("disabled", false).val("");
        } else {
            $("#id_Detalles_relevantes").prop("disabled", true).val("N/A");
            $("#id_T").prop("disabled", true).val("N/A");
            $("#id_perfusion").prop("disabled", true).val("N/A");
        }


    });
});


$(document).ready(function () {
    $("input[name='confirm_perfusionista']").on("change", function(e){
        let valor = e.target.checked;
        console.log(valor)
         if(valor){
            $("#id_Detalles_relevantes").prop("disabled", false).val("");
            $("#id_T").prop("disabled", false).val("");
            $("#id_perfusion").prop("disabled", false).val("");
        } else {
            $("#id_Detalles_relevantes").prop("disabled", true).val("N/A");
            $("#id_T").prop("disabled", true).val("N/A");
            $("#id_perfusion").prop("disabled", true).val("N/A");
        }
    });
});

