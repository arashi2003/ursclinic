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
            $this->Cell(0, 5, '', 0, 1);
        }
        
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['userid'];
            $activity = "saved a pdf for dental form";
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

            // $datetime and page
            $date = date('F d, Y');
            $this->Cell(0, 5, '', 0, 1);
            $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-10', 0, 1, 'L');            
            $this->Cell(100, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(195, 0, 'Effectivity Date: ' . $date, 0, 1, 'R');
        }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetTitle("Treatment Record");
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 8);

    $trid = $_REQUEST['id'];

    $pdf->Cell(0, 2, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->Cell(0, 0, 'TREATMENT RECORDS', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, '', 0, 1);

    $sql = "SELECT * FROM treatment_record WHERE id='$trid'";
    $result = mysqli_query($conn, $sql);
    while($data=mysqli_fetch_array($result))
    {
        if (count(explode(" ", $data['middlename'])) > 1) 
        {
            $middle = explode(" ", $data['middlename']);
            $letter = $middle[0][0] . $middle[1][0];
            $middleinitial = $letter . ".";
        } 
        else 
        {
            $middle = $data['middlename'];
            if ($middle == "" or $middle == " ") 
            {
                $middleinitial = "";
            } 
            else 
            {
                $middleinitial = substr($middle, 0, 1) . ".";
            }
        }

        if($data['department'] != 'COLLEGE')
        {
            $dc = ucfirst(strtolower($data['department']));
        }
        else
        {
            $dc = ucfirst(strtolower($data['department'])) . " - " . ucwords(strtolower($data['college']));
        }
        $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " .ucwords(strtolower($data['lastname']));
        $pys = $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'] . $data['block'];

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 6, 'Student/Employee No.: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 6, $patientid, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(12, 6, 'Name: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, $fullname, 0);
        $pdf->Cell(0, 3, '', 0, 1);

        $pdf->Cell(39, 0, '', 0);
        $pdf->Cell(30, 0, '_______________', 0,1);
        $pdf->Cell(81, 0, '', 0);
        $pdf->Cell(0, 0, '_______________________________________________________', 0,1);

        $pdf->Cell(0, 4, '', 0,1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(37, 6, 'Department/College: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(54, 6, $dc, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 6, 'Program/Year/Section: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, $pys, 0);
        $pdf->Cell(0, 3, '', 0, 1);

        $pdf->Cell(36, 0, '', 0);
        $pdf->Cell(30, 0, '___________________________', 0,1);
        $pdf->Cell(130, 0, '', 0);
        $pdf->Cell(0, 0, '______________________________', 0,1);

        $pdf->Cell(0, 4, '', 0,1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(24, 6, 'Date of Birth: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(54, 6, date("F d, Y",strtotime($data['birthday'])), 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(22, 6, 'Civil Status: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 6, $data['civil_status'], 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'Sex: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, ucfirst(strtolower($data['sex'])), 0);
        $pdf->Cell(0, 3, '', 0, 1);

        $pdf->Cell(23, 0, '', 0);
        $pdf->Cell(30, 0, '___________________________', 0,1);
        $pdf->Cell(100, 0, '', 0);
        $pdf->Cell(0, 0, '___________________', 0,1);
        $pdf->Cell(150, 0, '', 0);
        $pdf->Cell(0, 0, '____________________', 0,1);

        $pdf->Cell(0, 4, '', 0,1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(16, 6, 'Address: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(77.2, 6, $data['address'], 0);
        $pdf->Cell(0, 3, '', 0, 1);

        $pdf->Cell(16, 0, '', 0);
        $pdf->Cell(30, 0, '________________________________________________________________________________________', 0,1);
    
        $pdf->Cell(0, 5, '', 0, 1);
        
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 7, 'Date', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Diagnosis', 1, 0, 'C');
        $pdf->Cell(20, 7, 'Tooth No.', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Treatment Done', 1, 0, 'C');
        $pdf->Cell(45, 7, 'Operating Dentist', 1, 0, 'C');
        $pdf->SetFont('Arial', '', 7);

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_1'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_1'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_1'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_1'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_1'], 1, 0);// 
        
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_2'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_2'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_2'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_2'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_2'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_3'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_3'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_3'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_3'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_3'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_4'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_4'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_4'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_4'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_4'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_5'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_5'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_5'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_5'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_5'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_6'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_6'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_6'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_6'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_6'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_7'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_7'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_7'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_7'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_7'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_8'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_8'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_8'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_8'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_8'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_9'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_9'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_9'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_9'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_9'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_10'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_10'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_10'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_10'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_10'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_11'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_11'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_11'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_11'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_11'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_12'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_12'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_12'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_12'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_12'], 1, 0);// 
        
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_13'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_13'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_13'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_13'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_13'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_14'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_14'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_14'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_14'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_14'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_15'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_15'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_15'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_15'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_15'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_16'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_16'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_16'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_16'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_16'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_17'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_17'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_17'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_17'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_17'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_18'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_18'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_18'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_18'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_18'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_19'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_19'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_19'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_19'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_19'], 1, 0);// 

        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date_20'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis_20'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno_20'], 1, 0);//
        $pdf->Cell(50, 7, $data['treatment_20'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist_20'], 1, 0);// 
    }

    $filename = "Treatment_Record_". $patientid . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>