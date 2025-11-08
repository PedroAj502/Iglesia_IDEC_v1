    <?php include "scripts.php" ?>
    <title>Modificar célula</title>
    </head>

    <body>

        <?php include "menu.php" ?>

        <main>

            <center>

                <?php
                include "../database/conexion.php";
                $id__celula = $_GET['id'];

                $query = mysqli_query($conection, "SELECT * FROM celula WHERE id_celula = '$id__celula'");
                $result = mysqli_num_rows($query);

                if ($result == 0) {
                    header("Location: v-id-modificar-celulas.php");
                } else {
                    if ($data = mysqli_fetch_assoc($query)) {
                        $id                 =   $data['id_celula'];
                        $nombre_d_celula    = $data['nombre_celula'];
                        $cargo_celula       = $data['cargo'];
                        $fechaiunauguracion = $data['fecha_inau'];
                        $direccion_data     = $data['direccion'];
                        $no_zona            = $data['zona'];
                        $estado_actividad   = $data['estado'];
                    }
                }
                ?>

                <form class="frm_crear_u" method="POST" action="../database/m_modify_celula.php" enctype="multipart/form-data">

                    <div class="header_form">
                        <h1 align="center"><i class="las la-church"></i> <br> Modificar célula</h1>
                        <br>
                        <hr width="750px"><br>
                    </div>
                    <br>
                    <div class="body_form">
                        <div class="left-column">
                            <input type="hidden" name="id" value="<?php echo $id__celula; ?>"> <!-- llamar y esconder el ID -->
                            <input type="text" name="nombre_celula" value="<?php echo $nombre_d_celula; ?>" placeholder="Nombre de la célula">
                            <input type="text" name="cargo" value="<?php echo $cargo_celula; ?>" placeholder="Célula acargo de:">
                            <div class="input-group">
                                <input type="date" id="fecha-inau" name="fecha_inau" class="input-date" placeholder=" " value="<?php echo $fechaiunauguracion; ?>" />
                                <label for="fecha-inau" class="floating-label">Fecha de inauguración</label>
                            </div>


                        </div>

                        <div class="right-column">
                            <input type="text" name="direccion" value="<?php echo $direccion_data; ?>" placeholder="Dirección">
                            <input type="number" name="n_zona" value="<?php echo $no_zona; ?>" placeholder="Zona">
                            <select class="form-control" name="estado" id="estado">
                                <option value="" disabled selected>Estado</option>
                                <option <?php if ($estado_actividad == 1)
                                            echo 'selected'; ?> value="1">Activo</option>
                                <option <?php if ($estado_actividad == 0)
                                            echo 'selected'; ?> value="0">Inactivo</option>
                            </select>
                        </div>


                    </div><br>

                    <div class="butonnn">
                        <button type="submit" value="Registrar" name="modi-fi">Modificar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-celulas.php'">Regresar</button>
                    </div>
                </form>
            </center>

        </main>

        <?php include "footer.php" ?>