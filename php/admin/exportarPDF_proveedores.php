<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
require('../../pdf/fpdf.php');

$sql = "SELECT * FROM proveedores";
$result = $conexion->query($sql);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0);
$pdf->Cell(190, 10, 'Lista de Proveedores', 0, 1, 'C');
$pdf->Ln(5);

// Colores
$pdf->SetFillColor(255, 192, 203); // Rosita
$pdf->SetDrawColor(200, 100, 100);

// Encabezado
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(50, 8, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(70, 8, 'Correo', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Telefono', 1, 1, 'C', true);

// Datos
$pdf->SetFont('Arial', '', 7);
$fill = false;

while ($row = $result->fetch_assoc()) {
    $pdf->SetFillColor(255, 230, 240); // Rosita claro
    $pdf->Cell(25, 7, $row['id'], 1, 0, 'C', $fill);
    $pdf->Cell(50, 7, utf8_decode($row['nombre_empresa']), 1, 0, 'C', $fill);
    $pdf->Cell(70, 7, utf8_decode($row['email']), 1, 0, 'C', $fill);
    $pdf->Cell(45, 7, utf8_decode($row['telefono']), 1, 1, 'C', $fill);
    $fill = !$fill;
}

$pdf->Output('D', 'proveedores.pdf');
?>
