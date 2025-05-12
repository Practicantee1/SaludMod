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



