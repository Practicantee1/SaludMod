<!DOCTYPE html>
<html lang="es">

<head>
 
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title><?php echo $pageTitle ?></title>
  <link rel="shortcut icon" href="<?php echo BASE_URL; ?>../favicon.ico" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/fonts.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../plantilla/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../plantilla/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../plantilla/dist/css/adminlte.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/responsive.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../plantilla/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../plantilla/dist/css/datatable.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/select2-bootstrap.min.css" />
  <link href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/mdb.lite.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/mdb.min.css" />
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/choices.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>../view/css/cssAdicionales/bootstrap-select.css" />
  <script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.6.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.3"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"/>
  <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/UbicacionCitasPacientes/view/CSS/UbicacionCitasPacientes.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Incapacidades/view/CSS/Incapacidad.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/desarrollo_epidemiologia/view/CSS/estilos.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Cirugia_RH/view/CSS/estilo.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</style>
  <style>
    
   
.input-field {
    position: relative;
    margin-bottom: 10px;
  }
  
  .input-field label {
    position: absolute;
    top: 78%;
    left: 30px;
    transform: translateY(-100%);
    color: #aaa;
    pointer-events: none;
    transition: .3s;
    font-weight: lighter;
  }
  
  .input-field input:focus ~ label,
  .input-field input:valid ~ label {
    top: 0;
    font-size: 16px;
    padding: 0px;
    background-color: transparent;
    color: #555;
  }
  
  .valid{
    top: 0;
    font-size: 16px;
    padding: 0px;
    background-color: transparent;
    color: #555;
  }

  .input-field textarea:focus ~ label,
.input-field textarea:not(:placeholder-shown) ~ label {
  top: -10px; /* Coloca el label en la posición final */
  font-size: 14px;
  background-color: #fff; /* Fondo opcional para mejorar visibilidad */
  padding: 0 4px;
  color: #555;
}
  
    .input{
      padding: 10px 8px;
      border-radius: 4px;
      background-color: #F4F6F9;
      border: .5px solid #ccc;
      border-radius: 5px;
      outline: none;
    }
    #spinner {
      width: 122px;
      height: 122px;
      border-radius: 50%;
      display: inline-block;
      position: relative;
      border: 7px solid;
      border-color: #FFF #FFF transparent transparent;
      box-sizing: border-box;
      animation: rotation 1s linear infinite;
    }

    #spinner {
      width: 112px;
      height: 112px;
      border-radius: 53%;
      display: inline-block;
      position: relative;
      border: 10px solid;
      border-color: #FFF #FFF transparent transparent;
      box-sizing: border-box;
      animation: rotation 1s linear infinite;
    }
    #spinner::after,
    #spinner::before {
      content: '';  
      box-sizing: border-box;
      position: absolute;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      margin: auto;
      border: 8px solid;
      border-color: transparent transparent #77cc77 #77cc77;
      width: 82px;
      height: 82px;
      border-radius: 50%;
      box-sizing: border-box;
      animation: rotationBack 0.5s linear infinite;
      transform-origin: center center;
    }
    #spinner::before {
      width: 52px;
      height: 52px;
      border-color: #3F8755 #3F8755 transparent transparent;
      animation: rotation 1.5s linear infinite;
    }
        
    @keyframes rotation {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    } 
    @keyframes rotationBack {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(-360deg);
      }
    }
 
    #loading_container{
      position: fixed;
      z-index: 9999;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(rgba(8, 8, 8, 1), rgba(63, 135, 85, 0.4)); 
      animation: 3s slide-right;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: all 2s; 
      
    }

    .swal2-popup {
      font-size: 1.6rem !important;
    }
    .page-item{
    color: green;
    border: 2px solid;
    padding: 11px;
    margin: 6px;
    border-radius: 20px;
    }
    .page-item:hover{
      background-color: rgb(119,222,119);
    }

    .select2-container .select2-choice,
    .select2-result-label {
      font-size: 1.5em;
      height: 41px;
      overflow: auto;
    }

    .select2-selection {
      min-height: 10px !important;
    }

    .select2-container .select2-selection--single {
      height: 35px !important;
    }

    .select2-selection__arrow {
      height: 34px !important;
    }
    table {
     border: none;
     width: 100px;
     border-collapse: collapse;
     top: 100%;
    }

  
    td { 
      padding: 5px 10px;

      text-align: center;
      border: 1px solid #999;
    }
    th { 
      padding: 5px 10px;
      text-align: center;
      border: 1px solid #999;
    }
