<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregunta del Juego</title>
    <link rel="stylesheet" href="CSS/cuestionario.css">
    <link rel="stylesheet" href="CSS/fondo.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
    <title>Document</title>

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
    <div class="contenedor-barra">
        <div class="contador">
            <span></span>
            <div class="barra"></div>
        </div>
    </div>
    <div class="container">
        
        <div class="question-box">
            <div class="categoria">
                <span style="font-weight: 100;" >Geografia</span>
            </div>
            <div class="question">
                <p>¿Cuál es la capital de Japon?</p>
            </div>
            <div class="options">
                <button class="option pixelify-sans-100">A: Nueva Delhi</button>
                <button class="option pixelify-sans-100">B: Osaka</button>
                <button class="option pixelify-sans-100">C: Tokio</button>
                <button class="option pixelify-sans-100">D: Seul</button>
            </div>
            <div class="controls">
                <div class="progress">
                    <span>1/4</span>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../control/fondo.js"></script>
<script src="../control/cuestionario.js"></script>
</html>
