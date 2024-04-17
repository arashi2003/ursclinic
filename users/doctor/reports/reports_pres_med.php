<?php
session_start();
require('../../../fpdf/fpdf.php');
include('connection.php');
$accountid = $_SESSION['userid'];
$campus = $_SESSION['campus'];
date_default_timezone_set("Asia/Manila");

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../../../images/urs.png', 25, 12, 12);
        $this->Image('../../../images/medlogo.png', 110, 12, 22);
        $this->Cell(0, 4, '', 0, 1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 0, 'Republic of the Philippines', 0, 1, 'C');
        $this->Cell(0, 4, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0, 'UNIVERSITY OF RIZAL SYSTEM', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 4, '', 0, 1);
        $this->Cell(0, 0, 'Province of Rizal', 0, 1, 'C');
        $this->Cell(0, 4, '', 0, 1);
        $this->Cell(0, 0, 'HEALTH SERVICES UNIT', 0, 1, 'C');
        $this->Cell(0, 4, '', 0, 1);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 0, "Medical Office", 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 4, '', 0, 1);
        $this->Cell(0, .1, '', 1, 0);
        $this->Cell(0, 8, '', 0, 1);
    }
    function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('Arial', '', 8);

        // datetime and page
        $date = date('F d, Y');
        $rev = 0;
        
        $this->Cell(128, 0, '____________________ MD.', 0, 1, 'R');
        $this->Cell(0, 5, '', 0, 1);
        $this->Cell(128, 0, '___________________ Lic. #', 0, 1, 'R');
        $this->Cell(0, 10, '', 0, 1);
        $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-03', 0, 1, 'L');
        $this->Cell(67.25, 0, 'Rev. ' . $rev, 0, 1, 'R');
        $this->Cell(128, 0, 'Effectivity Date: ' . $date, 0, 1, 'R');
    }
}


$pdf = new PDF('P', 'mm', 'A5');
$pdf->SetTitle("Prescription");
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);

$account_no = $_POST['patientid'];
$fullname = $_POST['patient'];
$sex = ucfirst(strtolower($_POST['sex']));
$medsup = $_POST['medsup'];
$datetime = date("F d, Y", strtotime($_POST['datetime'] . "+ 8 hours"));

$query = mysqli_query($conn, "SELECT designation, birthday, address, department, college, campus FROM patient_info WHERE patientid = '$account_no'");
if ($data = mysqli_fetch_array($query)) {

    $college = $data['department'] . " of " . $data['college'];
    $campus = $data['campus'];
    $designation = $data['designation'];
    $department = $data['department'];
    $address = $data['address'];
    $age =  floor((time() - strtotime($data['birthday'])) / 31556926);
}

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 0, 'Date: ', 0, 0);
$pdf->Cell(1, 0, '__________________', 0);
$pdf->Cell(23, 0, $datetime, 0, 'C');

$pdf->Cell(0, 7, '', 0, 1);

$pdf->Cell(11, 0, 'Name:', 0);
$pdf->Cell(1, 0, '_____________________________________________', 0);
$pdf->Cell(72, 0, $fullname);
$pdf->Cell(27, 0, 'Age:', 0, 0, 'R');
$pdf->Cell(3, 0, '________', 0,);
$pdf->Cell(1, 0, $age, 0, 'C');

$pdf->Cell(0, 7, '', 0, 1);

$pdf->Cell(15, 0, 'Address:', 0);
$pdf->Cell(1, 0, '___________________________________________', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(68, 0, $address);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(27, 0, 'Sex:', 0, 0, 'R');
$pdf->Cell(3, 0, '________', 0,);
$pdf->Cell(1, 0, $sex, 0, 'C');

$pdf->Cell(0, 15, '', 0, 1);


$pdf->Cell(20, 8, '', 0);
$pdf->MultiCell(110, 6, $medsup, 0);

$pdf->Image('../../../images/rx.png', 10, 62, 15, 15);


//date kung kelan prinint/sinave
$date = date("F_Y");
$filename = "Prescription_" . $account_no . "_" . $date . ".pdf";
$pdf->Output($filename, 'I');
mysqli_close($conn);
