<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $campus = $_SESSION['campus'];
    $accountid = $_SESSION['userid'];
    
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
            $this->SetFont('Arial','',8);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, 0, $campus . " CAMPUS", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(0, 4, '', 0, 1);
            $this->Cell(0, .1, '', 1, 0);
            $this->Cell(0, 8, '', 0, 1);

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
            $this->Cell(0, 0, 'MEDICAL SUPPLY CONSUMPTION REPORT ' . $date, 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);

            $this->SetFont('Arial','', 10);
            $this->Cell(85, 8, '', 1, 0, 'C');
            $this->Cell(26.25, 8, 'Beginning Bal.', 1, 0, 'C');
            $this->Cell(26.25, 8, 'Received', 1, 0, 'C');
            $this->Cell(26.25, 8, 'Issued', 1, 0, 'C');
            $this->Cell(26.25, 8, 'Ending Bal.', 1, 0, 'C');
            $this->Cell(0, 8, '', 0, 1);

            $this->SetFont('Arial','B',8);
            $this->Cell(85, 6, 'Medical Supply', 1, 0, 'C');
            $this->SetFont('Arial','',8);
            $this->Cell(10, 6, 'Qty.', 1, 0, 'C');
            $this->Cell(16.25, 6, 'Unit Cost', 1, 0, 'C');
            $this->Cell(10, 6, 'Qty.', 1, 0, 'C');
            $this->Cell(16.25, 6, 'Total Qty', 1, 0, 'C');
            $this->Cell(10, 6, 'Qty.', 1, 0, 'C');
            $this->Cell(16.25, 6, 'Amount', 1, 0, 'C');
            $this->Cell(10, 6, 'Qty.', 1, 0, 'C');
            $this->Cell(16.25, 6, 'Amount', 1, 0, 'C');
            $this->Cell(0, 6, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['userid'];

            $dt = date("Y-m-t");//$_POST['month'];
            $date = strtoupper(date("F Y", strtotime($dt)));
            $activity = "saved a pdf report of medical supply consumption for " . $date;
            
            // code for revision number  
            include('connection.php');       
            $query = mysqli_query($conn, "SELECT * FROM audit_trail WHERE user = '$user' AND activity LIKE '%$activity%' AND datetime='$date'");
            $count = 0;
            while($data=mysqli_fetch_array($query))
            {
                if($data['activity'] = 0)
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
    $pdf->SetTitle("Medical Supply Consumption Report");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 10);

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


    $query = mysqli_query($conn, "SELECT * FROM report_medsupinv $ca $date AND type != 'medicine' AND type != 'med_admin' ORDER BY medicine ASC");
    while($data=mysqli_fetch_array($query))
    {
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(85, 5, $data['medicine'], 1, 0);
        $pdf->Cell(10, 5, $data['bqty'], 1, 0, 'C');
        $pdf->Cell(16.25, 5, number_format($data['buc'], 2, '.'), 1, 0, 'C');
        $pdf->Cell(10, 5, $data['rqty'], 1, 0, 'C');
        $pdf->Cell(16.25, 5, $data['tqty'], 1, 0, 'C');
        $pdf->Cell(10, 5, $data['iqty'], 1, 0, 'C');
        $pdf->Cell(16.25, 5, number_format($data['iamt'], 2, '.'), 1, 0, 'C');
        $pdf->Cell(10, 5, $data['eqty'], 1, 0, 'C');
        $pdf->Cell(16.25, 5, number_format($data['eamt'], 2, '.'), 1, 0, 'C');
        $pdf->Cell(0, 5, '', 0, 1);
    }


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
    $pdf->Cell(180, 8, 'Date Submitted: ' . $ddd, 0, 0, 'R');
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

    $dt = date("Y-m-t");//$_POST['month'];
    if ($dt == "")
    {
        $ddd = date("F_Y");
    }
    else
    {
        $ddd = date("F_Y", strtotime($dt));
    }
    $filename = "Supply_Inventory_Report_". $ddd . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>