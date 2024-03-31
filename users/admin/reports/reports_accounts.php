<?php
    session_start();
    require('connection.php');
    require('../../../fpdf/fpdf.php');
    date_default_timezone_set("Asia/Manila");

    class PDF extends FPDF
    {
        function Header()
        {
            $au_campus = $_SESSION['campus']  . ' CAMPUS';
            
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
            $this->Cell(0, 4, '', 0, 1);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(0, 0, $au_campus, 0, 1, 'C');
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, .1, '', 1, 0);
            $this->Cell(0, 10, '', 0, 1);

            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 0, 'USER ACCOUNTS REPORT', 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial', 'B', 9);
            $this->Cell(8, 8, '', 1, 0, 'C');
            $this->Cell(25, 8, 'Campus', 1, 0, 'C');
            $this->Cell(25, 8, 'Account ID', 1, 0, 'C');
            $this->Cell(75, 8, 'Full Name', 1, 0, 'C');
            $this->Cell(25, 8, 'User Type', 1, 0, 'C');
            $this->Cell(30, 8, 'Contact Number', 1, 0, 'C');
            $this->Cell(62, 8, 'Email', 1, 0, 'C');
            $this->Cell(25, 8, 'Status', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);
        }

        function Footer()
        {
            $this->SetY(-10);
            $this->SetX(-52);
            $datetime = date('m/d/Y h:i A');
            $this->Cell(0, 6, $datetime . " | " . $this->PageNo() . "/{nb}", 0, 1);
        }
    }

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->SetTitle("User Accounts Report");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 9);

    $campus = isset($_REQUEST['campus']) ? $_REQUEST['campus'] : '';
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
    $usertype = isset($_REQUEST['usertype']) ? $_REQUEST['usertype'] : '';

    //campus filter
    if ($campus == "") {
        $ca = "";
    } else {
        $ca = " WHERE campus = '$campus'";
    }

    //status filter
    if ($status == "") {
        $stat = "";
    } elseif ($ca == "" and $status != "") {
        $stat = " WHERE status = '$status'";
    } elseif ($ca != "" and $status != "") {
        $stat = " AND status = '$status'";
    }

    //status filter
    if ($usertype == "") {
        $utype = "";
    } elseif ($ca == "" and $stat == "" and $usertype != "") {
        $utype = " WHERE usertype = '$usertype'";
    } elseif ($ca != "" or $stat != "" and $statususertype != "") {
        $utype = " AND usertype = '$usertype'";
    }

    $query = mysqli_query($conn, "SELECT * FROM account $ca $stat $utype");
    $count = 1;
    while ($data = mysqli_fetch_array($query)) {
        if (count(explode(" ", $data['middlename'])) > 1) {
            $middle = explode(" ", $data['middlename']);
            $letter = !empty($middle[0][0]) . !empty($middle[1][0]);
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
        $pdf->Cell(8, 6, $id, 1, 0, 'C');
        $pdf->Cell(25, 6, strtoupper($data['campus']), 1, 0, 'C');
        $pdf->Cell(25, 6, strtoupper($data['accountid']), 1, 0, 'C');
        $pdf->Cell(75, 6, strtoupper($data['firstname'] . " " . $middleinitial . " " . $data['lastname']), 1, 0);
        $pdf->Cell(25, 6, strtoupper($data['usertype']), 1, 0, 'C');
        $pdf->Cell(30, 6, $data['contactno'], 1, 0, 'C');
        $pdf->Cell(62, 6, $data['email'], 1, 0);
        $pdf->Cell(25, 6, strtoupper($data['status']), 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
        $count++;
    }

    // footer for pirma and stuff 

    $pdf->SetFont('Arial', '', 8);
    $ds = date("F d, Y H:i A");
    $pdf->Cell(270, 6, 'Date and Time Printed: ' . $ds, 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);

    $line = "_____________________________";

    $user = $_SESSION['userid'];

    $query = mysqli_query($conn, "SELECT * FROM account WHERE accountid ='$user'");
    if (mysqli_num_rows($query) > 0) {
        while ($data = mysqli_fetch_array($query)) {

            if (count(explode(" ", $data['middlename'])) > 1) {
                $middle = explode(" ", $data['middlename']);
                $letter = !empty($middle[0][0]) . !empty($middle[1][0]);
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
            $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'];
            $title1 = "URS" . $camAbbrev . ", " . "Admin";
        }
    } else {
        $camAbbrev = substr($data['campus'], 0, 1);
        $name1 = "";
        $title1 = "URS" . $camAbbrev . ", " . "Admin";
    }

    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(80, 6, 'Prepared By:', 0, 0);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(65, 5, $name1, 0, 0, 'C');
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(65, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);
    $pdf->Cell(65, -1, $title1, 0, 0, 'C');

    $datetimed = date('m/d/Y');
    $filename = "Accounts_Report_" . $campus . "_" . $datetimed . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
