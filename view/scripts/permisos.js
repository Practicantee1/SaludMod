$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: '../model/Permisos.php',
        success: function (response) {
            try {
                // Verificar si `response` es un objeto o una cadena
                const data = typeof response === "string" ? JSON.parse(response) : response;

                // Agrupar los datos
                const groupedData = data.reduce((result, current) => {
                    // Buscar si ya existe un módulo con el id actual
                    let modulo = result.find(mod => mod.id === current.id);

                    // Si no existe, crear uno nuevo
                    if (!modulo) {
                        modulo = {
                            id: current.id,
                            nombreModulo: current.nombreModulo,
                            submodulos: [] // Lista para los submódulos
                        };
                        result.push(modulo);
                    }

                    // Agregar el submódulo actual al módulo encontrado/creado
                    modulo.submodulos.push({
                        nombreSubmodulo: current.nombreSubmodulo,
                        idPermiso: current.idPermiso,
                        nombre: current.nombre
                    });

                    return result;
                }, []);

                console.log(groupedData);

                const contentModulos = $("#content-modulos");

                // Usar groupedData para generar la estructura
                groupedData.forEach(modulo => {
                    // Crear el contenedor del módulo
                    const moduloContainer = $(`
                        <div class="grid-container">
                            <h5 class="titulo-modulo">${modulo.nombreModulo} <i class="fa-solid fa-chevron-down"></i></h5>
                            <div class="submodulos-container" style="display: none;"></div>
                        </div>
                    `);
                
                    // Iterar sobre los submódulos
                    const submodulosContainer = moduloContainer.find('.submodulos-container');
                    modulo.submodulos.forEach((submodulo, index)=> {
                        // Crear el contenedor del submódulo
                        const submoduloContainer = $(`
                            <div class="sub-container">
                                <h4 style="text-align:center;">Submodulo ${index + 1} </h4>
                                <label for="">Nombre: <span>${submodulo.nombreSubmodulo}<span></label>
                                <div class="permisos-submodulo">
                                    <label for="">Permiso: ${submodulo.nombre}</label>
                                </div>
                            </div>
                        `);
                
                        // Agregar el submódulo al contenedor de submódulos
                        submodulosContainer.append(submoduloContainer);
                    });
                
                    // Agregar evento de clic al título del módulo
                    moduloContainer.find('.titulo-modulo').on('click', function () {
                        // Mostrar u ocultar los submódulos
                        submodulosContainer.slideToggle();
                    });
                
                    // Agregar el módulo completo al contenedor principal
                    contentModulos.append(moduloContainer);
                });
                moduloContainer.find('.titulo-modulo').on('click', function () {
                    submodulosContainer.slideToggle();
                });
            } catch (error) {
                console.error("Error processing data:", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX request failed:", error);
        }
    });
});


$(document).ready(function() {
    // Agregar evento de clic al título del módulo
    $('.titulo-modulo').on('click', function() {
      // Seleccionar el contenedor del submódulo dentro del mismo módulo
      var submodulosContainer = $(this).closest('.grid-container').find('.submodulos-container');
      
      // Animar la altura del contenedor para mostrar u ocultar con transición suave
      submodulosContainer.stop(true, true).slideToggle(300); // 300ms para la animación
    });
  });

$("#cancelarPermiso").click(function(){
    $("#modal-permiso").attr("hidden", true);
})

$("#agregarPermiso").click(function(){
    $("#modal-permiso").removeAttr("hidden");
})

$("#guardarPermiso").click(function(){
    let nombre = $("#nombrePermiso").val();
    $.ajax({
        type: "POST",
        url: '../model/Permisos.php',
        data: {
            nombre: nombre  // Convierte el array 'datos' a JSON
        },
        success: function(response) {
            console.log("se guardó:", response);
            Swal.fire({
                title: "Permiso creado!",
                icon: "success"
            });
            $("#modal-permiso").attr("hidden", true);
            $("#nombrePermiso").val("");
        },
        error: function(xhr, status, error) {
            console.error("AJAX request failed:", error);
        }
    });
})