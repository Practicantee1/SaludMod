
  
  const video = document.getElementById("video");
  const canvas = document.getElementById("canvas");
  const boton = document.getElementById("boton");
  
  // Solicitar acceso a la c�mara con configuraci�n adicional
  navigator.mediaDevices.getUserMedia({ 
    video: { 
      width: { ideal: 1280 },
      height: { ideal: 720 }
    } 
  })
  .then(stream => {
    video.srcObject = stream;
    video.play();
  })
  .catch(error => {
    console.error("Error al acceder a la camara:", error);
    alert("No se pudo acceder a la camara.");
  });
  
  function base64ToBlob(base64, mimeType = "image/png") {
    const binaryString = atob(base64.split(",")[1]);
    const len = binaryString.length;
    const binaryArray = new Uint8Array(len);
  
    for (let i = 0; i < len; i++) {
      binaryArray[i] = binaryString.charCodeAt(i);
    }
  
    return new Blob([binaryArray], { type: mimeType });
  }
  
  let blob = null;
  
  boton.addEventListener("click", (e) => {
    e.preventDefault();
    
    const contexto = canvas.getContext("2d");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
  
    contexto.drawImage(video, 0, 0, canvas.width, canvas.height);
  
    const dataUrl = canvas.toDataURL("image/png");
    blob = base64ToBlob(dataUrl, "image/png");
    
    Swal.fire({
      icon: "success",
      title: "Foto tomada correctamente",
    });
  });
  
function guardarDatos() {
  const formData = new FormData();
  const form = $("#evento-acom")[0];
  
  $(form).find("input, select, textarea").each(function() {
    formData.append(this.name, this.value);
  });
  
  formData.append("archivo", blob, "nombreArchivo.png");
  
  $.ajax({
    type: "POST",
    url: "../Control/RegistroAcompanante.php",
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
      console.log(response);
      Swal.fire({
        position: "center",
        icon: "success",
        title: "Acompañante ingresado correctamente",
        showConfirmButton: false,
        timer: 2000
      });
      
      setTimeout(() => {
        $.ajax({
          type: 'POST',
          url: '../Control/LlenarAcompaniante.php',
          data: $("#ConsultaUbicacionForm").serialize(),
          success: function(data) {
            $('#table_body').html(data);
            $('#exampleModalToggle').modal('show');
          }
        });
        $('#exampleModalToggle2').modal('hide');
      }, 2000);
      
      Swal.fire({
        icon: 'success',
        title: '¡Registro exitoso!',
        text: 'Acompañante ingresado correctamente.',
        showConfirmButton: false,
        timer: 3000, // Mostrará la alerta por 2 segundos
        timerProgressBar: true,
        position: 'center'
    }).then(() => {
        window.location.href = "UbicacionPacientes.php";
    });
    

      // Limpiar los campos del modal
      $('#tipoDocumentoAcompanante').val('');
      $('#Id').val('');
      $('#NombreAcompanante').val('');
      $('#ApellidoAcompanante').val('');
      $('#Genero').val('');
      $('#Telefono').val('');
      $('#Direccion').val('');
      $('#compania').val('');
    }
  });
}

// Mostrar mensaje al cargar la página si existe en localStorage
document.addEventListener("DOMContentLoaded", function() {
  const mensajeGuardado = localStorage.getItem("mensajeGuardado");
  if (mensajeGuardado) {
    Swal.fire({
      position: "center",
      icon: "success",
      title: mensajeGuardado,
      showConfirmButton: false,
      timer: 2000
    });
    localStorage.removeItem("mensajeGuardado");
  }
});
function openModal(imageSrc) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    var captionText = document.getElementById("caption");

    // Establecer el src de la imagen en el modal y la leyenda
    modal.style.display = "flex";
    modal.style.justifyContent = "center";
    modal.style.alignItems = "center";
    modal.style.flexDirection = "column";
    modalImg.src = imageSrc;
    captionText.innerHTML = "Imagen ampliada"; // Puedes modificar este texto seg�n desees
}

// Funci�n para cerrar el modal
function closeModal() {
    var modal = document.getElementById("imageModal");
    modal.style.display = "none";
}
