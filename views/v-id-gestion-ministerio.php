<?php include "scripts.php" ?>
<title>Gestión de ministerios</title>
</head>

<body>

    <?php include "menu.php" ?>

    <main>
        <div class="container_option_bar">
            <div class="options_bar">
                <a href="../views/v-id-add-ministerio.php" class="btn-open-popup"> <i class="las la-plus"></i> </a>

                <div class="titulo">
                    <h1 class="las la-clipboard-check"> Gestión de ministerios</h1>
                </div>
                <div class="buttons">
                    <a class="btn-open-popup" type="button" onclick="exportarxls_mi()"><i class="las la-file-excel"></i></a> &nbsp;
                    <a type="button" class="btn-open-popup" onclick="exportarPDF_mi()"><i class="las la-file-pdf"></i></a>
                </div>
            </div>
        </div>

        <div class="container_table" align="center">
            <img id="logo_empresa" src="../assets/imagens/LOGOO.jpg" style="display:none;">
            <table id="data_table" class="tbl_views">
                <thead>
                    <th> # </th>
                    <th> Nombre del ministerio </th>
                    <th> Descripción</th>
                    <th> <span>Editar</span></th>
                    <th> <span>SUPR</span></th>
                </thead>

                <tbody>
                    <?php
                    include "../database/conexion.php";
                    $query = mysqli_query($conection, "SELECT id_ministerio, nombre_ministerio, descripcion FROM ministerio");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <td><?php echo $data['id_ministerio']; ?></td>
                                <td><?php echo $data['nombre_ministerio']; ?></td>
                                <td><?php echo $data['descripcion']; ?></td>

                                <td> <a class="button_2" href="v-id-modificar-ministerio.php?id=<?php echo $data['id_ministerio']; ?>"> <span class="las la-pen"></span></a></td>
                                <td> <a class="button_3" onclick="return confirm_eraser_min()" href="../database/d_delete_ministerio.php?id=<?php echo $data['id_ministerio']; ?>"><span class="las la-trash"></span></a></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>

                </tbody>
            </table>

        </div>

    </main>

    <?php include "footer.php" ?>