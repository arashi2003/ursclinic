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

        $count = 0; // Start count from 0 to skip header row
        foreach ($data as $row) {
            if ($count > 0) { // Skip the first row (header row)
                if (count($row) == 10) { // Check if the number of columns matches
                    $accountid = $row[0];
                    $password = $row[1];
                    $usertype = $row[2];
                    $firstname = $row[3];
                    $middlename = $row[4];
                    $lastname = $row[5];
                    $email = $row[6];
                    $contactno = $row[7];
                    $campus = $row[8];
                    $status = $row[9];

                    $dup = "SELECT accountid FROM account WHERE accountid = '$accountid'";
                    $result = mysqli_query($conn, $dup);
                    if (mysqli_num_rows($result) == 0) {
                        $studentQuery = "INSERT INTO account (accountid, password, usertype, firstname, middlename, lastname, email, contactno, campus, status, datetime_created, datetime_updated) VALUES ('$accountid','$password','$usertype','$firstname','$middlename','$lastname','$email','$contactno','$campus','$status', now(), now())";
                        $result = mysqli_query($conn, $studentQuery);
                        $_SESSION['alert'] = "Successfully Imported";
                    } else {
                        $_SESSION['alert'] = "Not Imported. Account ID already exists.";
                    }
                } else {
                    $_SESSION['alert'] = "Invalid File. Column number does not match.";
                    header('Location: ../account_users');
                    exit(0);
                }
            } else {
                $count++;
            }
        }

        header('Location: ../account_users');
        exit(0);
    } else {
        $_SESSION['alert'] = "Invalid File";
        header('Location: ../account_users');
        exit(0);
    }
}
