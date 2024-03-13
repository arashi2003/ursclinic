<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    
    class PDF extends FPDF
    {
        function Header()
        {
            include('connection.php');
            $campus = $_SESSION['campus'];
            $this->Image('../../../images/urs.png', 100, 12, 12);
            $this->Image('../../../images/medlogo.png', 183, 12, 22);
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
            $this->SetFont('Arial','',8);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, $campus . " CAMPUS", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, .1, '', 1, 0);
            $this->Cell(0, 8, '', 0, 1);

            $this->SetFont('Arial','B',14);
            $this->Cell(0, 0, 'APPOINMENT REPORT', 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial','',10);
            $this->Cell(30, 8, 'Date', 1, 0, 'C');
            $this->Cell(30, 8, 'Time', 1, 0, 'C');
            $this->Cell(50, 8, 'Physician', 1, 0, 'C');
            $this->Cell(70, 8, 'Patient', 1, 0, 'C');
            $this->Cell(65, 8, 'Type and Purpose', 1, 0, 'C');
            $this->Cell(30, 8, 'Status', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['userid'];
            $activity = "saved a pdf report for appointment";

            include('connection.php');
            // code for revision number  
            $query = mysqli_query($conn, "SELECT * FROM audit_trail WHERE user = '$user' AND activity = '$activity'");
            $count = 0;
            while($data=mysqli_fetch_array($query))
            {
                if($data == 0)
                {
                    $count = 0;
                }
                else
                {
                    $count++;
                    $rev = $count;
                }
            }
            $rev = $count;

            // datetime and page
            $date = date('F d, Y');
            $this->Cell(0, 5, '', 0, 1);
            $this->Cell(91.67, 0, 'URS-AF-GE-MED-F-2017-07', 0, 1, 'L');            
            $this->Cell(145, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(280, 0, 'Effectivity Date: ' . $date . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
        }
    }

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->SetTitle("Appointment Report");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 8);
    
    $dt_from = "";//$_POST['date_from'];
    $dt_to = "";//$_POST['date_to'];
    $pod =  "";//$_POST['physician'];
    $status = "";//$_POST['status'];


    //campus filter
    if ($campus == "")
    {
        $ca = "";
    }
    else
    {
        $ca = " WHERE ac.campus = '$campus'";
    }

    //date filter
    if ($dt_from =="" AND $dt_to =="")
    {
        $date = "";
    }
    elseif ($ca == "" AND $dt_to == $dt_from)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
    }
    elseif ($ca != "" AND $dt_to == $dt_from)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " AND date >= '$fdate' AND date <= '$ldate'";
    }

    elseif ($ca == "" AND $dt_to == "" AND $dt_from != "" )
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND date >= '$fdate'";
    }
    elseif ($ca != "" AND $dt_to == "" AND $dt_from != "" )
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $date = " AND date >= '$fdate'";
    }
    elseif ($ca == "" AND $dt_from == "" AND $dt_to != "" )
    {
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " WHERE date <= '$d'";
    }
    elseif ($ca != "" AND $dt_from == "" AND $dt_to != "" )
    {
        $d = date("Y-m-d", strtotime($dt_to));
        $date = " AND date <= '$d'";
    }
    elseif ($ca == "" AND $dt_from != "" AND $dt_to != "" AND $dt_from != $dt_to)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
    }
    elseif ($ca != "" AND $dt_from != "" AND $dt_to != "" AND $dt_from != $dt_to)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-d", strtotime($dt_to));
        $date = " AND date >= '$fdate' AND date <= '$ldate'";
    }

    //physician filter
    if ($pod =="")
    {
        $doc = "";
    }
    elseif ($ca == "" AND $date== "" AND $pod != "")
    {
        $doc = " WHERE ap.physician = '$pod'";
    }
    elseif ($ca != "" OR $date!= "" AND $pod != "")
    {
        $doc = " AND ap.physician = '$pod'";
    }

    //status filter
    if ($status =="")
    {
        $st = "";
    }
    elseif ($ca == "" AND $date == "" AND $doc == "" AND $status != "")
    {
        $st = " WHERE ap.status = '$status'";
    }
    elseif ($ca != "" OR $date != "" OR $doc != "" AND $status != "")
    {
        $st = " AND ap.status = '$status'";
    }

    
    $query = mysqli_query($conn, "SELECT ap.date, ap.time_from, ap.time_to, ap.physician, ap.patient, ap.type, ap.status, ap.purpose, ac.campus, ac.firstname, ac.middlename, ac.lastname, t.type, p.purpose FROM appointment ap INNER JOIN account ac ON ac.accountid=ap.patient INNER JOIN appointment_type t ON t.id=ap.type INNER JOIN appointment_purpose p ON p.id=ap.purpose $ca $date $doc $st ORDER BY ap.date, ap.time_from");
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
        if ($data['physician'] == "")
        {
            $phys = "NONE";
        }
        else
        {
            $phys = $data['physician'];
        }

        $pdf->Cell(30, 6, date("F d, Y", strtotime($data['date'])), 1, 0, 'C');
        $pdf->Cell(30, 6, date("g:i A", strtotime($data['time_from'])). " - " . date("g:i A", strtotime($data['time_to'])), 1, 0, 'C');
        $pdf->Cell(50, 6, $phys, 1, 0);
        
        
        $pdf->Cell(70, 6, ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " .ucwords(strtolower($data['lastname'])), 1, 0);
        $pdf->Cell(65, 6, $data['type'] . " - " . $data['purpose'], 1, 0);
        $pdf->Cell(30, 6, strtoupper($data['status']), 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
    }



    // footer for pirma and stuff 

    // Date submitted is 1st weekday of the month;
    $pdf->SetFont('Arial', '', 8);
    $ds1 = date("F d, Y H:i A");
    $pdf->Cell(10, 8, 'Date and Time Printed: ' . $ds1);
    $ds = date("F d, Y", strtotime('first day of next month'));
    $pdf->Cell(260, 8, 'Date Submitted: ' . $ds, 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);

    $line = "_____________________________";

    $query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Nurse' AND adminid ='$user'");
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
            $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
            $title1 = "URS" . $camAbbrev . ", " . $data['title'];
        }
    }
    else
    {
        $camAbbrev = substr($data['campus'], 0, 1);
        $name1 = "";
        $title1 = "URS" . $camAbbrev . ", " . "Campus Nurse";
    }

    //campus director
    $query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Director'");
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
            $camAbbrev = substr($data['campus'], 0, 1) . ".";
            $name2 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
            $title2 =  "URS" . $camAbbrev . ", " . $data['title'];
        }
    }
    else
    {
        $camAbbrev = substr($data['campus'], 0, 1);
        $name2 = "";
        $title2 = "URS" . $camAbbrev . ", " . "Campus Director";
    }

    // med unit head
    $query = mysqli_query($conn, "SELECT * FROM organization WHERE title='Head, Health Services Unit'");
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
            $name3 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
            $title3 = $data['title'];
        }
    }
    else
    {
        $name3 = "";
        $title3 = "Head, Health Services Unit";
    }

    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(80, 6, 'Prepared By:', 0, 0);
    $pdf->Cell(150, 6, 'Noted:', 0, 0);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(65, 5, $name1 , 0, 0, 'C');
    $pdf->Cell(90, 5, $name2 , 0, 0, 'C');
    $pdf->Cell(70, 5, $name3 , 0, 0, 'C');

    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(65, 0, $line, 0, 0, 'C');
    $pdf->Cell(90, 0, $line, 0, 0, 'C');
    $pdf->Cell(70, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);

    $pdf->Cell(65, -1, $title1, 0, 0, 'C');
    $pdf->Cell(90, -1, $title2, 0, 0, 'C');
    $pdf->Cell(70, -1, $title3, 0, 0, 'C');

    $datetimed = date('m/d/Y');
    $filename = "Appointment_Report_". $st . "_". $datetimed . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
