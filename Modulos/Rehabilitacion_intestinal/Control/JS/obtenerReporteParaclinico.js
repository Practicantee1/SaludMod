let datos = [];
let resultados_cultivos = [];
let cultivos_formato_JSON = [];

$(document).ready(function(){

  const aliasMap = {
    "p90221001": "leucocitos",
    "p90221002": "neutrofilos",
    "p90221003": "linfocitos",
    "p90221005": "eosinofilos",
    "p90221015": "hemoglobina",
    "p90221016": "hematocrito",
    "p90222001": "plaquetas",
    "p902204": "vsg",
    "p903867": "tgo",
    "p903866": "tgp",
    "p90380901": "bilirrubina_total",
    "p903809-02": "bilirrubina_directa",
    "p903838": "ggt",
    "p903833": "fosfatasa_alcalina",
    "p90204501": "tp",  //TP
    "p90204502": "inr",  //INR
    "p902049": "tpt",
    "p903805": "amilasa",
    "p903864": "sodio",
    "p903835": "fosforo",
    "p903859": "potasio",
    "p903813": "cloro",
    "p903604": "calcio",
    "p903854": "magnesio",
    "p903818": "colesterol_total",
    "p903815": "colesterol_hdl",
    "p903816": "colesterol_ldl",
    "p903868": "trigliceridos",
    "p903863": "proteinas_totales",
    "p903803": "albumina",
    "p906912": "pre_albumina",
    "p903703": "vitamina_b12",
    "p903706": "vitamina_d",
    "p903895": "creatinina",
    "p903883": "glicemia",
    "p90383905": "HCO",
    "p90383908": "EB",
    "p90383901": "Ph",
    "p906913" : "pcr"
  };



  let intervalo = setInterval(() => {
    let documento = $("#nroDocu").val();

      if(documento){
        limpiarCampos();
        obtenerResultados(documento);
        clearInterval(intervalo);
    }
  }, 100);

  function obtenerBotellasCultivos(cultivosJSON){
    const json_valido = cultivosJSON.map(([a, b, nombre_cultivo, d, codigo_Lab, info_cultivo]) => [nombre_cultivo, info_cultivo.replace(/'/g, '"'), codigo_Lab]);
    const json_cultivos = json_valido.map(([nombre, json, codigo]) => [nombre, JSON.parse(json), codigo]);
    cultivos_formato_JSON = json_cultivos;
  }

  function obtenerResultados(documento_paciente){
      $.ajax({
          type: "POST",
          url: "../logica/obtenerReporteParaclinico.php",
          data: {documento_paciente : documento_paciente},
          success: function(response){
              response = JSON.parse(response);
              if(!response.success){
                  return;
              }

              if(response.message.length <= 0){
                  return;
              }
              datos = response.message;
              console.log(datos)
              resultados_cultivos = datos.filter(arr => arr[4] === "p90123601" || 
                                      arr[4] === "p901221022" ||
                                      arr[4] === "p90122102" ||
                                      arr[4] === "p901223");
              console.log(resultados_cultivos);
              obtenerBotellasCultivos(resultados_cultivos)
              asignarValores(response.message);
          }
      });
  }

  function crearOpcionesCultivos(nombre_cultivo, codigo_lab,botella = ""){
    const codigos = {
      "p901221022" : "hemocultivoPediatri",
      "p90122102" : "hemocultivoAero",
      "p901223" : "hemocultivo",
      "p90123601" : "urocultivo"
    };

    const select = document.querySelector("#tipoEstudio");

    const option = document.createElement("option");
    option.value = codigos[codigo_lab];
    option.textContent = nombre_cultivo;

    if(botella["NUMERO DE BOTELLA"]){
      option.textContent = `${nombre_cultivo} - ${botella["NUMERO DE BOTELLA"]}`;
      option.dataset.botella = botella["NUMERO DE BOTELLA"];
    }

    select.appendChild(option);
  }


  function limpiarCampos(){
    // Limpiar todos los inputs antes de asignar nuevos valores
    for (let alias of Object.values(aliasMap)) {
      $(`#${alias} input`).val(""); 
      $(`#${alias} input`).css("backgroundColor", "white");
    }
  }


  function asignarValores(datos) {
    datos.forEach(item => {
      let prueba = item[4];
      let resultado = item[3];
      let alias = aliasMap[prueba];

      if (alias) {
        $(`#${alias} input`).val(resultado || ""); 
        $(`#${alias} input`).css("backgroundColor", "rgb(223, 242, 191)"); 
        $(`#${alias} input`).css("color", "rgb(0, 128, 0)"); 
      } 
    });
    mostrarMensajeCultivos();
  }

  function limpiarCamposIniciales(){
    $("#germen").val("");
    $("#fechaAislamientos").val("");
    $("#origen").val("");
    $("#nom_germen").text("GERMEN");
    $("#campo_coloracion").prop("hidden", true);
    $("#coloracion").val("");
  }



  $("#tipoEstudio").change(function(e){
    let valor = e.target.value;
    limpiarCamposIniciales();

    const cultivos = {
      'urocultivo' : 'p90123601',
      'hemocultivoPediatri' : 'p901221022',
      'hemocultivoAero' : 'p90122102',
      'hemocultivo' : 'p901223'
    };

    let cultivo_buscar = cultivos[valor];
    let resultado;
    
    let dataset = e.target.options[e.target.selectedIndex].dataset.botella;
    if(dataset){
      resultado = resultados_cultivos.find(arr => arr[4] === cultivo_buscar && 
                                  JSON.parse(arr[5].replace(/'/g, '"'))["NUMERO DE BOTELLA"] === dataset);
    }else{
      resultado = resultados_cultivos.find(arr => arr[4] === cultivo_buscar);
    }

    if(resultado == []){
      return;
    }
    const texto = resultado[5];
    const pares = [...texto.matchAll(/'([^']+)'\s*:\s*'([^']*)'/g)];
    const vector = pares.map(([_, clave, valor]) => [clave, valor]);
    
    // Obtener valor de fecha
    const fecha = vector.filter(([clave]) => clave === "Fecha Validación" || clave === "Fecha de Recepcion").map(([_, fecha])=> fecha);

    // Obtener valor de tipo de muestra
    const tipoMuestra = vector.filter(([clave]) => clave === "Tipo Muestra" || clave === "Tipo de Muestra").map(([_, muestra]) => muestra);

    // Obtener todos los valores de "Microorganismo"
    const microorganismos = vector
      .filter(([clave]) => clave === 'Microorganismo')
      .map(([_, valor]) => valor);

    // const microorganismos = (() => {
    //   const micro = vector
    //     .filter(([clave, valor]) => clave === 'Microorganismo' && valor.trim() !== "")
    //     .map(([_, valor]) => valor);

    //   if (micro.length > 0) {
    //     return micro;
    //   }

    //   return vector
    //     .filter(([clave, valor]) => clave.trim() === 'Otro' && valor.trim() !== "")
    //     .map(([_, valor]) => valor);
    // })();

    $("#origen").val(tipoMuestra[0]);
    if(microorganismos.length === 0){
      cambiarAInformePreliminar(vector);
      $("#fechaAislamientos").val(cambiarFormatoFecha(fecha[0], false));
    }else{
      $("#germen").val(obtenerTextoGermen(microorganismos));
      $("#fechaAislamientos").val(cambiarFormatoFecha(fecha[0]));

      const coloracion_gram = vector.filter(([nombre]) => nombre === "RESULTADO COLORACION DE GRAM").map(([_, valor]) => valor);
      $("#campo_coloracion").prop("hidden", false);
      $("#coloracion").val(coloracion_gram[0]);
    }
    
  });



  function cambiarAInformePreliminar(vector){
    const informe_preliminar = vector.filter(([nombre]) => nombre === "Informe preliminar").map(([_, valor]) => valor);
    if(informe_preliminar.length === 0){
      return;
    }

    $("#nom_germen").text("INFORME PRELIMINAR");
    $("#germen").val(informe_preliminar[0]);
  }



  function mostrarMensajeCultivos(){
    let informacion = "";
    let botella;
    console.log(cultivos_formato_JSON)
    if(cultivos_formato_JSON != []){
      
      cultivos_formato_JSON.forEach(element => {
        //console.log(element)
        botella = element[1]["NUMERO DE BOTELLA"];
        if(botella){
          informacion += `${element[0]} - ${botella} <br>`;
        }else{
          informacion += `${element[0]} <br>`;
        }
        crearOpcionesCultivos(element[0], element[2], element[1]);
      });
    }
    if(informacion == ""){
        $("#mensaje_cultivos p").html("<strong>El paciente actual no tiene cultivos</strong>");
        $("#mensaje_cultivos").css("background-color", "#fbadad");
        $("#mensaje_cultivos").css("color", "red");
        $("#mensaje_cultivos").prop("hidden", false);

        return;
    }

    $("#mensaje_cultivos p").html(
      `
      <strong>El paciente actualmente cuenta con lo siguientes cultivos:</strong><br><br>
      
      ${informacion}<br>

      `);
    $("#mensaje_cultivos").css("background-color", "#bbffb9");
    $("#mensaje_cultivos").css("color", "green");
    $("#mensaje_cultivos").prop("hidden", false);
  }




  $("#agregar_aisla").click(function(e){
    
    if(document.querySelector("#tipoEstudio").value == "" || document.querySelector("#germen").value == ""){
      return;      
    }

    if(VerificarFila($("#tipoEstudio").val())){
      return;
    }

    let tabla = document.querySelector("#tabla_cultivos tbody");

    let fila = document.createElement("tr");

    let fecha = document.createElement("td");
    fecha.textContent = document.querySelector("#fechaAislamientos").value;

    let select = document.querySelector("#tipoEstudio");
    let textoSeleccionado = select.options[select.selectedIndex].text;

    let prueba = document.createElement("td");
    prueba.textContent = textoSeleccionado;

    let resultado = document.createElement("td");
    resultado.textContent = document.querySelector("#germen").value;

    let gram = document.createElement("td");
    gram.textContent = document.querySelector("#coloracion").value;

    let eliminar = document.createElement("td");
    eliminar.innerHTML = '<button class="btn btn-danger eliminar_cultivos"><i class="bi bi-trash3"></i> Eliminar</button>';

    let origen = document.createElement("td");
    origen.textContent = document.querySelector("#origen").value;

    let codigoLab = document.createElement("td");
    codigoLab.setAttribute("hidden", true);
    codigoLab.textContent = document.querySelector("#codigolab").value;

    let valor = document.createElement("td");
    valor.setAttribute("hidden", true);
    valor.textContent = document.querySelector("#tipoEstudio").value;

    fila.appendChild(fecha);
    fila.appendChild(prueba);
    fila.appendChild(resultado);
    fila.appendChild(origen);
    fila.appendChild(gram);
    fila.appendChild(eliminar);
    fila.appendChild(codigoLab);
    fila.appendChild(valor);

    tabla.appendChild(fila);
  });



  function VerificarFila(texto){
    let existe = false;
    let filas = document.querySelectorAll("#tabla_cultivos tbody tr");
    filas.forEach(fila => {
      let celda = fila.cells[6]; 
      if (celda && celda.textContent.trim() === texto) {
        existe = true;
      }
    });
    return existe;
  }



  $(document).on("click", ".eliminar_cultivos, .eliminar_examenes", function(e){
    e.target.parentElement.closest("tr").remove();
  });



  $("#agregar_examen").click(function(e){
    
    if(document.querySelector("#nombreExamen").value == "" || document.querySelector("#valorExamen").value == ""){
      return;      
    }

    let tabla = document.querySelector("#tabla_examenes tbody");

    let fila = document.createElement("tr");

    let Nombre = document.createElement("td");
    Nombre.textContent = document.querySelector("#nombreExamen").value;

    let Valor = document.createElement("td");
    Valor.textContent = document.querySelector("#valorExamen").value;

    let eliminar = document.createElement("td");
    eliminar.innerHTML = '<button class="btn btn-danger eliminar_examenes"><i class="bi bi-trash3"></i> Eliminar</button>';


    fila.appendChild(Nombre);
    fila.appendChild(Valor);
    fila.appendChild(eliminar);

    tabla.appendChild(fila);

    document.querySelector("#nombreExamen").value = "";
    document.querySelector("#valorExamen").value = "";
  });  



  document.getElementById('exampleModal').addEventListener('show.bs.modal', () => {
      document.body.style.position = 'fixed';
  });



  document.getElementById('exampleModal').addEventListener('hidden.bs.modal', () => {
      document.body.style.position = '';
  });


  
  function cambiarFormatoFecha(fechaNF, datetime = true){
    if(!datetime){
      let nueva_fecha = fechaNF.split("/");
      return `${nueva_fecha[2]}-${nueva_fecha[1]}-${nueva_fecha[0]}`;
    }
    let fecha_datetime = fechaNF.split(" ");
    let fecha = fecha_datetime[0].split("/");
    return `${fecha[2]}-${fecha[1]}-${fecha[0]} ${fecha_datetime[1]}`;
  }



  function obtenerTextoGermen(texto){
    return texto.join(";");
  }

});
