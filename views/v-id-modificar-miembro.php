<?php include "scripts.php" ?>
<title>Modificar miembro</title>
</head>

<body>

    <?php include "menu.php" ?>

    <main>

        <center>
            <?php
            include "../database/conexion.php";
            $id__miembro = $_GET['id'];

            $query = mysqli_query($conection, "SELECT * FROM miembro WHERE id_miembro = '$id__miembro'");
            $result = mysqli_num_rows($query);

            if ($result == 0) {
                header("Location: v-id-modificar-miembro.php");
            } else {
                if ($data = mysqli_fetch_assoc($query)) {
                    $id                 =   $data['id_miembro'];
                    $nombre_d_miembro    = $data['nombre_completo'];
                    $dpi_miembro       = $data['dpi'];
                    $genero_macho_f     = $data['genero'];
                    $edad_miembro       = $data['edad'];
                    $fecha_d_nac        = $data['fecha_nacimiento'];
                    $estado__civil      = $data['estado_civil'];
                    $profesion_oficio   = $data['profesion_oficio'];
                    $estado_actual      = $data['estado'];
                    $residecia_miembro  = $data['direccion'];
                    $telefono_miembro   = $data['telefono'];
                    $email_miembro      = $data['email'];
                    $fecha_conversion   = $data['fecha_conversion'];
                    $lugar_conversion   = $data['lugar_conversion'];
                    $bautizo_agua       = $data['bautizo_agua'];
                    $fecha_bautizo_agua = $data['fecha_bautizo_agua'];
                    $lugar_bautizo_agua = $data['lugar_bautizo_agua'];
                    $bautizo_espiritu   = $data['bautizo_espiritu'];
                    $fecha_bautizo_esp  = $data['fecha_bautizo_espiritu'];
                    $lugar_bautizo_esp  = $data['lugar_bautizo_espiritu'];
                    $id_celula_asig     = $data['id_celula'];
                    $fecha_asig_celula  = $data['fecha-asign-celula'];
                    $id_ministerio_asig = $data['id_ministerio'];
                    $fecha_asig_minist  = $data['fecha-asign-ministerio'];
                }
            }
            ?>
            <form class="frm_crear_u" method="POST" action="../database/m_modify_miembro.php" enctype="multipart/form-data">

                <div class="header_form">
                    <h1 align="center"><br> Modificar miembro</h1> <br>
                    <div class="profile-photo" style="text-align:center; margin-bottom:20px;">
                        <?php if (!empty($data['photo'])): ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($data['photo']); ?>"
                                alt="Foto del miembro"
                                style="width:140px; height:140px; object-fit:cover; border-radius:50%; border:3px solid #fff; box-shadow:0 0 8px #000;">
                        <?php else: ?>
                            <span class="fa fa-user" style="font-size:120px; color:#ccc;"></span>
                        <?php endif; ?>
                        <br><br>
                        <label for="idecimg" style="font-weight:bold;">Cambiar foto:</label><br>
                        <input class="input-date" type="file" name="idecimg" id="idecimg" accept="image/jpeg, image/png">
                    </div>
                    <br>
                    <hr width="750px"><br>
                </div>
                <!----------------------------------------------------------------- DATOS PERSONALES ------------------------------------------------------------------------>
                <h2 align="center">Datos personales:</h2>
                <br>
                <div class="body_form">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="left-column">

                        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- llamar y esconder el ID -->

                        <input type="text" name="nombre-completo" value="<?php echo $nombre_d_miembro; ?>" placeholder="Nombre y apellidos:">

                        <input type="text" name="dpi" value="<?php echo $dpi_miembro; ?>" placeholder="DPI/CUI">

                        <select class="form-control" name="genero" id="genero">
                            <option value="" disabled selected>Género</option>
                            <option <?php if ($genero_macho_f == 1)
                                        echo 'selected'; ?> value="1">Masculino</option>
                            <option <?php if ($genero_macho_f == 0)
                                        echo 'selected'; ?> value="0">Femenino</option>
                        </select>



                        <input type="text" name="edad_m" value="<?php echo $edad_miembro; ?>" placeholder="Edad">

                        <div class="input-group">
                            <input type="date" id="fecha-nac" name="fecha-nac" class="input-date" value="<?php echo $fecha_d_nac; ?>" />
                            <label for="fecha-nac" class="floating-label">Fecha de nacimiento:</label>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="right-column">
                        <input type="text" name="es-civil" value="<?php echo $estado__civil; ?>" placeholder="Estado civil">
                        <input type="text" name="profesion-oficio" value="<?php echo $profesion_oficio ?>" placeholder="Profesión u oficio">

                        <select class="form-control" name="estado" id="estado">
                            <option value="" disabled selected>Estado</option>
                            <option <?php if ($estado_actual == 1)
                                        echo 'selected'; ?> value="1">Activo</option>
                            <option <?php if ($estado_actual == 0)
                                        echo 'selected'; ?> value="0">Inactivo</option>
                        </select>
                    </div>

                    <hr width="750px">
                </div> <br>
                <!--------------------------------------------------------- CONTACTO Y UBICACION ------------------------------------------------------------------------>

                <h2 align="center">Contacto y ubicación:</h2>
                <br>
                <div class="body_form">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="left-column">
                        <input type="text" name="address" value="<?php echo $residecia_miembro; ?>" placeholder="Dirección de residencia">
                        <input type="number" name="telcel" value="<?php echo $telefono_miembro; ?>" placeholder="Número de teléfono/Celular">
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="right-column">
                        <input type="text" name="e-mail" value="<?php echo $email_miembro; ?>" placeholder="Correo electrónico">

                        <br>

                    </div>

                    <hr width="750px">
                </div><br>

                <!-------------------------------------------------------------- BAUTIZOS ----------------------------------------------------------------------------->
                <h2 align="center">Bautizos:</h2>
                <br>
                <div class="body_form">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="left-column">
                        <p align="center">Conversión:</p>

                        <div class="input-group">
                            <input type="date" id="fecha-d-conversion" name="fecha-d-conversion" class="input-date" value="<?php echo $fecha_conversion; ?>" />
                            <label for="fecha-conversion" class="floating-label">Fecha de conversión:</label>
                        </div>

                        <input type="text" name="lugar-conversion" value="<?php echo $lugar_conversion; ?>" placeholder="Lugar de conversión:">
                        <br>

                        <p align="center">Bautizo de agua:</p>

                        <select class="form-control" name="bautizoa" id="bautizoa">
                            <option value="" disabled selected>¿Fue bautizado?</option>
                            <option <?php if ($bautizo_agua == 1)
                                        echo 'selected'; ?> value="1">Si</option>
                            <option <?php if ($bautizo_agua == 0)
                                        echo 'selected'; ?> value="0">No</option>
                        </select>


                        <div class="input-group">
                            <input type="date" id="fecha-bautizo-a" name="fecha-bautizo-a" class="input-date" value="<?php echo $fecha_bautizo_agua; ?>" />
                            <label for="fecha-bautizo" class="floating-label">Fecha de bautizo en agua</label>
                        </div>
                        <input type="text" name="lugar-bautizo-a" value="<?php echo $lugar_bautizo_agua; ?>" placeholder="Lugar del bautizo en agua">
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="right-column">
                        <p align="center">Bautizo de espíritu:</p>

                        <select class="form-control" name="bautizoe" id="bautizoe">
                            <option value="" disabled selected>¿Fue bautizado?</option>
                            <option <?php if ($bautizo_espiritu == 1)
                                        echo 'selected'; ?> value="1">Si</option>
                            <option <?php if ($bautizo_espiritu == 0)
                                        echo 'selected'; ?> value="0">No</option>
                        </select>

                        <div class="input-group">
                            <input type="date" id="fecha-bautizo-e" name="fecha-bautizo-e" class="input-date" placeholder=" " value="<?php echo $fecha_bautizo_esp; ?>" />
                            <label for="fecha-bautizo" class="floating-label">Fecha de bautizo de espiritu</label>
                        </div>
                        <input type="text" name="lugar-bautizo-e" value="<?php echo $lugar_bautizo_esp; ?>" placeholder="Lugar del bautizo de espiritu">

                    </div>
                    <hr width="750px">
                </div><br>

                <!------------------------------------------------------------ ASIGNACIONES --------------------------------------------------------------------------->

                <h2 align="center">Asignaciones:</h2>
                <br>
                <div class="body_form">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="left-column">
                        <p align="center">Asignar célula:</p>

                        <select class="form-control" name="celula-select">
                            <option disabled selected value=""> ¡Seleccione una célula! </option>
                            <option value="" <?php echo (empty($id_celula_asig) && $id_celula_asig !== 0) ? 'selected' : ''; ?>>No asignado</option>
                            <?php
                            include "../database/conexion.php";
                            $query = mysqli_query($conection, "SELECT * FROM celula ORDER BY id_celula ASC");
                            while ($celula = mysqli_fetch_assoc($query)) {
                                // marcar opción seleccionada si coincide con el id guardado
                                $selected = ($celula['id_celula'] == $id_celula_asig) ? 'selected' : '';
                                echo '<option value="' . $celula['id_celula'] . '" ' . $selected . '>' . $celula['nombre_celula'] . '</option>';
                            }
                            ?>
                        </select>


                        <div class="input-group">
                            <input type="date" id="fecha-asignacion-c" name="fecha-asignacion-c" class="input-date" value="<?php echo $fecha_asig_celula; ?>" />
                            <label for="fecha-asignacion" class="floating-label">Fecha de asignación:</label>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA -->

                    <div class="right-column">

                        <p align="center">Asignar ministerio:</p>

                        <select class="form-control" name="ministerio-select">
                            <option disabled selected value=""> ¡Seleccione un ministerio! </option>
                            <option value="" <?php echo (empty($id_ministerio_asig) && $id_ministerio_asig !== 0) ? 'selected' : ''; ?>>No asignado</option>
                            <?php
                            include "../database/conexion.php";
                            $query = mysqli_query($conection, "SELECT * FROM ministerio ORDER BY id_ministerio ASC");
                            while ($data = mysqli_fetch_assoc($query)) {
                                $selected = ($data['id_ministerio'] == $id_ministerio_asig) ? 'selected' : '';
                                echo '<option value="' . $data['id_ministerio'] . '" ' . $selected . '>' . $data['nombre_ministerio'] . '</option>';
                            }
                            ?>
                        </select>



                        <div class="input-group">
                            <input type="date" id="fecha-asignacion-m" name="fecha-asignacion-m" class="input-date" value="<?php echo $fecha_asig_minist; ?>" />
                            <label for="fecha-asignacion" class="floating-label">Fecha de asignación:</label>
                        </div>

                    </div>

                    <hr width="750px">
                </div><br>


                <div class="butonnn">
                    <button type="submit" value="Registrar" name="modi-fi-miem">Guardar</button>
                    <button type="button" onclick="window.location='../views/v-id-gestion-miembros.php'">Regresar</button>

                </div>
            </form>
        </center>

    </main>

    <?php include "footer.php" ?>