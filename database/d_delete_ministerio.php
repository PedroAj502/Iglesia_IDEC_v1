<?php
include('conexion.php');
session_start();


$id = $_GET['id'];
$query_delete = mysqli_query($conection, "DELETE FROM ministerio WHERE id_ministerio = '$id'");

echo '<script>
    window.location = "../views/v-id-gestion-ministerio.php";
    </script>';
?>