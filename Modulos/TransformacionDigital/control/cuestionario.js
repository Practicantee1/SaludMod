$(document).ready(function () {
    let totalTime = 15; 
    let width = 100; 

    let countdown = setInterval(function () {
        totalTime--; 
        width = (totalTime / 15) * 100; 
        
        $(".barra").css("width", width + "%");

        let minutes = Math.floor(totalTime / 60);
        let seconds = totalTime % 60;

        let displayTime = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
        $(".contador span").text(displayTime);
        if(seconds <= 10){
            $(".contador").addClass("flicker3");
        }
        if (totalTime <= 0) {
            clearInterval(countdown);
            $(".barra").css("width", "0%");
            $(".contador span").text("Tiempo terminado");
        }
    }, 1000); 
});

$(document).ready(function () {
    const $questionBox = $(".question-box");
    const $options = $(".option");
    const $progress = $(".progress span");
  
    // Preguntas (puedes agregar más)
    const preguntas = [
      {
        categoria: "Geografía",
        pregunta: "¿Cuál es la capital de Japón?",
        opciones: ["Nueva Delhi", "Osaka", "Tokio", "Seúl"],
        progreso: "1/4",
      },
      {
        categoria: "Historia",
        pregunta: "¿En qué año terminó la Segunda Guerra Mundial?",
        opciones: ["1940", "1942", "1945", "1950"],
        progreso: "2/4",
      },
      {
        categoria: "Ciencia",
        pregunta: "¿Qué planeta es conocido como el planeta rojo?",
        opciones: ["Mercurio", "Venus", "Marte", "Júpiter"],
        progreso: "3/4",
      },
      {
        categoria: "Deportes",
        pregunta: "¿Cuántos jugadores tiene un equipo de fútbol?",
        opciones: ["9", "10", "11", "12"],
        progreso: "4/4",
      },
    ];
  
    let preguntaActual = 0;
  
    // Añade evento a las opciones
    $options.on("click", function () {
      // Animación de salida
      $questionBox.css("animation", "exit-to-bottom 1s ease-out forwards");
  
      // Cambiar a la siguiente pregunta después de la animación
      setTimeout(() => {
        preguntaActual++;
        if (preguntaActual < preguntas.length) {
            console.log(preguntas.length)
          actualizarPregunta();
        } else {
            Swal.fire({
                title: "GRACIAS POR PARTICIPAR!",
                text: "Muy pronto estaremos actualizando la tabla de posiciones. Mucha suerte!",
                icon: "success",
                confirmButtonText: "Aceptar",
                customClass: {
                    title: 'pixelify-sans',
                    htmlContainer: 'pixelify-sans'
                },
                allowOutsideClick: false, // Bloquear clics fuera del cuadro de alerta
                allowEscapeKey: false,   // Bloquear cierre con tecla Escape
                allowEnterKey: true      // Permitir confirmar con Enter
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirigir solo cuando se presiona el bot�n de confirmaci�n
                    window.location.href = '../view/inicio.php';
                }
            });        }
      }, 1000); // Tiempo sincronizado con la animación
    });
  
    function actualizarPregunta() {
      const data = preguntas[preguntaActual];
      $(".categoria span").text(data.categoria);
      $(".question p").text(data.pregunta);
      $(".option").each(function (index) {
        $(this).text(`${String.fromCharCode(65 + index)}: ${data.opciones[index]}`);
      });
      $progress.text(data.progreso);
  
      // Animación de entrada
      $questionBox.css("animation", "enter-from-top 1s ease-out forwards");
    }
  });
  