<?php include "scripts.php" ?>
<title>Agregar miembro</title>
</head>
 
<body>

    <?php include "menu.php" ?>

    <main>

        <center>
            <form class="frm_crear_u" method="POST" action="../database/m_crear_miembro.php" enctype="multipart/form-data">
                <!-- ENCABEZADO DEL FORMULARIO -->
                <div class="header_form">
                    <h1 align="center"><i class="las la-user-circle"></i> <br> Agregar miembro</h1>
                    <br>
                    <hr width="750px"><br>
                </div>
                <!----------------------------------------------------------------- DATOS PERSONALES ------------------------------------------------------------------------>
                <h2 align="center">Datos personales:</h2>
                <br>
                <div class="body_form">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="left-column">
                        <input type="text" name="nombre-completo" value="" placeholder="Nombre y apellidos:">

                        <input type="text" name="dpi" value="" placeholder="DPI/CUI">

                        <select name="genero_select" id="genero_select" required>
                            <option disabled selected value=""> Género </option>
                            <option value="1"> Masculino </option>
                            <option value="0"> Femenino </option>
                        </select>

                        <input type="text" name="edad_m" value="" placeholder="Edad">

                        <div class="input-group">
                            <input type="date" id="fecha-nac" name="fecha-nac" class="input-date" />
                            <label for="fecha-nac" class="floating-label">Fecha de nacimiento:</label>
                        </div>
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="right-column">
                        <input type="text" name="es-civil" value="" placeholder="Estado civil">
                        <input type="text" name="profesion-oficio" value="" placeholder="Profesión u oficio">

                        <select name="estado" id="estado" required>
                            <option value="" disabled selected>Estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>

                        <div class="input-group">
                            <input class="input-date" type="file" name="idecimg" id="idecimg" accept="image/jpeg, image/png">
                            <label for="subida-foto" class="floating-label">Subir foto:</label>
                        </div>

                    </div>

                    <hr width="750px">
                </div> <br>
                <!--------------------------------------------------------- CONTACTO Y UBICACION ------------------------------------------------------------------------>

                <h2 align="center">Contacto y ubicación:</h2>
                <br>
                <div class="body_form">
                    <!-- COLUMNA IZQUIERDA -->
                    <div class="left-column">
                        <input type="text" name="address" value="" placeholder="Dirección de residencia">
                        <input type="number" name="telcel" value="" placeholder="Número de teléfono/Celular">
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="right-column">
                        <input type="text" name="e-mail" value="" placeholder="Correo electrónico">

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
                            <input type="date" id="fecha-d-conversion" name="fecha-d-conversion" class="input-date" />
                            <label for="fecha-conversion" class="floating-label">Fecha de conversión:</label>
                        </div>

                        <input type="text" name="lugar-conversion" value="" placeholder="Lugar de conversión:">
                        <br>

                        <p align="center">Bautizo de agua:</p>
                        <select class="form-control" name="bautizado-a" required>
                            <option disabled selected value=""> ¿Fue bautizado? </option>
                            <option value="1"> Si </option>
                            <option value="0"> No </option>
                        </select>

                        <div class="input-group">
                            <input type="date" id="fecha-bautizo-a" name="fecha-bautizo-a" class="input-date" />
                            <label for="fecha-bautizo" class="floating-label">Fecha de bautizo en agua</label>
                        </div>
                        <input type="text" name="lugar-bautizo-a" value="" placeholder="Lugar del bautizo en agua">
                    </div>

                    <!-- COLUMNA DERECHA -->
                    <div class="right-column">
                        <p align="center">Bautizo de espíritu:</p>

                        <select class="form-control" name="bautizado-e" required>
                            <option disabled selected value=""> Bautizo de espíritu </option>
                            <option value="1"> Si </option>
                            <option value="0"> No </option>
                        </select>

                        <div class="input-group">
                            <input type="date" id="fecha-bautizo-e" name="fecha-bautizo-e" class="input-date" placeholder=" " />
                            <label for="fecha-bautizo" class="floating-label">Fecha de bautizo de espiritu</label>
                        </div>
                        <input type="text" name="lugar-bautizo-e" value="" placeholder="Lugar del bautizo de espiritu">

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

                        <select class="form-control" name="celula-select" >

                            <option disabled selected value=""> ¡Seleccione una célula! </option>
                            <option value="">No asignado</option>
                            <?php
                            include "../database/conexion.php";
                            $query = mysqli_query($conection, "SELECT * FROM celula ORDER BY id_celula ASC");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) {
                                    
                            ?>
                                    <option value="<?php echo $data['id_celula']; ?>"> <?php echo $data['nombre_celula']; ?></option>
                                <?php } ?>

                        </select>

                    <?php } ?>

                    <div class="input-group">
                        <input type="date" id="fecha-asignacion-c" name="fecha-asignacion-c" class="input-date"/>
                        <label for="fecha-asignacion" class="floating-label">Fecha de asignación:</label>
                    </div>
                    </div>

                    <!-- COLUMNA DERECHA -->

                    <div class="right-column">

                        <p align="center">Asignar ministerio:</p>

                        <select class="form-control" name="ministerio-select" >

                            <option disabled selected value=""> ¡Seleccione un ministerio! </option>
                            <option value="">No asignado</option>
                            <?php
                            include "../database/conexion.php";
                            $query = mysqli_query($conection, "SELECT * FROM ministerio ORDER BY id_ministerio ASC");
                            $result = mysqli_num_rows($query);
                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) {
                                    
                            ?>
                                    <option value="<?php echo $data['id_ministerio']; ?>"> <?php echo $data['nombre_ministerio']; ?></option>
                                <?php } ?>

                        </select>

                    <?php } ?>

                    <div class="input-group">
                        <input type="date" id="fecha-asignacion-m" name="fecha-asignacion-m" class="input-date" placeholder=" " />
                        <label for="fecha-asignacion" class="floating-label">Fecha de asignación:</label>
                    </div>

                    </div>

                    <hr width="750px">
                </div><br>


                <div class="butonnn">
                    <button type="submit" value="Registrar" name="save-miembro">Guardar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-miembros.php'">Regresar</button>

                </div>
            </form>
        </center>

    </main>

    <?php include "footer.php" ?>