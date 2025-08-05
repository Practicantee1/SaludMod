let fechaUltimoRegistro;
let activeColumnIndex=null;
let id;
let reportePlantillas = [];
let tablaConDatos = true;
let nuevosExamenes = [];


let nombresTit = [
    "FECHA","HORA", "LEUCOCITOS", "NEUTROFILOS", "LINFOCITOS", "EOSINOFILOS", "HEMOGLOBINA", "HEMATOCRITO",
    "PLAQUETAS", "VSG", "PCR", "TGO/AST", "TGP/ALT", "BILIRRUBINA TOTAL","BILIRRUBINA DIRECTA", "GGT",
    "FOSFATASA ALCALINA", "TP", "INR", "TPT", "AMILASA", "SODIO", "FOSFORO", "POTASIO", "CLORO", "CALCIO",
    "MAGNESIO", "COLESTEROL TOTAL", "COLESTEROL HDL", "TRIGLICERIDOS", "PROTEINAS TOTALES", "ALBUMINA", "PRE-ALBUMINA",
    "VITAMINA B12", "VITAMINA D", "CREATININA", "GLICEMIA", "GASES HCO₃⁻", "GASES EB", "GASES Ph"
];

let nombresRegistroFilasTabla = [
    "FECHA", "HORA", "LEUCOCITOS", "NEUTROFILOS", "LINFOCITOS", "EOSINOFILOS", "HEMOGLOBINA", "HEMATOCRITO",
    "PLAQUETAS", "VSG", "PCR", "TGO/AST", "TGP/ALT", "BILIRRUBINA TOTAL","BILIRRUBINA DIRECTA", "GGT",
    "FOSFATASA ALCALINA", "TP", "INR", "TPT", "AMILASA", "SODIO", "FOSFORO", "POTASIO", "CLORO", "CALCIO",
    "MAGNESIO", "COLESTEROL TOTAL", "COLESTEROL HDL", "TRIGLICERIDOS", "PROTEINAS TOTALES", "ALBUMINA", "PRE-ALBUMINA",
    "VITAMINA B12", "VITAMINA D", "CREATININA", "GLICEMIA", "GASES HCO₃⁻", "GASES EB", "GASES Ph", "AISLAMIENTOS"
];

let nombreFilaTabla = [
    "fecha", "hora", "leucocitos", "neutrofilos", "linfocitos", "eosinofilos", "hemoglobina", "hematocrito",
    "plaquetas", "vsg", "pcr", "tgo", "tgp", "bilirrubina_total","bilirrubina_directa", "ggt",
    "fosfatasa_alcalina", "tp", "inr", "tpt", "amilasa", "sodio", "fosforo", "potasio", "cloro", "calcio",
    "magnesio", "colesterol_total", "colesterol_hdl", "trigliceridos", "proteinas_totales", "albumina", "pre_albumina",
    "vitamina_b12", "vitamina_d", "creatinina", "glicemia", "HCO", "EB", "Ph", "aislamientos"
];

// const codigoLab = [
//     "p90221001", "p90221002", "p90221003", "p90221005", "p90221015", "p90221016", "p90222001", "p902204","p906913", "p903867",
//     "p903866", "p90380901", "p903809-02", "p903838", "p903833", "p90204501",   "p90204502",   "p902049", "p903805", "p903864",
//     "p903835", "p903859", "p903813", "p903604", "p903854", "p903818", "p903815", "p903868", "p903863", "p903803", "p906912",
//     "p903703", "p903706", "p903895", "p903883", "p90383905", "p90383909", "p90383901"
// ];

const codigoLab = [
    ["p90221001"], ["p90221002"], ["p90221003"], ["p90221005"], ["p90221015", "gp902213"], ["p90221016", "gp902211"], ["p90222001"], ["p902204"], ["p906913"], ["p903867"],
    ["p903866"], ["p90380901"], ["p903809-02"], ["p903838"], ["p903833"], ["p90204501"], ["p90204502"], ["p902049"], ["p903805"], ["p903864"],
    ["p903835"], ["p903859"], ["p903813"], ["p903604"], ["p903854"], ["p903818"], ["p903815"], ["p903868"], ["p903863"], ["p903803"], ["p906912"],
    ["p903703"], ["p903706"], ["p903895"], ["p903883"], ["p90383905"], ["p90383909"], ["p90383901"]
];

