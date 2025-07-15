<?php
  define('BASE_URL', '');
  require_once 'template/header.php';
  $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/SaludMod';
?>       
<div class="content-wrapper" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
  <section class="content text-center" style="padding: 2rem;">
    <img 
      alt="Colibrí triste" 
      src="<?php echo $baseUrl ?>/view/img/Colibri_triste.png" 
      style="max-width: 300px; width: 100%; height: auto; margin-bottom: 1.5rem;"
    >
    <h1 style="font-size: 2.2rem; color: #218838; margin-bottom: 1rem;">Acceso Denegado</h1>
    <p style="font-size: 1.1rem; color: #6c757d; max-width: 500px; margin: 0 auto;">
      Lo sentimos, no tienes los permisos necesarios para ver este contenido. Si crees que esto es un error, por favor contacta con el área de Gestión TIC.
    </p>
    <a href="<?php echo $baseUrl ?>/view/escritorio.php" 
       style="margin-top: 2rem; display: inline-block; background-color: #28a745; color: #fff; padding: 0.6rem 1.2rem; border-radius: 5px; text-decoration: none;">
      Volver al inicio
    </a>
  </section>
</div>

<?php
  require_once 'template/footer.php';
?>