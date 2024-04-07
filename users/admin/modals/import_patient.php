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
                if (count($row) == 16) {
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

                    $dup = "SELECT patientid FROM patient_info WHERE patientid = '$patientid'";
                    $result = mysqli_query($conn, $dup);
                    if (mysqli_num_rows($result) == 0) {
                        $studentQuery = "INSERT INTO patient_info (patientid,designation,sex,birthday,department,campus,college,program,yearlevel,section,block,address,email,contactno,emcon_name,emcon_number, datetime_created, datetime_updated) VALUES ('$patientid','$designation','$sex','$birthday','$department','$campus','$college','$program','$yearlevel','$section','$block','$address','$email','$contactno','$emcon_name','$emcon_number', now(), now())";
                        $result = mysqli_query($conn, $studentQuery);
                        $msg = true;
                    } else {
                        $_SESSION['alert'] = "Not Imported. There is a duplicate entry for Patient ID.";
                        header('Location: ../patients');
                        exit(0);
                    }
                } else {
                    $_SESSION['alert'] = "Invalid File. Column number does not match.";
                    header('Location: ../patients');
                    exit(0);
                }
            } else {
                $count++;
            }
        }

        if (isset($msg)) {
            // Add records to meddoc table
            $doc = "INSERT INTO `meddoc` (`type`, `applicant`, `doc_desc`, `document`, `status`, `remarks`, `dt_uploaded`, `dt_updated`) VALUES
            ('ATHLETE', '$patientid', 'X-Ray', 'nofile.png', 'Pending', '', now(), now()),
            ('ATHLETE', '$patientid', 'Pregnancy Test', 'nofile.png', 'Pending', '', now(), now()),
            ('ATHLETE', '$patientid', 'Urinalysis', 'nofile.png', 'Pending', '', now(), now()),
            ('ATHLETE', '$patientid', 'CBC', 'nofile.png', 'Pending', '', now(), now()),
            ('FRESHMEN', '$patientid', 'X-Ray', 'nofile.png', 'Pending', '', now(), now()),
            ('FRESHMEN', '$patientid', 'CBC', 'nofile.png', 'Pending', '', now(), now()),
            ('FRESHMEN', '$patientid', 'DRUG TEST', 'nofile.png', 'Pending', '', now(), now()),
            ('OJT', '$patientid', 'CBC', 'nofile.jpg', 'Pending', '', now(), now()),
            ('OJT', '$patientid', 'Urinalysis', 'nofile.png', 'Pending', '', now(), now()),
            ('OJT', '$patientid', 'Pregnancy Test', 'nofile.png', 'Pending', '', now(), now()),
            ('OJT', '$patientid', 'X-Ray', 'nofile.png', 'Pending', '', now(), now());";
            mysqli_query($conn, $doc);

            $user = $_SESSION['userid'];
            $au_campus = $_SESSION['campus'];
            $fullname = strtoupper($_SESSION['name']);
            $activity = "added a patient information";
            $au_status = "unread";
            
            // Add record to patient_image table
            $sql = "INSERT INTO patient_image (patient_id, image,created_at) VALUES ('$patientid', 'noprofile.png', now())";
            mysqli_query($conn, $sql);

            // Add record to audit_trail table
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            mysqli_query($conn, $sql);

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
