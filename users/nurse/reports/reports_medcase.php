<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    
    class PDF extends FPDF
    {
        function Header()
        {
            $cam = $_SESSION['campus'];
            if ($cam == "NULL")
            {
                $campus = "";
            }
            else
            {
                $campus = $cam;
            }

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
            $this->Cell(0, 10, '', 0, 1);

            $dt = date("Y-m");//$_POST['month'];
            if ($dt == "")
            {
                $date = "";
            }
            else
            {
                $date = "FOR " . strtoupper(date("F Y", strtotime($dt)));
            }
            $this->SetFont('Arial','B',14);
            $this->Cell(0, 0, 'MEDICAL CASES REPORT ' . $date, 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial','B',10);
            $this->Cell(60, 8, 'Medical Cases', 1, 0, 'C');
            $this->Cell(43, 8, 'Students', 1, 0, 'C');
            $this->Cell(43, 8, 'Personnel', 1, 0, 'C');
            $this->Cell(43, 8, 'Grand Total', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);

            $this->SetFont('Arial','',10);
            $this->Cell(60, 6, '', 1, 0, 'C');
            $this->Cell(14.3, 6, 'Male', 1, 0, 'C');
            $this->Cell(14.3, 6, 'Female', 1, 0, 'C');
            $this->Cell(14.4, 6, 'Total', 1, 0, 'C');
            $this->Cell(14.3, 6, 'Male', 1, 0, 'C');
            $this->Cell(14.3, 6, 'Female', 1, 0, 'C');
            $this->Cell(14.4, 6, 'Total', 1, 0, 'C');
            $this->Cell(14.3, 6, 'Male', 1, 0, 'C');
            $this->Cell(14.3, 6, 'Female', 1, 0, 'C');
            $this->Cell(14.4, 6, 'Total', 1, 0, 'C');
            $this->Cell(0, 6, '', 0, 1);
        }
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['accountid'];

            // itong date based sa datepicker na month at year lang
            $date = date("F Y");
            $activity = "saved a pdf report of medical cases for" . $date;
            
            // code for revision number  
            include('connection.php');      
            $query = mysqli_query($conn, "SELECT * FROM audit_trail WHERE user = '$user' AND activity = '$activity'");
            $count = 0;
            while($data=mysqli_fetch_array($query))
            {
                if($data = 0)
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
    $pdf->SetTitle("Medical Cases Report");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 10);

    $dt = date("Y-m");//$_POST['month'];
    $date = date("Y-m-t", strtotime($dt));

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
    if ($dt =="")
    {
        $date = "AND date = '0000-00-00'";
    }
    elseif ($ca == "" AND $dt != "")
    {
        $date = " WHERE date = '$date'";
    }
    elseif ($ca != "" AND $dt != "")
    {
        $date = "AND date = '$date'";
    }

    //main
    $query = mysqli_query($conn, "SELECT * FROM reports_medcase $ca $date AND type='main'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(60, 6, $data['medcase'], 1, 0);
        $pdf->Cell(14.3, 6, $data['sm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['sf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['st'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['pm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['pf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['pt'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['gm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['gf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['gt'], 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
    }

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 6, 'Others:', 1, 0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(129, 6, '', 1, 0, 'C');
    $pdf->Cell(0, 6, '', 0, 1);

    $query = mysqli_query($conn, "SELECT * FROM reports_medcase $ca $date AND type='others'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(60, 6, $data['medcase'], 1, 0);
        $pdf->Cell(14.3, 6, $data['sm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['sf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['st'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['pm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['pf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['pt'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['gm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['gf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['gt'], 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
    }

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 6, 'Total', 1, 0, 'C');
    $pdf->SetFont('Arial','',10);

    $query = mysqli_query($conn, "SELECT sum(sm) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(sm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(sf) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(sf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(st) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(st)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pm) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(pm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pf) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(pf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pt) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(pt)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gm) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(gm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gf) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(gf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gt) FROM reports_medcase $ca $date AND type != 'checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(gt)'], 1, 0, 'C');
    }

    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 6, 'Checkups', 1, 0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(129, 6, '', 1, 0, 'C');
    $pdf->Cell(0, 6, '', 0, 1);

    $query = mysqli_query($conn, "SELECT * FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(60, 6, $data['medcase'], 1, 0);
        $pdf->Cell(14.3, 6, $data['sm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['sf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['st'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['pm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['pf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['pt'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['gm'], 1, 0, 'C');
        $pdf->Cell(14.3, 6, $data['gf'], 1, 0, 'C');
        $pdf->Cell(14.4, 6, $data['gt'], 1, 0, 'C');
        $pdf->Cell(0, 6, '', 0, 1);
    }

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 6, 'Total', 1, 0, 'C');
    $pdf->SetFont('Arial','',10);

    $query = mysqli_query($conn, "SELECT sum(sm) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(sm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(sf) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(sf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(st) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(st)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pm) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(pm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pf) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(pf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pt) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(pt)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gm) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(gm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gf) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(gf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gt) FROM reports_medcase $ca $date AND type='checkups'");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(gt)'], 1, 0, 'C');
    }

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 6, 'GRAND TOTAL', 1, 0, 'C');
    $pdf->SetFont('Arial','',10);
    
    $query = mysqli_query($conn, "SELECT sum(sm) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(sm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(sf) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(sf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(st) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(st)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pm) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(pm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pf) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(pf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(pt) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(pt)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gm) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(gm)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gf) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.3, 6, $data['sum(gf)'], 1, 0, 'C');
    }

    $query = mysqli_query($conn, "SELECT sum(gt) FROM reports_medcase $ca $date");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->Cell(14.4, 6, $data['sum(gt)'], 1, 0, 'C');
    }

    $pdf->Cell(0, 6, '', 0, 1);


    // footer for pirma and stuff 

    // Date submitted is 1st weekday of the month;
    $pdf->SetFont('Arial', '', 8);
    if ($dt == "")
    {
        $ddd = date("F d, Y", strtotime('first day of next month'));
    }
    else
    {
        $ddd = date("F d, Y", strtotime('first day of next month', strtotime($dt)));
    }
    $ds = date("F d, Y H:i A");
    $pdf->Cell(10, 8, 'Date and Time Printed: ' . $ds);
    $pdf->Cell(180, 6, 'Date Submitted: ' . $ddd, 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);

    $line = "_____________________________";

    $query = mysqli_query($conn, "SELECT * FROM organization WHERE campus='$campus' AND title='Campus Nurse' AND adminid ='$accountid'");
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


    // date galing dapat sa datepicker filter
    if ($dt == "")
    {
        $ddd = date("F_Y");
    }
    else
    {
        $ddd = date("F_Y", strtotime($dt));
    }
    $filename = "Medical_Cases_Report_". $ddd . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>