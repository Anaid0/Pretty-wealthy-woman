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

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0);
$pdf->Cell(190, 10, 'Lista de Usuarios', 0, 1, 'C');
$pdf->Ln(5);

// Colores
$pdf->SetFillColor(255, 192, 203); // Rosita
$pdf->SetDrawColor(200, 100, 100);

// Encabezado
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Correo', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Documento', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Celular', 1, 0, 'C', true);
$pdf->Cell(15, 8, 'Rol', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Estado', 1, 1, 'C', true);

// Datos
$pdf->SetFont('Arial', '', 7);
$fill = false;

while ($row = $result->fetch_assoc()) {
    $pdf->SetFillColor(255, 230, 240); // Rosita claro para filas
    $pdf->Cell(15, 7, $row['id_usuario'], 1, 0, 'C', $fill);
    $pdf->Cell(30, 7, utf8_decode($row['nombre']), 1, 0, 'C', $fill);
    $pdf->Cell(45, 7, utf8_decode($row['correo']), 1, 0, 'C', $fill);
    $pdf->Cell(25, 7, utf8_decode($row['documento']), 1, 0, 'C', $fill);
    $pdf->Cell(30, 7, utf8_decode($row['celular']), 1, 0, 'C', $fill);
    $pdf->Cell(15, 7, utf8_decode($row['rol']), 1, 0, 'C', $fill);
    $pdf->Cell(20, 7, utf8_decode($row['estado']), 1, 1, 'C', $fill);
    $fill = !$fill;
}

$pdf->Output('D', 'usuarios.pdf');
?>
