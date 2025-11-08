<?php
require_once __DIR__ . '/../../../database/conexion.php';
require_once __DIR__ . '/fpdf/fpdf.php';

$id_miembro = isset($_GET['id']) ? (int) $_GET['id'] : 1;

// Consulta datos del miembro
$sql = "SELECT m.*, c.nombre_celula, min.nombre_ministerio 
        FROM miembro m
        LEFT JOIN celula c ON m.id_celula = c.id_celula
        LEFT JOIN ministerio min ON m.id_ministerio = min.id_ministerio
        WHERE m.id_miembro = $id_miembro";
$res = mysqli_query($conection, $sql);
$data = mysqli_fetch_assoc($res);

// Tamaño tipo carné (landscape pequeño)
$pdf = new FPDF('L', 'mm', array(100, 75)); 
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);

// Logo (arriba a la derecha)
$logo = __DIR__ . '/../../imagens/LOGOO.jpg';
$logoWidth = 15; // ancho en mm
$pageWidth = $pdf->GetPageWidth();
$marginRight = 4;
$xLogo = $pageWidth - $logoWidth - $marginRight;
if (file_exists($logo)) {
    $pdf->Image($logo, $xLogo, 4, $logoWidth);
}

// Título centrado arriba
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetY(4);
$pdf->Cell(0, 6, utf8_decode('Iglesia de Dios'), 0, 1, 'C');

$pdf->Cell(0, 7, utf8_decode('Evangelio Completo'), 0, 1, 'C');

// Foto del miembro (izquierda)
$photoX = 5;
$photoY = 18;
$photoW = 24;
$photoH = 28;

function saveImageTemp($dataBytes, $mimePref = null) {
    // intenta detectar MIME
    $mime = null;
    if (function_exists('finfo_open')) {
        $f = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_buffer($f, $dataBytes);
        finfo_close($f);
    }
    if (empty($mime) && $mimePref) $mime = $mimePref;

    // elegir extensión
    $ext = 'jpg';
    if ($mime) {
        if (strpos($mime, 'png') !== false) $ext = 'png';
        elseif (strpos($mime, 'gif') !== false) $ext = 'gif';
        elseif (strpos($mime, 'jpeg') !== false || strpos($mime, 'jpg') !== false) $ext = 'jpg';
    }

    $tmp = tempnam(sys_get_temp_dir(), 'img_') . ".$ext";
    file_put_contents($tmp, $dataBytes);
    // si PNG y GD disponible, convertir a JPG (evita problemas de transparencia en FPDF)
    if ($ext === 'png' && function_exists('imagecreatefromstring') && function_exists('imagejpeg')) {
        $im = @imagecreatefromstring($dataBytes);
        if ($im !== false) {
            $tmpJpg = tempnam(sys_get_temp_dir(), 'img_') . ".jpg";
            imagejpeg($im, $tmpJpg, 90);
            imagedestroy($im);
            @unlink($tmp);
            return $tmpJpg;
        }
    }
    return $tmp;
}

if (!empty($data['photo'])) {
    $photoField = $data['photo'];

    try {
        // caso 1: si es ruta/filename guardado
        if (is_string($photoField) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $photoField)) {
            $possible = $photoField;
            if (!file_exists($possible)) {
                $possible = __DIR__ . '/../../imagens/' . basename($photoField);
            }
            if (file_exists($possible)) {
                $pdf->Image($possible, $photoX, $photoY, $photoW, $photoH);
            } else {
                $pdf->Rect($photoX, $photoY, $photoW, $photoH);
            }
        } else {
            // caso 2: BLOB binario o base64
            $raw = $photoField;

            // si es data URI base64 -> extraer
            if (is_string($raw) && preg_match('/^data:image\/([a-zA-Z]+);base64,/', $raw, $m)) {
                $mimePref = 'image/' . strtolower($m[1]);
                $raw = base64_decode(substr($raw, strpos($raw, ',') + 1));
            } else {
                // si parece estar en base64 sin prefijo, intentar decodificar y comprobar
                if (is_string($raw) && base64_decode($raw, true) !== false && strlen(base64_decode($raw)) > 0 && strlen($raw) % 4 === 0) {
                    $decoded = base64_decode($raw);
                    // si decoded tiene bytes binarios razonables, usarlo
                    if ($decoded !== false && strlen($decoded) > 0) {
                        $raw = $decoded;
                    }
                }
            }

            // ahora raw debe ser bytes binarios
            $tmpFile = saveImageTemp($raw, $mimePref ?? null);
            if (file_exists($tmpFile) && filesize($tmpFile) > 0) {
                $pdf->Image($tmpFile, $photoX, $photoY, $photoW, $photoH);
                @unlink($tmpFile);
            } else {
                // fallback visual si algo falla
                if (isset($tmpFile)) @unlink($tmpFile);
                $pdf->Rect($photoX, $photoY, $photoW, $photoH);
            }
        }
    } catch (Exception $e) {
        // en caso de error, mostrar recuadro
        $pdf->Rect($photoX, $photoY, $photoW, $photoH);
    }
} else {
    // sin foto
    $pdf->Rect($photoX, $photoY, $photoW, $photoH);
    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY($photoX, $photoY + ($photoH / 2) - 2);
    $pdf->Cell($photoW, 4, utf8_decode('Sin foto'), 0, 0, 'C');
}

