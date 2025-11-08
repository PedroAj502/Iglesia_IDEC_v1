<?php include "scripts.php" ?>
<title>Células de oración</title>
</head>

<body>

    <?php include "menu.php" ?>

    <main>
        <div class="container_option_bar">
            <div class="options_bar">
                    <a class="btn-open-popup" type="button" onclick="exportarxls_ce()"><i class="las la-file-excel"></i></a> 

                <div class="titulo">
                    <h1 class="las la-church"> Células de oración</h1>
                </div>
                <div class="buttons">
                    <a type="button" class="btn-open-popup" onclick="exportarPDF_ce()"><i class="las la-file-pdf"></i></a>

                </div>
            </div>
        </div>

        <div class="container_table" align="center">
            <img id="logo_empresa" src="../assets/imagens/LOGOO.jpg" style="display:none;">
            <table id="data_table" class="tbl_views">
                <thead>
                    <th> # </th>
                    <th> Nombre de la célula </th>
                    <th> Acargo de </th>
                    <th> Dirección </th>
                    <th> Zona </th>
                    <th> Estado</th>
                    <th> Fecha de inauguración</th>
                </thead>

                <tbody>
                    <?php
                    include "../database/conexion.php";
                    $query = mysqli_query($conection, "SELECT id_celula, nombre_celula, cargo, direccion, zona, fecha_inau, estado FROM celula ");
                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <td><?php echo $data['id_celula']; ?></td>
                                <td><?php echo $data['nombre_celula']; ?></td>
                                <td><?php echo $data['cargo']; ?></td>
                                <td><?php echo $data['direccion']; ?></td>
                                <td><?php echo $data['zona']; ?></td>
                                <td><?php if ($data['estado'] == 1) {
                                        echo 'Activo';
                                    } else {
                                        echo 'Inactivo';
                                    } ?>
                                </td>
                                <td><?php echo $data['fecha_inau']; ?></td> 
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