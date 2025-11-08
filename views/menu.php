<?php
session_start();
if (empty($_SESSION['active'])) {
    header('location: ../');
}
if (isset($_SESSION["ID_user"])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 6000) //60  
    {
        header('location: ../database/destroy_session.php');
    } else {
        $_SESSION['last_login_timestamp'] = time();
        $_SESSION["ID_user"];
        $_SESSION['last_login_timestamp'];
    }
} else {
    header('location: ../');
}
$id_rol = $_SESSION['id_rol'];
?>

<input type="checkbox" id="nav-toggle">
<div class="sidebar">
    <div class="sidebar_brand">
        <h2><span><img src="../assets/imagens/f631a54d-d14a-4f61-a3c5-b27ba5edf119.jfif" width="100px" height="100px" alt=""></span></h2>
    </div>
    <div class="sidebar_menu">
        <ul>
            <?php
            if ($id_rol == 1 || $id_rol == 2 || $id_rol == 3) {
            ?>
                <li><a href="inicio.php" class="active">
                        <span><img class="active" src="../assets/imagens/f631a54d-d14a-4f61-a3c5-b27ba5edf119.jfif" width="50px" height="50px" alt=""></span>
                        <span>Dashboard</span></a>
                </li>
            <?php }
            ?>



            <?php
            if ($id_rol == 1 || $id_rol == 2) {
            ?>
                <li><a href="v-id-gestion-miembros.php">
                        <span class="las la-user-plus"></span>
                        <span>Gestión de miembros</span></a>
                </li>

                <li><a href="v-id-gestion-ministerio.php">
                        <span class="las la-clipboard-check"></span>
                        <span>Ministerios</span></a>
                </li>

                <li><a href="v-id-gestion-celulas.php">
                        <span class="las la-church"></span>
                        <span>Células de oración</span></a>
                <?php }
                ?>


                <?php
                if ($id_rol == 3) {
                ?>
                <li><a href="v-id-gestion-miembros-consultor.php">
                        <span class="las la-user-plus"></span>
                        <span>Gestión de miembros</span></a>
                </li>

                <li><a href="v-id-gestion-ministerio-consultor.php">
                        <span class="las la-clipboard-check"></span>
                        <span>Ministerios</span></a>
                </li>

                <li><a href="v-id-gestion-celulas-consultor.php">
                        <span class="las la-church"></span>
                        <span>Células de oración</span></a>
            <?php }
            ?>
            </li>

            <hr><br>

            <?php
            if ($id_rol == 1 || $id_rol == 3) {
            ?>
                <li><a href="../views/reportes.php">
                        <span class="las la-file"></span>
                        <span>Reportes</span></a>
                </li>
            <?php }
            ?>


            <?php
            if ($id_rol == 1) {
            ?>
                <hr><br>
                <li><a href="v-id-gestion-usuarios.php">
                        <span class="las la-user-cog"></span>
                        <span>Configuracion de Usuarios</span></a>
                </li>
            <?php }
            ?>

            <li><a href="ayuda.php">
                    <span class="las la-heart"></span>
                    <span>Ayuda</span></a>
            </li>
            <li><a href="../database/destroy_session.php">
                    <span class="las la-power-off"></span>
                    <span>Salir</span></a>
            </li>
            <hr>
        </ul>
    </div>
</div>

<div class="main_content">
    <header>
        <h2>
            <label for="nav-toggle">
                <span class="las la-bars"></span>
            </label>
            Dashboard
        </h2>


        <div class="user_wrapper">
            <?php
            include "../database/conexion.php";
            $id_usuario = $_SESSION['ID_user'];

            $query = "SELECT r.id_rol, r.nombre_rol, u.* FROM rol r, usuario u WHERE u.id_usuario = '$id_usuario' AND r.id_rol = u.id_rol";
            $resul = $conection->query($query);
            $row = $resul->fetch_assoc();
            ?>
            <!-- <img src="data:image/jpg;base64,<?php echo base64_encode($row['bkgd_imagen']); ?>" width="40px" height="40px" alt=""> -->

            <div>
                <h4><?php
                    echo $row['nombre_usuario'];
                    ?>
                </h4>

                <small><?php
                        echo $row['nombre_rol'];
                        ?>
                </small>
            </div>
        </div>
    </header>