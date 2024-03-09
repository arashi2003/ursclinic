<?php
    session_start();
    include('../../../connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = 'added a transaction record for ' . $_POST['type'];

    //patient info
    $patientid = $_POST['patientid'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $designation = $_POST['designation'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $department = $_POST['department'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $block = $_POST['block'];

    //logbook info
    $type = $_POST['type'];
    $transaction = $_POST['transaction'];
    $purpose = $_POST['service'];
    $chief_complaint = $_POST['chief_complaint'] . " " . $_POST['chief_complaint_others'];
    $findiag = $_POST['findiag'] . " " . $_POST['findiag_others'];
    $remarks = $_POST['remarks'];
    $medicine = $_POST['medicine'];
    $supply = $_POST['supply'];
    $quantity = $_POST['quantity'];
    $referral = $_POST['refferal'];
    $medcase = $_POST['medcase'];
    $medcase_others = $_POST['medcase_others'];
    $pod_nod = $fullname;
    $issued = "";//pa sentence na qty + medsup


    $query = "INSERT INTO transaction_history
    (patient, firstname, middlename, lastname, designation, age, sex, 
    department, college, program, yearlevel, section, block, type, transaction,	
    purpose, chief_complaint, findiag, remarks, referral,	
    medsup, pod_nod, medcase, medcase_others, campus, datetime)
    VALUES 
    ('$patient', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', 
    '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$birthday', '$type', '$transaction',	
    '$purpose', '$chief_complaint', '$findiag', '$remarks', '$referral',	
    '$issued', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";    
    $result = mysqli_query($conn, $query);
    if($result)
    {
        //inventory update
        //inventory_medicine update
        //inv_total update
        //report_medsupinv update
    }
    else
    {
        // modal message box saying "Transaction was not recorded."
?>
<script>
    setTimeout(function() {
        window.location = "../transaction_add.php";
    });
    </script>
<?php
}
mysqli_close($conn);