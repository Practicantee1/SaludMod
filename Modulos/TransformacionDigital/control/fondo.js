$(document).ready(function() {
    var rowContent = `
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
    `;

    for (var i = 0; i < 30; i++) {
        $('#fondo').append(rowContent);
    }

});

$(document).ready(function () {
    const savedTheme = localStorage.getItem('theme');
    
    // Si existe una preferencia de tema guardada, aplícala
    if (savedTheme === 'light') {
        $('body').addClass('light-theme');
        $('#btn-theme').addClass('activate');
    } else if (savedTheme === 'dark') {
        $('body').removeClass('light-theme');
        $('#btn-theme').removeClass('activate');
    }

    // Cambio de tema cuando se hace clic en el botón
    $('#btn-theme').click(function () {
        $('body').toggleClass('light-theme');
        $(this).toggleClass('activate');
        
        // Guarda la preferencia del tema en localStorage
        if ($('body').hasClass('light-theme')) {
            localStorage.setItem('theme', 'light');
        } else {
            localStorage.setItem('theme', 'dark');
        }
    });
});