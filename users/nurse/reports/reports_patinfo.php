<?php
session_start();
require('../../../fpdf/fpdf.php');
include('connection.php');
$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
date_default_timezone_set("Asia/Manila");


class PDF extends FPDF
{
    function Header()
    {
        $campus = $_SESSION['campus'];

        $this->Image('../../../images/urs.png', 100, 12, 12);
        $this->Image('../../../images/medlogo.png', 183, 12, 22);
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
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, '', 0, 1);
        $this->Cell(0, 0, $campus . " CAMPUS", 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 4, '', 0, 1);
        $this->Cell(0, .1, '', 1, 0);
        $this->Cell(0, 8, '', 0, 1);

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 0, 'PATIENT INFORMATION', 0, 1, 'C');
        $this->Cell(0, 5, '', 0, 1);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 6, 'Stu./Emp. ID', 1, 0, 'C');
        $this->Cell(55, 6, 'Full Name', 1, 0, 'C');
        $this->Cell(8, 6, 'Age', 1, 0, 'C');
        $this->Cell(13, 6, 'Sex', 1, 0, 'C');
        $this->Cell(20, 6, 'Designation', 1, 0, 'C');
        $this->Cell(28, 6, 'Prog. Year & Sec.', 1, 0, 'C');
        $this->Cell(48, 6, 'Email', 1, 0, 'C');
        $this->Cell(25, 6, 'Contact #', 1, 0, 'C');
        $this->Cell(40, 6, 'Emergency Contact', 1, 0, 'C');
        $this->Cell(20, 6, 'E. Contact #', 1, 0, 'C');
        $this->Cell(0, 6, '', 0, 1);
    }

    function Footer()
    {
        $this->SetY(-12);
        $user = $_SESSION['userid'];
        $activity = "saved a pdf report for patient information";

        // code for revision number  
        include('connection.php');
        $query = mysqli_query($conn, "SELECT * FROM audit_trail WHERE user = '$user' AND activity = '$activity'");
        $count = 0;
        while ($data = mysqli_fetch_array($query)) {
            if ($data == 0) {
                $count = 0;
            } else {
                $count++;
                $rev = $count;
            }
        }
        $rev = $count;

        // datetime and page
        $date = date('F d, Y');
        $this->Cell(0, 5, '', 0, 1);
        $this->Cell(91.67, 0, 'URS-AF-GE-MED-F-2017-07', 0, 1, 'L');
        $this->Cell(145, 0, 'Rev. ' . $rev, 0, 1, 'R');
        $this->Cell(280, 0, 'Effectivity Date: ' . $date . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
    }
}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->SetTitle("Patient Information Report");
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetFont('Arial', '', 10);

$department = $_POST['department'];
$college = $_POST['college'];
$program = $_POST['program'];
$yearlevel = $_POST['yearlevel'];
$designation = $_POST['designation'];
$patient = $_POST['patient'];

//campus filter
if ($campus == "") {
    $ca = "";
} else {
    $ca = " WHERE a.campus = '$campus'";
}
//designation filter
if ($designation != "") {
    $ca .= " AND p.designation = '$designation'";
}

//yearlevel filter
if ($yearlevel != "") {
    $ca .= " AND p.yearlevel = '$yearlevel'";
}

//department filter
if ($department != "") {
    $ca .= " AND p.department = '$department'";
}

//college filter
if ($college != "") {
    $ca .= " AND p.college = '$college'";
}

//program filter
if ($program != "") {
    $ca .= " AND p.program = '$program'";
}

$query = mysqli_query($conn, "SELECT *
FROM patient_info p
INNER JOIN account a ON a.accountid=p.patientid
$ca
ORDER BY p.patientid");
$count = 1;
while ($data = mysqli_fetch_array($query)) {
    if (count(explode(" ", $data['middlename'])) > 1) {
        $middle = explode(" ", $data['middlename']);
        $letter = $middle[0][0] . $middle[1][0];
        $middleinitial = $letter . ".";
    } else {
        $middle = $data['middlename'];
        if ($middle == "" or $middle == " ") {
            $middleinitial = "";
        } else {
            $middleinitial = substr($middle, 0, 1) . ".";
        }
    }

    if ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' AND $data['department'] == 'COLLEGE' AND $data['college'] != 'GRADUATE STUDIES') {
        $college = $data['college'];
        $pys = $data['program'] . " " . $data['yearlevel'] . "-" .  $data['section'] . $data['block'];
    } elseif ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' AND $data['college'] == 'GRADUATE STUDIES') {
        $college = $data['college'];
        $pys =  $data['program'];
    } elseif ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' AND $data['department'] == 'JUNIOR HIGH SCHOOL') {
        $college = "N/A";
        $pys = $data['yearlevel'];
    } elseif ($data['designation'] == 'STUDENT' and $data['usertype'] != 'ALUMNI' AND $data['department'] == 'SENIOR HIGH SCHOOL') {
        $college = "N/A";
        $pys =  $data['program'] . " - " . $data['yearlevel'];
    } else{
        $college = "N/A";
        $pys = "N/A";
    }

    $age = floor((time() - strtotime($data['birthday'])) / 31556926);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(20, 6, $data['patientid'], 1, 0, 'C');
    $pdf->Cell(55, 6,  ucwords(strtolower($data['lastname'])) . ", " . ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial), 1, 0, '');
    $pdf->Cell(8, 6, $age, 1, 0, 'C');
    $pdf->Cell(13, 6, $data['sex'], 1, 0, 'C');
    $pdf->Cell(20, 6, $data['designation'], 1, 0, 'C');
    $pdf->Cell(28, 6, $pys, 1, 0, 'C');
    $pdf->Cell(48, 6, $data['email'], 1, 0);
    $pdf->Cell(25, 6, $data['contactno'], 1, 0, 'C');
    $pdf->Cell(40, 6, $data['emcon_name'], 1, 0);
    $pdf->Cell(20, 6, $data['emcon_number'], 1, 0, 'C');
    $pdf->Cell(0, 6, '', 0, 1);
}


