<?php
include('conexion.php');
session_start();


$id = $_GET['id'];
$query_delete = mysqli_query($conection, "DELETE FROM usuario WHERE id_usuario = '$id'");

echo '<script>
    window.location = "../views/v-id-gestion-usuarios.php";
    </script>';
