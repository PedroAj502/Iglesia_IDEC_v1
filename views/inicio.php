<?php include "scripts.php" ?>
<title>Dashboard</title>
</head>

<body>
    <?php include "menu.php" ?>
    <!-- INICIO CONFIG CARDS -->
     
    <!-- CARD CELULA ACTIVA -->
    <?php
    include "../database/conexion.php";
    $sql = "SELECT COUNT(*) AS total_activas FROM celula WHERE estado = 1";
    $result = mysqli_query($conection, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_activas = $row['total_activas'];
    ?>
    <!-- CARD TOTAL MINISTERIOS -->
    <?php
    include "../database/conexion.php";
    $sql = "SELECT COUNT(*) AS total_ministerios FROM ministerio";
    $result = mysqli_query($conection, $sql);
    $row = mysqli_fetch_assoc($result);
    $total__ministerios = $row['total_ministerios'];
    ?>
    <!-- CARD TOTAL MIEMBROS -->
    <?php
    include "../database/conexion.php";
    $sql = "SELECT COUNT(*) AS total_miembros FROM miembro";
    $result = mysqli_query($conection, $sql);
    $row = mysqli_fetch_assoc($result);
    $total__mmiembros = $row['total_miembros'];
    ?>
    <!-- CARD MIMBROS ACTIVOS TOTALES -->
    <?php
    include "../database/conexion.php";
    $sql = "SELECT COUNT(*) AS total_m_activos FROM miembro WHERE estado = 1";
    $result = mysqli_query($conection, $sql);
    $row = mysqli_fetch_assoc($result);
    $total__m_activos = $row['total_m_activos'];
    ?>
    <!-- END CONFIG CARDS -->

    <main>
        <h2 style="color: #000;">Resumen general de la iglesia</h2>
        <div class="cards">
            <div class="card_single">
                <div>
                    <h1><?php echo $total__mmiembros; ?></h1>
                    <span>Miembros totales</span>
                </div>
                <div>
                    <span class="las la-users"></span>
                </div>
            </div>

            <div class="card_single">
                <div>
                    <h1><?php echo $total__m_activos; ?></h1>
                    <span>Miembros activos</span>
                </div>
                <div>
                    <span class="las la-user-check"></span>
                </div>
            </div>

            <div class="card_single">
                <div>
                    <h1><?php echo $total__ministerios; ?></h1>
                    <span>Ministerios</span>
                </div>
                <div>
                    <span class="las la-heart"></span>
                </div>
            </div>

            <div class="card_single">
                <div>
                    <h1><?php echo $total_activas; ?></h1>
                    <span>Células activas</span>
                </div>
                <div>
                    <span class="las la-church"></span>
                </div>
            </div>

        </div>
        <!-- CARTELERA -->

        <div class="recent_grid">
            <!-- <div class="orders">
                <div class="card">
                    <div class="card_header">
                        <h3>Miembros</h3>
                        <button>Ver todo <span clas="las la-arrow-right"></span></button>
                    </div>
                    <div class="card_body">
                        <div class="table_responsive">
                            <table id="table_ini" width="100%">
                                <thead>
                                    <tr>
                                        <td>Projects Title</td>
                                        <td>Departament</td>
                                        <td>Status</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>UI/UX Design</td>
                                        <td>Web Dev</td>
                                        <td>
                                            <span class="status"></span>
                                            review
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Web Development</td>
                                        <td>Front end</td>
                                        <td>
                                            <span class="status"></span>
                                            In Progress
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ushop app</td>
                                        <td>movil team</td>
                                        <td>
                                            <span class="status"></span>
                                            pending
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

        
            <div class="mate_">
                <div class="card">
                    <div class="card_header">
                        <h3>Miembros recientes</h3>
                        <?php
                        if ($id_rol == 1 || $id_rol == 2) {
                        ?>
                            <button type="button" onclick="window.location='../views/v-id-gestion-miembros.php'">Ver todo</button>
                        <?php }
                        ?>

                        <?php
                        if ($id_rol == 3) {
                        ?>
                            <button type="button" onclick="window.location='../views/v-id-gestion-miembros-consultor.php'">Ver todo</button>
                        <?php }
                        ?>
                    </div>
                    <div class="card_body">
                        <?php
                        include "../database/conexion.php";
                        $query = mysqli_query($conection, "SELECT id_miembro, nombre_completo, direccion, photo FROM miembro ORDER BY id_miembro DESC LIMIT 3");
                        while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                            <div class="mat_prim">
                                <div class="info">
                                    <!-- Si existe foto la mostramos, sino ponemos una por defecto -->
                                    <?php if (!empty($data['photo'])) { ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['photo']); ?>"
                                            width="45px" height="45px" alt="">
                                    <?php } else { ?>
                                        <img src="../assets/imagens/default1.png" width="45px" height="45px" alt="">
                                    <?php } ?>

                                    <div>
                                        <h4><?php echo $data['nombre_completo']; ?></h4>
                                        <small><?php echo $data['direccion']; ?></small>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

    </main>
    <?php include "footer.php" ?>