/* 
    tr:nth-child(1) {
      background: #dedede;
    } */
    .saludmod-navbar{
            font-family: Arial, sans-serif;
            font-weight: bold;
            font-size: 1.5em;
            color: #CECECE;
            padding:2px 10px;
            display: inline-block;
            font-style: italic; /* Aplica estilo itálico */
            /* transform: skewX(-3deg);  */
            margin: 0;

    }

    .btn-Colibri{
      border: 1px solid #fff;
      border-radius: 15px;
      background-color: #fff;
    }
    .nav-link-menu{
      background-color: black; /* Fondo negro para el enlace */
    color: white; /* Color blanco para el ícono */
    padding: 0 4px; /* Espacio alrededor del ícono */
    border-radius: 5px; /* Bordes redondeados opcionales */
    display: inline-flex; /* Para centrar el ícono en el contenedor */
    align-items: center; /* Alinear verticalmente el ícono */
    justify-content: center; /* Alinear horizontalmente el ícono */
    }
    .nav-link-menu i {
    color: white; /* Asegúrate de que el ícono sea blanco */
    }
    .lb-hospital{
      font-family: Arial, sans-serif;
      font-weight: 700;
      font-size: 1em;
      color: #CECECE;
      padding: 2px 4px 2px 12px;
      display: inline-block;
      margin: 0;

    }
    .lb-sanvi{
      font-family: Arial, sans-serif;
      font-weight: 500;
      font-size: .45em;
      color: #CECECE;
      display: inline-block;
      margin: 0;
    }

.nav-item .submodule-link {
    position: relative;
    padding-left: 20px; 
}

.nav-item .submodule-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0px;
    bottom: -10px;
    width: 2px;
    background-color: white;
    height: 80%;
    
}

.nav-item .submodule-link::after {
    content: '';
    position: absolute;
    left: 0px;
    top: 50%;
    width: 15px;
    height: 2px;
    background-color: white;
    transform: translateY(-50%);
}

.card-header{
  background-color: #fff !important;
}

#card-inca{
  background-color: #fff !important;

}


.span{
  background-color: #fff !important;
} 
  </style>
  
  
</head>


<!-- onload="deshabilitaRetroceso()" -->
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper" style="width: 100%;">
    <!-- Preloader -->
    <div id="loading_container">
      <span id="spinner" class="loader"></span>
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light" style="background-color: #fff; height: 73px;">
  <!-- Left navbar links -->
  <ul class="navbar-nav" style="flex: 0.5; display: flex; align-items: center;">
    <li class="nav-item">
      <a class="nav-link-menu" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <!-- Center label -->
  <ul class="navbar-nav" style="flex: 3; justify-content: center;">
    <li class="nav-item d-none d-sm-inline-block" style="text-align: center;">
      <label style="color: #066E45; font-size: 1rem; margin:0; margin-left: 5%; width: 100%;">
      <?php echo isset($_SESSION['module_title']) ? $_SESSION['module_title'] : 'SALUDMOD'; ?>
      </label>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav" style="flex: 1; display: flex; justify-content: flex-end; align-items: center;">
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>

    <!-- Profile dropdown -->
    <div class="dropdown" style="display: flex; align-items: center;">
      <div style="display:flex; flex-direction:column">
        <label style="margin: 0 5px;"><?php echo $_SESSION['nombre']; ?></label>
        <label style="margin: 0 5px; font-weight: 400"><?php echo $_SESSION['cargo']; ?></label>
      </div>
        <button class="btn-Colibri" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="<?php echo BASE_URL; ?>../plantilla/dist/img/logoColibri.png" alt="AdminLTE Logo" style="opacity: .8; max-width: 45px;">
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li class="user-footer">
          <?php if(isset($_SESSION['login'])) { ?>
            <a href="<?php echo BASE_URL; ?>../controller/usuario.php?op=cambiar contrasena" class="dropdown-item">
              <i class="fa-solid fa-user"></i> Cambiar Contrase&#241;a
            </a>
          <?php } ?>
          <a href="<?php echo BASE_URL; ?>../controller/usuario.php?op=salir" class="dropdown-item">
            <i class="fas fa-arrow-left mr-2"></i> Salir
          </a>
        </li>
      </div>
    </div>
  </ul>
