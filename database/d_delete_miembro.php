<?php
include('conexion.php');
session_start();

$id = $_GET['id'];
$query_delete = mysqli_query($conection, "DELETE FROM miembro WHERE id_miembro = '$id'");

echo '<script>
    window.location = "../views/v-id-gestion-miembros.php";
    </script>';
