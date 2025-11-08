<?php
include('conexion.php');

if (isset($_POST['modify'])) {

    if ($_POST['contraseña'] == $_POST['confirmacion']) {
        
        date_default_timezone_set('America/Guatemala');
        $fecha__actual = date("Y-m-d H:i:s");
        $id_usser = $_POST['id'];
        $nombre__usuario = $_POST['nombre_usuario'];
        $rol = $_POST['rol'];
        $password_encript = md5($_POST['contraseña']);

        $sql_update = mysqli_query($conection, "UPDATE usuario SET nombre_usuario='$nombre__usuario', contrasena='$password_encript', id_rol='$rol', fecha_modificacion='$fecha__actual' WHERE id_usuario = $id_usser");

        echo '<script>
            alert("Perfil actualizado"); 
                  window.location = "../views/v-id-gestion-usuarios.php";
            </script>';
    } else {
        echo '<script>
        alert("contraseñas no coinciden"); 
                  window.location = "../views/v-id-gestion-usuarios.php";
        </script>';
    }
} else {
    echo '<script>
        alert("Error al actualizar el perfil"); 
                  window.location = "../views/v-id-gestion-usuarios.php";
        </script>';
}
