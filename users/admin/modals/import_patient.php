<?php
session_start();
include('../../../connection.php');

require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['save_excel_data'])) {
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach ($data as $row) {
            if ($count > 0) {
                $patientid = $row['0'];
                $designation = $row['1'];
                $age = $row['2'];
                $sex = $row['3'];
                $birthday = $row['4'];
                $department = $row['5'];
                $campus = $row['6'];
                $college = $row['7'];
                $program = $row['8'];
                $yearlevel = $row['9'];
                $section = $row['10'];
                $block = $row['11'];
                $address = $row['12'];
                $email = $row['13'];
                $contactno = $row['14'];
                $emcon_name = $row['15'];
                $emcon_number = $row['16'];

                $studentQuery = "INSERT INTO patient_info (patientid,designation,age,sex,birthday,department,campus,college,program,yearlevel,section,block,address,email,contactno,emcon_name,emcon_number, datetime_created, datetime_updated) 
                VALUES ('$patientid','$designation','$age','$sex','$birthday','$department','$campus','$college','$program','$yearlevel','$section','$block','$address','$email','$contactno','$emcon_name','$emcon_number', now(), now())";
                $result = mysqli_query($conn, $studentQuery);
                $msg = true;
            } else {
                $count = "1";
            }
        }

        if (isset($msg)) {
            $_SESSION['alert'] = "Successfully Imported";
            header('Location: patients');
            exit(0);
        } else {
            $_SESSION['alert'] = "Not Imported";
            header('Location: patients');
            exit(0);
        }
    } else {
        $_SESSION['alert'] = "Invalid File";
        header('Location: patients');
        exit(0);
    }
}
