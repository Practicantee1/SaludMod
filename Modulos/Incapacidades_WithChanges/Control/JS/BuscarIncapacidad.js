var dataTableInstance;

$(document).ready(function() {
  
    createIncapacidadConsolidadoDataTable();

});

document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    var Input = document.getElementById('DocumentoIncapacidad');

    // Add event listener for keydown event
    Input.addEventListener('keydown', function(event) {
        // Check if the pressed key is Enter (key code 13)
        if (event.keyCode === 13) {
            listarIncapacidades();
        }
    });
});

$(document).ready(function() {
    $('#BuscarIncapacidad').click(function(e) {
        listarIncapacidades();
    });
});

function listarIncapacidades(){
    var DocumentoIncapacidad = document.getElementById("DocumentoIncapacidad").value;
    $.ajax({
        type: "POST",
        url: '../Logica/ConsultarIncapacidades.php',
        data: {"DocumentoIncapacidad" : DocumentoIncapacidad},
        success: function(response){
            var quickScript = new Function($(response).text());
            quickScript();

            if ($.fn.DataTable.isDataTable('#TablaIncapacidades')) {
                
                dataTableInstance.clear(); // Destroy the existing DataTable instance
                $('#table_body tr').each(function() {
                    dataTableInstance.row.add($(this)).draw();
                });
            }

        },
        error: function(response) {
            var txt = "ERROR";
            console.log(txt);
            console.log(response);
        } 
    });
}

function createIncapacidadConsolidadoDataTable(){
    dataTableInstance = $('#TablaIncapacidades').DataTable( {
      autoWidth: true, 
      
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
          "copy": "Copiar",
          "colvis": "Visibilidad"
        }
      },
  
      
      dom: 'rtip',
      buttons: [
        {
          extend: 'excel',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          exportOptions: {
            text: 'Fecha: ' + new Date().toLocaleDateString(),
            columns: ':visible',
            
          },
          customize: function (doc) {
            // Cambiar la orientación a horizontal
            
            doc.pageOrientation = 'landscape'; 
            var currentDateTime = new Date().toLocaleString();
              
            
            var content = '' + currentDateTime + '\n\n\n\n';
  
  
            doc.content.splice(0, 0, {
              text: content,
              style: 'header'
            });
          }
        },
      ], 
  
    });
  
  }