</nav>

    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #08090A;">
      <!-- Brand Logo -->
      <a class="brand-link" style="background-color: #08090A; display:flex; align-items: center;">
        <img src="<?php echo BASE_URL; ?>../plantilla/dist/img/logoverde.png" alt="AdminLTE Logo" class=" img-circle elevation-3" style="opacity: .8; max-width: 45px; margin-left: 10px">
        <div style="display: flex; flex-direction: column;">
          <h5 class="saludmod-navbar" style="margin: 0; margin-left: 2px; ">SaludMod</h5>

        </div>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: none;">

          <!-- <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['nombre']; ?></a>
          </div> -->
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul id="ul-navbar" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          
    
          <?php


           

// if ($_SESSION['modificar_estado'] == 1) {
//   echo '<li class="nav-item">
//         <a href="'.BASE_URL.'../view/Estados_solicitudes.php" class="nav-link active" style="background-color: #3f8755;">
//         &nbsp;<i class="fa-solid fa-house fa-lg" style="color: #ffffff;"></i>
//           <p>
//           &nbsp;&nbsp;Inicio 
//           </p>
//         </a>
//         </li>';
// }



//TODOS TIENE ACCESO AL ESCRITORIO

if (isset($_SESSION['Escritorio']) && $_SESSION['Escritorio'] == 1) {
  echo '<li class="nav-item">
  <a href="'.BASE_URL.'../view/escritorio.php" class="nav-link active" style="background-color: transparent;">
  &nbsp;<i class="fa-solid fa-house fa-lg" style="color: #ffffff;"></i>
    <p>
    &nbsp;&nbsp;Inicio
    </p>
  </a>
  </li>';

   
  
}



// // MODULOS DETERMINADOS POR PERMISOS

// if(isset($_SESSION['UbicacionPaciente']) && $_SESSION['UbicacionPaciente'] == 1){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fa-solid fa-hospital-user" style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Ubicación y Citas
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none;">

//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/UbicacionCitasPacientes/View/UbicacionPacientes.php" class="nav-link">
//       &nbsp;<i class="fa-solid fa-street-view"></i>
//       <p>&nbsp;&nbsp;Ubicación de pacientes</p>
//       </a>
//     </li>

//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/UbicacionCitasPacientes/View/CitasPacientes.php" class="nav-link">
//       &nbsp;<i class="fa-solid fa-calendar-check"></i>
//       <p>&nbsp;&nbsp;Consulta de citas</p>
//       </a>
//     </li>
//   </ul>

      
//   </li>';
// }
// if(isset($_SESSION['Odontograma']) && $_SESSION['Odontograma'] == 1){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fa-solid fa-tooth" style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Odontograma
//     <i class="fas fa-angle-left right"></i>
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none;">

//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/odontograma/view/odontograma.php" class="nav-link">
//       &nbsp;<i class="fa-sharp fa-solid fa-teeth-open"></i>
//       <p>&nbsp;&nbsp;Registrar Odontograma</p>
//       </a>
//     </li>

//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/odontograma/view/buscarOdontograma.php" class="nav-link">
//       &nbsp;<i class="fa-solid fa-magnifying-glass"></i>
//       <p>&nbsp;&nbsp;Buscar Odontograma</p>
//       </a>
//     </li>
//   </ul>

      
//   </li>';
// }

// // SI EL USUARIO TIENE PERMISOS DE ALGUNO DE LAS SUB PAGINAS DEL MODULO, ENTONCES SE PERMITE ACCEDER AL MENU PRINCIPAL QUE LAS CONTIENE
// if((isset($_SESSION['GenerarIncapacidades']) && $_SESSION['GenerarIncapacidades'] == 1) || (isset($_SESSION['ObservarIncapacidades']) && $_SESSION['ObservarIncapacidades'] == 1)){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fa-solid fa-file-waveform" style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Incapacidades
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none;">';

// // PRIMERA SUBPAGINA DEL MODULO INCAPACIDADES: -CREACION DE INCAPACIDADES
// if(isset($_SESSION['GenerarIncapacidades']) && $_SESSION['GenerarIncapacidades'] == 1){
//     echo '<li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Incapacidades?CH=2" class="nav-link">
//       &nbsp;<i class="fa-solid fa-file-circle-plus"></i>
//       <p>&nbsp;&nbsp;Ingresar Incapacidad</p>
//       </a>
//     </li>';
// }

