<?php

session_start();

include('../../connection.php');

$patientid = $_POST['patientid'];
$firstname = strtoupper($_POST['firstname']);
$middlename = strtoupper($_POST['middlename']);
$lastname = strtoupper($_POST['lastname']);
$designation = strtoupper($_POST['designation']);
$age = $_POST['age'];
$sex = strtoupper($_POST['sex']);
$department = $_POST['department'];
$college = $_POST['college'];
$program = $_POST['program'];
$yearlevel = $_POST['yearlevel'];
$section = $_POST['section'];
$block = strtoupper($_POST['block']);
$campus = $_SESSION['campus'];

// Logbook info
$type = $_POST['type'];
$transaction = $_POST['transaction'];
$purpose = $_POST['service'];
$chief_complaint = $_POST['chief_complaint'] . " " . $_POST['chief_complaint_others'];
$findiag = $_POST['findiag'] . " " . $_POST['findiag_others'];
$remarks = $_POST['remarks'];
$referral = $_POST['referral'];
$medcaseid = $_POST['medcase'];
$medcase_others = $_POST['medcase_others'];
$pod_nod = $fullname;

foreach ($_POST['medicine']  as $key => $value) {
    $stmt = $conn->prepare('INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction, purpose, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $patientid,
        $firstname,
        $middlename,
        $lastname,
        $designation,
        $age,
        $sex,
        $department,
        $college,
        $program,
        $yearlevel,
        $section,
        $block,
        $value, // This is where you insert the medicine ID
        $transaction, // Assuming $transaction holds the transaction type
        $purpose,
        $chief_complaint,
        $findiag,
        $remarks,
        $referral,
        $value, // This should be the medicine ID, replace with appropriate variable if needed
        $pod_nod,
        $medcaseid, // Assuming $medcaseid holds the medical case ID
        $medcase_others,
        $campus,
        date('Y-m-d H:i:s') // Use the current date and time
    ]);
}

// Optionally, you may add error handling here to catch any exceptions thrown during the database insertion process

// Redirect the user to a specific page after successful insertion
header("Location: transaction_add.php");
exit();
