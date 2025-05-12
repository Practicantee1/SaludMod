<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta del Juego</title>
    <link rel="stylesheet" href="CSS/fondoiconos.css">
    <link rel="stylesheet" href="CSS/fondo.css">
    <link rel="stylesheet" href="CSS/ranking.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Tilt+Neon&display=swap" rel="stylesheet">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body class="pixelify-sans-100">
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
    <audio id="myAudio" src="musicaFondo.mp3" autoplay></audio>
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
                <h1 class="pixelify-sans title">POSICIONES</h1>
            </div>
            <div class="contenido">
                <div class="card posiciones">
                    <table class="tbl-ranking">
                        <th class="pixelify-sans">POSICION</th>
                        <th class="pixelify-sans">NOMBRES</th>
                        <th class="pixelify-sans">PUNTOS</th>
                        <tbody class="tbody-ranking">
                            <tr class="pixelify-sans top-1" >
                                <td>1</td>
                                <td>Juan Vasquez <i class="fa-solid fa-medal"></i></td>
                                <td>1980</td>
                            </tr>
                            <tr class="pixelify-sans top-2">
                                <td>2</td>
                                <td>Jose Alvarado <i class="fa-solid fa-medal"></i></td>
                                <td>1870</td>
                            </tr>
                            <tr class="pixelify-sans top-3">
                                <td>3</td>
                                <td>Juana Ospina <i class="fa-solid fa-medal"></i></td>
                                <td>1510</td>
                            </tr>
                            <tr class="pixelify-sans" >
                                <td>4</td>
                                <td>Juan Rebolledo </td>
                                <td>1280</td>
                            </tr>
                            <tr class="pixelify-sans">
                                <td>5</td>
                                <td>Esteban Giraldo </td>
                                <td>1120</td>
                            </tr>
                            <tr class="pixelify-sans">
                                <td>6</td>
                                <td>Gabriel Mosquera </td>
                                <td>1090</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button id="premios" class="pixelify-sans btn-ranking">PREMIOS</button>
                <button id="volver-menu" class="pixelify-sans btn-ranking">VOLVER</button>
            </div> 
        </div>
        <div class="card__back">
            <div class="titulo">
                <h1 class="pixelify-sans title">PREMIOS</h1>
            </div>
            <div class="contenido">
                <div class="content">
                    <label for="">1. Carro 0km 2025</label>
                    <label for="">2. Carro 0km 2025</label>
                    <label for="">3. Carro 0km 2025</label>
                </div>
            </div>
            <button id="volver-ranking" class="pixelify-sans btn-ranking reves">VOLVER</button>
        </div>
    </div>
</body>
<script src="../control/fondo.js"></script>
<script src="../control/ranking.js"></script>
</html>