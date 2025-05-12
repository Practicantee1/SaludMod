<script>
    <?php
    include('../../../logica/ApiSap.php');



    $IdNumber = isset($_POST["IDNumber"]) ? $_POST["IDNumber"] : "0";
    $IdUbicacion_cama = isset($_POST["IdUbicacion_cama"]) ? $_POST["IdUbicacion_cama"] : "0";

    $DataPaciente = getApi(0, $IdNumber);
    ?>
    <?php



    //Verificar si la cedula del paciente encuentra datos en la API
    if (($DataPaciente !== null) && array_key_exists('DatosPaciente', $DataPaciente) && !is_null($DataPaciente['DatosPaciente'])) {

        $DatosBasicos = $DataPaciente["DatosPaciente"];

    ?>
        document.getElementById("FullName").value = '<?php echo $DatosBasicos["Nombre_completo"] ?>';
        document.getElementById("Age").value = '<?php echo $DatosBasicos["Edad"] ?>';
        document.getElementById("segundoApellido").value = '<?php echo $DatosBasicos["Segundo_apellido"] ?>';
        document.getElementById("TipoDocumento").value = '<?php echo $DatosBasicos["Desc_documento"] ?>';
        document.getElementById("documento").value = '<?php echo $DatosBasicos["Numero_documento"] ?>';
        // document.getElementById("IDNumero").value = '<?php echo $DatosBasicos["Numero_documento"] ?>';
        document.getElementById("nombre").value = '<?php echo $DatosBasicos["Primer_nombre"] ?>';
        document.getElementById("primerApellido").value = '<?php echo $DatosBasicos["Primer_apellido"] ?>';

        <?php


        //Verificar si el ultimo episodio del paciente tiene alguna observación
        if (array_key_exists('DatosEpisodio', $DataPaciente) && !is_null($DataPaciente['DatosEpisodio'])) {

            $DatosEpisodio = $DataPaciente['DatosEpisodio'];

            if (!(array_key_exists('MessageUbicacionEpisodio', $DatosEpisodio))) {

                if (array_key_exists('DatosUltimoEpisodio', $DataPaciente)) {
                    $DatosExtra = $DataPaciente["DatosUltimoEpisodio"];

                    

        ?>
                    document.getElementById("DateServiceStarted").value = '<?php echo $DatosExtra["F_Inicio_atencion"] ?>';
                    document.getElementById("Status").value = '<?php echo $DatosExtra["Clase_Episodio"] ?>';

                    if ('<?php echo $DatosExtra["Clase_Episodio"] ?>' === 'AMBULATORIO') {
        Swal.fire({
            icon: 'warning',
            title: 'Paciente en estado ambulatorio',
            text: 'Este paciente no permite registrar acompañante.',
            background: '#ffffff',
            color: '#d97706', // Naranja oscuro
            showConfirmButton: false,
            timer: 3000,
            customClass: {
                popup: 'swal2-professional-warning'
            }
        });

        document.getElementById("Search-acompanante").disabled = true;
    } else {
        //document.getElementById("Search-acompanante").disabled = false;
    }

                <?php

                }

                if (array_key_exists('Ubicacion', $DatosEpisodio)) {
                    $UbicacionPaciente = $DatosEpisodio["Ubicacion"];

                ?>
                    document.getElementById("Block").value = '<?php echo $UbicacionPaciente["Unidad_Organizativa"] ?>';

                    document.getElementById("Ward").value = '<?php echo $UbicacionPaciente["UbicacionEdificio"] ?>';

                    document.getElementById("Bed").value = '<?php echo $UbicacionPaciente["Ubicacion_cama"] ?>';

                    document.getElementById("Bed_code").value = '<?php echo $UbicacionPaciente["IdUbicacion_cama"] ?>';

                    document.getElementById("Bedcode").value = '<?php echo $UbicacionPaciente["IdUbicacion_cama"] ?>';




                    document.getElementById("Status").value = '<?php echo $DatosExtra["Clase_Episodio"] ?>';

                <?php

                }
            } else {

                //Verificar si el paciente ya ha sido dado de alta
                if ($DatosEpisodio['MessageUbicacionEpisodio'] == 'Episodio en estado Alta.') {
                ?>
                    document.getElementById("Status").value = 'De Alta';

                    document.getElementById("Ward").value = '---';
                    document.getElementById("Age").value = '---';
                    document.getElementById("DateServiceStarted").value = '---';
                    document.getElementById("Bed").value = '---';
                    document.getElementById("Bed_code").value = '---';
                    document.getElementById("Block").value = '---';

                    // Deshabilitar el botón de abrir modal
                    // document.getElementById("#Search-acompanante").disabled = true;
                    Swal.fire({
                        icon: 'success',
                        title: 'Paciente ya ha sido dado de alta',
                        background: '#fffff', // Verde clarito (fondo suave)
                        color: '#065f46', // Verde oscuro para el texto
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: {
                            popup: 'swal2-professional-success'
                        }
                    });


                    document.getElementById("Search-acompanante").disabled = true;
        <?php

                }
            }
        }
    } else {

        ?>
        document.getElementById("Status").value = "";
        document.getElementById("FullName").value = "";
        document.getElementById("Age").value = "";
        document.getElementById("DateServiceStarted").value = "";
        document.getElementById("Ward").value = "";
        document.getElementById("Bed").value = "";
        document.getElementById("Bed_code").value = "";
        document.getElementById("Block").value = "";
        let num = '<?php echo $IdNumber ?>';
        console.log("numero:" + num);
        Swal.fire({
            icon: 'info',
            title: 'Documento no encontrado',
            text: 'El número de documento ingresado no se encuentra registrado.',
            background: '#ffffff', // Azul muy claro
            color: '#1e3a8a', // Azul oscuro para el texto
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'swal2-professional-info'
            }
        });

        document.getElementById("Search-acompanante").disabled = true;
    <?php

    }

    ?>
</script>