// // SEGUNDA SUBPAGINA DEL MODULO INCAPACIDADES: -CONSOLIDADO DE INCAPACIDADES
// if(isset($_SESSION['ObservarIncapacidades']) && $_SESSION['ObservarIncapacidades'] == 1){
//     echo '<li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Incapacidades/View/ConsolidadoIncapacidad.php" class="nav-link">
//       &nbsp;<i class="fa-solid fa-book-medical"></i>
//       <p>&nbsp;&nbsp;Consultar Incapacidad</p>
//       </a>
//     </li>';
// }
    
//   echo '</ul>

      
//   </li>';
// }

// /* if(isset($_SESSION['Incapacidades']) && $_SESSION['Incapacidades'] == 1){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fa-solid fa-file-waveform" style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Incapacidades
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none;">
//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Incapacidades?CH=2" class="nav-link">
//       &nbsp;<i class="fa-solid fa-file-circle-plus"></i>
//       <p>&nbsp;&nbsp;Ingresar Incapacidad</p>
//       </a>
//     </li>
//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Incapacidades/View/ConsolidadoIncapacidad.php" class="nav-link">
//       &nbsp;<i class="fa-solid fa-book-medical"></i>
//       <p>&nbsp;&nbsp;Consultar Incapacidad</p>
//       </a>
//     </li>
//   </ul>

      
//   </li>';
// } */



// // ADMIN ONLY

// if((isset($_SESSION['verificaciones_implantados']) && $_SESSION['verificaciones_implantados'] == 1)){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fa-solid fa-list-check"style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Verificación implantes
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none;">';

// // // PRIMERA SUBPAGINA DEL MODULO INCAPACIDADES: -CREACION DE INCAPACIDADES
// // if(isset($_SESSION['verificaciones_implantados']) && $_SESSION['verificaciones_implantados'] == 1){
// //     echo '<li class="nav-item">
// //       <a href="'.BASE_URL.'../Modulos/desarrollo_epidemiologia/view/auxiliar.php" class="nav-link">
// //       &nbsp;<i class="fa-solid fa-user-nurse"></i>
// //       <p>&nbsp;&nbsp;List. verificacion aux. enfermeria.</p>
// //       </a>
// //     </li>';
    
// // }

// // SEGUNDA SUBPAGINA DEL MODULO INCAPACIDADES: -CONSOLIDADO DE INCAPACIDADES
// if(isset($_SESSION['verificaciones_implantados']) && $_SESSION['verificaciones_implantados'] == 1){
//     echo '<li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/desarrollo_epidemiologia/view/enfermeras.php" class="nav-link">
//       &nbsp;<i class="fa-solid fa-user-nurse"></i>
//       <p>&nbsp;&nbsp;Auxiliares y enfermeras.</p>
//       </a>
//     </li>';
// }

// if(isset($_SESSION['verificaciones_implantados']) && $_SESSION['verificaciones_implantados'] == 1){
//   echo '<li class="nav-item">
//     <a href="'.BASE_URL.'../Modulos/desarrollo_epidemiologia/view/epidemiologa.php" class="nav-link">
//     &nbsp;<i class="fa-solid fa-user-nurse"></i>
//     <p>&nbsp;&nbsp;Epidemiologia</p>
//     </a>
//   </li>';
// }
    
//   echo '</ul>

      
//   </li>';
// }

// // PRIMERA SUBPAGINA DEL MODULO programa educativo: 
// if((isset($_SESSION['ProgramaEducativo']) && $_SESSION['ProgramaEducativo'] == 1)){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//    <i class="fa-solid fa-list-check"style="color: #ffffff;"></i>
//   <p>&nbsp;&nbsp;Programa Educativo
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none; position: relative; padding-left: 20px;">
//           <!-- Línea vertical de conexión -->
//           <span style="content: \'\'; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background-color: white;    height: 79%;"></span>';

// // PRIMERA SUBPAGINA DEL MODULO INCAPACIDADES: -CREACION DE INCAPACIDADES
//     echo '<li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Programas_educativos/view/programa_educativo.php" class="nav-link">
//        <!-- Línea horizontal de conexión -->
//       <span style="content: \'\'; position: absolute; left: -10px; top: 50%; width: 15px; height: 2px; background-color: white;"></span>
//       <p>&nbsp;&nbsp;Programa Educativo 1 </p>
//       </a>
//     </li>
//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Programas_educativos/view/programas_educativos2.php" class="nav-link">
//        <!-- Línea horizontal de conexión -->
//       <span style="content: \'\'; position: absolute; left: -10px; top: 50%; width: 15px; height: 2px; background-color: white;"></span>
//       <p>&nbsp;&nbsp;Programa Educativo 2</p>
//       </a>
//     </li>';
    

