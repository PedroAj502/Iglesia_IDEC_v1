    <?php include "scripts.php" ?>
    <title>Crear célula</title>
    </head>

    <body>

        <?php include "menu.php" ?>

        <main>

            <center>
                <form class="frm_crear_u" method="POST" action="../database/m_crear_celula.php" enctype="multipart/form-data">

                    <div class="header_form">
                        <h1 align="center"><i class="las la-church"></i> <br> Crear célula</h1>
                        <br>
                        <hr width="750px"><br>
                    </div>
                    <br>
                    <div class="body_form">
                        <div class="left-column">
                            <input type="text" name="nombre_celula" value="" placeholder="Nombre de la célula">
                            <input type="text" name="cargo" value="" placeholder="Célula acargo de:">
                            <div class="input-group">
                                <input type="date" id="fecha-inau" name="fecha-inaug" class="input-date" placeholder=" " />
                                <label for="fecha-inau" class="floating-label">Fecha de inauguración</label>
                            </div>


                        </div>

                        <div class="right-column">
                            <input type="text" name="direccion" value="" placeholder="Dirección">
                          
                            <input type="number" name="n_zona" value="" placeholder="Zona">
                            
                            <select name="estado" id="estado" required>
                                <option value="" disabled selected>Estado</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>


                    </div><br>
                    
                    <div class="butonnn">
                        <button type="submit" value="Registrar" name="save">Guardar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-celulas.php'">Regresar</button>
                    </div>
                </form>
            </center>

        </main>

        <?php include "footer.php" ?>