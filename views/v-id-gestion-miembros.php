<?php include "scripts.php" ?>
<title>Gestión de miembros</title>
</head>

<body>

    <?php include "menu.php" ?>

    <main>
        <div class="container_option_bar">
            <div class="options_bar">
                <a href="../views/v-id-add_miembro.php" class="btn-open-popup"> <i class="las la-user-plus"></i> </a>

                <div class="titulo">
                    <h1 class="las la-user"> Gestión de miembros</h1>
                </div>
                <div class="buttons">
                    <a class="btn-open-popup" type="button" onclick="exportarxls_mie()"><i class="las la-file-excel"></i></a> &nbsp;
                    <a type="button" class="btn-open-popup" onclick="exportarPDF_mie()"><i class="las la-file-pdf"></i></a>

                </div>
            </div>
        </div>

        <div class="container_table" align="center">
        <img id="logo_empresa" src="../assets/imagens/LOGOO.jpg" style="display:none;">
            <table id="data_table" class="tbl_views">
                <thead>
                    <th> # </th> 
                    <th> Miembro </th> 
                    <th> DPI/CUI </th>
                    <th> Género</th>
                    <th>Edad</th>
                    <th>Fecha de nacimiento</th>
                    <th>Estado civil</th>
                    <th>Profesión/Oficio</th>
                    <th>Estado</th>
                    <th>Dirección</th>
                    <th>No. Teléfono</th>
                    <th>Correo electrónico</th>
                    <th>Fecha de conversión</th>
                    <th>Lugar de conversión</th>
                    <th>Bautizo de agua</th>
                    <th>Fecha del bautizo</th>
                    <th>Lugar del bautizo</th>
                    <th>Bautizo de espíritu</th>
                    <th>Fecha del bautizo</th>
                    <th>Lugar del bautizo</th>
                    <th>Célula</th>
                    <th>Fecha de asignación</th>
                    <th>Ministerio</th>
                    <th>Fecha de asignación</th>
                    <th>Creador</th>
                    <th> Fecha de registro</th>
                    <th> D.I.</th>
                    <th > Editar</th>
                    <th > SUPR</th>
                </thead>

                <tbody>
                    <?php
                    include "../database/conexion.php";

                    $query = mysqli_query($conection, "SELECT uss.id_usuario, uss.nombre_usuario, m.id_usuario, m.id_miembro, m.nombre_completo, m.dpi, m.genero, m.edad, m.fecha_nacimiento, m.estado_civil, m.profesion_oficio, m.estado,
                    m.direccion, m.telefono, m.photo, m.email, m.fecha_conversion,m.lugar_conversion,m.bautizo_agua,m.fecha_bautizo_agua,m.lugar_bautizo_agua,m.bautizo_espiritu,m.fecha_bautizo_espiritu,
                    m.lugar_bautizo_espiritu, m.fecha_registro, c.nombre_celula,m.`fecha-asign-celula`,min.nombre_ministerio,m.`fecha-asign-ministerio` FROM miembro m 
                    LEFT JOIN usuario uss ON m.id_usuario = uss.id_usuario
                    LEFT JOIN celula c ON m.id_celula = c.id_celula
                    LEFT JOIN ministerio min ON m.id_ministerio = min.id_ministerio");

                    $result = mysqli_num_rows($query);
                    if ($result > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                    ?>
                            <tr>
                                <td><?php echo $data['id_miembro']; ?></td>
                                <td><?php echo $data['nombre_completo']; ?></td>
                                <td><?php echo $data['dpi']; ?></td>
                                <td><?php if ($data['genero'] == 1) {
                                        echo 'Masculino';
                                    } else {
                                        echo 'Femenino';
                                    }; ?></td>
                                <td><?php echo $data['edad']; ?></td>
                                <td><?php echo $data['fecha_nacimiento']; ?></td>
                                <td><?php echo $data['estado_civil']; ?></td>
                                <td><?php echo $data['profesion_oficio']; ?></td>
                                <td><?php if ($data['estado'] == 1) {
                                        echo 'Activo';
                                    } else {
                                        echo 'Inactivo';
                                    }; ?></td>
                                <td><?php echo $data['direccion']; ?></td>
                                <td><?php echo $data['telefono']; ?></td>
                                <td><?php echo $data['email']; ?></td>
                                <td><?php echo $data['fecha_conversion']; ?></td>
                                <td><?php echo $data['lugar_conversion']; ?></td>
                                <td><?php if ($data['bautizo_agua'] == 1) {
                                        echo 'Sí';
                                    } else {
                                        echo 'No';
                                    }; ?></td>
                                <td><?php echo $data['fecha_bautizo_agua']; ?></td>
                                <td><?php echo $data['lugar_bautizo_agua']; ?></td>
                                <td><?php if ($data['bautizo_espiritu'] == 1) {
                                        echo 'Sí';
                                    } else {
                                        echo 'No';
                                    }; ?></td>
                                <td><?php echo $data['fecha_bautizo_espiritu']; ?></td>
                                <td><?php echo $data['lugar_bautizo_espiritu']; ?></td>
                                <td><?php if ($data['nombre_celula']){
                                    echo $data['nombre_celula'];
                                } else {
                                    echo 'No asignado';
                                }; ?></td>
                                <td><?php echo $data['fecha-asign-celula']; ?></td>
                                <td><?php if ($data['nombre_ministerio'] == Null){
                                    echo 'No asignado';
                                } else {
                                    echo $data['nombre_ministerio'];
                                }; ?></td>
                                <td><?php echo $data['fecha-asign-ministerio']; ?></td>
                                <td><?php echo $data['nombre_usuario']; ?></td>
                                
                                    
                                <td><?php echo $data['fecha_registro']; ?></td>
                                <td>
                                    
                                        <a class="button_2" href="../assets/reports/pdf/carne.php?id=<?php echo $data['id_miembro']; ?>" target="_blank">
                                            <span class="las la-address-card"></span>
                                        </a>
                                    
                                </td>

                                <td>
                                    <a class="button_2"  href="v-id-modificar-miembro.php?id=<?php echo $data['id_miembro']; ?>">
                                        <span class="las la-pen"></span>
                                    </a>
                                </td>

                                <td>
                                    
                                        <a class="button_2" href="../assets/reports/pdf/carne.php?id=<?php echo $data['id_miembro']; ?>" target="_blank">
                                            <span class="las la-address-card"></span>
                                        </a>
                                    
                                </td>

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