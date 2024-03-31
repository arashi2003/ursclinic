<?php
    session_start();
    require('connection.php');
    require('../../../fpdf/fpdf.php');
    date_default_timezone_set("Asia/Manila");
    class PDF extends FPDF
    {
        function Header()
        {
            //filter campus
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
            $this->SetFont('Arial','B',8);
            $this->Cell(0, 0, $campus . ' CAMPUS', 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, .1, '', 1, 0);
            $this->Cell(0, 10, '', 0, 1);

            $this->SetFont('Arial','B',14);
            $this->Cell(0, 0, "AUDIT TRAIL", 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial','',10);
            $this->Cell(8, 8, '', 1, 0, 'C');
            //$this->Cell(30, 8, 'Campus', 1, 0, 'C');
            $this->Cell(132, 8, 'Activity', 1, 0, 'C');
            $this->Cell(50, 8, 'Date and Time', 1, 0, 'C');
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

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->SetTitle("Audit Trail");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 10);
    
    $dt_from = $_POST['date_from'];
    $dt_to = $_POST['date_to'];
    $campus = $_SESSION['campus'];


    //campus filter
    if ($campus == "")
    {
        $ca = "";
    }
    else
    {
        $ca = " WHERE account.campus = '$campus'";
    }

    //date filter
    if ($dt_from =="" AND $dt_to =="")
    {
        $date = "";
    }
    elseif ($ca == "" AND $dt_to == $dt_from)
    {
        $d2 = date("Y-m-d", strtotime("$dt_to + 1 day"));
        $date = " WHERE datetime >= '$dt_from' AND datetime <= '$d2'";
    }
    elseif ($ca != "" AND $dt_to == $dt_from)
    {
        $d2 = date("Y-m-d", strtotime("$dt_to + 1 day"));
        $date = " AND datetime >= '$dt_from' AND datetime <= '$d2'";
    }

    elseif ($ca == "" AND $dt_to == "" AND $dt_from != "" )
    {
        $d1 = date("Y-m-d", strtotime("$dt_from"));
        $d2 = date("Y-m-d", strtotime("+ 1 day"));
        $date = " WHERE datetime >= '$d1' AND datetime <= '$d2'";
    }
    elseif ($ca != "" AND $dt_to == "" AND $dt_from != "" )
    {
        $d1 = date("Y-m-d", strtotime("$dt_from"));
        $d2 = date("Y-m-d", strtotime("+ 1 day"));
        $date = " AND datetime >= '$d1' AND datetime <= '$d2'";
    }
    elseif ($ca == "" AND $dt_from == "" AND $dt_to != "" )
    {
        $d = date("Y-m-d", strtotime("$dt_to + 1 day"));
        $date = " WHERE datetime <= '$d'";
    }
    elseif ($ca != "" AND $dt_from == "" AND $dt_to != "" )
    {
        $d = date("Y-m-d", strtotime("$dt_to + 1 day"));
        $date = " AND datetime <= '$d'";
    }
    elseif ($ca == "" AND $dt_from != "" AND $dt_to != "" )
    {
        $d = date($dt_to, strtotime("+ 1 day"));
        $date = " WHERE datetime >= '$dt_from' AND datetime <= '$d'";
    }
    elseif ($ca != "" AND $dt_from != "" AND $dt_to != "" )
    {
        $d = date("Y-m-d", strtotime("+ 1 day"));
        $date = " AND datetime >= '$dt_from' AND datetime <= '$d'";
    }

    $query = mysqli_query($conn, "SELECT audit_trail.activity, audit_trail.datetime, account.campus, account.firstname, account.middlename, account.lastname FROM audit_trail INNER JOIN account ON account.accountid=audit_trail.user $ca $date ORDER BY datetime DESC");
    $count = 1;
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
        $fullname = ucwords(strtolower($data['firstname'] . " " . strtoupper($middleinitial) . " " . $data['lastname']));
        $dt = date("F d, Y h:i:s A", strtotime($data['datetime']));
        $pdf->Cell(8, 6, $id, 1, 0, 'C');
        //$pdf->Cell(30, 6, $data['campus'], 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(132, 6, $fullname . " ".  $data['activity'], 1, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(50, 6, $dt, 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
        $count++;
    }

    // footer for pirma and stuff 

    $pdf->SetFont('Arial', '', 8);
    $ds = date("F d, Y H:i A");
    $pdf->Cell(191, 6, 'Date and Time Printed: ' . $ds, 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);

    $line = "_____________________________";

    $user = $_SESSION['userid'];

    $query = mysqli_query($conn, "SELECT * FROM account WHERE accountid ='$user'");
    if(mysqli_num_rows($query) > 0)
    {
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
            $camAbbrev = substr($data['campus'], 0, 1);
            $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'];
            $title1 = "URS" . $camAbbrev . ", " . "Admin";
        }
    }
    else
    {
        $camAbbrev = substr($data['campus'], 0, 1);
        $name1 = "";
        $title1 = "URS" . $camAbbrev . ", " . "Admin";
    }

    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(80, 6, 'Prepared By:', 0, 0);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(65, 5, $name1 , 0, 0, 'C');
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(65, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);
    $pdf->Cell(65, -1, $title1, 0, 0, 'C');

    $datetimed = date('m/d/Y');
    $filename = "Audit_Trail_" . $campus . "_". $datetimed . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>