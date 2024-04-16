<?php
session_start();
require('../../../fpdf/fpdf.php');
include('connection.php');
$campus = $_SESSION['campus'];
$user = $_SESSION['userid'];
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
        $this->Cell(0, 0, 'MEDICAL DOCUMENT ACCOMPLISHMENT REPORT', 0, 1, 'C');
        $this->Cell(0, 5, '', 0, 1);

        $this->SetFont('Arial', '', 8);
        $this->Cell(27, 6, 'Student ID', 1, 0, 'C');
        $this->Cell(65, 6, 'Full Name', 1, 0, 'C');
        $this->Cell(45, 6, 'College', 1, 0, 'C');
        $this->Cell(40, 6, 'Program, Year & Section', 1, 0, 'C');
        $this->Cell(40, 6, 'Medical Document', 1, 0, 'C');
        $this->Cell(30, 6, 'Status', 1, 0, 'C');
        $this->Cell(30, 6, 'Last Updated', 1, 0, 'C');
        //275
        $this->Cell(0, 6, '', 0, 1);
    }

    function Footer()
    {
        $this->SetY(-12);
        $user = $_SESSION['userid'];
        $activity = "saved a pdf of transaction report";

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
$pdf->SetTitle("Medical Document Accomplishment Report");
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetFont('Arial', '', 8);

$dt_from = $_POST['date_from'];
$student = $_POST['student'];
$dt_to = $_POST['date_to'];
$college = $_POST['college'];
$status = $_POST['status'];
$docu = $_POST['docu'];
$yearlevel = $_POST['yearlevel'];
$program = $_POST['program'];

//campus filter
$ca = " WHERE a.campus = '$campus'";

//student filter
if ($student != "") {
    $ca .= "AND (CONCAT(a.firstname,' ', a.lastname) LIKE '%$student%' OR CONCAT(a.firstname, ' ', a.middlename,' ', a.lastname) LIKE '%$student%' OR m.applicant LIKE '%$student%')";
}

//date filter
if ($dt_to == "" and $dt_from == "") {
    $ca .= "";
} elseif ($ca != "" and $dt_to == $dt_from) {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ldate = date("Y-m-d", strtotime($dt_to));
    $ca .= " AND dt_updated >= '$fdate' AND dt_updated <= '$ldate'";
} elseif ($ca == "" and $dt_to == "" and $dt_from != "") {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ca .= " AND dt_updated >= '$fdate'";
} elseif ($ca != "" and $dt_to == "" and $dt_from != "") {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ca .= " AND dt_updated >= '$fdate'";
} elseif ($ca != "" and $dt_from == "" and $dt_to != "") {
    $d = date("Y-m-d", strtotime($dt_to));
    $ca .= " AND dt_updated <= '$d'";
} elseif ($ca != "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ldate = date("Y-m-d", strtotime($dt_to));
    $ca .= " AND dt_updated >= '$fdate' AND dt_updated <= '$ldate'";
}

//docu filter
if ($docu != "") {
    $ca .= " AND m.type = '$docu'";
}

//yearlevel filter
if ($yearlevel != "") {
    $ca .= " AND p.yearlevel = '$yearlevel'";
}

//status filter
if ($status != "") {
    $ca .= " AND m.status = '$status'";
}

//college filter
if ($college != "") {
    $ca .= " AND p.college = '$college'";
}

//program filter
if ($program != "") {
    $ca .= " AND p.program = '$program'";
}

$count = 1;
$query = mysqli_query(
    $conn,
    "SELECT 
    m.type, m.applicant, m.status, m.dt_updated, m.dt_uploaded,
    p.patientid, p.designation, p.department, p.college,
    p.program, p.yearlevel, p.section, p.block, 
    a.accountid, a.firstname, a.middlename, a.lastname, a.campus
    FROM meddoc m 
    INNER JOIN patient_info p ON p.patientid=m.applicant 
    INNER JOIN account a ON a.accountid=m.applicant
    $ca AND m.dt_updated != m.dt_uploaded
    GROUP BY m.applicant, m.type
    ORDER BY m.dt_updated DESC"
);
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

    $applicant = $data['applicant'];
    $type = $data['type'];
    $chu = "SELECT dt_updated FROM meddoc WHERE applicant = '$applicant' AND type='$type' ORDER BY dt_updated DESC LIMIT 1";
    $grr = mysqli_query($conn, $chu);
    $boop = mysqli_fetch_array($grr);
    $updated = $boop['dt_updated'];


    // Check if all medical documents are approved
    $sql_check_approved = "SELECT COUNT(*) AS total_approved FROM meddoc WHERE applicant='$applicant' AND type='$type' AND status='APPROVED'";
    $result_check_approved = mysqli_query($conn, $sql_check_approved);
    $row_check_approved = mysqli_fetch_assoc($result_check_approved);
    $total_approved = $row_check_approved['total_approved'];

    // Check if all medical documents are approved
    $sql_check_disapproved = "SELECT COUNT(*) AS total_disapproved FROM meddoc WHERE applicant='$applicant' AND type='$type' AND status='DISAPPROVED'";
    $result_check_disapproved = mysqli_query($conn, $sql_check_disapproved);
    $row_check_disapproved = mysqli_fetch_assoc($result_check_disapproved);
    $total_disapproved = $row_check_disapproved['total_disapproved'];

    // Fetch total number of medical documents for OJT of the user
    $sql_total_medical_docs = "SELECT COUNT(*) AS total_medical_docs FROM meddoc WHERE applicant='$applicant' AND type='$type'";
    $result_total_medical_docs = mysqli_query($conn, $sql_total_medical_docs);
    $row_total_medical_docs = mysqli_fetch_assoc($result_total_medical_docs);
    $total_medical_docs = $row_total_medical_docs['total_medical_docs'];

    if ($total_approved === $total_medical_docs && $total_medical_docs > 0 && $total_disapproved == 0) {
        $status = 'APPROVED';
    } elseif ($total_disapproved > 0) {
        $status = 'DISAPPROVED';
    } else {
        $status = 'PENDING';
    }

    $pdf->Cell(27, 6, $data['applicant'], 1, 0, 'C');
    $pdf->Cell(65, 6, ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])), 1, 0);
    $pdf->Cell(45, 6, $data['college'], 1, 0, 'C');
    $pdf->Cell(40, 6, $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'] . $data['block'], 1, 0, 'C');
    $pdf->Cell(40, 6, $data['type'], 1, 0, 'C');
    $pdf->Cell(30, 6, $status, 1, 0, 'C');
    $pdf->Cell(30, 6, date("F d, Y", strtotime($updated)), 1, 0, 'C');
    $pdf->Cell(0, 6, '', 0, 1);
    $count++;
}


// footer for pirma and stuff 

// Date submitted is 1st weekday of the month;
$pdf->SetFont('Arial', '', 8);
$ddd = date("F d, Y", strtotime('first day of next month'));
$ds = date("F d, Y H:i A");
$pdf->Cell(10, 8, 'Date and Time Printed: ' . $ds);
$ds = date("F d, Y", strtotime('first day of next month'));
$pdf->Cell(260, 8, 'Date Submitted: ' . $ddd, 0, 0, 'R');
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

$pdf->Cell(0, 10, '', 0, 1);
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

$pdf->Cell(65, -2, $title1, 0, 0, 'C');
$pdf->Cell(90, -2, $title2, 0, 0, 'C');
$pdf->Cell(70, -2, $title3, 0, 0, 'C');

$ddd = date("F_d_Y");
$filename = "Medical_Document_Accomplishment_Report_" . $ddd . ".pdf";
$pdf->Output($filename, 'I');
mysqli_close($conn);
