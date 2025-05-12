// Crear submódulo
$(document).on("click", ".btn-SubmoduloNuevo", function () {
    let completo = true;

    // Verificar si todos los inputs están completos
    $(".div-nuevoSubmodulo .input").each(function () {
        if ($(this).val().trim() === "") {
            completo = false;    
            alert("s");
            return false; 
        }
    });

    if (completo) {
        // Crear el contenedor de nuevos submódulos
        const nuevosSubmodulos = $('<div class="submodulos" style="display:flex;"></div>');

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
        const boton = $("<button class='btn-remover btn-aceptar' style='background-color: #C02020; width: 25%'><i class='fa-solid fa-trash'></i></button>");
        const boton2 = $("<button class='btn-aceptar btn-SubmoduloNuevo' style='width: 25%; margin-right: 25%;'><i class='fa-regular fa-pen-to-square' style='width: 100%;'></i></button>");

        divPermisos.append(inputPermisos, labelPermisos);
        
        divNombreArchivo.append(inputNombreArchivo, labelNombreArchivo); 
        divBoton.append(boton2, boton); 

        // Agregar los nuevos elementos al contenedor principal
        nuevosSubmodulos.append(divSubmodulo, divNombreArchivo, divPermisos, divBoton);
        
        $("#SubmodulosNuevos").append(nuevosSubmodulos);
    }
});


$("#btn-guardarSubmodulos").click(function () {

    let idModulo = $("#select-modulo option:selected").val();
    let submodulo1 = $("#submodulo1").val();
    let nombreArchivo1 = $("#nombreArchivo1").val();
    let permiso1 = $("#permiso").val() 

    let datos = [];


    $(".submodulos").each(function () {
        let submodulo = $(this).find(".nombreSubmodulo").val();
        let nombreArchivo = $(this).find(".nombreArchivo").val();
        let permiso1 = $(this).find(".permiso").val();

        datos.push({
            submodulo: submodulo,
            nombreArchivo: nombreArchivo,
            permiso: permiso1
        });
        console.log(datos, idModulo);
        
    });
    if(idModulo != "" && permiso != ""){
        $.ajax({
            type: "POST",
            url: '../logica/agregarSubmodulos.php',
            data: {
                idModulo: idModulo,
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
