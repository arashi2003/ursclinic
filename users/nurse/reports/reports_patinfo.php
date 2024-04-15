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

        $this->SetFont('Arial', '', 8);
        $this->Cell(8, 8, '', 1, 0, 'C');
        $this->Cell(61, 8, 'Full Name', 1, 0, 'C');
        $this->Cell(8, 8, 'Age', 1, 0, 'C');
        $this->Cell(13, 8, 'Sex', 1, 0, 'C');
        $this->Cell(20, 8, 'Designation', 1, 0, 'C');
        $this->Cell(25, 8, 'Prog. Year & Sec.', 1, 0, 'C');
        $this->Cell(45, 8, 'Email', 1, 0, 'C');
        $this->Cell(25, 8, 'Contact #', 1, 0, 'C');
        $this->Cell(45, 8, 'Emergency Contact', 1, 0, 'C');
        $this->Cell(25, 8, 'E. Contact #', 1, 0, 'C');
        $this->Cell(0, 8, '', 0, 1);
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

$department = ""; //$_POST['department'];
$college = ""; //$_POST['college'];
$program = ""; //$_POST['course'];
$year = ""; //$_POST['yearlevel'];
$designation = ""; //$_POST['designation'];

//campus filter
if ($campus == "") {
    $ca = "";
} else {
    $ca = " WHERE a.campus = '$campus'";
}

//department filter
if ($ca == "" and $department != "") {
    $depa = " WHERE pi.department = '$department'";
} elseif ($department == "") {
    $depa = "";
} elseif ($ca != "" and $department != "") {
    $depa = " AND pi.department = '$department'";
}

//college filter
if ($college == "") {
    $co = "";
} elseif ($ca == "" and $depa == "" and $college != "") {
    $co = " WHERE pi.college = '$college'";
} elseif ($ca != "" or $depa != "" and $college != "") {
    $co = " AND pi.college = '$college'";
}

//prgram filter
if ($program == "") {
    $pr = "";
} elseif ($ca == "" and $depa == "" and $co == "" and $program != "") {
    $pr = " WHERE pi.program = '$program'";
} elseif ($ca != "" or $depa != "" or $co != "" and $program != "") {
    $pr = " AND pi.program = '$program'";
}

//year filter
if ($year == "") {
    $y = "";
} elseif ($ca == "" and $depa == "" and $co == "" and $pr == "" and $year != "") {
    $y = " WHERE yearlevel = '$year'";
} elseif ($ca != "" or $depa != "" or $co != ""  or $pr != "" and $year != "") {
    $y = " AND yearlevel = '$year'";
}

//designation filter
if ($designation == "") {
    $des = "";
} elseif ($ca == "" and $depa == "" and $co == "" and $pr == "" and $y == "" and $designation != "") {
    $des = " WHERE pi.designation = '$designation'";
} elseif ($ca != "" or $depa != "" or $co != ""  or $pr != "" or $y != "" and $designation != "") {
    $des = " AND pi.designation = '$designation'";
}


$query = mysqli_query($conn, "SELECT firstname,  middlename, lastname, a.email, a.contactno, a.campus, designation, sex, birthday, pi.department, college, program, yearlevel, section, emcon_number, emcon_name FROM account a INNER JOIN patient_info pi ON pi.patientid=a.accountid $ca $depa $co $pr $y $des ORDER BY lastname");
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
    $age = floor((time() - strtotime($data['birthday'])) / 31556926);

    $id = $count;
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(8, 8, $id, 1, 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(61, 8,  ucwords(strtolower($data['lastname'])) . ", " . ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial), 1, 0, '');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(8, 8, $age, 1, 0, 'C');
    $pdf->Cell(13, 8, $data['sex'], 1, 0, 'C');
    $pdf->Cell(20, 8, $data['designation'], 1, 0, 'C');
    $pdf->Cell(25, 8, $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'], 1, 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 8, $data['email'], 1, 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(25, 8, $data['contactno'], 1, 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(45, 8, $data['emcon_name'], 1, 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(25, 8, $data['emcon_number'], 1, 0, 'C');
    $pdf->Cell(0, 8, '', 0, 1);
    $count++;
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
