<?php include "scripts.php" ?>
<title>Modificar usuario</title>
</head>


<body>

    <?php include "menu.php" ?>

    <main>

        <center>
            <?php
            include "../database/conexion.php";
            $id__usuario = $_GET['id'];

            $query = mysqli_query($conection, "SELECT * FROM usuario WHERE id_usuario = '$id__usuario'");
            $result = mysqli_num_rows($query);

            if ($result == 0) {
                header("Location: add_usuario.php");
            } else {
                if ($data = mysqli_fetch_assoc($query)) {
                    $id    =   $data['id_usuario'];
                    $nombre__usuario    =   $data['nombre_usuario'];
                    $rol_actual         =   $data['id_rol'];
                }
            }
            ?>
            <form class="frm_crear_u" method="POST" action="../database/m_modify_usuario.php" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Campo oculto para el ID -->

                <div class="header_form">
                    <h1 align="center"><i class="fas fa-user-pen"></i> <br> Modificar usuario</h1>
                    <br>
                    <hr width="750px"><br>
                </div>
                <h2 align="center">Datos personales:</h1>
                    <br>
                    <div class="body_form">
                        <div class="left-column">
                            <input type="text" name="nombre_usuario" value="<?php echo $nombre__usuario; ?>" placeholder="Nombre de usuario">
                            <input type="password" name="contraseña" value="" placeholder="Contraseña">


                        </div>

                        <div class="right-column">
                            <select class="form-control" name="rol">
                                <option disabled value=""> ¡Seleccione un cargo! </option>
                                <?php
                                $query = mysqli_query($conection, "SELECT * FROM rol ORDER BY id_rol ASC");
                                while ($rol = mysqli_fetch_assoc($query)) {
                                    if ($rol['id_rol'] == 1) {
                                        continue;
                                    }
                                    $selected = ($rol['id_rol'] == $rol_actual) ? 'selected' : '';
                                    echo '<option value="' . $rol['id_rol'] . '" ' . $selected . '>' . $rol['nombre_rol'] . '</option>';
                                }
                                ?>
                            </select>

                            <input type="password" name="confirmacion" value="" placeholder="Confirmación de Contraseña">

                        </div>


                    </div><br>


                    <div class="butonnn">
                        <button type="submit" value="Registrar" name="modify">Modificar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-usuarios.php'">Regresar</button>

                    </div>
            </form>
        </center>

    </main>

    <?php include "footer.php" ?>