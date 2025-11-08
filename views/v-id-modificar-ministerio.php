    <?php include "scripts.php" ?>
    <title>Modificar ministerio</title>
    </head>

    <body>

        <?php include "menu.php" ?>

        <main>

            <center>

                <?php
                include "../database/conexion.php";
                $id__ministerio = $_GET['id'];

                $query = mysqli_query($conection, "SELECT * FROM ministerio WHERE id_ministerio = '$id__ministerio'");
                $result = mysqli_num_rows($query);

                if ($result == 0) {
                    header("Location: v-id-modificar-ministerio.php");
                } else {
                    if ($data = mysqli_fetch_assoc($query)) {
                        $id                 =   $data['id_ministerio'];
                        $nombre_d_ministerio    = $data['nombre_ministerio'];
                        $descripcion_ministerio       = $data['descripcion'];
                    }
                }
                ?>

                <form class="frm_crear_u" method="POST" action="../database/m_modify_ministerio.php" enctype="multipart/form-data">

                    <div class="header_form">
                        <h1 align="center"><i class="las la-heart"></i> <br> Modificar ministerio</h1>
                        <br>
                        <hr width="750px"><br>
                    </div>
                    <br>
                    <div class="body_form">
                        <div class="left-column">
                            <input type="hidden" name="id" value="<?php echo $id__ministerio; ?>"> <!-- llamar y esconder el ID -->
                            <input type="text" name="nombre_ministerio" value="<?php echo $nombre_d_ministerio; ?>" placeholder="Nombre del ministerio">
                            <input type="text" name="descripcion_min" value="<?php echo $descripcion_ministerio; ?>" placeholder="Descripción del ministerio">

                        </div>

                    </div><br>

                    <div class="butonnn">
                        <button type="submit" value="Registrar" name="modi-fi-min">Modificar</button>
                        <button type="button" onclick="window.location='../views/v-id-gestion-ministerio.php'">Regresar</button>
                    </div>
                </form>
            </center>

        </main>

        <?php include "footer.php" ?>