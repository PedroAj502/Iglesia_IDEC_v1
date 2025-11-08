<?php
include('conexion.php');
session_start();

$id = $_GET['id'];
$query_delete = mysqli_query($conection, "DELETE FROM celula WHERE id_celula = '$id'");

echo '<script>
    window.location = "../views/v-id-gestion-celulas.php";
    </script>';
