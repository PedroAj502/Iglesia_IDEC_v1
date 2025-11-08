<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/imagens/f631a54d-d14a-4f61-a3c5-b27ba5edf119.jfif">
    <link rel="stylesheet" href="assets/login_style.css">
    <title>IDEC</title>
</head>

<body>
    <center>
        <div class="login">
            <div class="into">
                <form method="POST" action="index.php?controller=auth&action=login" enctype="multipart/form-data">
                    <h1 class="title_log">Iniciar Sesión</h1>
                    <input type="text" name="in_nombre_usuario" value="" placeholder="Nombre de Usuario"><br>
                    <input type="password" name="in_password" value="" placeholder="Contraseña"><br>
                    <div class="alert"><?php echo isset($alert)? $alert : ' '; ?>
                
                </div>
                    <button type="submit" name="inicio"> <i class="fa fa-lock"></i> Ingresar</button>
                    <br>
                </form>

            </div>
        </div>
    </center>

    
</body>

</html>