<?php
    session_start();
    include('../../../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = 'added a transaction record for ' . $_POST['type'] . " to " . ;

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
    $referral = $_POST['referral'];
    $medcase = $_POST['medcase'];
    $medcase_others = $_POST['medcase_others'];
    $pod_nod = $fullname;
    
    $qty_m = $_POST['quantity_med'];
    $medicine = $_POST['medicine'];
    $qty_s = $_POST['quantity_sup'];
    $supply = $_POST['supply'];
    $issued = "";

    // code for issued
    if($medicine != "" AND $supply != "")
    {
        for($a = 0; $a < count($medicine); $a++)
        {
            $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
            }
            $issued .= $qty_m[$a] . " " . $med . ", ";
        }
        for($b = 0; $b < count($supply); $b++)
        {
            $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $sup = $data['supply']. " " . $data['volume'] .  $data['unit_measure']; 
            }
            $issued .= $qty_s[$b] . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    elseif($medicine == "" AND $supply != "")
    {
        for($b = 0; $b < count($supply); $b++)
        {
            $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $sup = $data['supply'].  $data['volume'] .  $data['unit_measure']; 
            }
            $issued .= $qty_s[$b] . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    elseif($medicine != "" AND $supply == "")
    {
        $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
        }
        $issued .= $qty_m[$a] . " " . $med;
        $issued .= $qty_s[$b] . " " . $sup;
        if($b < count($medicine) - 1)
        {
            $issued .= ", ";
        }
    }
    
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
        //inventory_medicine and supply update
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