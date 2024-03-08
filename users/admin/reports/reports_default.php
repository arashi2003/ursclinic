<?php
    require('../../../fpdf/fpdf.php');
    require('connection.php');
    
    class PDF extends FPDF
    {
        function Header()
        {
            $this->Image('../../../images/urs.png', 55, 12, 12);
            $this->Image('../../../images/medlogo.png', 140, 12, 22);
            $this->Cell(0, 4, '', 0, 1);
            $this->SetFont('Arial','',10);
            $this->Cell(0, 0, 'Republic of the Philippines', 0, 1, 'C');
            $this->Cell(0, 4, '', 0, 1);
            $this->SetFont('Arial','B',10);
            $this->Cell(0, 0, 'UNIVERSITY OF RIZAL SYSTEM', 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, 'Province of Rizal', 0, 1, 'C');
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, 'HEALTH SERVICES UNIT', 0, 1, 'C');
            $this->Cell(0, 10, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-10);
            $this->SetX(-52);
            $datetime = date('m/d/Y h:i A');
            $this->Cell(0, 6, $datetime . " | " . $this->PageNo() . "/{nb}", 0, 1);
        }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->SetTitle("USU Report");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    
    $pdf->Output('I');
?>