//   echo '</ul>

      
//   </li>';
// }
// // Define el permiso de acceso IMPLANTES
// if(isset($_SESSION['implantes']) && $_SESSION['implantes'] == 1){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fa-solid fa-stethoscope" style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Implantes
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none; position: relative; padding-left: 20px;">
//           <!-- Línea vertical de conexión -->
//           <span style="content: \'\'; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background-color: white;    height: 52%;"></span>

//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Implantes/View/form_encuesta.php" class="nav-link"">
//       &nbsp;
//       <!-- Línea horizontal de conexión -->
//               <span style="content: \'\'; position: absolute; left: -10px; top: 50%; width: 15px; height: 2px; background-color: white;"></span>
//       <p>&nbsp;&nbsp;Registro de implantes</p>
//       </a>
//     </li>
//   </ul>

      
//   </li>';
// }

// // DEFINE EL ACCESO A CIRUGIA-HR

// if(isset($_SESSION['Cirugia_RH']) && $_SESSION['Cirugia_RH'] == 1){
//   echo '<li class="nav-item">
//   <a href="#" class="nav-link active" style="background-color: #066E45;">
//   &nbsp;<i class="fas fa-user-md" style="color: #ffffff;"></i>
//   <p>
//     &nbsp;&nbsp;Cirugia HR
//     <i class="fas fa-angle-left right"></i>
    
//   </p>
//   </a>
//   <ul class="nav nav-treeview" style="display: none; position: relative; padding-left: 20px;">
//           <!-- Línea vertical de conexión -->
//           <span style="content: \'\'; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background-color: white;    height: 82%;"></span>

//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Cirugia_RH/View/cirugia.php" class="nav-link"">
//       &nbsp;
//       <!-- Línea horizontal de conexión -->
//               <span style="content: \'\'; position: absolute; left: -10px; top: 50%; width: 15px; height: 2px; background-color: white;"></span>
//       <p>&nbsp;&nbsp;Nuevo procedimiento</p>
//       </a>
//     </li>


//     <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Cirugia_RH/View/continuarForm.php" class="nav-link"">
//       &nbsp;
//       <!-- Línea horizontal de conexión -->
//               <span style="content: \'\'; position: absolute; left: -10px; top: 50%; width: 15px; height: 2px; background-color: white;"></span>
//       <p>&nbsp;&nbsp;Continuar con el formulario</p>
//       </a>
//     </li>
 
//   <li class="nav-item">
//       <a href="'.BASE_URL.'../Modulos/Cirugia_RH/View/terminadosForm.php" class="nav-link"">
//       &nbsp;
//       <!-- Línea horizontal de conexión -->
//               <span style="content: \'\'; position: absolute; left: -10px; top: 50%; width: 15px; height: 2px; background-color: white;"></span>
//       <p>&nbsp;&nbsp;Buscar Formularios terminados</p>
//       </a>
//     </li>
 

//   </ul>
//   </li>';
// }

include(__DIR__ . '/../../config/Conexion.php');

// Consulta para obtener los módulos con sus permisos
$consultaModulos = "
    SELECT m.nombreCarpeta, m.nombreModulo, p.nombre AS nombrePermiso
    FROM Modulos m
    INNER JOIN permiso p ON p.idpermiso = m.idPermiso
";
$resultadoModulos = $conexion->query($consultaModulos);

// Consulta para obtener los submódulos con sus permisos y asociarlos a sus módulos
$consultaSubmodulos = "
    SELECT sm.nombreSubmodulo, sm.nombreArchivoPHP, m.nombreModulo, m.nombreCarpeta, p.nombre AS nombrePermiso
    FROM Submodulos sm
    INNER JOIN Modulos m ON sm.idModulo = m.id
    INNER JOIN permiso p ON p.idpermiso = sm.idPermiso
";
$resultadoSubmodulos = $conexion->query($consultaSubmodulos);

// Inicializamos un array para almacenar los módulos y sus submódulos
$menu = [];

