
$("#comoJugar").on("click touchstart", function(e) {
    e.preventDefault();
    $(".carta").addClass("flipped");
});
$("#volver").on("click touchstart", function(e) {
    e.preventDefault();
    $(".carta").removeClass("flipped");
});

const audio = document.getElementById("myAudio");

audio.addEventListener("ended", function() {
    audio.currentTime = 0;  // Reinicia el audio al inicio
    audio.play();           // Lo vuelve a reproducir
});

const playButton = document.getElementById("comoJugar");

    playButton.addEventListener("click", () => {
        audio.play()
            .then(() => {
                console.log("Reproducción iniciada");
            })
            .catch(error => {
                console.error("No se pudo iniciar la reproducción: ", error);
            });
    });

    $("#jugar").click(function(){
        window.location.href = "../view/cuestionario.php";
    });
    $("#ranking").click(function(){
        window.location.href = "../view/ranking.php";
    });