function crearFilaTabla(examen, tabla, inicio = 0){
    let clase = inicio == 0 ? "elim" : "elim nuevo";
    let dato;
    let fecha = examen["FECHA"];
    for(let i = 0; i < nombresRegistroFilasTabla.length - 1; i++){
        dato = document.createElement("td");
        dato.classList.add(...clase.split(" "));
        dato.textContent = examen[nombresRegistroFilasTabla[i]];
        tabla.querySelector(`#${nombreFilaTabla[i]}`).appendChild(dato)
    }

    const aislamientos = document.createElement("td");
    aislamientos.classList.add(...clase.split(" "));
    const pre = document.createElement("pre");
    pre.style.width = "200px"; 
    pre.style.whiteSpace = "pre-wrap"; 
    pre.style.wordBreak = "break-word"; 
    pre.style.overflow = "hidden"; 
    const aislamientosRaw = examen["AISLAMIENTOS"] || "";

    const texto = aislamientosRaw.trim() === ""
        ? ""
        : "Fecha toma: " + fecha + "\n\n" +
            aislamientosRaw
                .split("\n")
                .map(aislamiento =>
                    aislamiento
                        .split(",")
                        .map(e => e.trim())
                        .join("\n")
                )
                .join("\n\n");
    pre.textContent = texto;
    aislamientos.append(pre);

    tabla.querySelector("#aislamientos").appendChild(aislamientos);
}



function limpiarCampos(){
    let filasElim = document.querySelectorAll(".elim");
    filasElim.forEach(elemento => {
        elemento.remove();
    });
}


function limpiarRegistrosExamanes(){
    let filasElim = document.querySelectorAll("#tabla_examenes tbody tr");
    filasElim.forEach(elemento => {
        elemento.remove();
    });
}

function filterExams() {
    const searchValue = document.getElementById("searchInput").value.toLowerCase();
    const examItems = document.getElementsByClassName("exam-item");

    for (let i = 0; i < examItems.length; i++) {
        const examLabel = examItems[i].getElementsByTagName("label")[0].innerText.toLowerCase(); // Change from "div" to "label"
        if (examLabel.includes(searchValue)) {
            examItems[i].style.display = ""; // Show the exam item
        } else {
            examItems[i].style.display = "none"; // Hide the exam item
        }
    }
}


async function llenarHistoricoParaclinico(episodio, documento){
    if(!episodio){
        return;
    }

    datos = {
        episodio: episodio,
        documento: documento,
        opcionHistorico: "full"
    };

    let registros = await new Promise((resolve) => {
        $.ajax({
            type: "POST",
            url: '../logica/llenarHistoricoParaclinico.php',
            data: datos,
            dataType: "json",
            success: function (response) {
                if (response.status !== 'success') {
                    console.error("Error del servidor:", response.message || "Respuesta no exitosa");
                    return;
                }

                if(response.examenes.length > 0){
                    reportePlantillas = response.examenes;
                    fechaUltimoRegistro = `${response.examenes[0]["FECHA"]} ${response.examenes[0]["HORA"]}`;

                    construirRegistrosExamanes(response);
                    
                }
                return resolve(response);
            }
        });
    });

    return registros;
}

function llenarHistoricoParaclinicoXfecha(episodio, documento, historico){
    if (!episodio) {
        return;
    }

    let fechaDesde = $("#fecha_desde").val();
    let fechaHasta = $("#fecha_hasta").val();
    datos = {
        episodio: episodio,
        documento: documento,
        opcionHistorico: historico,
        fechaDesde: fechaDesde,
        fechaHasta: fechaHasta
    };

    $.ajax({
        type: "POST",
        url: '../logica/llenarHistoricoParaclinico.php',
        data: datos,
        dataType: "json",
        success: function (response) {
            if (response.status !== 'success') {
                console.error("Error del servidor:", response.message || "Respuesta no exitosa");
                return;
            }

            reportePlantillas = response.examenes;

            construirRegistrosExamanes(response);
        }
    });
}

function verificarNuevosExamanes(documento_paciente, opc = 0){
    const tabla = document.querySelector("#registroTabla tbody");
    let url;
    let data;
    let ultimaFecha;

    if(opc === 0){
        url = "../logica/obtenerNuevoReporte.php";
        data = {
            documento: documento_paciente,
            fecha_hora: fechaUltimoRegistro
        };
    }else{
        url = "../logica/obtenerReporteParaclinico.php";
        data = {
            documento: documento_paciente
        };
    }


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function(response){
            response = JSON.parse(response);
            console.log(response)
            if(response.message.length <= 0){
                return;
            }
            ultimaFecha = response.message[response.message.length - 1][0];
            response.fechas.forEach(fecha => {
                let fecha_hora = fecha[0].split(" ");
                let registros_fecha = response.message.filter(([fecha_hora]) => fecha_hora == fecha);
                let examanes = {"FECHA": fecha_hora[0], "HORA": fecha_hora[1]};
                for (let i = 0; i < codigoLab.length; i++) {
                    let valor = registros_fecha.find(([a, b, c, d, codigo]) => codigoLab[i].includes(codigo));
                    let texto = valor?.[3] || "";
                    examanes[nombresRegistroFilasTabla[i + 2]] = (texto.length > 6) ? "N/A" : texto;
                }
                examanes["AISLAMIENTOS"] = encontrarCultivos(registros_fecha);
                nuevosExamenes.push(examanes);
                crearFilaTabla(examanes, tabla, 1);
            });
            guardarDatos(nuevosExamenes);
        }
    });
}



