<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
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
            $rev = 0;

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


    if (count(explode(" ", $_POST['middlename'])) > 1)
    {
        $middle = explode(" ", $_POST['middlename']);
        $letter = $middle[0][0].$middle[1][0];
        $middleinitial = $letter . ".";
    }
    else
    {
        $middle = $_POST['middlename'];
        if ($middle == "" OR $middle == " ")
        {
            $middleinitial = "";
        }
        else
        {
            $middleinitial = substr($middle, 0, 1) . ".";
        }    
    }

    $fullname = strtoupper($_POST['firstname'] . " ". $middleinitial . " " . $_POST['lastname']);
    $sex = strtoupper($_POST['sex']);
    $age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
    $course = $_POST['course'];
    $yearlevel = $_POST['yearlevel'];
    $section = strtoupper($_POST['section']);
    $birthday = $_POST['bday'];
    $bday = strtoupper(date("F d, Y", strtotime($birthday)));
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bp = $_POST['bp'];
    $pr = $_POST['pr'];
    $temp = $_POST['temp'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $query = mysqli_query($conn, "SELECT campus FROM account WHERE accountid = '$user'");
    while($data=mysqli_fetch_array($query))
    {
        $campus = $data['campus'];
    }
    // code for department and college
    if ( $_POST['college'] == "")
    {
        $college = $_POST['department'];
    }
    else
    {
        $college = $_POST['department'] . " - " . $_POST['college'];
    }
    // code for course, year, section
    if ($_POST['course'] == "" AND $_POST['yearlevel'] == "" AND $_POST['section'] == "")
    {
        $cys = $_POST['department'];
    }
    else
    {
        $cys = $course . " " . $yearlevel . "-" . $section;
    }
    // code for birthday
    if ( $_POST['bday'] == "")
    {
        $bb = "";
    }
    else
    {
        $bb = $bday;
    }

    $pdf->Cell(52, 0, 'Student/Employee Number: ', 0,0, 'R');
    $pdf->Cell(1, 0, '___________________', 0,);
    $pdf->Cell(19, 0, '', 0, 'C');

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

    $pdf->Cell(63.3, 6, 'Height: '  . $height, 1, 0);
    $pdf->Cell(63.3, 6, 'Weight: '  . $weight, 1, 0);
    $pdf->Cell(63.3, 6, 'Birthday: ' . $bb, 1, 0);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->Cell(63.3, 6, 'Blood Pressure(BP): ' . $bp, 1, 0);
    $pdf->Cell(63.3, 6, 'Pulse Rate(PR): ' . $pr, 1, 0);
    $pdf->Cell(63.3, 6, 'Temperature: '  . $temp, 1, 0);

    $pdf->Cell(0, 6, '', 0, 1);

    $pdf->Cell(190, 6, 'H.E.E.N.T.:', 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Chest/Lungs:', 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Heart:', 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Abdomen:', 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, 'Extremeties:', 1, 0);
    $pdf->Cell(0, 6, '', 0, 1);
    $pdf->Cell(190, 6, '', 1, 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(40, 6, 'Bronchial Asthma', 0);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(40, 6, 'Heart Disease', 0);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(40, 6, 'Epilepsy', 0);
    
    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(40, 6, 'Surgery', 0);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(40, 6, 'Allergies', 0);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(40, 6, 'Hernia', 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(31.6, 6, '', 'B', 0);
    $pdf->Cell(31.6, 6, 'Last Menstrual Period', 0);
    $pdf->Cell(0, 10, '', 0, 1);


    $pdf->Cell(190, 87, '', 1);    
    $pdf->Cell(0, 1, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'Dental Examination:', 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(3, 3, '', 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'No Dental Defects', 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(3, 3, '', 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
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
    $pdf->Cell(3, 3, '', 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'Presence of GINGIVITIS and/or PERIODONTITIS', 0);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(3, 3, '', 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'For Tooth Scaling and Polishing', 0);
    
    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(5.7, 0, '', 0);
    $pdf->Cell(3, 3, '', 1, 0);
    $pdf->Cell(4.7, 0, '', 0);
    $pdf->Cell(3, 3, 'Other Dento-Facial Findings:_______________________________________________________________', 0);
    
    $pdf->Cell(0, 5, '', 0, 1);
    $pdf->SetFont('Arial', 'BI', 7);
    $pdf->Cell(3, 3, 'Note: You are therefore advised to correct the above mentioned dental findings', 0);
    $pdf->SetFont('Arial', '', 8);

    $pdf->Cell(0, 7, '', 0, 1);
    $pdf->Cell(0, 3, '____________________________________        ', 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, 'Dentist II                                   ', 0, 1, 'R');
    $pdf->Cell(0, 10, '', 0, 1);

    $pdf->Cell(0, 3, 'Remarks:', 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 3, '_______________________________________________________________________________________________________________', 0, 1, 'R');

    $pdf->Cell(0, 3, '', 0, 1);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 3, 'Recommendation:', 0);
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


    $filename = "Medical_Certificate_". $_POST['lastname'] . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>