// footer for pirma and stuff 

// Date submitted is 1st weekday of the month;
$pdf->SetFont('Arial', '', 8);
$ds = date("F d, Y", strtotime('first day of next month'));
$ds1 = date("F d, Y H:i A");
$pdf->Cell(10, 8, 'Date and Time Printed: ' . $ds1);
$pdf->Cell(260, 8, 'Date Submitted: ' . $ds, 0, 0, 'R');
$pdf->SetFont('Arial', '', 10);

$line = "_____________________________";

$query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Nurse' AND adminid ='$user'");
if (mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_array($query)) {
        if (count(explode(" ", $data['middlename'])) > 1) {
            $middle = explode(" ", $data['middlename']);
            $letter = $middle[0][0] . $middle[1][0];
            $middleinitial = $letter . ".";
        } else {
            $middle = $data['middlename'];
            if ($middle == "" or $middle == " ") {
                $middleinitial = "";
            } else {
                $middleinitial = substr($middle, 0, 1) . ".";
            }
        }
        $camAbbrev = substr($data['campus'], 0, 1);
        $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
        $title1 = "URS" . $camAbbrev . ", " . $data['title'];
    }
} else {
    $camAbbrev = substr($data['campus'], 0, 1);
    $name1 = "";
    $title1 = "URS" . $camAbbrev . ", " . "Campus Nurse";
}

//campus director
$query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Director'");
if (mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_array($query)) {
        if (count(explode(" ", $data['middlename'])) > 1) {
            $middle = explode(" ", $data['middlename']);
            $letter = $middle[0][0] . $middle[1][0];
            $middleinitial = $letter . ".";
        } else {
            $middle = $data['middlename'];
            if ($middle == "" or $middle == " ") {
                $middleinitial = "";
            } else {
                $middleinitial = substr($middle, 0, 1) . ".";
            }
        }
        $camAbbrev = substr($data['campus'], 0, 1) . ".";
        $name2 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
        $title2 =  "URS" . $camAbbrev . ", " . $data['title'];
    }
} else {
    $camAbbrev = substr($data['campus'], 0, 1);
    $name2 = "";
    $title2 = "URS" . $camAbbrev . ", " . "Campus Director";
}

// med unit head
$query = mysqli_query($conn, "SELECT * FROM organization WHERE title='Head, Health Services Unit'");
if (mysqli_num_rows($query) > 0) {
    while ($data = mysqli_fetch_array($query)) {
        if (count(explode(" ", $data['middlename'])) > 1) {
            $middle = explode(" ", $data['middlename']);
            $letter = $middle[0][0] . $middle[1][0];
            $middleinitial = $letter . ".";
        } else {
            $middle = $data['middlename'];
            if ($middle == "" or $middle == " ") {
                $middleinitial = "";
            } else {
                $middleinitial = substr($middle, 0, 1) . ".";
            }
        }
        $name3 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
        $title3 = $data['title'];
    }
} else {
    $name3 = "";
    $title3 = "Head, Health Services Unit";
}

$pdf->Cell(0, 6, '', 0, 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(80, 6, 'Prepared By:', 0, 0);
$pdf->Cell(150, 6, 'Noted:', 0, 0);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 6, '', 0, 1);
$pdf->Cell(65, 5, $name1, 0, 0, 'C');
$pdf->Cell(90, 5, $name2, 0, 0, 'C');
$pdf->Cell(70, 5, $name3, 0, 0, 'C');

$pdf->Cell(0, 3, '', 0, 1);
$pdf->Cell(65, 0, $line, 0, 0, 'C');
$pdf->Cell(90, 0, $line, 0, 0, 'C');
$pdf->Cell(70, 0, $line, 0, 0, 'C');
$pdf->Cell(0, 4, '', 0, 1);

$pdf->Cell(65, -1, $title1, 0, 0, 'C');
$pdf->Cell(90, -1, $title2, 0, 0, 'C');
$pdf->Cell(70, -1, $title3, 0, 0, 'C');

$datetimed = date('m/d/Y');
$filename = "Patient_Information_" . $datetimed . ".pdf";
$pdf->Output($filename, 'I');
mysqli_close($conn);
