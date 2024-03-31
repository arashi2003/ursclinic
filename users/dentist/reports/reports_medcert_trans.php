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
            $this->Cell(0, 7, '', 0, 1);

            $this->SetFont('Arial','B',14);
            $this->Cell(0, 0, 'MEDICAL CERTIFICATE', 0, 1, 'C');
            $this->Cell(0, 5, '', 0, 1);
            $this->SetFont('Arial','',11);
            $this->Cell(0, 0, '(For Student-Athlete, OJT, Scholarship, Graduate School)', 0, 1, 'C');
            $this->Cell(0, 10, '', 0, 1);
        }
        function Footer()
        {
            $this->SetY(-12);
            $user = $_SESSION['userid'];

            $activity = "downloaded a medical certificate for" . $user;
            
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
    $pdf->SetTitle("Medical Certificate");
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 10);


    $account_no = $_POST['patientid'];
    $fullname = $_POST['patient'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $birthday = date("F d, Y", strtotime($_POST['birthday']));
    $bp = $_POST['bp'];
    $pr = $_POST['pr'];
    $temp = $_POST['temp'];

    $ddefects = $_POST['ddefects'];
    $dcs = $_POST['dcs'];
    $gp = $_POST['gp'];
    $scaling_polish = $_POST['scaling_polish'];
    $dento_facial = $_POST['dento_facial'];
    
    $remarks = $_POST['remarks'];
    $referral = $_POST['referral'];

    $heent = $_POST['heent'];
    $chest_lungs = $_POST['chest_lungs'];
    $heart = $_POST['heart'];
    $abdomen = $_POST['abdomen'];
    $extremities = $_POST['extremities'];
    $bronchial_asthma = $_POST['bronchial_asthma'];
    $surgery = $_POST['surgery'];
    $heart_disease = $_POST['heart_disease'];
    $allergies = $_POST['allergies'];
    $lmp = date("M. d, Y", strtotime($_POST['lmp']));
    $hernia = $_POST['hernia'];
    $epilepsy = $_POST['epilepsy'];
    $referral = $_POST['referral'];
    $remarks = $_POST['remarks'];
    $age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
    $sex = ucfirst(strtolower($_POST['sex']));
    $pys = $_POST['pys'];
    // code for course, year, section
    if ($pys == "")
    {
        $cys = "N/A";
    }
    else
    {
        $cys = $pys;
    }

    $query = mysqli_query($conn, 
    "SELECT department, designation, college, campus FROM patient_info WHERE patientid='$account_no'");
    if($data=mysqli_fetch_array($query))
    {
        $campus = $data['campus'];
        // code for department and college
        if ( $data['college'] == "")
        {
            $college = $data['department'];
        }
        else
        {
            $college = $data['department'] . " - " . $data['college'];
        }
    }
    else
    {
        $campus = "";
        $college = "";
    }

    $pdf->Cell(52, 0, 'Student/Employee Number: ', 0,0, 'R');
    $pdf->Cell(1, 0, '___________________', 0,);
    $pdf->Cell(19, 0, $account_no, 0, 'C');

    $pdf->Cell(0, 7, '', 0, 1);


    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(11, 0, 'Name:', 0);
    $pdf->Cell(1, 0, '________________________________________________________', 0);
    $pdf->Cell(1, 0, $fullname);
    $pdf->Cell(120, 0, 'Sex:', 0,0, 'R');
    $pdf->Cell(2, 0, '__________', 0,);
    $pdf->Cell(19, 0, $sex, 0, 'C');
    $pdf->Cell(30, 0, 'Age:', 0,0, 'R');
    $pdf->Cell(3, 0, '_____', 0,);
    $pdf->Cell(1, 0, $age, 0, 'C');
    
    $pdf->Cell(0, 5, '', 0, 1);

    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(15, 0, 'Campus:', 0);
    $pdf->Cell(1, 0, '______________', 0);
    $pdf->Cell(1, 0, $campus);
    $pdf->Cell(62, 0, 'College/Department: ', 0,0, 'R');
    $pdf->Cell(2, 0, '_________________________________________________', 0,);
    $pdf->Cell(19, 0, $college, 0, 'C');

    $pdf->Cell(0, 5, '', 0, 1);
    
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(48, 0, 'Course/Program, Year & Section:', 0);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(1, 0, '_______________', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(1, 0, $cys);
    $pdf->SetFont('Arial', '', 10);

    
    $pdf->Cell(0, 5, '', 0, 1);

    $pdf->Cell(63.3, 6, 'Height: ' . $height, 1, 0);
    $pdf->Cell(63.3, 6, 'Weight: ' . $weight, 1, 0);
    $pdf->Cell(63.3, 6, 'Birthday: ' . $birthday, 1, 0);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->Cell(63.3, 6, 'Blood Pressure(BP): ' . $bp, 1, 0);
    $pdf->Cell(63.3, 6, 'Pulse Rate(PR): ' . $pr, 1, 0);
    $pdf->Cell(63.3, 6, 'Temperature: ' . $temp, 1, 0);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->Cell(190, 6, 'H.E.E.N.T.:'  . $heent, 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Chest/Lungs: ' . $chest_lungs, 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Heart: ' . $heart, 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Abdomen: ' . $abdomen, 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Extremities: ' . $extremities, 1, 0);

    $pdf->Cell(0, 13, '', 0, 1);
    $pdf->Cell(31.6, 6, $bronchial_asthma, 'B', 0);
    $pdf->Cell(40, 6, 'Bronchial Asthma', 0);
    $pdf->Cell(31.6, 6, $heart_disease, 'B', 0);
    $pdf->Cell(40, 6, 'Heart Disease', 0);
    $pdf->Cell(31.6, 6, $epilepsy, 'B', 0);
    $pdf->Cell(40, 6, 'Epilepsy', 0);
    
    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(31.6, 6, $surgery, 'B', 0);
    $pdf->Cell(40, 6, 'Surgery', 0);
    $pdf->Cell(31.6, 6, $allergies, 'B', 0);
    $pdf->Cell(40, 6, 'Allergies', 0);
    $pdf->Cell(31.6, 6, $hernia, 'B', 0);
    $pdf->Cell(40, 6, 'Hernia', 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(31.6, 6, $lmp, 'B', 0);
    $pdf->Cell(31.6, 6, 'Last Menstrual Period', 0);
    $pdf->Cell(0, 15, '', 0, 1);


    $pdf->Cell(190, 87, '', 1);    
    $pdf->Cell(0, 1, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'Dental Examination:', 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 3, $ddefects, 1, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'No Dental Defects', 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 3, $dcs, 1, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 3, 'Presence of Oral Debris, Calculi (tartar) deposits, Stains/discoloration', 0);
    
    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(3, 3, '', 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'TEETH indicated for RESTORATION (encircled). For EXTRACTION (crossed-out):', 0);
    
    $pdf->Cell(0, 7, '', 0, 1);

    $pdf->Cell(35.625, 5, '', 0);
    $pdf->Cell(11.875, 5, '55', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '54', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '53', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '52', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '51', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '61', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '62', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '63', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '64', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '65', 1, 0, 'C');
    
    $pdf->Cell(0, 5, '', 0, 1);

    $pdf->Cell(11.875, 5, '18', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '17', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '16', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '15', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '14', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '13', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '12', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '11', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '21', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '22', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '23', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '24', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '25', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '26', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '27', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '28', 1, 0, 'C');

    $pdf->Cell(0, 5, '', 0, 1);

    $pdf->Cell(11.875, 5, '48', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '47', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '46', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '45', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '44', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '43', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '42', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '41', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '31', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '32', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '33', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '34', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '35', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '36', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '37', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '38', 1, 0, 'C');

    $pdf->Cell(0, 5, '', 0, 1);

    $pdf->Cell(35.625, 5, '', 0);
    $pdf->Cell(11.875, 5, '85', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '84', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '83', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '82', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '81', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '71', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '72', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '73', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '74', 1, 0, 'C');
    $pdf->Cell(11.875, 5, '75', 1, 0, 'C');

    $pdf->Cell(0, 9, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(3, 3, $gp, 1, 0);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(3, 3, 'Presence of GINGIVITIS and/or PERIODONTITIS', 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(3, 3, $scaling_polish, 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'For Tooth Scaling and Polishing', 0);
    
    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    if($dento_facial != "")
    {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(3, 3, 'x', 1, 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(4.7, 0, '', 0);
        $pdf->Cell(3, 3, 'Other Dento-Facial Findings: ' . $dento_facial, 0);
    }
    else
    {
        $pdf->Cell(3, 3, '', 1, 0);
        $pdf->Cell(4.7, 0, '', 0);
        $pdf->Cell(3, 3, 'Other Dento-Facial Findings: ', 0);
    }
    
    
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'BI', 7);
    $pdf->Cell(3, 3, 'Note: You are therefore advised to correct the above mentioned dental findings', 0);
    $pdf->SetFont('Arial', '', 8);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(0, 3, '____________________________________        ', 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, 'Dentist II                                   ', 0, 1, 'R');
    $pdf->Cell(0, 10, '', 0, 1);

    $pdf->Cell(0, 3, 'Remarks: ' . $remarks, 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 3, '_______________________________________________________________________________________________________________', 0, 1, 'R');

    $pdf->Cell(0, 3, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, 'Recommendation: ' . $referral, 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 3, '______________________________________________________________________________________________________', 0, 1, 'R');
    
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->Cell(0, 3, '____________________________________', 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, 'Medical Oficer III                       ', 0, 1, 'R');
    $pdf->Cell(0, 2, '', 0, 1);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 3, 'Lic. No.:_____________________________', 0, 1, 'R');


    $pdf->Cell(0, 0, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, 'Date:_______________________', 0,1);
    $pdf->SetFont('Arial', '');

    


    $filename = "Medical_Certificate_". $account_no . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>