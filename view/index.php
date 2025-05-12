<?php 
//redireccionar a la vista de loginss
header ('Location: view/login.php');
?>
<script>
  function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
}
</script>