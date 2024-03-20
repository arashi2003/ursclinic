<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    
    class PDF extends FPDF
    {
        function Header()
        {
            $campus = $_SESSION['campus'];

            $this->Image('../../../images/urs.png', 25, 12, 12);
            $this->Image('../../../images/medlogo.png', 110, 12, 22);
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
            $this->Cell(0, 0, 'CLEARANCE SLIP', 0, 1, 'C');
            $this->Cell(0, 10, '', 0, 1);
        }
        function Footer()
        {
            $this->SetY(-12);
            $this->SetFont('Arial', '', 8);

            $date = date('F d, Y');
            $rev = 0;
            $this->Cell(0, 5, '', 0, 1);
            $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-08', 0, 1, 'L');            
            $this->Cell(67.25, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(135, 0, 'Effectivity Date: ' . $date, 0, 1, 'R');
        }
    }


    $pdf = new PDF('P', 'mm', 'A5');
    $pdf->SetTitle("Medical Clearance Slip");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);

    $account_no = $_REQUEST['patientid'];
    $rem_den = $_POST['rem_den'];
    $rem_med = $_POST['rem_med'];

    $query = mysqli_query($conn, "SELECT firstname, middlename, lastname, account.campus, designation, sex, birthday, department, college, program, yearlevel, section FROM account INNER JOIN patient_info pi ON pi.patientid=account.accountid WHERE accountid = '$account_no'");
    if($data=mysqli_fetch_array($query))
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

        $fullname = strtoupper($data['firstname'] . " ". $middleinitial . " " . $data['lastname']);
        $sex = strtoupper($data['sex']);
        $age = floor((time() - strtotime($data['birthday'])) / 31556926); 
        $college = $data['department'] . " " . $data['college'];
        $course = $data['program'];
        $year = $data['yearlevel'];
        $section = $data['section'];
        $campus = $data['campus'];
        $department = $data['department'];

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 7, 'Name: ' . $fullname, 1, 0);
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(0, 7, 'College/Program: ' . $college . ' - ' . $course, 1, 0);
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(0, 7, 'Age: ' . $age, 1, 0);
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(0, 7, 'Sex: ' . $sex, 1, 0);
        $pdf->Cell(0, 10, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 7, 'REMARKS', 1, 0, 'C');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->MultiCell(0, 6, 'DENTAL EXAMINATION: ' . $rem_den, 1, 'L');
        $pdf->MultiCell(0, 6, 'MEDICAL EXAMINATION: ' . $rem_med, 1, 'L');
    }
    


    // footer for pirma and stuff 
    $name = $accountid;

    $query = mysqli_query($conn, "SELECT * FROM organization WHERE adminid ='$name'");
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
            $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
    }



    $line = "__________________________________";

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->Cell(0, 5, $name1 , 0, 0, 'C');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(0, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);
    $pdf->Cell(0, -1, "Medical Officer", 0, 0, 'C');


    //date kung kelan prinint/sinave
    $date = date("F_Y");
    $filename = "Clearance_Slip_". $account_no . "_" . $date. ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>