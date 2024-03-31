<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    date_default_timezone_set("Asia/Manila");
    
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
            $this->Cell(0, 0, 'MEDICAL RECORD', 0, 1, 'C');
            $this->Cell(0, 7, '', 0, 1);
        }
        function Footer()
        {
            $this->SetY(-12);
            $this->SetFont('Arial', '', 8);

            // datetime and page
            $date = date('F d, Y');
            $rev = 0;
            $this->Cell(0, 5, '', 0, 1);
            $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-07', 0, 1, 'L');            
            $this->Cell(67.25, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(135, 0, 'Effectivity Date: ' . $date . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
        }
    }


    $pdf = new PDF('P', 'mm', 'A5');
    $pdf->SetTitle("Medical Record");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);

    $account_no = $_POST['patientid'];
    $fullname = $_POST['patient'];
    $sex = ucfirst(strtolower($_POST['sex']));
    $medsup = $_POST['medsup'];
    $pys = $_POST['pys'];
    $cc = $_POST['cc'];
    $findiag = $_POST['findiag'];
    $remarks = $_POST['remarks'];
    $referral = $_POST['referral'];
    $datetime = date("F d, Y | g:i A", strtotime($_POST['datetime']));
    
    $query = mysqli_query($conn, "SELECT designation, birthday, department, college, campus FROM patient_info WHERE patientid = '$account_no'");
    if($data=mysqli_fetch_array($query))
    {
        
        $college = $data['department'] . " of " . $data['college'];
        $campus = $data['campus'];
        $designation = $data['designation'];
        $department = $data['department'];
        if(!empty($_POST['age'])){
            $age = floor((time() - strtotime($data['department']) / 31556926)); 
        }else{
        $age = $_POST['age'];
        }
    }

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(25, 0, 'Date and Time: ', 0, 0);
    $pdf->Cell(1, 0, '___________________________', 0);
    $pdf->Cell(23, 0, $datetime, 0, 'C');

    $pdf->Cell(0, 7, '', 0, 1);

    $pdf->Cell(25, 0, 'Department: ', 0, 0);
    $pdf->Cell(1, 0, '___________________________', 0);
    $pdf->Cell(23, 0, $department, 0, 'C');

    $pdf->Cell(0, 7, '', 0, 1);

    $pdf->Cell(11, 0, 'Name:', 0);
    $pdf->Cell(1, 0, '___________________________________________________________', 0);
    $pdf->Cell(1, 0, $fullname);
    
    $pdf->Cell(0, 8, '', 0, 1);

    $pdf->Cell(8, 0, 'Sex:', 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(1, 0, '_________', 0);
    $pdf->Cell(1, 0, $sex);
    $pdf->Cell(27, 0, 'Age:', 0,0, 'R');
    $pdf->Cell(3, 0, '_____', 0,);
    $pdf->Cell(1, 0, $age, 0, 'C');
    $pdf->Cell(30, 0, 'Designation:', 0,0, 'R');
    $pdf->Cell(1, 0, '_____________________________', 0,);
    $pdf->Cell(1, 0, $designation . " - " . $campus, 0, 'C');
    
    $pdf->Cell(0, 8, '', 0, 1);

    $pdf->Cell(56, 0, 'Course/Program, Year & Section:', 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(1, 0, '____________________________________', 0);
    $pdf->Cell(1, 0, $pys, 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 10, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(44, 0, 'Chief Complaint:', 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(1, 4.5, '_________________________________________________________________', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(127.5, 4, $cc, 'B,B', 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(44, 0, 'Findings/Diagnosis:', 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(1, 4.5, '_________________________________________________________________', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(127.5, 4, $findiag, 'B,B', 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(44, 0, 'Issued Medicine and/or Medical Supply:', 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(1, 4.5, '_________________________________________________________________', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(127.5, 4, $medsup, 'B,B', 0);
    $pdf->SetFont('Arial', '', 9);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->SetFont('Arial', 'BI', 10);
    $pdf->Cell(44, 0, 'Referral:', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(1, 5.8, '________________________________________________________________________', 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(127.5, 4.5, $referral, 'B,B', 0);
    $pdf->SetFont('Arial', '', 10);
    


    // footer for pirma and stuff 

    $query = mysqli_query($conn, "SELECT * FROM organization WHERE adminid ='$accountid'");
    if (mysqli_num_rows($query) > 0)
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
            if ($data['campus'] == "UNIVERSITY")
            {
                $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
                $title1 = $data['title'];
            }
            else
            {
                $camAbbrev = substr($data['campus'], 0, 1);
                $name1 = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'] . ", " . $data['extension'];
                $title1 = "URS" . $camAbbrev . ", " . $data['title'];
            }
        }
    }
    else
    {
        $camAbbrev = substr($data['campus'], 0, 1);
        $name1 = "";
        $title1 = "URS" . $camAbbrev . ", " . "Campus Nurse";
    }

    $line = "_____________________________";

    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(65, 6, 'Physician on Duty/Nurse on Duty:', 0, 0);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 10, '', 0, 1);
    $pdf->Cell(65, 5, $name1 , 0, 0, 'C');

    $pdf->Cell(0, 3, '', 0, 1);
    $pdf->Cell(65, 0, $line, 0, 0, 'C');
    $pdf->Cell(0, 4, '', 0, 1);

    $pdf->Cell(65, -2, $title1, 0, 0, 'C');


    //date kung kelan prinint/sinave
    $date = date("F_Y");
    $filename = "Medical_Record_". $account_no . "_" . $date. ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>