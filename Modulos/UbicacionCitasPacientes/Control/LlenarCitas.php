<script>
<?php
include('../../../logica/ApiSap.php');

$IdNumber = isset($_POST["IDNumber"]) ? $_POST["IDNumber"] : "";

    $DataPaciente = getAppointmentList($IdNumber);

    if ($DataPaciente !== null && array_key_exists('PatientDetails', $DataPaciente) && !is_null($DataPaciente['PatientDetails'])) {
        $DatosPaciente = $DataPaciente["PatientDetails"];
        ?>
        document.getElementById("FullName").value = '<?php echo $DatosPaciente["Nom_paciente"] ?>';

        var citas = <?php echo json_encode($DatosPaciente["AppointmentDetails"]); ?>;

        var table_body = document.getElementById("table_body");
        table_body.innerHTML = "";

        citas.forEach(function(cita) {
            var row = table_body.insertRow();

            // Insertar celdas con los datos de la cita médica
            row.insertCell().innerHTML = cita["IdCita"];
            row.insertCell().innerHTML = '<?php echo $IdNumber ?>';
            row.insertCell().innerHTML = cita["PersTratam"];
            row.insertCell().innerHTML = cita["Fecha"];
            row.insertCell().innerHTML = cita["Hora"];
            row.insertCell().innerHTML = cita["Ubicacion"];
            row.insertCell().innerHTML = cita["Desc_unidad_edificio"];
        });

        <?php
    } else {
        ?>
        document.getElementById("FullName").value = "";
        document.getElementById("table_body").innerHTML = "";

        // Mostrar mensaje de error usando Swal.fire
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El documento del paciente no existe.',
            confirmButtonText: 'Aceptar'
        });
        <?php
    }
    ?>
</script>
