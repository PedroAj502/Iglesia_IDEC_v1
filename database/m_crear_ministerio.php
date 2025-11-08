<?php

use LDAP\Result;
 
include('../database/conexion.php');
session_start();

if (isset($_POST['save_ministerio'])) {
    date_default_timezone_set('America/Guatemala');

    $nombre_d_ministerio    = mysqli_real_escape_string($conection, $_POST['nombre_ministerio']);
    $descripcion_data       = mysqli_real_escape_string($conection, $_POST['descripcion_m']);

    $query = mysqli_query($conection, "SELECT * FROM ministerio WHERE nombre_ministerio ='$nombre_d_ministerio' ");
    $result = mysqli_fetch_array($query);

    if (
        empty($_POST['nombre_ministerio']) || empty($_POST['descripcion_m'])
    ) {
        echo '<script> alert("¡Debe completar todos los tampos!"); 
        window.location = "../views/v-id-add-ministerio.php";
        </script>';
    } elseif ($result > 0) {
        echo '<script> alert("El ministerio ya existe!");
        window.location = "../views/v-id-add-ministerio.php";
        </script>';
    } elseif ($result == 0) {
        
        //detecta caracteres especiales en el nombre del ministerio
        if (preg_match("/[@#\!\'\^%\$&\*\(\)\[\]\{\}\|<>\/]/", $nombre_d_ministerio)) {
            echo '<script> alert("El nombre no puede contener caracteres especiales como @, #, !, \', etc."); 
            window.location = "../views/v-id-add-ministerio.php";
            </script>';
            exit;
        }


        $query = mysqli_query($conection, "INSERT INTO ministerio (nombre_ministerio, descripcion) 
        VALUES ('$nombre_d_ministerio', '$descripcion_data')");
        if ($query) {
            echo '<script> alert("¡Registro Exitoso!");
            window.location = "../views/v-id-gestion-ministerio.php";
            </script>';
        } else {
            echo '<script> alert("¡Error al Registrar!");
            window.location = "../";
            </script>';
        }
    } else {
        echo '<script> alert("¡Registro Exitoso!");
        window.location = "../views/v-id-gestion-ministerio.php";
        </script>';
    }
}
