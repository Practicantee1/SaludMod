let datos = [];

$(document).ready(function(){

  const aliasMap = {
    "p90221001": "leucocitos",
    "p90221002": "neutrofilos",
    "p90221003": "linfocitos",
    "p90221005": "eosinofilos",
    "p90221015": "hemoglobina",
    "p90221016": "hematocrito",
    "p90222001": "plaquetas",
    "p90222003": "plaquetas",
    "p902204": "vsg",
    "p903867": "tgo",
    "p903866": "tgp",
    "p90380901": "bilirrubina_total",
    "p903809-02": "bilirrubina_directa",
    "p903838": "ggt",
    "p903833": "fosfatasa_alcalina",
    "p90204501": "tp_inr",
    "p90204503": "tp_inr",
    "p90204502": "tp_inr",
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
    // "p90681201": "electroforesis_proteinas",
    // "p90681202": "electroforesis_proteinas",
    // "p90681203": "electroforesis_proteinas",
    "p903703": "vitamina_b12",
    "p903706": "vitamina_d",
    "p903895": "creatinina",
    "p903883": "glicemia",
    "p90383905": "HCO",
    "p90383908": "EB",
    "p90383901": "Ph",
    // "p901221022": "hemocultivo_ped",
    // "p90122102": "hemocultivo_aer",
    // "p901223": "hemocultivo_anaer",
    // "p90123601": "urocultivo",
    // "p906913" : "pcr"
    // "p901221022": "cultivos_",
    // "p90122102": "cultivos_",
    // "p901223": "cultivos_",
    // "p90123601": "cultivos_",
    "p906913" : "pcr"
  };


  // let input_documento = document.getElementById("nroDocu");

  // input_documento.addEventListener('keydown', function(event) {
  //   if (event.key === 'Enter') {
  //     let documento = $("#nroDocu").val();
  //     limpiarCampos();
  //     obtenerResultados(documento);
  //   }
  // })

  let intervalo = setInterval(() => {
    let documento = $("#nroDocu").val();

      if(documento){
        limpiarCampos();
        obtenerResultados(documento);
        clearInterval(intervalo);
    }
  }, 100);

  function obtenerResultados(documento_paciente){
      $.ajax({
          type: "POST",
          url: "../logica/obtenerReporteParaclinico.php",
          data: {documento_paciente : documento_paciente},
          success: function(response){
              response = JSON.parse(response);
              console.log(response)
              if(!response.success){
                  return;
              }

              if(response.message.length <= 0){
                  return;
              }
              datos = response.message;
              asignarValores(response.message);
          }
      });
  }


  function limpiarCampos(){
    // Limpiar todos los inputs antes de asignar nuevos valores
    for (let alias of Object.values(aliasMap)) {
      $(`#${alias} input`).val(""); 
      $(`#${alias} input`).css("backgroundColor", "white");
    }
  }


  function asignarValores(datos) {
    console.log(datos)
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

  $("#tipoEstudio").change(function(e){
    let valor = e.target.value;
    $("#germen").val("");
    $("#fechaAislamientos").val("");
    if(valor == "urocultivo"){
      const resultado = datos.find(arr => arr[4] === 'p90123601');
      if(resultado != []) {
        $("#germen").val(resultado[3]);
        $("#fechaAislamientos").val(resultado[0]);
        $("#codigolab").val(resultado[4]);
      }
      return;
    }

    if(valor == "hemocultivoPediatri"){
      const resultado = datos.find(arr => arr[4] === 'p901221022');
      if(resultado != []) {
        $("#germen").val(resultado[3]);
        $("#fechaAislamientos").val(resultado[0]);
        $("#codigolab").val(resultado[4]);
      }
      return;
    }

    if(valor == "hemocultivoAero"){
      const resultado = datos.find(arr => arr[4] === 'p90122102');
      if(resultado != []) {
        $("#germen").val(resultado[3]);
        $("#fechaAislamientos").val(resultado[0]);
        $("#codigolab").val(resultado[4]);
      }
      return;
    }

    if(valor == "hemocultivo"){
      const resultado = datos.find(arr => arr[4] === 'p901223');
      if(resultado != []) {
        $("#germen").val(resultado[3]);
        $("#fechaAislamientos").val(resultado[0]);
        $("#codigolab").val(resultado[4]);
      }
      return;
    }
    
  });

  function mostrarMensajeCultivos(){
    let informacion = "";
    let cultivos;
    if(datos != []){
      
      cultivos = datos.filter(arr => arr[4] === "p90123601" || 
                                    arr[4] === "p901221022" ||
                                    arr[4] === "p90122102" ||
                                    arr[4] === "p901223");
      cultivos.forEach(element => {
        console.log(element)
        informacion += element[2] + "<br>";
      });
    }
    console.log(informacion == "")
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


});



