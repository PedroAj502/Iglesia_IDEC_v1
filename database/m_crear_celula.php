<?php

use LDAP\Result;

include('../database/conexion.php');
session_start();

if (isset($_POST['save'])) {
    date_default_timezone_set('America/Guatemala');

    $nombre_d_celula         = $_POST['nombre_celula'];
    $cargo_celula            = $_POST['cargo'];
    $fechaiunauguracion      = $_POST['fecha-inaug'];
    $direccion_data          = $_POST['direccion'];
    $no_zona                 = $_POST['n_zona'];
    $estado_actividad        = $_POST['estado'];

    $query = mysqli_query($conection, "SELECT * FROM celula WHERE nombre_celula ='$nombre_d_celula'");
    $result = mysqli_fetch_array($query);

    if (
        empty($_POST['nombre_celula']) || empty($_POST['cargo']) || empty($_POST['fecha-inaug'])
        || empty($_POST['direccion']) || empty($_POST['n_zona']) || !isset($_POST['estado'])
    ) {
        echo '<script> alert("¡Debe completar todos los tampos!"); 
        window.location = "../views/v-id-add-celula.php";
        </script>';
    } elseif ($result > 0) {
        echo '<script> alert("¡La célula ya existe!");
        window.location = "../views/v-id-add-celula.php";
        </script>';
    } elseif ($result == 0) {


        $query = mysqli_query($conection, "INSERT INTO celula (nombre_celula, cargo, direccion, zona, fecha_inau, estado) 
        VALUES ('$nombre_d_celula', '$cargo_celula', '$direccion_data', '$no_zona', '$fechaiunauguracion', '$estado_actividad')");
        if ($query) {
            echo '<script> alert("¡Registro Exitoso!");
            window.location = "../views/v-id-gestion-celulas.php";
            </script>';
        } else {
            echo '<script> alert("¡Error al Registrar!");
            window.location = "../";
            </script>';
        }
    } else {
        echo '<script> alert("¡Registro Exitoso!");
        window.location = "../views/v-id-add-celula.php";
        </script>';
    }
}