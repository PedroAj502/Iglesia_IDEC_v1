<?php
include('conexion.php');

if (isset($_POST['modi-fi'])) {
    $id_mod = $_POST['id']; 
    $nombre_d_celula    = $_POST['nombre_celula'];
    $cargo_celula       = $_POST['cargo'];
    $fechaiunauguracion = $_POST['fecha_inau']; 
    $direccion_data     = $_POST['direccion'];
    $no_zona            = $_POST['n_zona'];       
    $estado_actividad   = $_POST['estado'];

    $sql_update = mysqli_query($conection, "UPDATE celula SET nombre_celula='$nombre_d_celula', cargo='$cargo_celula', direccion='$direccion_data', zona='$no_zona', fecha_inau='$fechaiunauguracion', estado='$estado_actividad' WHERE id_celula = '$id_mod'");

    echo '<script>
        alert("¡Célula modificada exitosamente!"); 
        window.location = "../views/v-id-gestion-celulas.php"
        </script>';

}
