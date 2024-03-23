<?php
session_start();
include('../../../connection.php');
$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$au_status = "unread";

if ($_POST['patientid'] != "" || $_POST['patientid'] != " ") {
    $activity = 'added a transaction record for ' . $_POST['type'] . " of " . $_POST['patientid'];
} else {
    $activity = 'added a transaction record for ' . $_POST['type'];
}

// Patient info
$patientid = $_POST['patientid'];
$firstname = strtoupper($_POST['firstname']);
$middlename = strtoupper($_POST['middlename']);
$lastname = strtoupper($_POST['lastname']);
$designation = strtoupper($_POST['designation']);
$age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
$sex = strtoupper($_POST['sex']);
$birthday = date("Y-m-d", strtotime($_POST['birthday']));
$department = $_POST['department'];
$college = $_POST['college'];
$program = $_POST['program'];
$yearlevel = $_POST['yearlevel'];
$section = $_POST['section'];
$block = strtoupper($_POST['block']);

// Logbook info
$bp = $_POST['bp'];
$pr = $_POST['pr'];
$temp = $_POST['temp'];
$respiratory = $_POST['respiratory'];
$oxygen = $_POST['oxygen'];
$type = "Walk-In";
$transaction =  $_POST['transaction'];
echo $purpose = $_POST['service'];
$chief_complaint = $_POST['chief_complaint'] . " " . $_POST['chief_complaint_others'];
$findiag = $_POST['findiag'] . " " . $_POST['findiag_others'];
$remarks = $_POST['remarks'];
$referral = $_POST['referral'];
$med_case = $_POST['medcase'];
$pod_nod = $fullname;

$sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
$result = mysqli_query($conn, $sql);
while($data=mysqli_fetch_array($result))
{
    if($data['medcase'] != 'Others:')
    { 
        $medcase =  $_POST['medcase'];
        $medcase_type = $data['type'];
        $medcase_others = $_POST['medcase_others'];
    }
    else
    {
        $medcase_type ="others";
        $medcase_others = $_POST['medcase_others'];
        $medcase = $medcase_others;
    }
}

$datenow = date("Y-m-d");
$enddate = date("Y-m-t");


// Handling for issued medicine
if (!empty($_POST['medicine'])) {
    $issued_medicine = [];
    foreach ($_POST['medicine'] as $key => $medicine) {
        $med = ''; // Initialize medicine string
        // Retrieve medicine details from the database
        $query0 = "SELECT state, medicine, dosage, unit_measure FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query0);
        while ($data = mysqli_fetch_assoc($result)) {
            $med = $data['medicine'] . " " . $data['dosage'] . " " . $data['unit_measure'];
        }
        // Combine medicine and quantity into a string and add to the issued_medicine array
        $issued_medicine[] = $_POST['quantity_med'][$key] . " " . $med;
    }
    // Combine issued medicine statements into a single statement
    $issued_medicine_statement = implode(", ", $issued_medicine);
} else {
    $issued_medicine_statement = ""; // Initialize as empty if no medicine is issued
}

// Handling for issued supply
if (!empty($_POST['supply'])) {
    $issued_supply = [];
    foreach ($_POST['supply'] as $key => $supply) {
        $sup = ''; // Initialize supply string
        // Retrieve supply details from the database
        $query0 = "SELECT state, supply, volume, unit_measure FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query0);
        while ($data = mysqli_fetch_assoc($result)) {
            $sup = $data['supply'] . " " . $data['volume'] . " " . $data['unit_measure'];
        }
        // Combine supply and quantity into a string and add to the issued_supply array
        $issued_supply[] = $_POST['quantity_sup'][$key] . " " . $sup;
    }
    // Combine issued supply statements into a single statement
    $issued_supply_statement = implode(", ", $issued_supply);
} else {
    $issued_supply_statement = ""; // Initialize as empty if no supply is issued
}

// Combine issued medicine and supply statements into a single statement
$medsup = rtrim($issued_medicine_statement . ", " . $issued_supply_statement, ", ");

// Insert transaction history
$query = "INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction, purpose,  bp, pr, temp, respiratory, oxygen_saturation, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) 
    VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', 
    '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', 
    '$bp', '$pr', '$temp', '$respiratory', '$oxygen', '$chief_complaint', '$findiag', '$remarks', '$referral', '$medsup', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
$result = mysqli_query($conn, $query);

