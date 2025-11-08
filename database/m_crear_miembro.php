
<?php
include('../database/conexion.php');
session_start();

if (isset($_POST['save-miembro'])) {
    // Escapar todos los campos
    
    date_default_timezone_set('America/Guatemala');
    $fecha_actual = date("Y-m-d H:i:s");

    $id_usuario         = $_SESSION['ID_user'];
    $nombre_m_completo  = mysqli_real_escape_string($conection, $_POST['nombre-completo']);
    $dpi_cui            = mysqli_real_escape_string($conection, $_POST['dpi']);
    $genero_macho_f     = mysqli_real_escape_string($conection, $_POST['genero_select']);
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
    $bautizo_agua       = mysqli_real_escape_string($conection, $_POST['bautizado-a']);
    $fecha_bautizo_agua = $_POST['fecha-bautizo-a'];
    $lugar_bautizo_agua = mysqli_real_escape_string($conection, $_POST['lugar-bautizo-a']);
    $bautizo_espiritu   = mysqli_real_escape_string($conection, $_POST['bautizado-e']);
    $fecha_bautizo_esp  = $_POST['fecha-bautizo-e'];
    $lugar_bautizo_esp  = mysqli_real_escape_string($conection, $_POST['lugar-bautizo-e']);
    $id_celula_asig     = (int)$_POST['celula-select'];
    $fecha_asig_celula  = $_POST['fecha-asignacion-c'];
    $id_ministerio_asig = (int)$_POST['ministerio-select'];
    $fecha_asig_minist  = $_POST['fecha-asignacion-m'];
 
    // Validación de campos obligatorios
    if (
        empty($nombre_m_completo) || empty($dpi_cui) || !isset($_POST['genero_select']) ||
        empty($edad_miembro) || empty($fecha_d_nac) || empty($estado__civil) ||
        empty($profesion_oficio) || !isset($_POST['estado'])
    ) {
        echo '<script> alert("¡Debe completar todos los campos obligatorios!"); window.location = "../views/v-id-gestion-miembros.php";</script>';
        exit;
    }


    // Validación de duplicados
    $dpi_cui = trim(mysqli_real_escape_string($conection, $_POST['dpi']));

    $check = mysqli_query($conection, "SELECT * FROM miembro WHERE dpi='$dpi_cui'");
    if (mysqli_num_rows($check) > 0) {
        echo '<script>alert("Ya existe un miembro con ese DPI."); window.location = "../views/v-id-gestion-miembros.php";</script>';
        exit;
    }

    // Validación de imagen
    if ($_FILES['idecimg']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['idecimg']['type'], $allowed_types)) {
            echo '<script>alert("Solo se permiten imágenes JPG o PNG."); window.location = "../views/v-id-add-miembros.php";</script>';
            exit;
        }
        if ($_FILES['idecimg']['size'] > 2 * 1024 * 1024) {
            echo '<script>alert("La imagen no debe superar los 2MB."); window.location = "../views/v-id-add_miembros.php";</script>';
            exit;
        }
        $archivo = addslashes(file_get_contents($_FILES['idecimg']['tmp_name']));
    } else {
        $archivo = null;
    }

    // verifica si el ministerio y la celula es nulo... envia NULL a la base de datos
    // si no es nulo, envia el valor seleccionado
    $id_ministerio_asig = isset($_POST['ministerio-select']) && $_POST['ministerio-select'] !== "" ? (int)$_POST['ministerio-select'] : "NULL";
   $id_celula_asig = isset($_POST['celula-select']) && $_POST['celula-select'] !== "" ? (int)$_POST['celula-select'] : "NULL";

    //consulta: inserta en la base de datos
    $query = mysqli_query($conection, "INSERT INTO miembro 
        (id_usuario, nombre_completo, dpi, genero, edad, fecha_nacimiento, estado_civil, profesion_oficio, estado, photo, direccion, telefono, email, 
        fecha_conversion, lugar_conversion, bautizo_agua, fecha_bautizo_agua, lugar_bautizo_agua, bautizo_espiritu, fecha_bautizo_espiritu, lugar_bautizo_espiritu, 
        id_celula, `fecha-asign-celula`, id_ministerio, `fecha-asign-ministerio`, fecha_registro)
        VALUES (
        '$id_usuario', '$nombre_m_completo', '$dpi_cui', '$genero_macho_f', '$edad_miembro', '$fecha_d_nac', '$estado__civil', '$profesion_oficio', '$estado_actual', '$archivo',
    '$residecia_miembro', '$telefono_miembro', '$email_miembro',
    '$fecha_conversion', '$lugar_conversion', '$bautizo_agua', '$fecha_bautizo_agua', '$lugar_bautizo_agua', '$bautizo_espiritu', '$fecha_bautizo_esp', '$lugar_bautizo_esp',
    " . ($id_celula_asig === "NULL" ? "NULL" : $id_celula_asig) . ", '$fecha_asig_celula', " . ($id_ministerio_asig === "NULL" ? "NULL" : $id_ministerio_asig) . ", '$fecha_asig_minist', '$fecha_actual')");

    if ($query) {
        echo '<script> alert("¡Miembro registrado exitosamente!"); window.location = "../views/v-id-gestion-miembros.php";</script>';
    } else {
        error_log(mysqli_error($conection));
        echo '<script> alert("¡Error al registrar el miembro!"); window.location = "../views/v-id-add_miembro.php";</script>';
    }
}
?>