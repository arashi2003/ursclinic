<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $user = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    
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
            $this->Cell(0, 0, "DOCTOR'S VISIT REPORT", 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial','',10);
            $this->Cell(10, 8, '', 1, 0, 'C');
            $this->Cell(40, 8, 'Date', 1, 0, 'C');
            $this->Cell(40, 8, 'Time', 1, 0, 'C');
            $this->Cell(65, 8, 'Physician', 1, 0, 'C');
            $this->Cell(35, 8, 'Campus', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['accountid'];
            $activity = "saved a pdf report for appointment";
            // code for revision number  
            include('connection.php');        
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
            $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-07', 0, 1, 'L');            
            $this->Cell(100, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(195, 0, 'Effectivity Date: ' . $date . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
        }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetTitle("Doctor's Visit Schedule Report");
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 8);

    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $dt_from = date("Y-m-d");//$_POST['date_from'];
    $dt_to = date("Y-m-t");//$_POST['date_to'];
    $pod =  "";//$_POST['physician'];
    
    //campus filter
    if ($campus == "")
    {
        $ca = "";
    }
    else
    {
        $ca = " WHERE s.campus = '$campus'";
    }

    //date filter
    if ($dt_from =="" AND $dt_to =="")
    {
        $date = "";
    }
    elseif ($ca == "" AND $dt_to == $dt_from)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-t", strtotime($dt_to));
        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
    }
    elseif ($ca != "" AND $dt_to == $dt_from)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-t", strtotime($dt_to));
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
        $d = date("Y-m-t", strtotime($dt_to));
        $date = " WHERE date <= '$d'";
    }
    elseif ($ca != "" AND $dt_from == "" AND $dt_to != "" )
    {
        $d = date("Y-m-t", strtotime($dt_to));
        $date = " AND date <= '$d'";
    }
    elseif ($ca == "" AND $dt_from != "" AND $dt_to != "" AND $dt_from != $dt_to)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-t", strtotime($dt_to));
        $date = " WHERE date >= '$fdate' AND date <= '$ldate'";
    }
    elseif ($ca != "" AND $dt_from != "" AND $dt_to != "" AND $dt_from != $dt_to)
    {
        $fdate = date("Y-m-d", strtotime($dt_from));
        $ldate = date("Y-m-t", strtotime($dt_to));
        $date = " AND date >= '$fdate' AND date <= '$ldate'";
    }

    //physician filter
    if ($pod =="")
    {
        $doc = "";
    }
    elseif ($ca == "" AND $date== "" AND $pod != "")
    {
        $doc = " WHERE s.physician = '$pod'";
    }
    elseif ($ca != "" OR $date!= "" AND $pod != "")
    {
        $doc = " AND s.physician = '$pod'";
    }

    $query = mysqli_query($conn, "SELECT s.date, s.time_from, s.time_to, s.campus, ac.firstname, ac.middlename, ac.lastname FROM schedule s INNER JOIN account ac ON ac.accountid=s.physician $ca $date $doc ORDER BY s.date DESC");

    $count=1;
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
        
        $pdf->SetFont('Arial', '', 10);
        $id = $count;
        $pdf->Cell(10, 6, $id, 1, 0, 'C');
        $pdf->Cell(40, 6, date("F d, Y", strtotime($data['date'])), 1, 0, 'C');
        $pdf->Cell(40, 6, date("g:i A", strtotime($data['time_from'])). " - " . date("g:i A", strtotime($data['time_to'])), 1, 0, 'C');
        $pdf->Cell(65, 6, ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " .ucwords(strtolower($data['lastname'])), 1, 0);
        $pdf->Cell(35, 6, $data['campus'], 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
        $count++;
    }


    // footer for pirma and stuff 

    // Date submitted is 1st weekday of the month;
    $pdf->SetFont('Arial', '', 8);
    $ds1 = date("F d, Y H:i A");
    $pdf->Cell(10, 8, 'Date and Time Printed: ' . $ds1);
    $ds = date("F d, Y", strtotime('first day of next month'));
    $pdf->Cell(181, 8, 'Date Submitted: ' . $ds, 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);

    $line = "_____________________________";

    $query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Nurse' AND adminid ='$user'");
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

    //campus director
    $query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Director'");
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
        $title2 = "URS" . $camAbbrev . ", " . $data['title'];
    }


    // med unit head
    $query = mysqli_query($conn, "SELECT * FROM organization WHERE title='Head, Health Services Unit'");
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


    
    $pdf->Cell(0, 10, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(65, 6, 'Prepared By:', 0, 0);
    $pdf->Cell(100, 6, 'Noted:', 0, 0);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(65, 5, $name1 , 0, 0, 'C');
    $pdf->Cell(60, 5, $name2 , 0, 0, 'C');
    $pdf->Cell(50, 5, $name3 , 0, 0, 'C');

    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(65, 0, $line, 0, 0, 'C');
    $pdf->Cell(60, 0, $line, 0, 0, 'C');
    $pdf->Cell(50, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);

    $pdf->Cell(65, -2, $title1, 0, 0, 'C');
    $pdf->Cell(60, -2, $title2, 0, 0, 'C');
    $pdf->Cell(50, -2, $title3, 0, 0, 'C');

    $datetimed = date('m/d/Y');
    $filename = "Doc_Visit_Report_". $datetimed . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>