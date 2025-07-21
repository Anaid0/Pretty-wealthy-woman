<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
require('../../pdf/fpdf.php');
$sql = "SELECT 
            p.id_producto,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.activo,
            pr.nombre_empresa AS nombre_proveedor
        FROM productos p
        INNER JOIN proveedores pr ON p.id_proveedor = pr.id
        ORDER BY p.nombre ASC";

$result = $conexion->query($sql);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Lista de Productos', 0, 1, 'C');
$pdf->Ln(5);

// Encabezados de tabla
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 8, 'ID', 1, 0, 'C');
$pdf->Cell(40, 8, 'Nombre', 1, 0, 'C');
$pdf->Cell(50, 8, 'Descripcion', 1, 0, 'C');
$pdf->Cell(20, 8, 'Precio', 1, 0, 'C');
$pdf->Cell(15, 8, 'Stock', 1, 0, 'C');
$pdf->Cell(25, 8, 'Estado', 1, 0, 'C');
$pdf->Cell(30, 8, 'Proveedor', 1, 1, 'C');

// Colores
$pdf->SetFillColor(255, 192, 203); // Rosita
$pdf->SetDrawColor(200, 100, 100);

// Cuerpo de tabla
$pdf->SetFont('Arial', '', 7);
$fill = false;
while ($row = $result->fetch_assoc()) {
    $pdf->SetFillColor(255, 230, 240);

    $pdf->Cell(10, 6, $row['id_producto'], 1, 0, 'C', $fill);
    $pdf->Cell(40, 6, utf8_decode($row['nombre']), 1, 0, 'L', $fill);
    $pdf->Cell(50, 6, utf8_decode($row['descripcion']), 1, 0, 'L', $fill);
    $pdf->Cell(20, 6, '$' . number_format($row['precio'], 0), 1, 0, 'R', $fill);
    $pdf->Cell(15, 6, $row['stock'], 1, 0, 'C', $fill);
    $pdf->Cell(25, 6, utf8_decode($row['activo']), 1, 0, 'C', $fill);
    $pdf->Cell(30, 6, utf8_decode($row['nombre_proveedor']), 1, 1, 'L', $fill);

    $fill = !$fill;
}

$pdf->Output('D', 'productos.pdf');
?>