<?php
session_start();
    require('fpdf/fpdf.php');
    include('connection.php');
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial','B',10);
            $this->Cell(20);
            $this->Image('images/university-seal.png', 50, 12, 12);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, 'Republic of the Philippines', 0, 1, 'C');
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, 'Province of Rizal', 0, 1, 'C');
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, 'University of Rizal System', 0, 1, 'C');
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, 'University Service Unit', 0, 1, 'C');
            $this->Cell(0, 10, '', 0, 1);

            $date1 = date('Y-m-d - h:i a');
            $campus = "Binangonan";
            $date = $date1;
            $this->Cell(60, 8, 'Audit Trail', 1, 0, 'C');
            $this->Cell(85, 8, $date, 1, 0, 'C');
            $this->Cell(45, 8, $campus, 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);

            $this->SetFont('Arial','',10);
            $this->Cell(25, 8, 'Account ID', 1, 0, 'C');
            $this->Cell(60, 8, 'Fullname', 1, 0, 'C');
            $this->Cell(60, 8, 'Activity', 1, 0, 'C');
            $this->Cell(45, 8, 'Date and Time', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-10);
            $this->SetX(-55);
            $datetime = date('m/d/Y h:i A');
            $this->Cell(0, 6, $datetime . " | " . $this->PageNo() . "/{nb}", 0, 1);
        }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 10);
    
    $query = mysqli_query($conn, "select * from activitylogtbl");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(25, 6, $data['account_no'], 1, 0, 'C');
        $pdf->Cell(60, 6, $data['fullname'], 1, 0, 'C');
        $pdf->Cell(60, 6, $data['activity'], 1, 0, 'C');
        $pdf->Cell(45, 6, $data['datetime'], 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
    }


    $pdf->Cell(0, 10, '', 0, 1);
    $name = "Diosa A. Salvador";
    $line = "_____________________________";
    $pdf->Cell(0, 6, 'Prepared By:', 0, 0);
    $pdf->Cell(0, 12, '', 0, 1);
    $pdf->Cell(85, 6, $name . ", RN", 0, 0, 'C');
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(85, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);
    $pdf->Cell(85, 0, 'Binangonan Campus Nurse', 0, 0, 'C');

    $datetimed = date('m/d/Y');
    $filename = "Audit_Trail_". $datetimed . ".pdf";
    $pdf->Output($filename, 'I');
?>