// Procesamos los resultados de los módulos
while ($fila = $resultadoModulos->fetch_assoc()) {
    // Verificamos si el permiso del módulo está en la sesión y está habilitado
    if (isset($_SESSION[$fila['nombrePermiso']]) && $_SESSION[$fila['nombrePermiso']] == 1) {
        // Si el módulo no está en el array $menu, lo agregamos
        if (!isset($menu[$fila['nombreModulo']])) {
            $menu[$fila['nombreModulo']] = [
                'nombreModulo' => $fila['nombreModulo'],
                'nombreCarpeta' => $fila['nombreCarpeta'],
                'submodulos' => []
            ];
        }
    }
}

// Procesamos los resultados de los submódulos
while ($fila = $resultadoSubmodulos->fetch_assoc()) {
    // Verificamos si el permiso del submódulo está en la sesión y está habilitado
    if (isset($_SESSION[$fila['nombrePermiso']]) && $_SESSION[$fila['nombrePermiso']] == 1) {
        // Si el módulo correspondiente no está en $menu, lo agregamos (para incluir submódulos sin módulo previo)
        if (!isset($menu[$fila['nombreModulo']])) {
            $menu[$fila['nombreModulo']] = [
                'nombreModulo' => $fila['nombreModulo'],
                'nombreCarpeta' => $fila['nombreCarpeta'],
                'submodulos' => []
            ];
        }

        // Agregamos el submódulo al módulo correspondiente
        $menu[$fila['nombreModulo']]['submodulos'][] = [
            'nombreSubmodulo' => $fila['nombreSubmodulo'],
            'nombreArchivoPHP' => $fila['nombreArchivoPHP']
        ];
    }
}

// Generamos el menú dinámico basado en los módulos y submódulos de la base de datos
foreach ($menu as $modulo) {
    echo '<li class="nav-item">
            <a href="#" class="nav-link active" style="background-color: #066E45;">
                <i class="fa-solid fa-hospital-user"></i>
                <p>&nbsp;&nbsp;' . htmlspecialchars($modulo['nombreModulo']) . '&nbsp;<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview" style="display: none; padding-left: 20px;">';
    
    // Para cada submódulo, generamos un enlace
    foreach ($modulo['submodulos'] as $submodulo) {
        // Verificamos si el valor de 'nombreCarpeta' existe para evitar errores de clave indefinida
        $nombreCarpeta = isset($modulo['nombreCarpeta']) ? htmlspecialchars($modulo['nombreCarpeta']) : '';
        $nombreArchivoPHP = isset($submodulo['nombreArchivoPHP']) ? htmlspecialchars($submodulo['nombreArchivoPHP']) : '';

        echo '<li class="nav-item" style="position: relative;">
                <a href="http://localhost/SaludMod/Modulos/' . $nombreCarpeta . '/view/' . $nombreArchivoPHP . '" class="nav-link submodule-link" style="position: relative;">
                    <p>&nbsp;&nbsp;' . htmlspecialchars($submodulo['nombreSubmodulo']) . '</p>
                </a>
              </li>';
    }

    echo '</ul></li>';
}
if (isset($_SESSION['acceso']) && $_SESSION['acceso'] == 1) {
  echo '<li class="nav-item">
          <a href="#" class="nav-link active" style="background-color: #006941;">
              <i class="nav-icon fas fa-key"></i>
              <p>Acceso<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview" style="display: none;">
              <li class="nav-item"><a href="'.BASE_URL.'../view/usuarios.php" class="nav-link"><i class="far fa-check-circle nav-icon"></i><p>Usuarios</p></a></li>
              <li class="nav-item"><a href="'.BASE_URL.'../view/permisos.php" class="nav-link"><i class="far fa-check-circle nav-icon"></i><p>Permisos</p></a></li>
          </ul>
        </li>';
}
echo '</ul>';

// Generamos el menú de acceso


?>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

  <script>
    var loading_container = document.getElementById('loading_container');

    window.addEventListener("load", function() {
      loading_container.style.opacity = '0';
      setTimeout(() => {
        loading_container.style.display = 'none';
      }, 100);

      
    });



    document.querySelectorAll('.input-field input').forEach(input => {
    if (input.value) {
        input.classList.add('valid');
    }

    input.addEventListener('input', () => {
        if (input.value) {
            input.classList.add('valid');
        } else {
            input.classList.remove('valid');
        }
    });
});

  </script>
