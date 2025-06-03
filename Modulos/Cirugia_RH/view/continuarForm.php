<?php
//Activamos el almacenamiento en el buffer
include('../../../config/Conexion.php');
ob_start();

session_start();

foreach ($_GET as $key => $value) {
    $_SESSION[$key] = $value;
}

if (!isset($_SESSION["nombre"])) {

    $_SESSION["PrePage"] = "../Modulos/Cirugia_RH/view/cirugia.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Completar Formularios";

    require_once '../../../view/template/header.php';

    if ($_SESSION['completar_procedimiento'] == 1) {

?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>../Modulos/Cirugia_RH/view/CSS/estilos_completar.css">
    <div class="content-wrapper">
    <div id="alertContainer" class="alert" role="alert"></div>
    <!--- Content Header (Page header) ----->
    <div class="container" style="overflow-y: hidden;">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8">
                <div class="card-header">
                    <div class="row" id="MainTittle-UbiCitas">
                        <div class="col-20 text-center" style="top: -15px;">
                            <h2 class="text-success" style="margin-top: 15px;">Formularios incompletos de cirugía</h2>
                        </div>
                    </div>
                    
                    <br>
                    <h4 class="form-label text-divider-r"><span class="left-span"></span><span>COMPLETAR FORMULARIOS</span></h4>
                    <br>
                    <div class="div_contenedor">
                        <div class="table-responsive"> <!-- Asegúrate de que este div contenga la tabla -->
                            <table class="table">
                            <thead class="thead-light">
                                    <tr>
                                        <th class="text-center bg-success">Fecha </th>
                                        <th class="text-center bg-success">N episodio</th>
                                        <th class="text-center bg-success">N documento</th>
                                        <th class="text-center bg-success">Nombre paciente</th>
                                        <th class="text-center bg-success">Primera Pausa</th>
                                        <th class="text-center bg-success">Segunda Pausa</th>
                                        <th class="text-center bg-success">Tercera Pausa</th>
                                        <th class="text-center bg-success">Firma entrada</th>
                                        <th class="text-center bg-success">Firma Salida</th>
                                        <th class="text-center bg-success">Continuar</th> <!-- Nueva columna para el botón "Completar" -->
                                    </tr>
                                </thead>
                                <tbody id="registroTablaBody" style="font-family: Arial, sans-serif; font-size: 15px; text-align: left; background-color: #dedede;">
                                    <!-- Aquí se agregarán las filas dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
        </div>
        <br><br>
    </div>
</div>


<script>
        function completarFormulario(episodio) {
    $.ajax({
        type: "POST",
        url: "completarFormulario.php",
        data: { episodio: episodio },
        success: function(response) {
            // Aquí puedes manejar la respuesta del servidor
            console.log("episodio enviado con éxito.");
            // Si necesitas redirigir después de la respuesta exitosa
            // window.location.href = "nueva_pagina.php"; 
        },
        error: function(xhr, status, error) {
            // Manejo de errores
            console.error("Error al enviar el episodio: " + error);
        }
    });
}
</script>

    <?php
    } else {
        require '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';
    ?>

<?php
}
ob_end_flush();
?>

<script src="../control/JS/incompletosForm.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