function encontrarCultivos(registros){
    let cultivos = registros.filter(([a, b, c, d, codigo]) => codigo == "p901221022"
                                                            || codigo == "p90122102"
                                                            || codigo == "p901223"
                                                            || codigo == "p90123601");
    let textoAislamientos = "";
    cultivos.forEach(cultivo => {
        const texto = cultivo[5];
        const pares = [...texto.matchAll(/'([^']+)'\s*:\s*'([^']*)'/g)];
        const vector = pares.map(([_, clave, valor]) => [clave, valor]);

        let nombre = cultivo[2];

        const botella = vector.filter(([clave]) => clave === "NUMERO DE BOTELLA").map(([_, botella])=> botella);
        if(botella[0]){
            nombre += `-${botella}`;
        }

        // Obtener valor de fecha
        //const fecha = vector.filter(([clave]) => clave === "Fecha Validación" || clave === "Fecha de Recepcion").map(([_, fecha])=> fecha);

        // Obtener valor de tipo de muestra
        const tipoMuestra = vector.filter(([clave]) => clave === "Tipo Muestra" || clave === "Tipo de Muestra").map(([_, muestra]) => muestra);

        // Obtener todos los valores de "Microorganismo"
        const microorganismos = vector
            .filter(([clave]) => clave === 'Microorganismo' || clave === "Informe preliminar" || clave === "Otro")
            .map(([_, valor]) => valor).join(";");

        // Obtener valor de Colorado de Gram
        const coloracion_gram = vector.filter(([nombre]) => nombre === "RESULTADO COLORACION DE GRAM").map(([_, valor]) => valor);

        const partes = [
            //fecha,
            nombre,
            tipoMuestra,
            microorganismos,
            coloracion_gram
        ];

        textoAislamientos += partes.filter(valor => valor).join(",");
        textoAislamientos += "\n";
    });
    return textoAislamientos;
}

function guardarDatos(examenes){
    console.log(examenes)
    let episodio = $("#episodio").val();
    let documento = $("#nroDocu").val(); 
    let nombre_paciente = $("#nombre").val();
    let edad = $("#edad").val();
    let genero = $("#sexo").val();
    let ubicacion = $("#ubicacion").val();
    let cama = $("#cama").val(); 
    let aseguradora = $("#entidad").val();
    let fecha = $("#fecha").val();
    let hora = $("#hora").val().split(" ")[0];
    let especialidad = $("#especialidad").val();
    let medico = $("#nombreMed").val();

    $.ajax({
        type: "POST",
        url: "../logica/guardarNuevosExamenes.php",
        data:{
            episodio: episodio,
            documento: documento,
            nombre_paciente: nombre_paciente,
            edad: edad,
            genero: genero,
            ubicacion: ubicacion,
            cama: cama,
            aseguradora: aseguradora,
            fecha: fecha,
            hora: hora,
            especialidad: especialidad,
            medico: medico,
            examenes: examenes
        },
        success: function(response){
            console.log(response)
            response = JSON.parse(response);

            if(response.success){
                Swal.fire({
                    icon: "success",
                    title: "Nuevos examenes encontrados",
                    toast: true,
                    timer: 3000,
                    position: "bottom-start",
                    confirmButtonText: "Entendido",
                    confirmButtonColor: "#008000"
                });
            }
            console.log(response)
        }
    });
}

function construirRegistrosExamanes(response){
    console.log(response)
    if(response.examenes.length <= 0){
        return;
    }
    const examanes = response.examenes.reverse();
    
    const tabla = document.querySelector("#registroTabla tbody");
    examanes.forEach(examen => {
        
        crearFilaTabla(examen, tabla);
    });
}



