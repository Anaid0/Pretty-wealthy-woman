<?php
require_once("../conexion.php");
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../../index.php");
    exit();
}
require('../../pdf/fpdf.php');

// Consulta SQL
$sql = "SELECT 
    c.id_compra,
    c.total,
    c.fecha_compra,
    u.nombre AS nombre_usuario,
    GROUP_CONCAT(CONCAT(p.nombre, ' ($', dc.precio_unitario, ')') SEPARATOR ', ') AS productos_con_precios
FROM 
    compras c
JOIN 
    usuarios u ON c.id_usuario = u.id_usuario
JOIN 
    detalle_compra dc ON c.id_compra = dc.id_compra
JOIN 
    productos p ON dc.id_producto = p.id_producto
GROUP BY 
    c.id_compra, u.nombre, c.total, c.fecha_compra";

$result = $conexion->query($sql);

// Validar resultados
if ($result->num_rows === 0) {
    die("No hay resultados para mostrar en el PDF.");
}

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Lista de Ventas', 0, 1, 'C');
$pdf->Ln(5);

// Colores
$pdf->SetFillColor(255, 192, 203); // Rosita
$pdf->SetDrawColor(200, 100, 100);

// Encabezado
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 6, 'ID', 1, 0, 'C');                
$pdf->Cell(60, 6, 'Productos Comprados', 1, 0, 'C');  
$pdf->Cell(25, 6, 'Precio Total', 1, 0, 'C');     
$pdf->Cell(40, 6, 'Nombre Usuario', 1, 0, 'C');        
$pdf->Cell(40, 6, 'Fecha', 1, 1, 'C');     

// Datos
$pdf->SetFont('Arial', '', 7);
$fill = false;
while ($row = $result->fetch_assoc()) {
    $pdf->SetFillColor(255, 230, 240);

    $pdf->Cell(15, 6, $row['id_compra'], 1, 0, 'C', $fill);
    $pdf->Cell(60, 6, utf8_decode($row['productos_con_precios']), 1, 0, 'L', $fill);
    $pdf->Cell(25, 6, '$' . number_format($row['total'], 2), 1, 0, 'C', $fill);
    $pdf->Cell(40, 6, utf8_decode($row['nombre_usuario']), 1, 0, 'C', $fill);
    $pdf->Cell(40, 6, $row['fecha_compra'], 1, 1, 'C', $fill);
    
    $fill = !$fill;
}

// Mostrar o descargar PDF
$pdf->Output('D', 'ventas.pdf');
?>