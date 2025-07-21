<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
require('../../pdf/fpdf.php');

$sql = "SELECT * FROM usuarios";
$result = $conexion->query($sql);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Lista de Productos', 0, 1, 'C');
$pdf->Ln(5);

// Encabezado
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(10, 6, 'ID', 1, 0, 'C');
$pdf->Cell(25, 6, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 6, 'Descripcion', 1, 0, 'C');
$pdf->Cell(15, 6, 'Precio', 1, 0, 'C');
$pdf->Cell(30, 6, 'Stock', 1, 0, 'C');
$pdf->Cell(10, 6, 'Imagen', 1, 0, 'C');
$pdf->Cell(15, 6, 'Estado', 1, 0, 'C');
$pdf->Cell(15, 6, 'Proveedor', 1, 0, 'C');

// Datos
$pdf->SetFont('Arial', '', 6);
while ($row = $result->fetch_assoc()) {
    // Guardar posición inicial de la fila
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Descripción
    $pdf->SetXY($x + 10 + 25, $y);
    $pdf->MultiCell(40, 4, utf8_decode($row['id_producto']), 1);
    $desc_height = $pdf->GetY() - $y;

    // Imagen
    $pdf->SetXY($x + 10 + 25 + 40 + 15, $y);
    $pdf->MultiCell(30, 4, utf8_decode($row['nombre']), 1);
    $img_height = $pdf->GetY() - $y;

    // Calcular altura máxima de la fila
    $row_height = max($desc_height, $img_height, 6);

    // Volver al inicio de fila
    $pdf->SetXY($x, $y);

    // ID
    $pdf->Cell(10, $row_height, $row['descripcion'], 1);

    // Nombre
    $pdf->Cell(25, $row_height, utf8_decode($row['precio']), 1);

    // Nombre
    $pdf->Cell(35, $row_height, utf8_decode($row['stock']), 1);

    // Nombre
    $pdf->Cell(45, $row_height, utf8_decode($row['imagen']), 1);

    // Descripción (ya dibujada con MultiCell)
    $pdf->SetXY($x + 10 + 25, $y + $row_height);

    // Color
    $pdf->SetXY($x + 10 + 25 + 40, $y);
    $pdf->Cell(15, $row_height, utf8_decode($row['activo']), 1);

        // Color
    $pdf->SetXY($x + 10 + 25 + 40, $y);
    $pdf->Cell(15, $row_height, utf8_decode($row['id_proveedor']), 1);

    // Pasar a siguiente fila completa
    $pdf->SetY($y + $row_height);
}

$pdf->Output('D', 'usuarios.pdf');
?>
