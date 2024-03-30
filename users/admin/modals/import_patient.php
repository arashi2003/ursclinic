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
                $sex = $row['2'];
                $birthday = $row['3'];
                $department = $row['4'];
                $campus = $row['5'];
                $college = $row['6'];
                $program = $row['7'];
                $yearlevel = $row['8'];
                $section = $row['9'];
                $block = $row['10'];
                $address = $row['11'];
                $email = $row['12'];
                $contactno = $row['13'];
                $emcon_name = $row['14'];
                $emcon_number = $row['15'];

                $studentQuery = "INSERT INTO patient_info 
                (patientid,designation,sex,birthday,department,campus,college,program,yearlevel,section,block,address,email,contactno,emcon_name,emcon_number, datetime_created, datetime_updated) VALUES 
                ('$patientid','$designation','$sex','$birthday','$department','$campus','$college','$program','$yearlevel','$section','$block','$address','$email','$contactno','$emcon_name','$emcon_number', now(), now())";
                $result = mysqli_query($conn, $studentQuery);
                $msg = true;
            } else {
                $count = "1";
            }
        }

        if (isset($msg)) {
            $_SESSION['alert'] = "Successfully Imported";
            header('Location: ../patients');
            exit(0);
        } else {
            $_SESSION['alert'] = "Not Imported";
            header('Location: ../patients');
            exit(0);
        }
    } else {
        $_SESSION['alert'] = "Invalid File";
        header('Location: ../patients');
        exit(0);
    }
}
