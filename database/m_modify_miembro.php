<?php
include('conexion.php');
session_start();
 
if (isset($_POST['modi-fi-miem'])) {
    $id_mod = (int)$_POST['id'];
    $id_usuario         = $_SESSION['ID_user'];
    $nombre_m_completo  = mysqli_real_escape_string($conection, $_POST['nombre-completo']);
    $dpi_cui            = mysqli_real_escape_string($conection, $_POST['dpi']);
    $genero_macho_f     = mysqli_real_escape_string($conection, $_POST['genero']);
    $edad_miembro       = (int)$_POST['edad_m'];
    $fecha_d_nac        = $_POST['fecha-nac'];
    $estado__civil      = mysqli_real_escape_string($conection, $_POST['es-civil']);
    $profesion_oficio   = mysqli_real_escape_string($conection, $_POST['profesion-oficio']);
    $estado_actual      = mysqli_real_escape_string($conection, $_POST['estado']);
    $residecia_miembro  = mysqli_real_escape_string($conection, $_POST['address']);
    $telefono_miembro   = mysqli_real_escape_string($conection, $_POST['telcel']);
    $email_miembro      = mysqli_real_escape_string($conection, $_POST['e-mail']);
    $fecha_conversion   = $_POST['fecha-d-conversion'];
    $lugar_conversion   = mysqli_real_escape_string($conection, $_POST['lugar-conversion']);
    $bautizo_agua       = mysqli_real_escape_string($conection, $_POST['bautizoa']);
    $fecha_bautizo_agua = $_POST['fecha-bautizo-a'];
    $lugar_bautizo_agua = mysqli_real_escape_string($conection, $_POST['lugar-bautizo-a']);
    $bautizo_espiritu   = mysqli_real_escape_string($conection, $_POST['bautizoe']);
    $fecha_bautizo_esp  = $_POST['fecha-bautizo-e'];
    $lugar_bautizo_esp  = mysqli_real_escape_string($conection, $_POST['lugar-bautizo-e']);
    $id_celula_asig     = isset($_POST['celula-select']) && $_POST['celula-select'] !== "" ? (int)$_POST['celula-select'] : "NULL";
    $fecha_asig_celula  = $_POST['fecha-asignacion-c'];
    $id_ministerio_asig = isset($_POST['ministerio-select']) && $_POST['ministerio-select'] !== "" ? (int)$_POST['ministerio-select'] : "NULL";
    $fecha_asig_minist  = $_POST['fecha-asignacion-m'];

    // Verifica que el DPI por modificar no exista en otro miembro
    $check = mysqli_query($conection, "SELECT id_miembro FROM miembro WHERE dpi='$dpi_cui' AND id_miembro != '$id_mod'");
    if (mysqli_num_rows($check) > 0) {
        echo '<script>alert("El DPI ingresado ya pertenece a otro miembro."); window.location = "../views/v-id-modificar-miembro.php?id='.$id_mod.'";</script>';
        exit;
    }

    //verifica la foto solo si se sube una nueva, si no no la modifica
    $foto_sql = "";
    if (isset($_FILES['idecimg']) && $_FILES['idecimg']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['idecimg']['type'], $allowed_types)) {
            echo '<script>alert("Solo se permiten imágenes JPG o PNG."); window.location = "../views/v-id-modificar-miembro.php?id='.$id_mod.'";</script>';
            exit;
        }
        if ($_FILES['idecimg']['size'] > 2 * 1024 * 1024) {
            echo '<script>alert("La imagen no debe superar los 2MB."); window.location = "../views/v-id-modificar-miembro.php?id='.$id_mod.'";</script>';
            exit;
        }
        $archivo = addslashes(file_get_contents($_FILES['idecimg']['tmp_name']));
        $foto_sql = ", photo='$archivo'";
    }

    //Actualiza todos los campos 
    $sql_update = mysqli_query($conection, "UPDATE miembro SET 
        nombre_completo='$nombre_m_completo',
        dpi='$dpi_cui',
        genero='$genero_macho_f',
        edad='$edad_miembro',
        fecha_nacimiento='$fecha_d_nac',
        estado_civil='$estado__civil',
        profesion_oficio='$profesion_oficio',
        estado='$estado_actual',
        direccion='$residecia_miembro',
        telefono='$telefono_miembro',
        email='$email_miembro',
        fecha_conversion='$fecha_conversion',
        lugar_conversion='$lugar_conversion',
        bautizo_agua='$bautizo_agua',
        fecha_bautizo_agua='$fecha_bautizo_agua',
        lugar_bautizo_agua='$lugar_bautizo_agua',
        bautizo_espiritu='$bautizo_espiritu',
        fecha_bautizo_espiritu='$fecha_bautizo_esp',
        lugar_bautizo_espiritu='$lugar_bautizo_esp',
        id_celula=$id_celula_asig,
        `fecha-asign-celula`='$fecha_asig_celula',
        id_ministerio=$id_ministerio_asig,
        `fecha-asign-ministerio`='$fecha_asig_minist'
        -- Agrega la foto solo si se sube una nueva
        $foto_sql
        WHERE id_miembro = '$id_mod'
    ");

    if ($sql_update) {
        echo '<script>
            alert("¡Miembro modificado exitosamente!"); 
            window.location = "../views/v-id-gestion-miembros.php"
            </script>';
    } else {
        echo '<script>
            alert("¡Error al modificar el miembro!"); 
            window.location = "../views/v-id-modificar-miembro.php?id='.$id_mod.'"
            </script>';
    }
}
?>