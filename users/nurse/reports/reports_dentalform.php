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
            $query = mysqli_query($conn, "SELECT * FROM audit_t']rail WHERE user = '$user' AND activity = '$activity'");
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

            // $data['datetime and page
            $date = date('F d, Y');
            $this->Cell(0, 5, '', 0, 1);
            $this->Cell(50, 0, 'URS-AF-GE-MED-F-2017-10', 0, 1, 'L');            
            $this->Cell(100, 0, 'Rev. ' . $rev , 0, 1, 'R');
            $this->Cell(195, 0, 'Effectivity Date: ' . $date, 0, 1, 'R');
        }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetTitle("Dental Form");
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 8);

    $patientid = $_REQUEST['patientid'];
   
    $sql = "SELECT * FROM dental_record_1 INNER JOIN dental_record_2 WHERE patientid='$patientid' LIMIT 1";
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

        $pdf->Cell(0, 5, '', 0,1);
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

        $pdf->Cell(0, 8, '', 0,1);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 0, 'INDIVIDUAL DENTAL HEALTH RECORD', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(0, 6, '', 0,1);
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

        $pdf->Cell(0, 5, '', 0,1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(16, 6, 'Address: ', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(77.2, 6, $data['address'], 0);
        $pdf->Cell(0, 3, '', 0, 1);

        $pdf->Cell(16, 0, '', 0);
        $pdf->Cell(30, 0, '________________________________________________________________________________________', 0,1);
    
        $pdf->Cell(0, 6, '', 0, 1);
        $pdf->Cell(95, 0, '', 0);
        $pdf->Cell(0, 103, '', 'L', 0);

        $pdf->Cell(0, 1, '', 0, 1);
        $pdf->Cell(81, 6, '', 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, '(LABIO  BUCCAL)', 0);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(0, 6, '', 0, 1);
        $pdf->Cell(15, 5, '', 0);
        $pdf->Cell(30, 5, 'OPERATION', 0);
        $pdf->Cell(10, 5, $data['t_55'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_54'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_53'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_52'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_51'] , 1, 0, 'C');// 
        
        $pdf->Cell(10, 5, $data['t_61'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_62'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_63'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_64'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_65'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(15, 5, '', 0);
        $pdf->Cell(30, 5, 'CONDITION', 0);
        $pdf->Cell(10, 5, $data['b_55'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_54'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_53'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_52'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_51'] , 1, 0, 'C');// 
        
        $pdf->Cell(10, 5, $data['b_61'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_62'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_63'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_64'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_65'] , 1, 0, 'C');// 
        
        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(15, 5, '', 0);
        $pdf->Cell(32, 5, '', 0);
        $pdf->Cell(10, 5, '55', 'C');
        $pdf->Cell(10, 5, '54', 'C');
        $pdf->Cell(10, 5, '53', 'C');
        $pdf->Cell(10, 5, '52', 'C');
        $pdf->Cell(10, 5, '51', 'C');
        
        $pdf->Cell(10, 5, '61', 'C');
        $pdf->Cell(10, 5, '62', 'C');
        $pdf->Cell(10, 5, '63', 'C');
        $pdf->Cell(10, 5, '64', 'C');
        $pdf->Cell(10, 5, '65', 'C');

        $pdf->Cell(0, 12, '', 0, 1);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 5, 'OPERATION', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, $data['t_18'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_17'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_16'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_15'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_14'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_13'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_12'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_11'] , 1, 0, 'C');// 

        $pdf->Cell(10, 5, $data['t_21'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_22'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_23'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_24'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_25'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_26'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_27'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_28'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 5, 'CONDITION', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, $data['b_18'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_17'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_16'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_15'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_14'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_13'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_12'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_11'] , 1, 0, 'C');// 

        $pdf->Cell(10, 5, $data['b_21'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_22'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_23'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_24'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_25'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_26'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_27'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_28'] , 1, 0, 'C');// 

        $pdf->Cell(0, 12, '', 0, 1);
        $pdf->Cell(17, 5, '', 0);
        $pdf->Cell(10, 5, '18', 'C');
        $pdf->Cell(10, 5, '17', 'C');
        $pdf->Cell(10, 5, '16', 'C');
        $pdf->Cell(10, 5, '15', 'C');
        $pdf->Cell(10, 5, '14', 'C');
        $pdf->Cell(10, 5, '13', 'C');
        $pdf->Cell(10, 5, '12', 'C');
        $pdf->Cell(10, 5, '11', 'C');
        
        $pdf->Cell(10, 5, '21', 'C');
        $pdf->Cell(10, 5, '22', 'C');
        $pdf->Cell(10, 5, '23', 'C');
        $pdf->Cell(10, 5, '24', 'C');
        $pdf->Cell(10, 5, '25', 'C');
        $pdf->Cell(10, 5, '26', 'C');
        $pdf->Cell(10, 5, '27', 'C');
        $pdf->Cell(10, 5, '28', 'C');

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(18, 13, '', 0);
        $pdf->Cell(154, 0, '', 'B', 0);

        $pdf->Cell(0, 1, '', 0, 1);
        $pdf->Cell(17, 5, '', 0);
        $pdf->Cell(10, 5, '48', 'C');
        $pdf->Cell(10, 5, '47', 'C');
        $pdf->Cell(10, 5, '46', 'C');
        $pdf->Cell(10, 5, '45', 'C');
        $pdf->Cell(10, 5, '44', 'C');
        $pdf->Cell(10, 5, '43', 'C');
        $pdf->Cell(10, 5, '42', 'C');
        $pdf->Cell(10, 5, '41', 'C');
        
        $pdf->Cell(10, 5, '31', 'C');
        $pdf->Cell(10, 5, '32', 'C');
        $pdf->Cell(10, 5, '33', 'C');
        $pdf->Cell(10, 5, '34', 'C');
        $pdf->Cell(10, 5, '35', 'C');
        $pdf->Cell(10, 5, '36', 'C');
        $pdf->Cell(10, 5, '37', 'C');
        $pdf->Cell(10, 5, '38', 'C');

        $pdf->Cell(0, 11.5, '', 0, 1);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 5, 'OPERATION', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, $data['t_48'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_47'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_46'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_45'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_44'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_43'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_42'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_41'] , 1, 0, 'C');// 

        $pdf->Cell(10, 5, $data['t_31'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_32'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_33'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_34'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_35'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_36'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_37'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_38'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(15, 5, 'CONDITION', 0);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 5, $data['b_48'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_47'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_46'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_45'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_44'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_43'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_42'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_41'] , 1, 0, 'C');// 

        $pdf->Cell(10, 5, $data['b_31'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_32'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_33'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_34'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_35'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_36'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_37'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_38'] , 1, 0, 'C');// 

        $pdf->Cell(0, 6, '', 0, 1);
        $pdf->Cell(15, 5, '', 0);
        $pdf->Cell(32, 5, '', 0);
        $pdf->Cell(10, 5, '85', 'C');
        $pdf->Cell(10, 5, '84', 'C');
        $pdf->Cell(10, 5, '83', 'C');
        $pdf->Cell(10, 5, '82', 'C');
        $pdf->Cell(10, 5, '81', 'C');
        
        $pdf->Cell(10, 5, '71', 'C');
        $pdf->Cell(10, 5, '72', 'C');
        $pdf->Cell(10, 5, '73', 'C');
        $pdf->Cell(10, 5, '74', 'C');
        $pdf->Cell(10, 5, '75', 'C');

        $pdf->Cell(0, 12, '', 0, 1);
        $pdf->Cell(15, 5, '', 0);
        $pdf->Cell(30, 5, 'OPERATION', 0);
        $pdf->Cell(10, 5, $data['t_85'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_84'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_83'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_82'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_81'] , 1, 0, 'C');// 
        
        $pdf->Cell(10, 5, $data['t_71'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_72'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_73'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_74'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['t_75'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(15, 5, '', 0);
        $pdf->Cell(30, 5, 'CONDITION', 0);
        $pdf->Cell(10, 5, $data['b_85'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_84'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_83'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_82'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_81'] , 1, 0, 'C');// 
        
        $pdf->Cell(10, 5, $data['b_71'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_72'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_73'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_74'] , 1, 0, 'C');// 
        $pdf->Cell(10, 5, $data['b_75'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5.5, '', 0, 1);
        $pdf->Cell(81, 6, '', 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, '(LABIO  BUCCAL)', 0);
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(0, 8, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'Year', 1, 0);
        $pdf->Cell(15.7, 5, $data['year_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['year_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['year_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['year_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['year_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'DATE of EXAMINATION', 1, 0);
        $pdf->Cell(15.7, 5, $data['doe_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['doe_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['doe_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['doe_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['doe_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'AGE LAST BIRTHDAY', 1, 0);
        $pdf->Cell(15.7, 5, $data['alb_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['alb_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['alb_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['alb_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['alb_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'PRESENCE OF ORAL DEBRIS / STAINS / CALCULUS', 1, 0);
        $pdf->Cell(15.7, 5, $data['posc_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['posc_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['posc_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['posc_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['posc_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'PRESENCE OF GINGIVITIS and/or PERIODONTITIS', 1, 0);
        $pdf->Cell(15.7, 5, $data['pgp_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['pgp_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['pgp_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['pgp_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['pgp_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'PRESENCE OF PERIODONTAL POCKETS', 1, 0);
        $pdf->Cell(15.7, 5, $data['ppp_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['ppp_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['ppp_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['ppp_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['ppp_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'PRESENCE OF DENTO-FACIAL ANOMALY', 1, 0);
        $pdf->Cell(15.7, 5, $data['pdfa_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['pdfa_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5, $data['pdfa_3'] , 1, 0, 'C');// 
        $pdf->Cell(15.3, 5, $data['pdfa_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['pdfa_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'USE TOOTHBRUSH', 1, 0);
        $pdf->Cell(15.7, 5, $data['toothbrush_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['toothbrush_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5,  $data['toothbrush_3'] , 1, 0, 'C');//
        $pdf->Cell(15.3, 5, $data['toothbrush_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['toothbrush_5'] , 1, 0, 'C');// 


        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(69.2, 5, 'TOOTH COUNT', 1, 0);
        $pdf->Cell(8, 5, '', 'L', 0);
        $pdf->Cell(7.85, 5, 'T', 1, 0, 'C');
        $pdf->Cell(7.85, 5, 'P', 1, 0, 'C');
        $pdf->Cell(7.75, 5, 'T', 1, 0, 'C');
        $pdf->Cell(7.75, 5, 'P', 1, 0, 'C');
        $pdf->Cell(7.85, 5, 'T', 1, 0, 'C');
        $pdf->Cell(7.85, 5, 'P', 1, 0, 'C'); 
        $pdf->Cell(7.65, 5, 'T', 1, 0, 'C');
        $pdf->Cell(7.65, 5, 'P', 1, 0, 'C');   
        $pdf->Cell(7.9, 5, 'T', 1, 0, 'C');
        $pdf->Cell(7.9, 5, 'P', 1, 0, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(69.2, 5, 'CARIES INDICATED FOR FILLING', 1, 0);
        $pdf->Cell(8, 5, '', 'L', 0, 'C');
        $pdf->Cell(7.85, 5, $data['ciff_t_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['ciff_p_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['ciff_t_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['ciff_p_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['ciff_t_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['ciff_p_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['ciff_t_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['ciff_p_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['ciff_t_5'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['ciff_p_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(69.2, 5, 'CARIES INDICATED FOR EXTRACTION', 1, 0);
        $pdf->Cell(8, 5, '', 'L', 0, 'C');
        $pdf->Cell(7.85, 5, $data['cife_t_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['cife_p_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['cife_t_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['cife_p_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['cife_t_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['cife_p_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['cife_t_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['cife_p_4'] , 1, 0, 'C');//
        $pdf->Cell(7.9, 5, $data['cife_t_5'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['cife_p_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(69.2, 5, 'ROOT FRAGMENT', 1, 0);
        $pdf->Cell(8, 5, '', 'L, B', 0, 'C');
        $pdf->Cell(7.85, 5, $data['rf_t_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['rf_p_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['rf_t_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['rf_p_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['rf_t_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['rf_p_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['rf_t_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['rf_p_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['rf_t_5'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['rf_p_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(69.2, 5, 'MISSING DUE TO CARIES', 1, 0);
        $pdf->Cell(8, 5, '', 'L, B', 0, 'C');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(7.85, 5, 'x', 1, 0, 'C');// 
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.85, 5, $data['mdtc_p_1'] , 1, 0, 'C');// 
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(7.75, 5, 'x', 1, 0, 'C');// 
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.75, 5, $data['mdtc_p_2'] , 1, 0, 'C');// 
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(7.85, 5, 'x', 1, 0, 'C');// 
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.85, 5, $data['mdtc_p_3'] , 1, 0, 'C');// 
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(7.65, 5, 'x', 1, 0, 'C');// 
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.65, 5, $data['mdtc_p_4'] , 1, 0, 'C');// 
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(7.9, 5, 'x', 1, 0, 'C');// 
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.9, 5, $data['mdtc_p_5'] , 1, 0, 'C');// 

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(69.2, 5, 'FILLED OR RESTORED', 1, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(8, 5, 'F', 1, 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.85, 5, $data['for_t_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['for_p_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['for_t_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['for_p_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['for_t_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['for_p_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['for_t_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['for_p_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['for_t_5'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['for_p_5'] , 1, 0, 'C');// 
        
        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(77.2, 5, 'TOTAL DMF & df', 1, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(7.85, 5, $data['tdmfdf_t_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['tdmfdf_p_1'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['tdmfdf_t_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.75, 5, $data['tdmfdf_p_2'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['tdmfdf_t_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.85, 5, $data['tdmfdf_p_3'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['tdmfdf_t_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.65, 5, $data['tdmfdf_p_4'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['tdmfdf_t_5'] , 1, 0, 'C');// 
        $pdf->Cell(7.9, 5, $data['tdmfdf_p_5'] , 1, 0, 'C');// 

        

        $pdf->Cell(0, 5, '', 0, 1);
        $pdf->Cell(17.8, 5, '', 0);
        $pdf->Cell(77.2, 5, 'FLUORIDE APPLICATION', 1, 0);
        $pdf->Cell(15.7, 5, $data['fa_1'] , 1, 0, 'C');// 
        $pdf->Cell(15.5, 5, $data['fa_2'] , 1, 0, 'C');// 
        $pdf->Cell(15.7, 5,  $data['fa_3'] , 1, 0, 'C');//
        $pdf->Cell(15.3, 5, $data['fa_4'] , 1, 0, 'C');// 
        $pdf->Cell(15.8, 5, $data['fa_5'] , 1, 0, 'C');// 
    }

    $pdf->Image('../../../images/smoltooth.jpg', 55.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 65.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 75.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 85.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 95.5, 103, 9, 6);

    $pdf->Image('../../../images/smoltooth.jpg', 105.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 115.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 125.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 135.5, 103, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 145.5, 103, 9, 6);

    $pdf->Image('../../../images/bigtooth.jpg', 25.5, 121, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 35.5, 121, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 45.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 55.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 65.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 75.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 85.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 95.5, 121, 9, 6);

    $pdf->Image('../../../images/smoltooth.jpg', 105.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 115.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 125.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 135.5, 121, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 145.5, 121, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 155.5, 121, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 165.5, 121, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 175.5, 121, 9, 6);

    $pdf->Image('../../../images/bigtooth.jpg', 25.5, 137.5, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 35.5, 137.5, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 45.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 55.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 65.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 75.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 85.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 95.5, 137.5, 9, 6);

    $pdf->Image('../../../images/smoltooth.jpg', 105.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 115.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 125.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 135.5, 137.5, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 145.5, 137.5, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 155.5, 137.5, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 165.5, 137.5, 9, 6);
    $pdf->Image('../../../images/bigtooth.jpg', 175.5, 137.5, 9, 6);

    $pdf->Image('../../../images/smoltooth.jpg', 55.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 65.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 75.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 85.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 95.5, 160, 9, 6);

    $pdf->Image('../../../images/smoltooth.jpg', 105.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 115.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 125.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 135.5, 160, 9, 6);
    $pdf->Image('../../../images/smoltooth.jpg', 145.5, 160, 9, 6);

    
    $pdf->Image('../../../images/right.jpeg', 10, 100.5, 17, 8);
    $pdf->Image('../../../images/left.jpeg', 167, 100.5, 17, 8);

    $pdf->Image('../../../images/upper.jpeg', 185, 123, 16, 6);
    $pdf->Image('../../../images/lower.jpeg', 185, 137, 16, 6);

    $pdf->Image('../../../images/decayed.jpg', 99.5, 227, 3, 18);

    $filename = "Dental_Form_". $patientid . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>