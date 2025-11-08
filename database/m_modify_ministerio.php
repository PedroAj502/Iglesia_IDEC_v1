<?php
include('conexion.php');

if (isset($_POST['modi-fi-min'])) {
    $id_mod = $_POST['id'];
    $nombre_d_ministerio    = mysqli_real_escape_string($conection, $_POST['nombre_ministerio']);
    $data__descripcion      = mysqli_real_escape_string($conection, $_POST['descripcion_min']);

    $sql_update = mysqli_query($conection, "UPDATE ministerio SET nombre_ministerio='$nombre_d_ministerio', descripcion='$data__descripcion' WHERE id_ministerio = '$id_mod'");

    echo '<script>
        alert("¡Ministerio modificado exitosamente!"); 
        window.location = "../views/v-id-gestion-ministerio.php"
        </script>';
}
