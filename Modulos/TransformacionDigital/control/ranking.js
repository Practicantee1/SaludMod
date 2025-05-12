$("#premios").on("click touchstart", function(e) {
    e.preventDefault();
    $(".carta").addClass("flipped");
});
$("#volver-ranking").on("click touchstart", function(e) {
    e.preventDefault();
    $(".carta").removeClass("flipped");
});


$("#volver-menu").click(function(){
    window.location.href = 'inicio.php'
})
