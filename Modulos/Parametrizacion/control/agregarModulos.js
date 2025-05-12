
$(document).ready(function(){
    $("#nuevoModulo").hide();   
    $("#EditarModulo").hide();   
})

$("#btn-agregar").click(function(){
    $("#EditarModulo").hide();
    $("#nuevoModulo").show();
})

$("#btn-editar").click(function(){
    $("#nuevoModulo").hide();
    $("#EditarModulo").show();
})

// Crear submódulo
$(document).on("click", ".btn-Submodulo", function () {
    let completo = true;

    // Verificar si todos los inputs están completos
    $("#div-submodulos .input").each(function () {
        if ($(this).val().trim() === "") {
            completo = false;
            return false; 
        }
    });

    if (completo) {
        // Crear el contenedor de nuevos submódulos
        const nuevosSubmodulos = $('<div class="nuevos-submodulos" style="display:flex;"></div>');

        // Crear el submódulo de entrada
        const divSubmodulo = $('<div class="form-group col-md-3 flex input-field" style="margin-bottom:40px"></div>');
        const inputSubmodulo = $('<input type="text" class="input nombreSubmodulo" required>');
        const labelSubmodulo = $('<label>Submodulo</label>');
        
        divSubmodulo.append(inputSubmodulo, labelSubmodulo); 

        // Crear el campo de nombre de archivo
        const divNombreArchivo = $('<div class="form-group col-md-4 flex input-field" style="margin-bottom:40px"></div>');
        const inputNombreArchivo = $('<input type="text" class="input nombreArchivo" required>');
        const labelNombreArchivo = $('<label>Nombre del Archivo</label>');

        // Crear el campo de permisos
        const divPermisos = $('<div id="div-submodulos" class="form-group col-md-3 flex input-field" style="margin-bottom:40px">');
        const inputPermisos = $('<input type="text" class="input permiso" required>');
        const labelPermisos = $('<label>Permiso</label>');

        // Crear el botón de eliminación y el botón de agregar
        const divBoton = $('<div id="div-submodulos" class="form-group col-md-2 flex input-field" style="margin-bottom:40px">');
        const boton = $("<button class='btn-remover btn-aceptar' style='background-color: #C02020; width: 5%'><i class='fa-solid fa-trash'></i></button>");
        const boton2 = $("<button class='btn-aceptar btn-Submodulo' style='width: 5%; margin-right: 5%;'><i class='fa-regular fa-pen-to-square' style='width: 100%;'></i></button>");

        divPermisos.append(inputPermisos, labelPermisos);
        
        divNombreArchivo.append(inputNombreArchivo, labelNombreArchivo); 

        // Agregar los nuevos elementos al contenedor principal
        nuevosSubmodulos.append(divSubmodulo, divNombreArchivo, divPermisos, boton2, boton);
        
        $("#nuevo-modulo").append(nuevosSubmodulos);
    }
});
// Evento delegado para el botón de remover
$(document).on("click", ".btn-remover", function () {
    // Usamos $(this).closest(".nuevos-submodulos") para eliminar solo el contenedor del submódulo correspondiente
    $(this).closest(".nuevos-submodulos").remove();
});


$("#btn-guardar").click(function () {

    let nombreModulo = $("#idNombre").val().trim();
    let nombreCarpeta = $("#idNombreCarpeta").val().trim();
    let submodulo1 = $("#submodulo1").val();
    let nombreArchivo1 = $("#nombreArchivo1").val();
    let permiso1 = $("#permiso").val() 

    let datos = [];
    datos.push({
                submodulo: submodulo1,
                nombreArchivo: nombreArchivo1,
                permiso:permiso1
            });

    $(".nuevos-submodulos").each(function () {
        let submodulo = $(this).find(".nombreSubmodulo").val();
        let nombreArchivo = $(this).find(".nombreArchivo").val();
        let permiso1 = $(this).find(".permiso").val();

        datos.push({
            submodulo: submodulo,
            nombreArchivo: nombreArchivo,
            permiso: permiso1
        });
    });
    console.log(datos, nombreModulo);
    if(nombreModulo != "" && permiso != ""){
    Swal.fire({
    title: "¿Estás seguro de que deseas crear este nuevo módulo?",
    text: "Muestra",
    html: `
        <ul id="ul-navbar" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
            <a href="#" class="nav-link active" style="background-color: #066E45;">
                <i class="fa-solid fa-hospital-user"></i>
                    <p>${nombreModulo}<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    ${datos.map(dato => `
                        <li class="nav-item" style="position: relative;">
                            <a class="nav-link submodule-link" style="position: relative;">
                                <p>${dato.submodulo}</p>
                            </a>
                        </li>
                    `).join('')}
                </ul>
            </li>
        </ul>
    `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#066E45",
        cancelButtonColor: "#C02020",
        confirmButtonText: "Si, deseo crear este modulo!",
        cancelButtonText: "Cancelar"
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: '../logica/Modulos.php',
                data: {
                    nombreModulo: nombreModulo,
                    nombreCarpeta:nombreCarpeta,
                    submodulos: JSON.stringify(datos)  // Convierte el array 'datos' a JSON
                },
                success: function(response) {
                    console.log("se guardó:", response);
                    Swal.fire({
                        title: "Modulo creado!",
                        text: "Por favor agregue el permiso y vuelva a loguearse.",
                        icon: "success"
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        }
    });
    }else{
        Swal.fire({
            title: "Por favor digita los campos antes de enviar",
            icon: "warning"
        });
    }
});
