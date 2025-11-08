    <?php include "scripts.php" ?>
    <title>Crear usuario</title>
    </head>

    <body>

        <?php include "menu.php" ?>

        <main>

            <center>
                <form class="frm_crear_u" method="POST" action="../database/m_crear_usuario.php" enctype="multipart/form-data">

                    <div class="header_form">
                        <h1 align="center"><i class="las la-user-plus"></i> <br> Crear usuario</h1>
                        <br>
                        <hr width="750px"><br>
                    </div>
                    <h2 align="center">Datos personales:</h1>
                        <br>
                        <div class="body_form">
                            <div class="left-column">
                                <input type="text" name="nombre_usuario" value="" placeholder="Nombre de usuario">
                                <input type="password" name="contraseña" value="" placeholder="Contraseña">


                            </div>

                            <div class="right-column">

                                <select class="form-control" name="rol">

                                    <option disabled selected value=""> ¡Seleccione un cargo! </option>
                                    <?php
                                    include "../database/conexion.php";
                                    $query = mysqli_query($conection, "SELECT * FROM rol ORDER BY id_rol ASC");
                                    $result = mysqli_num_rows($query);
                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            if ($data['id_rol'] == 1) {
                                                continue; 
                                            }
                                    ?>
                                            <option value="<?php echo $data['id_rol']; ?>"> <?php echo $data['nombre_rol']; ?></option>
                                        <?php } ?>

                                </select>

                            <?php } ?>
                            <input type="password" name="confirmacion" value="" placeholder="Confirmación de Contraseña">

                            </div>


                        </div><br>


                        <div class="butonnn">
                            <button type="submit" value="Registrar" name="save">Guardar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-usuarios.php'">Regresar</button>

                        </div>
                </form>
            </center>

        </main>

        <?php include "footer.php" ?>