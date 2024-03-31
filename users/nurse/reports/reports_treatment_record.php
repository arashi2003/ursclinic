<?php
    session_start();
    require('../../../fpdf/fpdf.php');
    include('connection.php');
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    date_default_timezone_set("Asia/Manila");
    
    class PDF extends FPDF
    {
        function Header()
        {
            include('connection.php');
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

            $patientid = $_REQUEST['patientid'];

            $this->Cell(0, 2, '', 0, 1);
            $this->SetFont('Arial', 'B', 13);
            $this->Cell(0, 0, 'TREATMENT RECORDS', 0, 1, 'C');
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 5, '', 0, 1);

            $sql = "SELECT * FROM treatment_record WHERE patientid='$patientid' LIMIT 1";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                if($data['patientid'] != "")
                {
                    $patientid = $data['patientid'];
                }
                else
                {
                    $patientid = "";
                }
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
                $pys = $data['program'] . " " . $data['year'] . "-" . $data['section'] . $data['block'];

                $this->SetFont('Arial', 'B', 10);
                $this->Cell(40, 6, 'Student/Employee No.: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(30, 6, $patientid, 0);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(12, 6, 'Name: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 6, $fullname, 0);
                $this->Cell(0, 3, '', 0, 1);

                $this->Cell(39, 0, '', 0);
                $this->Cell(30, 0, '_______________', 0,1);
                $this->Cell(81, 0, '', 0);
                $this->Cell(0, 0, '_______________________________________________________', 0,1);

                $this->Cell(0, 4, '', 0,1);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(37, 6, 'Department/College: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(54, 6, $dc, 0);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(40, 6, 'Program/Year/Section: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 6, $pys, 0);
                $this->Cell(0, 3, '', 0, 1);

                $this->Cell(36, 0, '', 0);
                $this->Cell(30, 0, '___________________________', 0,1);
                $this->Cell(130, 0, '', 0);
                $this->Cell(0, 0, '______________________________', 0,1);

                $this->Cell(0, 4, '', 0,1);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(24, 6, 'Date of Birth: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(54, 6, date("F d, Y",strtotime($data['birthday'])), 0);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(22, 6, 'Civil Status: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(40, 6, $data['civil_status'], 0);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(10, 6, 'Sex: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 6, ucfirst(strtolower($data['sex'])), 0);
                $this->Cell(0, 3, '', 0, 1);

                $this->Cell(23, 0, '', 0);
                $this->Cell(30, 0, '___________________________', 0,1);
                $this->Cell(100, 0, '', 0);
                $this->Cell(0, 0, '___________________', 0,1);
                $this->Cell(150, 0, '', 0);
                $this->Cell(0, 0, '____________________', 0,1);

                $this->Cell(0, 4, '', 0,1);
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(16, 6, 'Address: ', 0);
                $this->SetFont('Arial', '', 10);
                $this->Cell(77.2, 6, $data['address'], 0);
                $this->Cell(0, 3, '', 0, 1);

                $this->Cell(16, 0, '', 0);
                $this->Cell(30, 0, '________________________________________________________________________________________', 0,1);
            
                $this->Cell(0, 5, '', 0, 1);
                
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(25, 7, 'Date', 1, 0, 'C');
                $this->Cell(50, 7, 'Diagnosis', 1, 0, 'C');
                $this->Cell(20, 7, 'Tooth No.', 1, 0, 'C');
                $this->Cell(50, 7, 'Treatment Done', 1, 0, 'C');
                $this->Cell(45, 7, 'Operating Dentist', 1, 0, 'C');
                $this->SetFont('Arial', '', 7);
            }
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
            $this->Cell(195, 0, 'Effectivity Date: ' . $date  . " | " . $this->PageNo() . "/{nb}", 0, 1, 'R');
        }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetTitle("Treatment Record");
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->SetFont('Arial', '', 8);

    $patientid = $_REQUEST['patientid'];
    $sql = "SELECT * FROM treatment_record WHERE patientid='$patientid'";
    $result = mysqli_query($conn, $sql);
    while($data=mysqli_fetch_array($result))
    {
        $pdf->Cell(0, 7, '', 0, 1);
        $pdf->Cell(25, 7, $data['date'], 1, 0, 'C'); // 
        $pdf->Cell(50, 7, $data['diagnosis'], 1, 0);// 
        $pdf->Cell(20, 7,  $data['toothno'], 1, 0, 'C');//
        $pdf->Cell(50, 7, $data['treatment'], 1, 0);//
        $pdf->Cell(45, 7, $data['dentist'], 1, 0);// 
    }
    $filename = "Treatment_Record_" . $patientid . ".pdf";
    $pdf->Output($filename, 'I');
    mysqli_close($conn);
?>