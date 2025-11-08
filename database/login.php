<?php
include('conexion.php');
    
                
$alert = '';
session_start();


    if (isset($_POST['inicio'])) {

        if (empty($_POST['in_nombre_usuario']) || empty($_POST['in_password'])) {
            echo '<script>
              alert("Debe llenar todos los campos!");
              window.location = "../index.php";
              </script>';
        } else {

            $username = mysqli_real_escape_string($conection, $_POST['in_nombre_usuario']);
            $pass = md5(mysqli_real_escape_string($conection, $_POST['in_password']));

            $query      = mysqli_query($conection, "SELECT * FROM usuario WHERE nombre_usuario = '$username' AND contrasena = '$pass'");
            $result     = mysqli_num_rows($query);

            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['active']             = true;
                $_SESSION['ID_user']            = $data['id_usuario'];
                $_SESSION['nombre__usuario']    = $data['nombre_usuario'];
                $_SESSION['last_login_timestamp'] = time();
                $_SESSION['id_rol']    = $data['id_rol'];
                
                echo '<script>
                    window.location = "../views/inicio.php"
                    </script>';
                    
            } else {
                echo '<script>
            window.location = "../index.php"
            alert("¡Error! Nombre de usuario/contraseña incorrectos.");
            </script>';
            }
        }
    }
?>
