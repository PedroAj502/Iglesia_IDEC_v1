<?php include "scripts.php" ?>
<title>Gestión de usuarios</title>
</head>

<body>

    <?php include "menu.php" ?>

    <main>
        <div class="container_option_bar">
            <div class="options_bar">
                <a href="../views/v-id-add-usuarios.php" class="btn-open-popup"> <i class="las la-user-plus"></i> </a>

                <div class="titulo">
                    <h1 class="las la-user-cog"> Gestión de usuarios</h1>
                </div>
                <div class="buttons">
                    <a class="btn-open-popup" type="button" onclick="exportarxls()"><i class="las la-file-excel"></i></a> &nbsp;
                    <a type="button" class="btn-open-popup" onclick="exportarPDF()"><i class="las la-file-pdf"></i></a>

                </div>
            </div>
        </div>

        <div class="container_table" align="center">
        <img id="logo_empresa" src="../assets/imagens/LOGOO.jpg" style="display:none;">    
            <table id="data_table" class="tbl_views">
                <thead>
                    <th> # </th>
                    <th> Nombre del usuario </th>
                    <th> Cargo </th>
                    <th> Fecha de creación</th>
                    <th> Fecha de modificación</th>
                    <th> <span> Editar</span></th>
                    <th> <span> SUPR</span></th>
                </thead>

                <tbody>
                    <?php
                    include "../database/conexion.php";
                    $query = mysqli_query($conection, "SELECT r.id_rol, r.nombre_rol, u. * FROM rol r, usuario u WHERE r.id_rol = u.id_rol");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <td><?php echo $data['id_usuario']; ?></td>
                                <td><?php echo $data['nombre_usuario']; ?></td>
                                <td><?php echo $data['nombre_rol']; ?></td>
                                <td><?php echo $data['fecha_session']; ?></td>
                                <td><?php echo $data['fecha_modificacion']; ?></td>
                                <td> <a class="button_2" href="v-id-modificar-usuarios.php?id=<?php echo $data['id_usuario']; ?>"> <span class="las la-pen"></span></a></td>
                                <td> <a class="button_3" onclick="return confirm_eraser_u()" href="../database/delete_usuario.php?id=<?php echo $data['id_usuario']; ?>"><span class="las la-trash"></span></a></td>
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