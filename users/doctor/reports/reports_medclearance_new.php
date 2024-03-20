<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    
    class PDF extends FPDF
    {
        function Header()
        {
            $campus = $_SESSION['campus'];

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
            $this->Cell(0, 4, '', 0, 1);
            $this->SetFont('Arial','',8);
            $this->Cell(0, 0, $campus . " CAMPUS", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, .1, '', 1, 0);
            $this->Cell(0, 8, '', 0, 1);

            $this->SetFont('Arial','B',14);
            $this->Cell(0, 0, 'MEDICAL CLEARANCE', 0, 1, 'C');
            $this->Cell(0, 10, '', 0, 1);
        }
        function Footer()
        {
            $this->SetY(-12);
            $rev = 0;

            // datetime and page
            $date = date('F d, Y');
            $this->Cell(0, 5, '', 0, 1);
            $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-07', 0, 1, 'L');            
            $this->Cell(100, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(195, 0, 'Effectivity Date: ' . $date . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
        }
    }


    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->SetTitle("Medical Clearance");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 10);

    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    
    $fullname = strtoupper($_POST['firstname'] . " ". $_POST['middlename'] . " " . $_POST['lastname']);
    $sex = strtoupper($_POST['sex']);
    $age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
    $course = $_POST['course'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    // code for department and college
    if ( $_POST['college'] == "")
    {
        $college = $_POST['department'];
    }
    else
    {
        $college = $_POST['department'] . " - " . $_POST['college'];
    }
    // code for course, year, section
    if ($_POST['course'] == "" AND $_POST['yearlevel'] == "" AND $_POST['section'] == "")
    {
        $cys = $_POST['department'];
    }
    else
    {
        $cys = $course . " " . $yearlevel . "-" . $section;
    }

    $pdf->Cell(52, 0, 'Student/Employee Number: ', 0,0, 'R');
    $pdf->Cell(1, 0, '___________________', 0,);
    $pdf->Cell(19, 0, "", 0, 'C');

    $pdf->Cell(0, 10, '', 0, 1);


    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(11, 0, 'Name:', 0);
    $pdf->Cell(1, 0, '________________________________________________________', 0);
    $pdf->Cell(1, 0, $fullname);
    $pdf->Cell(120, 0, 'Sex:', 0,0, 'R');
    $pdf->Cell(2, 0, '__________', 0,);
    $pdf->Cell(19, 0, $sex, 0, 'C');
    $pdf->Cell(30, 0, 'Age:', 0,0, 'R');
    $pdf->Cell(3, 0, '_____', 0,);
    $pdf->Cell(1, 0, $age, 0, 'C');
    
    $pdf->Cell(0, 7, '', 0, 1);

    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(15, 0, 'Campus:', 0);
    $pdf->Cell(1, 0, '______________', 0);
    $pdf->Cell(1, 0, $campus);
    $pdf->Cell(62, 0, 'College/Department: ', 0,0, 'R');
    $pdf->Cell(2, 0, '_________________________________________________', 0,);
    $pdf->Cell(19, 0, $college, 0, 'C');

    $pdf->Cell(0, 7, '', 0, 1);
    
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(48, 0, 'Course/Program, Year & Section:', 0);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(1, 0, '_______________', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(1, 0, $course . " " . $yearlevel . "-" . $section);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->Cell(0, 3, '______________________________', 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 5, 'Medical Oficer III                       ', 0, 1, 'R');
    $pdf->Cell(0, 2, '', 0, 1);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 3, 'Lic. No.:_____________________________', 0, 1, 'R');


    $filename = "Medical_Clearance_" . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>