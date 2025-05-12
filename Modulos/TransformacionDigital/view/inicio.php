<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/fondo.css">
    <link rel="stylesheet" href="CSS/fondoiconos.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<script>
   // Recupera la preferencia de tema guardada en localStorage
const savedTheme = localStorage.getItem('theme');

// Si existe una preferencia de tema guardada, aplícala
if (savedTheme === 'light') {
    document.body.classList.add('light-theme');
    document.getElementById('btn-theme').classList.add('activate');
} else if (savedTheme === 'dark') {
    document.body.classList.remove('light-theme');
    document.getElementById('btn-theme').classList.remove('activate');
}

// Cambio de tema cuando se hace clic en el botón
document.getElementById('btn-theme').addEventListener('click', function() {
    document.body.classList.toggle('light-theme');
    this.classList.toggle('activate');
    
    // Guarda la preferencia del tema en localStorage
    if (document.body.classList.contains('light-theme')) {
        localStorage.setItem('theme', 'light');
    } else {
        localStorage.setItem('theme', 'dark');
    }
});
    </script>
    <a href="../../../view/escritorio.php" class="btn volver"><i class="fa-solid fa-arrow-left"></i></a>
    <audio id="myAudio" src="musicaFondo.mp3" autoplay></audio>
    <button id="btn-theme" class="switch btn"> 
        <span><i class="fa-regular fa-sun"></i></span>
        <span><i class="fa-regular fa-moon"></i></span>
    </button>
    
    <section id="fondo">
        <div class="row">
            <div>
                <i class="icon fa-solid fa-code"></i> <!-- code -->
                <i class="icon fa-solid fa-money-bill"></i> <!-- billete -->
                <i class="icon fa-solid fa-star"></i> <!-- estrella -->
                <i class="icon fa-solid fa-headphones"></i> <!-- audifonos -->
                <i class="icon fa-solid fa-list"></i> <!-- lista -->
                <i class="icon fa-solid fa-bolt"></i> <!-- rayo -->
                <i class="icon fa-solid fa-dove"></i> <!-- colibri -->
                <i class="icon fa-solid fa-heart"></i> <!-- corazon -->
                <i class="icon fa-solid fa-user"></i> <!-- user -->
                <i class="icon fa-solid fa-gamepad"></i> <!-- mando -->
                <i class="icon fa-solid fa-code"></i> <!-- code -->
                <i class="icon fa-solid fa-money-bill"></i> <!-- billete -->
                <i class="icon fa-solid fa-star"></i> <!-- estrella -->
                <i class="icon fa-solid fa-headphones"></i> <!-- audifonos -->
                <i class="icon fa-solid fa-list"></i> <!-- lista -->
                <i class="icon fa-solid fa-bolt"></i> <!-- rayo -->
                <i class="icon fa-solid fa-dove"></i> <!-- colibri -->
                <i class="icon fa-solid fa-heart"></i> <!-- corazon -->
                <i class="icon fa-solid fa-user"></i> <!-- user -->
                <i class="icon fa-solid fa-gamepad"></i> <!-- mando -->
                <i class="icon fa-solid fa-code"></i> <!-- code -->
                <i class="icon fa-solid fa-money-bill"></i> <!-- billete -->
                <i class="icon fa-solid fa-star"></i> <!-- estrella -->
                <i class="icon fa-solid fa-headphones"></i> <!-- audifonos -->
                <i class="icon fa-solid fa-list"></i> <!-- lista -->
                <i class="icon fa-solid fa-bolt"></i> <!-- rayo -->
                <i class="icon fa-solid fa-dove"></i> <!-- colibri -->
                <i class="icon fa-solid fa-heart"></i> <!-- corazon -->
                <i class="icon fa-solid fa-user"></i> <!-- user -->
                <i class="icon fa-solid fa-gamepad"></i> <!-- mando -->
            </div>
            <div>
                <i class="icon fa-solid fa-code"></i> <!-- code -->
                <i class="icon fa-solid fa-money-bill"></i> <!-- billete -->
                <i class="icon fa-solid fa-star"></i> <!-- estrella -->
                <i class="icon fa-solid fa-headphones"></i> <!-- audifonos -->
                <i class="icon fa-solid fa-list"></i> <!-- lista -->
                <i class="icon fa-solid fa-bolt"></i> <!-- rayo -->
                <i class="icon fa-solid fa-dove"></i> <!-- colibri -->
                <i class="icon fa-solid fa-heart"></i> <!-- corazon -->
                <i class="icon fa-solid fa-user"></i> <!-- user -->
                <i class="icon fa-solid fa-gamepad"></i> <!-- mando -->
                <i class="icon fa-solid fa-code"></i> <!-- code -->
                <i class="icon fa-solid fa-money-bill"></i> <!-- billete -->
                <i class="icon fa-solid fa-star"></i> <!-- estrella -->
                <i class="icon fa-solid fa-headphones"></i> <!-- audifonos -->
                <i class="icon fa-solid fa-list"></i> <!-- lista -->
                <i class="icon fa-solid fa-bolt"></i> <!-- rayo -->
                <i class="icon fa-solid fa-dove"></i> <!-- colibri -->
                <i class="icon fa-solid fa-heart"></i> <!-- corazon -->
                <i class="icon fa-solid fa-user"></i> <!-- user -->
                <i class="icon fa-solid fa-gamepad"></i> <!-- mando -->
                <i class="icon fa-solid fa-code"></i> <!-- code -->
                <i class="icon fa-solid fa-money-bill"></i> <!-- billete -->
                <i class="icon fa-solid fa-star"></i> <!-- estrella -->
                <i class="icon fa-solid fa-headphones"></i> <!-- audifonos -->
                <i class="icon fa-solid fa-list"></i> <!-- lista -->
                <i class="icon fa-solid fa-bolt"></i> <!-- rayo -->
                <i class="icon fa-solid fa-dove"></i> <!-- colibri -->
                <i class="icon fa-solid fa-heart"></i> <!-- corazon -->
                <i class="icon fa-solid fa-user"></i> <!-- user -->
                <i class="icon fa-solid fa-gamepad"></i> <!-- mando -->
            </div>
        </div>
    </section>
    <div class="div-contenido carta">
        <div class="card__front"> 
            <div class="titulo">
                <h1 class="pixelify-sans title">TRANSFORMACION DIGITAL</h1>
            </div>
            <div class="contenido">
                <div class="card">
                    <div class="circle"></div>
                    <div class="content">
                        <button class="card-modulo pixelify-sans" id="jugar">Jugar</button>
                        <button class="card-modulo pixelify-sans" id="ranking">Ranking</button>
                        <button class="card-modulo pixelify-sans" id="comoJugar">Como Jugar?</button>
                    </div>
                    <img src="colibri.png" alt="">
                    <h2 class="pixelify-sans subtitulo" style ="font-weight: light;"><i class="fa-solid fa-arrow-down icono_subtitulo flicker2"></i>&nbsp;&nbsp;COMENCEMOS&nbsp;&nbsp;<i class="fa-solid fa-arrow-down icono_subtitulo flicker2"></i></h2>
                </div>
            </div> 
        </div>
        <div class="card__back">
            <div class="titulo">
                <h1 class="pixelify-sans title">COMO JUGAR?</h1>
            </div>
            <div class="contenido">
                <div class="content">
           		    <h3 class="pixelify-sans">Instrucciones:</h3>
                    <p class="pixelify-sans">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iure quidem consectetur pariatur veniam autem impedit et? Corrupti illo minus doloremque quisquam ex, inventore eaque nobis ea voluptate ipsa quidem eveniet?</p>
                </div>
            </div>
            <button id="volver" class="pixelify-sans" >VOLVER</button>
        </div>
    </div>
</body>
<script src="../control/fondo.js"></script>
<script src="../control/fondoiconos.js"></script>
</html>