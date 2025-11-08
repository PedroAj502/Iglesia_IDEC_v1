    <?php include "scripts.php" ?>
    <title>Crear ministerio</title>
    </head>

    <body>

        <?php include "menu.php" ?>

        <main>

            <center>
                <form class="frm_crear_u" method="POST" action="../database/m_crear_ministerio.php" enctype="multipart/form-data">

                    <div class="header_form">
                        <h1 align="center"><i class="las la-heart"></i> <br> Crear ministerio</h1>
                        <br>
                        <hr width="750px"><br>
                    </div>
                    <br>
                    <div class="body_form">
                        <div class="left-column">
                            <input type="text" name="nombre_ministerio" value="" placeholder="Nombre del ministerio">
                            <input type="text" name="descripcion_m" value="" placeholder="Descripción del ministerio:">
                        </div>


                    </div><br>
                    
                    <div class="butonnn">
                        <button type="submit" value="Registrar" name="save_ministerio">Guardar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-ministerio.php'">Regresar</button>
                    </div>
                </form>
            </center>

        </main>

        <?php include "footer.php" ?>