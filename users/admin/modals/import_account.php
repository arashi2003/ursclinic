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
                $accountid = $row['0'];
                $password = $row['1'];
                $usertype = $row['2'];
                $firstname = $row['3'];
                $middlename = $row['4'];
                $lastname = $row['5'];
                $email = $row['6'];
                $contactno = $row['7'];
                $campus = $row['8'];
                $status = $row['9'];
                
                $studentQuery = "INSERT INTO account 
                (accountid, password, usertype, firstname, middlename, lastname, email, contactno, campus, status, datetime_created, datetime_updated) 
                VALUES 
                ('$accountid','$password','$usertype','$firstname','$middlename','$lastname','$email','$contactno','$campus','$status', now(), now())";
                $result = mysqli_query($conn, $studentQuery);
                $msg = true;
            } else {
                $count = "1";
            }
        }

        if (isset($msg)) {
            $_SESSION['alert'] = "Successfully Imported";
            header('Location: ../account_users');
            exit(0);
        } else {
            $_SESSION['alert'] = "Not Imported";
            header('Location: ../account_users');
            exit(0);
        }
    } else {
        $_SESSION['alert'] = "Invalid File";
        header('Location: ../account_users');
        exit(0);
    }
}
