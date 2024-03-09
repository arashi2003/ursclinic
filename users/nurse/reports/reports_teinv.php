<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $campus = $_SESSION['campus'];
    $user = $_SESSION['accountid'];
    
    class PDF extends FPDF
    {
        function Header()
        {
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
            $this->Cell(0, 4, '', 0, 1);
            $this->SetFont('Arial','',8);
            $this->Cell(0, 0, $campus . " CAMPUS", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, .1, '', 1, 0);
            $this->Cell(0, 10, '', 0, 1);

            $dt = date("Y-m-t");//$_POST['month'];
            if ($dt == "")
            {
                $date = "";
            }
            else
            {
                $date = "FOR " . strtoupper(date("F Y", strtotime($dt)));
            }
            $this->SetFont('Arial','B',14);
            $this->Cell(0, 0, 'TOOLS AND INVENTORY REPORT ' . $date, 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial','B',10);
            $this->Cell(88.8, 8, 'Tools and Equipment', 1, 0, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(71.35, 8, 'Beginning Balance', 1, 0, 'C');
            $this->Cell(49.55, 8, 'Received', 1, 0, 'C');
            $this->Cell(71.35, 8, 'Ending Balance', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);

            $this->SetFont('Arial','B',8);
            $this->Cell(88.8, 6, '', 1, 0, 'C');
            $this->SetFont('Arial','',8);
            $this->Cell(9.25, 6, 'N. W.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'U. M.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'G. C.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'D.', 1, 0, 'C');
            
            $this->Cell(12.55, 6, 'Total Qty', 1, 0, 'C');
            $this->Cell(21.8, 6, 'Unit Cost', 1, 0, 'C');

            $this->Cell(9.25, 6, 'N. W.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'U. M.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'G. C.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'D.', 1, 0, 'C');
            
            $this->Cell(12.55, 6, 'Total Qty', 1, 0, 'C');

            $this->Cell(9.25, 6, 'N. W.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'U. M.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'G. C.', 1, 0, 'C');
            $this->Cell(9.25, 6, 'D.', 1, 0, 'C');
            
            $this->Cell(12.55, 6, 'Total Qty', 1, 0, 'C');
            $this->Cell(21.8, 6, 'Amount', 1, 0, 'C');
            $this->Cell(7, 6, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['accountid'];
            $dt = date("Y-m-t");//$_POST['month'];
            $date =  date("Y-m-d", strtotime($dt));
            $activity = "saved a pdf report of tools and equipment inventory for" . $date;

            // code for revision number  
            include('connection.php');        
            $query = mysqli_query($conn, "SELECT * FROM audit_trail WHERE user = '$user' AND activity = '$activity' AND datetime = '$date'");
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
            $this->Cell(91.67, 0, 'URS-AF-GE-MED-F-2017-07', 0, 1, 'L');            
            $this->Cell(145, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(280, 0, 'Effectivity Date: ' . $date . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
        }
    }

    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->SetTitle("Tools and Inventory Report");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 7);
    
    $dt = date("Y-m-t");//$_POST['month'];
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

    $query = mysqli_query($conn, "SELECT * FROM report_teinv $ca $date ORDER BY tools_equip");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(88.8, 6, $data['tools_equip'], 1, 0);
        $pdf->Cell(9.25, 6, $data['bnw'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['bum'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['bgc'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['bd'], 1, 0, 'C');
        
        $pdf->Cell(12.55, 6, $data['btqty'], 1, 0, 'C');
        $pdf->Cell(21.8, 6, number_format($data['buc'], 2, '.'), 1, 0, 'C');

        $pdf->Cell(9.25, 6, $data['rnw'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['rum'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['rgc'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['rd'], 1, 0, 'C');
        
        $pdf->Cell(12.55, 6, $data['rtqty'], 1, 0, 'C');

        $pdf->Cell(9.25, 6, $data['enw'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['eum'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['egc'], 1, 0, 'C');
        $pdf->Cell(9.25, 6, $data['ed'], 1, 0, 'C');
        
        $pdf->Cell(12.55, 6, $data['etqty'], 1, 0, 'C');
        $pdf->Cell(21.8, 6, number_format($data['eamt'], 2, '.'), 1, 0, 'C');
        $pdf->Cell(7, 6, '', 0, 1);
    }



    // footer for pirma and stuff 

    // Date submitted is 1st weekday of the month;
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
    $ds = date("F d, Y", strtotime('first day of next month'));
    $pdf->Cell(260, 8, 'Date Submitted: ' . $ddd, 0, 0, 'R');



    # Legend for tools and equipment status 

    $pdf->Cell(0, 10, '', 0, 1);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(60, 6, 'Legend:','C');
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15, 4, '', 'C');
    $pdf->Cell(10, 4, 'N. W. - ', 'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(1, 4, 'Not Working', 0, 1, 'L');
    $pdf->Cell(0, 0, '', 0, 1);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15, 4, '', 'C');
    $pdf->Cell(10, 4, 'U. M. - ', 'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(1, 4, 'Under Maintenance', 0, 1, 'L');
    $pdf->Cell(0, 0, '', 0, 1);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15, 4, '', 'C');
    $pdf->Cell(10, 4, 'G. C. - ', 'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(1, 4, 'Good Condition', 0, 1, 'L');
    $pdf->Cell(0, 0, '', 0, 1);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(15, 4, '', 'C');
    $pdf->Cell(10, 4, 'D.      -', 'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(1, 4, 'Damaged', 0, 1, 'L');

    
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

    $pdf->Cell(65, -2, $title1, 0, 0, 'C');
    $pdf->Cell(90, -2, $title2, 0, 0, 'C');
    $pdf->Cell(70, -2, $title3, 0, 0, 'C');

    // date galing dapat sa datepicker filter
    if ($dt == "")
    {
        $ddd = date("F_Y");
    }
    else
    {
        $ddd = date("F_Y", strtotime($dt));
    }
    $filename = "Tools_Equipment_Inventory_Report_". $ddd . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>