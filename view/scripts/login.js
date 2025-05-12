
if ($("#frmAcceso").length) {
    $("#frmAcceso").on('submit', function (e) {
        e.preventDefault();
        
        logina = $("#logina").val();
        clavea = $("#clavea").val();
        
        
        loginOptions(logina, clavea);

                
    });
}



function loginOptions(logina, clavea){
    $.post("../controller/usuario.php?op=verificar",
        { "logina": logina, "clavea": clavea },
        function (rawData) {
            realData = rawData.split(",");
        
        if(realData[0] == String(1) || realData[0] == 1) {
            var genericPasswords = "1234";
            realData[2] = realData[2].replace(/\s/g, '');
            if (genericPasswords == String(realData[2])) {
                Swal.fire({
                    title: "Cambiar Contraseña",
                    text: "Debes cambiar la contraseña y proporcionar una pregunta secreta",
                    icon: "warning",
                    confirmButtonText: "Cambiar Contraseña",
                }).then((result) => {
                    if (result.isConfirmed) {
                        
                        $(location).attr("href", "../view/configurar_contrasena.php");
                    }
                });
            }else{
                $(location).attr("href", realData[1]);
            }
        }
        else{
            $.post("../controller/usuario.php?op=directorioactivo",
            { "logina": logina, "clavea": clavea },
            function (realData) {
                
                arrayData = realData.split(/\r?\n/g);
                data = arrayData[1];
                realData = data.split(",");

                if (realData[0] == String(1) || realData[0] == 1) {
                    $(location).attr("href", realData[1]);        

                }
                else if(realData[0] == String(3) || realData[0] == 3){
                    Swal.fire("ACCESO RESTRINGIDO", "No tiene permitido usar este aplicativo", "info"); 

                }   
                else if(realData[0] == String(4) || realData[0] == 4){
                    Swal.fire("ROL NO ENCONTRADO", "Usted no tiene un rol asignado", "info");
                }
                else{
                    Swal.fire("Credenciales Incorrectas", "Por favor, verifique", "warning");
                }
                
            });
        }
    }); 
    
}