<?php
// Iniciar sesión y verificar si hay compras
session_start();

if (!isset($_SESSION['compras']) || empty($_SESSION['compras'])) {
    die("No hay compras para generar el PDF.");
}

require('fpdf.php');

// Crear el objeto PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Título del reporte
$pdf->Cell(190, 10, 'Reporte de Compras', 0, 1, 'C');
$pdf->Ln(10);

// Cabeceras de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 10, 'Nombre', 1);
$pdf->Cell(20, 10, 'DNI', 1);
$pdf->Cell(50, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Precio Unitario', 1);
$pdf->Cell(20, 10, 'Cantidad', 1);
$pdf->Cell(30, 10, 'Precio Total', 1);
$pdf->Ln();

// Mostrar los datos de las compras
$pdf->SetFont('Arial', '', 10);
foreach ($_SESSION['compras'] as $compra) {
    $pdf->Cell(40, 10, $compra['nombre'], 1);
    $pdf->Cell(20, 10, $compra['dni'], 1);
    $pdf->Cell(50, 10, $compra['producto'], 1);
    $pdf->Cell(30, 10, number_format($compra['precio_unitario'], 2), 1);
    $pdf->Cell(20, 10, $compra['cantidad'], 1);
    $pdf->Cell(30, 10, number_format($compra['precio_total'], 2), 1);
    $pdf->Ln();
}

// Salida del PDF al navegador
$pdf->Output('D', 'reporte_compras.pdf');
?>
