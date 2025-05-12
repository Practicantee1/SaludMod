<?php
// Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    $_SESSION["PrePage"] = "../Modulos/odontograma/odontograma.php";
    header("Location: ../../../view/login.php");
} else {
    define('BASE_URL', '../../');
    $pageTitle = "Gestion de modulos";
    $_SESSION['module_title'] = "GESTION DE MODULOS";

    require_once '../../../view/template/header.php';

    if ($_SESSION['Gestion de modulos'] == 1) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/estilosDMD.css">
    <link rel="stylesheet" href="CSS/Consultar.css">
</head>
<style>
    .btn-aceptar {
        background-color: #066E45;
        width: 180px;
        height: 50px;
        border-radius: 15px;
        color: #fff;
        border: 1px solid #ccc;
        transition: all .2s;
        box-shadow: 0 0 4px #000;
    }

    .btn-aceptar:hover {
        background-color: #93C020;
    }

    .lb-opcion {
        font-size: 2rem;
        font-weight: 500;
    }

    h1, h2, h3, h4, h5, h6, body {
        margin: 0;
    }

    .opcion-content {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .buttons {
        display: flex;
        gap: 30px;
    }

    .input{
        width: 90%;
    }

    .oculto{
        opacity: 0;
    }
</style>
<body>
<div class="content-wrapper">
    <div id="alertContainer" class="alert" role="alert">
    </div>
    <div class="container">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8">
                <div class="well">
                    <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style="background-color:#F4F6F9 ;">GESTION DE MODULOS</span></h4>
                </div>
                <div class="opcion-content">
                    <h3 class="lb-opcion">Elige una opción:</h3>
                    <div class="buttons">
                        <button id="btn-agregar" class="btn-aceptar"><i class="fa-solid fa-plus"></i> Agregar un nuevo modulo</button>
                        <button id="btn-editar" class="btn-aceptar"><i class="fa-regular fa-pen-to-square"></i> Agregar un nuevo Submodulo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container " id="nuevoModulo">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8">
                <div class="well">
                    <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style="background-color:#F4F6F9 ;">NUEVO MODULO</span></h4>
                </div>
                <div id="nuevo-modulo" style="display: flex; flex-direction: column;">
                    <div style="display: flex; height:4rem;">
                        <div class="form-group col-md-4 input-field" style="display: flex;height: 46px; margin-bottom:40px">
                            <input type="text" id="idNombre" class="input" required >
                            <label for="idNombre">Nombre del modulo</label> 
                        </div>
                        <div class="form-group col-md-4 input-field" style="display: flex;height: 46px; margin-bottom:40px">
                            <input type="text" id="idNombreCarpeta" class="input" required >
                            <label for="idNombre">Nombre de la carpeta</label> 
                        </div>
                    </div>
                    <div class="well">
                        <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style="background-color:#F4F6F9 ;">SUBMODULOS</span></h4>
                    </div>
                    <div id="nuevos-submodulos" style="display:flex;">
                        <div class="div-submodulos form-group col-md-3 flex input-field" style="margin-bottom:40px">
                            <input type="text" class="input nombreSubmodulo" id="submodulo1" required>
                            <label>Submodulo</label>
                        </div>
                        <div class="div-submodulos form-group col-md-4 flex input-field" style="margin-bottom:40px">
                            <input type="text" class="input nombreArchivo" id="nombreArchivo1" required>
                            <label>Nombre del Archivo (.php)</label>
                        </div>
                        <div class="div-submodulos form-group col-md-3 flex input-field" style="margin-bottom:40px">
                            <input type="text" class="input permiso" id="permiso" required>
                            <label>Permiso</label>
                        </div>
                        <div class="buttons col-md-2">
                            <button class="btn-Submodulo btn-aceptar" style="width: 40%;"><i class="fa-regular fa-pen-to-square" style="width: 100%;"></i></button>
                        </div>  
                    </div>
                </div>
                <div style="display:flex; justify-content: center">
                    <button id="btn-guardar" class="btn-aceptar"><i class="fa-regular fa-floppy-disk"></i> Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container" id="EditarModulo">
        <div class="col-md-15">
            <div class="card shadow p-3 mb-8">
                <div class="well">
                    <h4 class="form-label text-divider-Epid"><span class="left-span"></span><span style="background-color:#F4F6F9 ;">NUEVO SUBMODULO</span></h4>
                </div>
                <div id="SubmodulosNuevos">
                    <div class="form-group col-md-7 flex" style="margin-bottom:50px">
                    <select name="" id="select-modulo" class="input">
                        <option disabled selected>Seleccione un modulo</option>
                        <?php
                            // Ejecutar el procedimiento almacenado
                            $sql = "CALL SP_consultarModulos()";
                            $query = $conexion->query($sql);

                            // Verificar si hay resultados y generar las opciones del select
                            if ($query && $query->num_rows > 0) {
                                while ($row = $query->fetch_assoc()) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nombreModulo'] . '</option>';
                                }
                            } else {
                                echo '<option disabled>No hay módulos disponibles</option>';
                            }
                            
                            // Liberar los resultados
                            $query->free();
                            
                            // Cerrar la conexión si no se necesita más
                            $conexion->close();
                        ?>
                    </select>
                    </div>
                    <div class="submodulos" style="display:flex;">
                        <div  class="div-nuevoSubmodulo form-group col-md-3 flex input-field" style="margin-bottom:40px">
                            <input type="text" class="input nombreSubmodulo" required>
                            <label>Submodulo</label>
                        </div>
                        <div  class="div-nuevoSubmodulo form-group col-md-4 flex input-field" style="margin-bottom:40px">
                            <input type="text" class="input nombreArchivo" required>
                            <label>Nombre del Archivo (.php)</label>
                        </div>
                        <div  class="div-nuevoSubmodulo form-group col-md-3 flex input-field" style="margin-bottom:40px">
                            <input type="text" class="input permiso" required>
                            <label>Permiso</label>
                        </div>
                        <div class="buttons col-md-2">
                            <button class="btn-SubmoduloNuevo btn-aceptar" style="width: 25%;"><i class="fa-regular fa-pen-to-square" style="width: 100%;"></i></button>
                        </div>  
                    </div>
                </div>
                <button id="btn-guardarSubmodulos" class="btn-aceptar"><i class="fa-regular fa-floppy-disk"></i> Guardar cambios</button>
            </div>
        </div>
    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../control/agregarModulos.js"></script>
<script src="../control/agregarSubmodulo.js"></script>
</body>
</html>

<?php
    } else {
        require_once '../../../view/noacceso.php';
    }

    require_once '../../../view/template/footer.php';
}
ob_end_flush();
?>