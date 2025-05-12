var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

    $("#formGoogle").on("submit", function (e) {
        guardaryeditar(e, 2);
    })

    // $("#imagenmuestra").hide();
    //Mostramos los permisos
    $.post("../controller/usuario.php?op=permisos&id=", function (r) {
        $("#permisos").html(r);
    });

    $.post("../controller/usuario.php?op=rolesGoogle&id=", function (r) {
        $("#rolesGoogle").html(r);
    });
    
}

//Función limpiar
function limpiar() {
    $("#nombre").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#emailGoogle").val("");
    
    $("#idusuario").val("");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag == "Manual") {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#formulariogoogle").hide();
        $("#btnGuardar").prop("disabled", false);
        $("btnRegistrar").prop("disabled", true);
        $("#btnagregar").hide();
        $("#btnAddGoogle").hide();
    } 
    else if(flag == "Google"){
        $("#listadoregistros").hide();
        $("#formularioregistros").hide();
        $("#formulariogoogle").show();
        $("#btnRegistrar").prop("disabled", false);
        $("#btnGuardar").prop("disabled", true);
        $("#btnagregar").hide();
        $("#btnAddGoogle").hide();
    }
    else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#formulariogoogle").hide();
        $("#btnagregar").show();
        $("#btnAddGoogle").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        /*"scrollY": 200,  navegar en el datatable
        "scrollX": true, */
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        
        responsive: true,
        "scrollX": true,

        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        lengthMenu: [
            [ 5, 10, 25, 50, -1 ],
            [ '5 filas','10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
        ],
        buttons: [
                  {
                        extend: 'pageLength',
                        text: 'LONGITUD DE LA PÁGINA',
                   },
                    {
                        extend: 'print',
                        text: 'IMPRIMIR',
                        title: 'Usuarios'
                    },
                    {
                        extend: 'pdf',
                        text: 'DESCARGAR PDF',
                        title: 'Usuarios'
                    },
		        ],
        "ajax": {
            url: '../controller/usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 20, //Paginación
        "order": [[0, "desc"]], //Ordenar (columna,orden)
        language: {
            zeroRecords: 'No hay registros para mostrar.',
            info: "Mostrando página _PAGE_ de _PAGES_ páginas",
            search: 'BUSCAR',
            emptyTable: 'La tabla está vacia.',
            "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Ultimo",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior",
            }
        }
    }).DataTable();
}

//Función para guardar o editar

function guardaryeditar(e, Opt = 1) {
    e.preventDefault(); //No se activará la acción predeterminada del evento

    var formData;
    if (Opt == 1) {
        $("#btnGuardar").prop("disabled", true);
        formData = new FormData($("#formulario")[0]);
    }
    if (Opt == 2) {
        $("#btnRegistrar").prop("disabled", true);
        formData = new FormData($("#formGoogle")[0]);
    }
    

    $.ajax({
        url: "../controller/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            console.log(datos);
            if (datos ==  1) {
                Swal.fire({
                    
                    icon: 'success',
                    title: 'Usuario registrado',
                    showConfirmButton: false,
                    timer: 1500
                })

            } else if (datos == 3) {
                
                Swal.fire({
                    
                    icon: 'success',
                    title: 'Usuario actualizado',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else if (datos == 2) {
                Swal.fire({
                    
                    icon: 'error',
                    title: 'No se pudo registrar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }else if (datos == 4){
                Swal.fire({
                    
                    icon: 'error',
                    title: 'No se pudo actualizar',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
            
            mostrarform(false);
            tabla.ajax.reload();
        }

    });
    limpiar();
}

function mostrar(idusuario) {
    
    $.post("../controller/usuario.php?op=mostrar", {
        idusuario: idusuario
    }, function (data, status) {
        data = JSON.parse(data);
        mostrarform('Manual');
        
        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento).trigger("change");
        $("#num_documento").val(data.num_documento);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#login").val(data.login);
        $("#clave").val(data.clave);
        $("#idusuario").val(data.idusuario);

    });
    $.post("../controller/usuario.php?op=permisos&id=" + idusuario, function (r) {
        $("#permisos").html(r);
    });
}

//Función para desactivar registros
function desactivar(idusuario) {



    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'DESACTIVAR USUARIO',
        text: "Esta acción influye sobre el acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Desactivar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../controller/usuario.php?op=desactivar", {
                idusuario: idusuario
            }, function (e) {
                tabla.ajax.reload();
            });
            Swal.fire({
                icon: 'success',
                title: 'Desactivado con éxito.',
                showConfirmButton: false,
                timer: 1500
            })
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire({
                
                icon: 'error',
                title: 'Se cancelo la desactivación',
                showConfirmButton: false,
                timer: 1500
            })
        }
    })

}

//Función para activar registros
function activar(idusuario) {

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: 'ACTIVAR USUARIO',
        text: "Esta acción influye sobre el Acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si, Activar!',
        cancelButtonText: 'No, cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            $.post("../controller/usuario.php?op=activar", {
                idusuario: idusuario
            }, function (e) {
                tabla.ajax.reload();
            });
            Swal.fire({
                
                icon: 'success',
                title: 'Activado con éxito.',
                showConfirmButton: false,
                timer: 1500
            })
        } else if (
            /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire({
                
                icon: 'error',
                title: 'Se cancelo la activación',
                showConfirmButton: false,
                timer: 1500
            })
        }
    })
}

init();
