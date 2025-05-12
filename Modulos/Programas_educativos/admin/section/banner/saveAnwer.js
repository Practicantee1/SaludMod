const answers = {};

function saveAnswer(link) {
    const value = link.getAttribute('data-value');
    let td = link.parentElement;
    let tr = td.closest('tr');
    let tds = tr.querySelectorAll('td.item');
    let questionId = tr.getAttribute('data-question');
    // Verificar si todos los campos estÃ¡n llenos

    answers[questionId] = value;
    // Si el td clickeado ya tiene la clase "boton-con-imagen", quitarla
    if (td.classList.contains('boton-con-imagen')) {
        td.classList.remove('boton-con-imagen');
        saveValue(null); // Limpiar el valor guardado
    } else {
        // Remover la clase de todos los tds
        tds.forEach(td => {
            td.classList.remove('boton-con-imagen');
        });

        // Agregar la clase solo al td clickeado
        td.classList.add('boton-con-imagen');
    }

    
}



function saveAllData() {
    let episodio = document.getElementById('episodio').value;
    let nombre = document.getElementById('nombre').value;
    let fechaReg = document.getElementById('registro').value;
    let documento = document.getElementById('documento').value;
    let sugerencias = document.getElementById('surgerencias').value;
    console.log(episodio +" "+ nombre +" "+ fechaReg +" "+documento +" "+ sugerencias);
    // Verificar el tamaÃ±o del objeto answers
    const keys = Object.keys(answers);
    if (keys.length < 5) {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Por favor, seleccione una respuesta por cada pregunta.",
          });
    return; // Detener la funciÃ³n si ninguna respuesta estÃ¡ seleccionada
    }
    // console.log(answers);
    // Verificar si todos los campos estÃ¡n llenos
    if (episodio === '' || nombre === '' || documento === '') {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "Por favor, complete todos los campos vacios antes de guardar.",
          });
        return; // Detener la funciÃ³n si algÃºn campo estÃ¡ vacÃ­o
    }

    if (fechaReg === "") {  // Si el campo de fecha estÃ¡ vacÃ­o
        let fechaActual = new Date();  // ObtÃ©n la fecha actual
        //alert(fechaActual);
        let fechaFormateada = formatearFecha(fechaActual);  // Formatea la fecha actual
        document.getElementById('registro').value = fechaFormateada;  // Establece la fecha actual como valor por defecto
        fechaReg = fechaFormateada;  // Actualiza la variable fechaReg con la fecha actual
    }
    
    sugerencias = sugerencias || "No aplica";
    pregunta1 = answers[1];
    pregunta2 = answers[2];
    pregunta3 = answers[3];
    pregunta4 = answers[4];
    pregunta5 = answers[5];

    
  
$.ajax({
    url: 'http://vmsrv-web2.hospital.com/SaludMod/Modulos/Programas_educativos/admin/section/banner/savebd.php',
    type: 'POST',
    data: { Episodio: episodio,
            Documento: documento,
            Nombre: nombre,
            Fecha: fechaReg,
            Sugerencias: sugerencias,
            pregunta1: pregunta1,
            pregunta2: pregunta2,
            pregunta3: pregunta3,
            pregunta4: pregunta4,
            pregunta5: pregunta5,
            usuario: usuario
     },
    dataType: 'json',
    success: function(data) {
        //console.log(data);
        clearCamp(); // Mover aquí la llamada a clearCamp
        $("#documento").removeAttr("readonly");
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Respuesta guardada con éxito!',
            showConfirmButton: false,
            timer: 1500
        });
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX error:', textStatus);
        console.error('Error thrown:', errorThrown);
        console.log('Full jqXHR object:', jqXHR);
        console.log('Response text:', jqXHR.responseText);
    }
});

}

function formatearFecha(fecha) {
    let anio = fecha.getFullYear();
    let mes = (fecha.getMonth() + 1).toString().padStart(2, '0');  // Los meses en JavaScript empiezan desde 0
    let dia = fecha.getDate().toString().padStart(2, '0');
    return `${anio}-${mes}-${dia}`;
}

function clearCamp(){
    // Limpiar los campos despuÃ©s de guardar los datos
    document.getElementById('episodio').value = '';
    document.getElementById('nombre').value = '';
    document.getElementById('registro').value = '';
    document.getElementById('documento').value = '';
    document.getElementById('surgerencias').value = '';

    // Limpiar las respuestas seleccionadas
    const selectedItems = document.querySelectorAll('.boton-con-imagen');
    selectedItems.forEach(item => {
        item.classList.remove('boton-con-imagen');
    });

    // Limpiar el objeto answers
    for (let key in answers) {
        if (answers.hasOwnProperty(key)) {
            delete answers[key];
        }
    }
}

    

