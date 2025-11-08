<?php
require_once 'conexion.php';
require_once 'fpdf/fpdf.php';

// asegurar que la conexión use UTF-8 para evitar problemas con tildes/ñ
if (isset($conection) && function_exists('mysqli_set_charset')) {
    mysqli_set_charset($conection, 'utf8');
}
 
date_default_timezone_set('America/Guatemala');

// Clase PDF con helpers para tabla multilinea
class PDF extends FPDF
{
    protected $widths;
    protected $aligns;

    function Header()
    {
        // logo centrado
        $logo = __DIR__ . '/../../imagens/LOGOO.jpg';
        if (file_exists($logo)) {
            $logoW = 35;
            $x = ($this->GetPageWidth() - $logoW) / 2;
            $this->Image($logo, $x, 8, $logoW);
        }
        $this->SetY(38);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 6, utf8_decode('Reporte de Miembros'), 0, 1, 'C');
        $this->Ln(2);
    }

    function SetWidths($w)
    {
        $this->widths = $w;
    }
    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            if (isset($cw[$c])) $l += $cw[$c];
            else $l += $cw['0'];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else $i++;
        }
        return $nl;
    }

    function CheckPageBreak($h, $headerCallback = null)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage();
            if (is_callable($headerCallback)) call_user_func($headerCallback);
        }
    }

    function Row($data, $lineHeight = 5, $headerCallback = null)
    {
        $nb = 0;
        for ($i = 0; $i < count($this->widths); $i++) {
            $txt = isset($data[$i]) ? $data[$i] : '';
            $nb = max($nb, $this->NbLines($this->widths[$i], $txt));
        }
        $h = $lineHeight * $nb;
        $this->CheckPageBreak($h, $headerCallback);

        $x = $this->GetX();
        $y = $this->GetY();
        for ($i = 0; $i < count($this->widths); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $txt = isset($data[$i]) ? $data[$i] : '';

            // celda marco
            $this->Rect($x, $y, $w, $h);
            // texto con padding
            $this->SetXY($x + 2, $y + 1);
            $this->MultiCell($w - 4, $lineHeight, $txt, 0, $a);
            // volver al tope y mover X
            $this->SetXY($x + $w, $y);
            $x += $w;
        }
        $this->SetXY($this->lMargin, $y + $h);
    }
}

// Instancia PDF
$pdf = new PDF('L', 'mm', 'legal');
$pdf->SetAutoPageBreak(true, 12);

// definir márgenes en variables (no usar $pdf->lMargin fuera de la clase)
$leftMargin  = 10;
$topMargin   = 10;
$rightMargin = 10;
$pdf->SetMargins($leftMargin, $topMargin, $rightMargin);

$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// recibir filtros del formulario (ajusta nombres si son diferentes)
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin    = $_POST['fecha_fin'] ?? '';

$where = "";
if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $where = "WHERE fecha_registro BETWEEN '$fecha_inicio' AND '$fecha_fin'";
}

$sql = "SELECT m.*, c.nombre_celula, min.nombre_ministerio 
        FROM miembro m
        LEFT JOIN celula c ON m.id_celula = c.id_celula
        LEFT JOIN ministerio min ON m.id_ministerio = min.id_ministerio
        $where
        ORDER BY m.id_miembro ASC";

$miembros = mysqli_query($conection, $sql);

// calcular anchos proporcionalmente al área imprimible para evitar desbordes
$printable = $pdf->GetPageWidth() - $leftMargin - $rightMargin;
$ratios = [4, 20, 12, 8, 6, 10, 10, 15, 15, 6]; // sum=105
$sumRatios = array_sum($ratios);
$widths = [];
$acc = 0;
for ($i = 0; $i < count($ratios); $i++) {
    // calcular con floor para evitar redondeos que excedan al final
    if ($i < count($ratios) - 1) {
        $w = (int) floor($printable * $ratios[$i] / $sumRatios);
        $widths[] = $w;
        $acc += $w;
    } else {
        // última columna: tomar el resto exacto para que la suma sea igual al printable
        $widths[] = (int) ($printable - $acc);
    }
}
$pdf->SetWidths($widths);
$pdf->SetAligns(['C', 'L', 'L', 'C', 'C', 'C', 'L', 'L', 'L', 'C']);

// función para dibujar encabezado de tabla
$drawTableHeader = function () use ($pdf, $widths, $leftMargin) {
    $headers = ['#', 'Nombre', 'DPI', 'Género', 'Edad', 'Fecha Nac.', 'Estado Civil', 'Célula', 'Ministerio', 'Estado'];
    $lineH = 6;
    $pdf->SetFont('Arial', 'B', 10);

    // asegurar separación respecto al Header de la página
    $y0 = $pdf->GetY();
    if ($y0 < 30) $y0 = 30; // bajar si está muy arriba (evita superposición con logo/título)

    // calcular altura del encabezado (soporta multi-línea)
    $maxLines = 1;
    for ($i = 0; $i < count($headers); $i++) {
        $lines = $pdf->NbLines($widths[$i], utf8_decode($headers[$i]));
        if ($lines > $maxLines) $maxLines = $lines;
    }
    $headerH = $lineH * $maxLines;

    // dibujar cada celda del encabezado controlando X manualmente
    $x = $leftMargin;
    for ($i = 0; $i < count($headers); $i++) {
        $w = $widths[$i];
        $pdf->Rect($x, $y0, $w, $headerH);
        $pdf->SetXY($x, $y0);
        $pdf->MultiCell($w, $lineH, utf8_decode($headers[$i]), 0, 'C');
        $x += $w;
    }

    // posicionar el cursor justo debajo de los encabezados
    $pdf->SetXY($leftMargin, $y0 + $headerH);
    $pdf->SetFont('Arial', '', 10);
};
// dibujar el header de tabla por primera vez
$drawTableHeader();

if ($miembros && mysqli_num_rows($miembros) > 0) {
    while ($row = mysqli_fetch_assoc($miembros)) {
        $id = $row['id_miembro'];
        $nombre = utf8_decode($row['nombre_completo'] ?? '');
        $dpi = $row['dpi'] ?? '';
        $genero = ($row['genero'] == 1) ? 'Masculino' : 'Femenino';
        $edad = $row['edad'] ?? '';
        $fechaN = '';
        if (!empty($row['fecha_nacimiento']) && ($ts = strtotime($row['fecha_nacimiento']))) {
            $fechaN = date('d/m/Y', $ts);
        } 
        $estadoCivil = utf8_decode($row['estado_civil'] ?? '');
        $celula = !empty($row['nombre_celula']) ? utf8_decode($row['nombre_celula']) : utf8_decode('No asignado');
        $ministerio = !empty($row['nombre_ministerio']) ? utf8_decode($row['nombre_ministerio']) : utf8_decode('No asignado');
        $estado = ($row['estado'] == 1) ? 'Activo' : 'Inactivo';

        $data = [
            $id,
            $nombre,
            $dpi,
            utf8_decode($genero),
            $edad,
            $fechaN,
            $estadoCivil,
            $celula,
            $ministerio,
            utf8_decode($estado)
        ];

        // pasar callback para que al AddPage vuelva a dibujar encabezado
        $pdf->Row($data, 6, function () use ($pdf, $drawTableHeader, $leftMargin) {
            // ajustar posición izquierda antes de dibujar header

            $pdf->SetX($leftMargin);
            $drawTableHeader();
        });
    }
}

$pdf->Output("reporte_miembros.pdf", "I");
exit;