$(document).ready(function() {

    
    let input_documento = document.getElementById("nroDocu");

    input_documento.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            episodio = document.getElementById("episodio").value || "N/A";  
            documento = document.getElementById("nroDocu").value || "N/A";
            llenarHistoricoParaclinico(episodio, documento); 
        }
    }); 

    $('#exampleModal').on('show.bs.modal', function () {
        crearPlantilla();
    });

    $('#exampleModal').on('hidden.bs.modal', function () {
        document.querySelector("#plantilla").value = "";
    });

    function convertirRegistros(reportes){
        const resultado = nombresTit.map(clave => reportes.map(obj => obj[clave]));
        console.log(resultado)
        return resultado;
    }

    function crearTextoExamenes(examenes){
        let texto = "";
        let cont = 0;

        texto +=  nombresTit[0].padEnd(21);
        console.log(examenes)
        examenes[0].forEach(elemento => {
            let fecha = elemento.split("-");
            let nueva_fecha = `${fecha[2]}/${fecha[1]}`;
            texto += nueva_fecha.padEnd(7);
        });

        texto += "\n";
        texto += nombresTit[1].padEnd(21);

        examenes[1].forEach(elemento => {
            let hora = elemento.split(":");
            let nueva_hora = `${hora[0]}:${hora[1]}`;
            console.log(nueva_hora)
            texto += nueva_hora.padEnd(7);
        });

        texto += "\n";
        texto += "-------------------------------------------\n";

        for(let i = 2; i < examenes.length; i++){
            cont = 0;
            let total = examenes[i].length;
            examenes[i].forEach(elemento => {
                if(elemento == ""){
                    cont++;
                }
            });
            if(cont == total){
                continue;
            }

            texto += nombresTit[i].padEnd(21);
            examenes[i].forEach(elemento => {
                texto += elemento != "" ? elemento.padEnd(7) : "-".padEnd(7);
            });
            texto += "\n";
        }

        return texto;
    }


    function crearPlantilla(){
        //reportePlantillas.reverse();
        let plantilla = "";
        console.log(reportePlantillas)
        let nuevo_array = convertirRegistros(reportePlantillas)

        plantilla += "Laboratorios:\nPARACLÍNICOS INSTITUCIONALES\n\n";


        plantilla += crearTextoExamenes(nuevo_array);

        //----------------------------- Aislamientos

        let prueba = [];
        let textoAislamientos = "";
        reportePlantillas.forEach(elemento =>{
            let datos = elemento['AISLAMIENTOS'].split("\n");
            prueba.push(datos);
            console.log(datos)
        });
        prueba.forEach(elemento => {
            elemento.forEach(Element => {
                let dato = Element.split(",");
                if(Element !== ""){
                    textoAislamientos += `${dato[0].split("T")[0]}:   Muestra:${dato[1]} | Origen:${dato[2]} | Germen:${dato[3]}`;
                    
                    if(dato[4]){
                        textoAislamientos += ` | Resultado Gram:${dato[4]}`;
                    }
                    textoAislamientos += "\n";
                }
            });
        });
        if(textoAislamientos !== ""){
            plantilla += "\n--------------------------------------------------------------------------------------------\n";
            plantilla += "Aislamientos:\n\n"
            plantilla += textoAislamientos + "\n";
        }
        document.querySelector("#plantilla").value = plantilla;
    }

    async function consultarReportes(episodio, documento, opcion){
        let registros;
        if(opcion == 1){
            registros = await llenarHistoricoParaclinico(episodio, documento); 
        }
        console.log(registros)
        if(reportePlantillas.length == 0){
            verificarNuevosExamanes(documento, 1);
            return;
        }else{
            verificarNuevosExamanes(documento);
        }
    }


    $("#boton_copiar").on("click", function(){
        let texto = $("#plantilla");
        texto.select();
        document.execCommand('copy');

        Swal.fire({
            toast: true,
            text: "¡Texto copiado en el portapapeles!",
            icon: "success",
            timer: 3000
        });
    });


    $("#fecha_desde, #fecha_hasta").on("change", function(){
        let episodio = $("#episodio").val();
        let documento = $("#nroDocu").val();
        let fechaDesdeValor = $("#fecha_desde").val();
        let fechaHastaValor = $("#fecha_hasta").val();

        if(fechaDesdeValor === "" || fechaHastaValor === ""){
            return;
        }

        let fechaDesde = new Date(fechaDesdeValor);
        let fechaHasta = new Date(fechaHastaValor);

        if(fechaHasta < fechaDesde){
            Swal.fire({
                icon: "info",
                toast: true,
                text: "La fecha inicio debe ser menor de la fecha final",
                timer: 2000,
                timerProgressBar: true
            });
            return;
        }
        let datosTabla = document.querySelectorAll(".elim");
        datosTabla.forEach(elemento => {
            elemento.remove();
        });
        llenarHistoricoParaclinicoXfecha(episodio, documento, "PorFecha");
        document.getElementById("button_plantilla").removeAttribute("hidden");
    });

    function verificarUltimaActualizacion(documento){
        $.ajax({
            type: "POST",
            url: "../logica/obtenerUltimaActualizacion.php",
            data: {documento: documento},
            success: function(response){
                response = JSON.parse(response);

                if(!response.success){
                    return;
                }

                $("#fecha_actualizacion").val(response.message["ultimaFecha"]);
            }
        });
    }


    let intervalo = setInterval(() => {
        let episodio = $("#episodio").val();
        let documento = $("#nroDocu").val();

        if(episodio && documento){
            $(".bloquear").prop("disabled", true);
            verificarUltimaActualizacion(documento);
            consultarReportes(episodio, documento, 1);
            clearInterval(intervalo);
        }
    }, 100);

});