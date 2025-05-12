$(document).ready(function () {
  // Agregar línea a la tabla
  $("#agregarLinea").submit(function (e) {
      e.preventDefault();
      var table = document.getElementById("table");
      table.hidden = false;

      var index = document.querySelectorAll("#table_body tr").length; // Usar índice basado en filas
      var episodioInput = document.getElementById("episodio").value;
      var numdocumento = document.getElementById("idNumeroDocumento").value;
      var nombrePaciente = document.getElementById("idNombrePaciente").value;      
      var aseguradora = document.getElementById("idAsegurador").value;
      var cirujano = document.getElementById("idNombreCirujano").value;
      var especialidad = document.getElementById("idEspecialidad").value;
      var date = document.getElementById("Fecha").value;
      var observaciones = document.getElementById("idObservaciones").value || "N/A";
      var nombreDiagnostico = document.getElementById("Diagnostico").value;
      var casaComercialId = document.getElementById("infCasaComercial").value;
      var nombreCasaComercial = document.getElementById("infCasaComercial").options[document.getElementById("infCasaComercial").selectedIndex].text;
      var tipoImplanteId = document.getElementById("tipoImplante").value;
      var entSoporte = document.getElementById("infEntrenamientoSoporte").value;
      var tiempoSoporte = document.getElementById("infLlegaTiempoSoporte").value;
      var material = document.getElementById("infMaterialCompleto").value;
      var falla = document.getElementById("infFallaImpl").value;
      var infImplLlegaTiempo = document.getElementById("infImplLlegaTiempo").value;
      var infImplLlegaCompleto = document.getElementById("infImplLlegaCompleto").value;

      var html = "<tr>";
      html += `<td>${episodioInput}</td><td>${numdocumento}</td><td>${nombrePaciente}</td>`;
      html += `<td>${aseguradora}</td><td>${cirujano}</td><td>${especialidad}</td><td>${date}</td>`;
      html += `<td>${observaciones}</td><td>${nombreDiagnostico}</td>`;
      html += `<td>${casaComercialId}</td><td>${nombreCasaComercial}</td>`;
      html += `<td>${tipoImplanteId}</td>`;
      html += `<td>${entSoporte}</td><td>${tiempoSoporte}</td><td>${material}</td>`;
      html += `<td>${falla}</td><td>${infImplLlegaTiempo}</td><td>${infImplLlegaCompleto}</td>`;
      html += `<td><button type='button' id='${index}' class='btn' style='background-color: #CF142B; color:white;' onclick='deleteRow(this);'>X</button></td>`;
      html += "</tr>";

      document.getElementById("table_body").insertRow().innerHTML = html;
      cleanForm();
  });

$('#tablaimplantes').submit(function (e) {
    e.preventDefault();
    var myTableArray = [];
    var centrosanitario = document.getElementById("centrosanitario").value;
    console.log(centrosanitario);
    $("#table_body tr").each(function () {
        var arrayOfThisRow = [];
        $(this).find('td').each(function () {
            arrayOfThisRow.push($(this).text());
        });
        arrayOfThisRow.push(centrosanitario)
        myTableArray.push(arrayOfThisRow);
    });

    $.ajax({
        type: 'POST',
        url: '../../Implantes/Logica/implantesSQL.php',
        data: { "table": myTableArray },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: response.success,
                    showConfirmButton: true
                });
                setTimeout(function(){location.reload();}, 2000);
            } else if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error,
                    showConfirmButton: true
                });
            }
        },
        error: function (xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error al enviar',
                text: 'No se pudo completar la solicitud, completar todos los campos',
                showConfirmButton: true
            });
            console.error(xhr.responseText);
        }
    });
    
});

});

function deleteRow(button) {
  button.parentElement.parentElement.remove();
  if ($("#table_body tr").length === 0) {
      document.getElementById("table").hidden = true;
  }
}

function cleanForm() {
    var checkbox = document.getElementById('checkboxAmbulatoria');
if (checkbox.checked) {
    document.getElementById("Diagnostico").value = "";
    checkbox.checked = false; // Desmarcar si está marcado

    // Emitir un evento personalizado
    const event = new Event('checkboxChanged');
    checkbox.dispatchEvent(event);
}
    // Limpiar el campo de diagnóstico (select)
    const diagnosticoSelect = document.getElementById("Diagnostico");
    if (diagnosticoSelect) {
        diagnosticoSelect.selectedIndex = 0; // Asegúrate de que el primer elemento sea el placeholder
    }

    // Limpiar el resto de los campos
    document.getElementById("tipoImplante").value = "";
    document.getElementById("infCasaComercial").selectedIndex = 0; // Limpiar el select de Casa Comercial
    document.getElementById("infEntrenamientoSoporte").selectedIndex = 0; // Limpiar el select de Entrenamiento Soporte
    document.getElementById("infLlegaTiempoSoporte").selectedIndex = 0; // Limpiar el select de Llega a Tiempo Soporte
    document.getElementById("infMaterialCompleto").selectedIndex = 0; // Limpiar el select de Material Completo
    document.getElementById("infFallaImpl").selectedIndex = 0; // Limpiar el select de Falla del implante
    document.getElementById("infImplLlegaTiempo").selectedIndex = 0; // Limpiar el select de Implante Llega a Tiempo
    document.getElementById("infImplLlegaCompleto").selectedIndex = 0; // Limpiar el select de Implante Llega Completo
}

