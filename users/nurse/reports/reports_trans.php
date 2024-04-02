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
        $this->Cell(0, 0, 'TRANSACTION REPORT', 0, 1, 'C');
        $this->Cell(0, 5, '', 0, 1);

        $this->SetFont('Arial', '', 8);
        $this->Cell(6, 6, '', 1, 0, 'C');
        $this->Cell(65, 6, 'Patient', 1, 0, 'C');
        $this->Cell(20, 6, 'Designation', 1, 0, 'C');
        $this->Cell(40, 6, 'POD/NOD', 1, 0, 'C');
        $this->Cell(57, 6, 'Type of Transaction', 1, 0, 'C');
        $this->Cell(40, 6, 'Service', 1, 0, 'C');
        $this->Cell(47, 6, 'Date and Time', 1, 0, 'C');
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
$pdf->SetTitle("Transaction Report");
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetFont('Arial', '', 8);

$dt_from = $_POST['date_from'];
$dt_to = $_POST['date_to'];

//campus filter
if ($campus == "") {
    $ca = "";
} else {
    $ca = " WHERE campus = '$campus'";
}

//date filter
if ($dt_from == "" and $dt_to == "") {
    $date = "";
} elseif ($ca == "" and $dt_to == $dt_from) {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ldate = date("Y-m-t", strtotime($dt_to));
    $date = " WHERE datetime >= '$fdate' AND datetime <= '$ldate'";
} elseif ($ca != "" and $dt_to == $dt_from) {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ldate = date("Y-m-t", strtotime($dt_to));
    $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
} elseif ($ca == "" and $dt_to == "" and $dt_from != "") {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $date = " AND datetime >= '$fdate'";
} elseif ($ca != "" and $dt_to == "" and $dt_from != "") {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $date = " AND datetime >= '$fdate'";
} elseif ($ca == "" and $dt_from == "" and $dt_to != "") {
    $d = date("Y-m-t", strtotime($dt_to));
    $date = " WHERE datetime <= '$d'";
} elseif ($ca != "" and $dt_from == "" and $dt_to != "") {
    $d = date("Y-m-t", strtotime($dt_to));
    $date = " AND datetime <= '$d'";
} elseif ($ca == "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ldate = date("Y-m-t", strtotime($dt_to));
    $date = " WHERE datetime >= '$fdate' AND datetime <= '$ldate'";
} elseif ($ca != "" and $dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
    $fdate = date("Y-m-d", strtotime($dt_from));
    $ldate = date("Y-m-t", strtotime($dt_to));
    $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
}

$count = 1;
$query = mysqli_query(
    $conn,
    "SELECT id, patient, firstname, middlename, lastname, designation, age, sex, department, college, program, birthday, yearlevel, section, type, transaction, purpose, height, weight, bp, pr, temp, heent, chest_lungs, heart, abdomen, extremities, bronchial_asthma, surgery, lmp, heart_disease, allergies, epilepsy, hernia, respiratory, oxygen_saturation, chief_complaint, findiag, remarks, medsup, pod_nod, medcase, medcase_others, datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial FROM transaction_history $ca $date ORDER BY datetime DESC "
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

    $id = $count;
    $pdf->Cell(6, 6, $id, 1, 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(65, 6, ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])), 1, 0);
    $pdf->SetFont('Arial', '', 8);
<<<<<<< HEAD
    $pdf->Cell(20, 6, $data['designation'], 1, 0, 'C');
    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(40, 6, $data['pod_nod'], 1, 0);
=======

    $dt_from = $_POST['date_from']; 
    $dt_to = $_POST['date_to'];
    $type = "";//$_POST['type'];

    //campus filter
    if ($campus == "")
    {
        $ca = "";
    }
    else
    {
        $ca = " WHERE campus = '$campus'";
    }
    //date filter

    if ($dt_from == "" and $dt_to == "") {
        // No date range provided
        $date = "";
    } elseif ($dt_to == $dt_from) {
        // Same start and end date
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND datetime LIKE '$fdate%'";
    } elseif ($dt_to == "" and $dt_from != "") {
        // Only start date provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND datetime >= '$fdate'";
    } elseif ($dt_from == "" and $dt_to != "") {
        // Only end date provided
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " AND datetime <= '$d'";
    } elseif ($dt_from != "" and $dt_to != "" and $dt_from != $dt_to) {
        // Start and end date range provided
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " AND datetime >= '$fdate' AND datetime <= '$ldate'";
    }

    
    $count = 1;
    $query = mysqli_query($conn, "SELECT id, patient, firstname, middlename, lastname, designation, age, sex, department, college, program, birthday, yearlevel, section, type, transaction, purpose, height, weight, bp, pr, temp, heent, chest_lungs, heart, abdomen, extremities, bronchial_asthma, surgery, lmp, heart_disease, allergies, epilepsy, hernia, respiratory, oxygen_saturation, chief_complaint, findiag, remarks, medsup, pod_nod, medcase, medcase_others, datetime, campus, referral, ddefects, dcs, gp, scaling_polish, dento_facial FROM transaction_history $ca $date ORDER BY datetime DESC "
    );
    while($data=mysqli_fetch_array($query))
    {
        if (count(explode(" ", $data['middlename'])) > 1)
        {
            $middle = explode(" ", $data['middlename']);
            $letter = $middle[0][0].$middle[1][0];
            $middleinitial = $letter . ".";
        }
        else
        {
            $middle = $data['middlename'];
            if ($middle == "" OR $middle == " ")
            {
                $middleinitial = "";
            }
            else
            {
                $middleinitial = substr($middle, 0, 1) . ".";
            }    
        }
        
        $id = $count;
        $pdf->Cell(6, 6, $id, 1, 0, 'C');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(65, 6, ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " .ucwords(strtolower($data['lastname'])), 1, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(20, 6, $data['designation'], 1, 0, 'C');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 6, $data['pod_nod'], 1, 0);
        $pdf->SetFont('Arial', '', 8);
        if($data['type'] != 'Walk-In')
        {
            $pdf->Cell(57, 6, $data['type'] . " - " . $data['transaction'], 1, 0);
            $pdf->Cell(40, 6, $data['purpose'], 1, 0);
        }
        else
        {
            $pdf->Cell(57, 6, $data['type'], 1, 0);
            $pdf->Cell(40, 6, $data['transaction'], 1, 0);
        }
        $pdf->Cell(47, 6, date("M d, Y", strtotime($data['datetime'])) . " " . date("g:i A", strtotime( $data['datetime'])), 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
        $count++;
    }


    // footer for pirma and stuff 

    // Date submitted is 1st weekday of the month;
>>>>>>> 42adf7f184a01343c052e5c4c84b13ed2eef8bc5
    $pdf->SetFont('Arial', '', 8);
    if ($data['type'] != 'Walk-In') {
        $pdf->Cell(57, 6, $data['type'] . " - " . $data['transaction'], 1, 0);
        $pdf->Cell(40, 6, $data['purpose'], 1, 0);
    } else {
        $pdf->Cell(57, 6, $data['type'], 1, 0);
        $pdf->Cell(40, 6, $data['transaction'], 1, 0);
    }
    $pdf->Cell(47, 6, date("M d, Y", strtotime($data['datetime'])) . " " . date("g:i A", strtotime($data['datetime'])), 1, 0, 'C');
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

$ddd = date("F_Y");
$filename = "Transaction_Report_" . $ddd . ".pdf";
$pdf->Output($filename, 'I');
mysqli_close($conn);