// Datos del miembro (a la derecha de la foto) y mostrar ID/Estado debajo de la foto
$startX = $photoX + $photoW + 6;
$lineHeight = 6;

// helper: normaliza texto desde la BD para FPDF (convierte UTF-8 -> ISO-8859-1)
function safeText($v) {
    $v = trim($v ?? '');
    // si ya está vacío devolver vacío
    if ($v === '') return '';
    // aplicar utf8_decode para que FPDF muestre tildes correctamente
    return utf8_decode($v);
}

// Preparar texto y estado (usar safeText)
$nombre = safeText($data['nombre_completo'] ?? '');
$dpi = $data['dpi'] ?? '';
// Formatear fecha a DD/mm/AA (si quieres 4 dígitos usar d/m/Y)
$fechaNacRaw = $data['fecha_nacimiento'] ?? '';
$fechaNac = '';
if (!empty($fechaNacRaw) && ($ts = strtotime($fechaNacRaw))) {
    $fechaNac = date('d/m/y', $ts); // dd/mm/aa
}
$genero = isset($data['genero']) ? ($data['genero'] == 1 ? 'Masculino' : 'Femenino') : '';
$celula = !empty($row['nombre_celula']) ? utf8_decode($row['nombre_celula']) : utf8_decode('No asignado');
$ministerio = !empty($row['nombre_ministerio']) ? utf8_decode($row['nombre_ministerio']) : utf8_decode('No asignado');
$estadoTxt = (isset($data['estado']) && $data['estado'] == 1) ? 'Activo' : 'Inactivo';

// Nombre: limitar ancho y permitir wrap (ya está en ISO-8859-1)
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY($startX, 18);
$rightWidth = $pageWidth - $startX - 5; // ancho disponible a la derecha de la foto
$pdf->MultiCell($rightWidth, $lineHeight, $nombre, 0, 'L');

// Otros campos (alineados a la misma X, usando el ancho calculado)
$pdf->SetFont('Arial', '', 9);
$pdf->SetX($startX);
$pdf->Cell($rightWidth, $lineHeight, safeText('DPI: ') . $dpi, 0, 1);

$pdf->SetX($startX);
$pdf->Cell($rightWidth, $lineHeight, safeText('Fecha Nac: ') . $fechaNac, 0, 1);

$pdf->SetX($startX);
$pdf->Cell($rightWidth, $lineHeight, safeText('Género: ') . safeText($genero), 0, 1);

$pdf->SetX($startX);
$pdf->Cell($rightWidth, $lineHeight, safeText('Célula: ') . $celula, 0, 1);

$pdf->SetX($startX);
$pdf->Cell($rightWidth, $lineHeight, safeText('Ministerio: ') . $ministerio, 0, 1);

// Mostrar ID y Estado debajo de la foto (centrado dentro del cuadro de la foto)
$pdf->SetFont('Arial', '', 9);
$pdf->SetXY($photoX, $photoY + $photoH + 2);
$pdf->Cell($photoW, 5, 'ID: ' . ($data['id_miembro'] ?? ''), 0, 1, 'C');
$pdf->SetX($photoX);
$pdf->Cell($photoW, 5, safeText('Estado: ') . safeText($estadoTxt), 0, 1, 'C');

// Línea separadora
$yAfter = max($photoY + $photoH + 12, $pdf->GetY()) + 2;
$pdf->SetDrawColor(160);
$pdf->Line(5, $yAfter, $pageWidth - 5, $yAfter);

// Info
$pdf->SetFont('Arial', 'B', 7   );
$pdf->SetXY(6, $yAfter + 4);
$pdf->Cell(40, 2, utf8_decode('El presente documento identifica al portador como miembro de la Iglesia '), 0, 0);
$pdf->SetXY(6, $yAfter + 8);
$pdf->Cell(40, 2, utf8_decode('de Dios Evangelio Completo. Válido únicamente con sello y firma autorizada.'), 0, 0);



// Generar PDF
$pdf->Output("carne_miembro_{$id_miembro}.pdf", "I");
exit;
?>