<?php

require('fpdf.php');

class PDF extends FPDF
{
    
    function Header()
    {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(60);
       
        $this->Cell(70, 10, 'Reporte de productos', 1, 0, 'C');
       
        $this->Ln(20);

        
        $this->Cell(100, 10, 'Nombre', 1, 0, 'C', 0);
        $this->Cell(45, 10, 'Precio', 1, 0, 'C', 0);
        $this->Cell(45, 10, 'Stock', 1, 1, 'C', 0);
    }

  
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}


require 'conexion.php';


$consultas = "SELECT * FROM productos";
$resultados = $mysqli->query($consultas);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);


while ($row = $resultados->fetch_assoc()) {
    $pdf->Cell(100, 10, $row['Nombre'], 1, 0, 'C', 0);
    $pdf->Cell(45, 10, number_format($row['Precio'], 2), 1, 0, 'C', 0); 
    $pdf->Cell(45, 10, $row['Stock'], 1, 1, 'C', 0);
}

$pdf->Output();
?>