// Update inventory for each medicine
if (!empty($_POST['medicine']) && isset($_POST['medicine'])) {
    $medicines = $_POST['medicine'];
    $quantities = $_POST['quantity_med'];
    foreach ($medicines as $key => $medicine) {
        $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $mstate = $data['state'];
        }

        if($mstate == 'per piece')
        {
            // Update inventory_medicine
            $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantities[$key]', qty = qty - '$quantities[$key]' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities[$key]', qty = qty - '$quantities[$key]' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities[$key]', qty = qty - '$quantities[$key]' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities[$key];
                $aotqty = $data['tqty'];
                $aieqty = $data['eqty'];
                $aiiamt = $data['iamt'];
                $aiiqty = $data['iqty'];
                $aieamt = $data['eamt']; //buc
                $cost = $data['eamt'] / $data['eqty'];
    
                $tqty = $aotqty - $qty;
                $eqty = $data['eqty'] - $qty;
    
                if ($data['tqty'] == 0) {
                    $aobuc = 0;
                    $abuc = number_format($aobuc, 2, ".");
                } else {
                    $aobuc = ($data['eamt'] - ($qty * $cost)) / $eqty;
                    $abuc = number_format($aobuc, 2, ".");
                }
                $aeamt = $eqty * $aobuc;
                if ($data['iqty'] == 0) {
                    $iamt =  $qty * $aobuc;
                    $iqty =  $qty;
                } else {
                    $iqty = $data['iqty'] + $qty;
                    $iamt = $iqty * ($aeamt / $eqty);
                }
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

// Update inventory for each supply
if (!empty($_POST['supply']) && isset($_POST['supply'])) {
    $supplies = $_POST['supply'];
    $quantities_sup = $_POST['quantity_sup'];
    foreach ($supplies as $key => $supply) {
        $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $sstate = $data['state'];
        }

        if($sstate == 'per piece')
        {
            // Update inventory_supply
            $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup[$key]', qty = qty - '$quantities_sup[$key]' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities_sup[$key]', qty = qty - '$quantities_sup[$key]' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities_sup[$key]', qty = qty - '$quantities_sup[$key]' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities_sup[$key];
                $aotqty = $data['tqty'];
                $aieqty = $data['eqty'];
                $aiiamt = $data['iamt'];
                $aiiqty = $data['iqty'];
                $aieamt = $data['eamt']; //buc
                $cost = $data['eamt'] / $data['eqty'];

                $tqty = $aotqty - $qty;
                $eqty = $data['eqty'] - $qty;

                if ($data['tqty'] == 0) {
                    $aobuc = 0;
                    $abuc = number_format($aobuc, 2, ".");
                } else {
                    $aobuc = ($data['eamt'] - ($qty * $cost)) / $eqty;
                    $abuc = number_format($aobuc, 2, ".");
                }
                $aeamt = $eqty * $aobuc;
                if ($data['iqty'] == 0) {
                    $iamt =  $qty * $aobuc;
                    $iqty =  $qty;
                } else {
                    $iqty = $data['iqty'] + $qty;
                    $iamt = $iqty * ($aeamt / $eqty);
                }
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

// Update medcase report
$sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
$result = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($result)) {
    // Update counts based on designation and sex
    switch (true) {
        case ($designation == "STUDENT" && $sex == "MALE"):
            $sm = $data['sm'] + 1;
            $sf = $data['sf'];
            $st = $data['st'] + 1;
            $pm = $data['pm'];
            $pf = $data['pf'];
            $pt = $data['pt'];
            $gm = $data['gm'] + 1;
            $gf = $data['gf'];
            $gt = $data['gt'] + 1;
            break;
        case ($designation == "STUDENT" && $sex == "FEMALE"):
            $sm = $data['sm'];
            $sf = $data['sf'] + 1;
            $st = $data['st'] + 1;
            $pm = $data['pm'];
            $pf = $data['pf'];
            $pt = $data['pt'];
            $gm = $data['gm'];
            $gf = $data['gf'] + 1;
            $gt = $data['gt'] + 1;
            break;
        case ($designation != "STUDENT" && $sex == "MALE"):
            $sm = $data['sm'];
            $sf = $data['sf'];
            $st = $data['st'];
            $pm = $data['pm'] + 1;
            $pf = $data['pf'];
            $pt = $data['pt'] + 1;
            $gm = $data['gm'] + 1;
            $gf = $data['gf'];
            $gt = $data['gt'] + 1;
            break;
        case ($designation != "STUDENT" && $sex == "FEMALE"):
            $sm = $data['sm'];
            $sf = $data['sf'];
            $st = $data['st'];
            $pm = $data['pm'];
            $pf = $data['pf'] + 1;
            $pt = $data['pt'] + 1;
            $gm = $data['gm'];
            $gf = $data['gf'] + 1;
            $gt = $data['gt'] + 1;
            break;
        default:
            $sm = $data['sm'];
            $sf = $data['sf'];
            $st = $data['st'];
            $pm = $data['pm'];
            $pf = $data['pf'];
            $pt = $data['pt'];
            $gm = $data['gm'];
            $gf = $data['gf'];
            $gt = $data['gt'];
            break;
    }
    // Update report
    $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
    mysqli_query($conn, $sql);
}

// Audit trail 
$sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
if ($result = mysqli_query($conn, $sql)) {
?>
    <script>
        setTimeout(function() {
            window.location = "../transaction_history";
        });
    </script>
<?php
    // modal message box saying "Transaction was recorded."
} else {
?>
    <script>
        setTimeout(function() {
            window.location = "../transaction_history";
        });
    </script>
<?php
    // modal message box saying "Transaction was recorded."
}

mysqli_close($conn);
?>