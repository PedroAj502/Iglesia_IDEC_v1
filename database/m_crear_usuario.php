<?php

use LDAP\Result;

include('../database/conexion.php');
session_start();

if (isset($_POST['save'])) { 
    date_default_timezone_set('America/Guatemala');
    $fecha_actual = date("Y-m-d H:i:s");

    $nombre__usuario    =   $_POST['nombre_usuario'];
    $rol                =   $_POST['rol'];
    $password           =   md5($_POST['contraseña']);

    $query = mysqli_query($conection, "SELECT * FROM usuario WHERE nombre_usuario='$nombre__usuario'");
    $result = mysqli_fetch_array($query);

    if (
        empty($_POST['nombre_usuario']) && empty($_POST['contraseña']) && empty($_POST['confirmacion'])
    ) {

        echo '<script>
          alert("Debe de llenar todos los campos"); 
          window.location = "../views/v-id-add-usuarios.php";
          </script>';
    } elseif ($result > 0) {
        echo '<script>
          alert("Usuario Existente"); 
          window.location = "../views/v-id-add-usuarios.php";
          </script>';
    } elseif ($_POST['rol'] == 1) {

        echo '<script>
          alert("No se puede crear un usuario administrador."); 
          window.location = "../views/v-id-add-usuarios.php";
          </script>';
    } elseif ($_POST['rol'] == 0){
        echo '<script>
          alert("Debe seleccionar un cargo"); 
          window.location = "../views/v-id-add-usuarios.php";
          </script>';

    }elseif ($_POST['contraseña'] == $_POST['confirmacion']) {
        if ($result == 0) {
            $query = mysqli_query($conection, "INSERT INTO usuario (nombre_usuario, contrasena, fecha_session, id_rol) 
        VALUES ('$nombre__usuario', '$password', '$fecha_actual', '$rol')");
            if ($query) {
                echo '<script>
                  alert("Registro Existoso"); 
                  window.location = "../views/v-id-gestion-usuarios.php";
                  </script>';
            } else {
                echo '<script>
                  alert("Error al registrar");   
                  window.location = "../views/v-id-gestion-usuarios.php";
                  </script>';
            }
        }
    } else {
        echo '<script>
          alert("Las contraseñas no coinciden"); 
          window.location = "../views/v-id-add-usuarios.php";
          </script>';
    }
} else {
    echo '<script>
        alert("Error al registrar"); 
                  window.location = "../views/v-id-gestion-usuarios.php";
        </script>';
}
