<?php
session_start();
include('../../../connection.php');
date_default_timezone_set("Asia/Manila");

// Patient info
$id = $_POST['id'];
$remarks = $_POST['remarks'];
$bp = $_POST['bp'];
$pr = $_POST['pr'];
$temp = $_POST['temp'];
$respiratory = $_POST['respiratory'];
$oxygen = $_POST['oxygen'];
if (!empty($_POST['findiag'])) {
    $findiag = $_POST['findiag'] . " " . $_POST['findiag_others'];
} else {
    $findiag = "";
}
$remarks = $_POST['remarks'];
$referral = $_POST['referral'];

$doot = "SELECT * FROM appointment WHERE id='$id'";
$result0 = mysqli_query($conn, $doot);
while ($row = mysqli_fetch_array($result0)) {
    $time_from = $row['time_from'];
    $time_to = $row['time_to'];
    $patientid = $row['patient'];
    $trans = $row['type'];
    $purp = $row['purpose'];
    $chief_complaint = $row['chiefcomplaint'] . " " . $row['others'];

    $sql = "SELECT type FROM appointment_type WHERE id='$trans'";
    $result = mysqli_query($conn, $sql);
    while ($grr = mysqli_fetch_array($result)) {
        $transaction = $grr['type'];
    }

    $sql = "SELECT purpose FROM appointment_purpose WHERE id='$purp'";
    $result = mysqli_query($conn, $sql);
    while ($grr = mysqli_fetch_array($result)) {
        $purpose = $grr['purpose'];
    }

    $query0 = "SELECT * FROM patient_info WHERE patientid = '$patientid'";
    $result = mysqli_query($conn, $query0);
    while ($data = mysqli_fetch_array($result)) {
        $designation = strtoupper($data['designation']);
        $age = floor((time() - strtotime($data['birthday'])) / 31556926);
        $sex = strtoupper($data['sex']);
        $birthday = date("Y-m-d", strtotime($data['birthday']));
        $department = $data['department'];
        $college = $data['college'];
        $program = $data['program'];
        $yearlevel = $data['yearlevel'];
        $section = $data['section'];
        $block = strtoupper($data['block']);
    }

    $query1 = "SELECT * FROM account WHERE accountid = '$patientid'";
    $result = mysqli_query($conn, $query1);
    while ($data = mysqli_fetch_array($result)) {
        $firstname = strtoupper($data['firstname']);
        $middlename = strtoupper($data['middlename']);
        $lastname = strtoupper($data['lastname']);
    }


    //kunin medcase type
    $med_case = $transaction;
    $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            if ($data['medcase'] != 'Others:') {
                $medcase =  $data['medcase'];
                $medcase_type = $data['type'];
                $medcase_others = $purpose;
            } else {
                $medcase_type = "others";
                $medcase_others = $transaction;
                $medcase = $purpose;
            }
        }
    } else {
        $medcase_type = "others";
        $medcase_others = $transaction;
        $medcase = $purpose;
    }


    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = 'added a appointment record for  of ' . $patientid;
    $pod_nod = $fullname;

    // Logbook info
    $type = "Appointment";
    $datenow = date("Y-m-d");
    $enddate = date("Y-m-t");
    $medsup0 = "";


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

    //kunin medcase type
    $med_case = $transaction;
    $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            if ($data['medcase'] != 'Others:') {
                $medcase =  $data['medcase'];
                $medcase_type = $data['type'];
                $medcase_others = $purpose;
            } else {
                $medcase_type = "others";
                $medcase_others = $transaction;
                $medcase = $purpose;
            }
        }
    } else {
        $medcase_type = "others";
        $medcase_others = $transaction;
        $medcase = $purpose;
    }


    // Insert transaction history
    $query = "INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction, purpose,  bp, pr, temp, respiratory, oxygen_saturation, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$bp', '$pr', '$temp', '$respiratory', '$oxygen', '$chief_complaint', '$findiag', '$remarks', '$referral', '$medsup', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
    $result = mysqli_query($conn, $query);


    // Update inventory for each medicine
    if (!empty($_POST['medicine']) && isset($_POST['medicine'])) {
        $medicines = $_POST['medicine'];
        $quantities = $_POST['quantity_med'];
        foreach ($medicines as $key => $medicine) {
            if ($medicine != "") {
                $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
                $result = mysqli_query($conn, $query5);
                while ($data = mysqli_fetch_array($result)) {
                    $mstate = $data['state'];
                }

                if ($mstate == 'per piece') {
                    // Update inventory_medicine
                    $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantities[$key]', qty = qty - '$quantities[$key]' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0 LIMIT 1";
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
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Update report_medsupinv
                        $qty = $quantities[$key];
                        $eqty = $row['eqty'] - $qty;
                        $aeqty = $row['iqty'];

                        $query3 = "SELECT * FROM inv_total WHERE stockid = '$medicine' AND type = 'medicine' AND campus = '$campus'";
                        $result = mysqli_query($conn, $query3);
                        while ($data = mysqli_fetch_assoc($result)) {
                            $cost = $data['unit_cost'];
                        }
                        $aeamt = $eqty * $cost;
                        $iamt = ($aeqty + $qty) * $cost;
                        $query4 = "UPDATE report_medsupinv SET iqty = iqty + '$qty', iamt = '$iamt', eqty = eqty - '$qty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                        mysqli_query($conn, $query4);
                    }
                }
            }
        }
    }

    // Update inventory for each supply
    if (!empty($_POST['supply']) && isset($_POST['supply'])) {
        $supplies = $_POST['supply'];
        $quantities_sup = $_POST['quantity_sup'];
        foreach ($supplies as $key => $supply) {
            if ($supply != "") {
                $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
                $result = mysqli_query($conn, $query5);
                while ($data = mysqli_fetch_array($result)) {
                    $sstate = $data['state'];
                }

                if ($sstate == 'per piece') {
                    // Update inventory_supply
                    $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup[$key]', qty = qty - '$quantities_sup[$key]' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0 LIMIT 1";
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
                        $eqty = $row['eqty'] - $qty;
                        $aeqty = $row['iqty'];

                        $query3 = "SELECT * FROM inv_total WHERE stockid = '$supply' AND type = 'supply' AND campus = '$campus'";
                        $result = mysqli_query($conn, $query3);
                        while ($data = mysqli_fetch_assoc($result)) {
                            $cost = $data['unit_cost'];
                        }
                        $aeamt = $eqty * $cost;
                        $iamt = ($aeqty + $qty) * $cost;
                        $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                        mysqli_query($conn, $query4);
                    }
                }
            }
        }
    }

    $sql = "UPDATE appointment SET status='COMPLETED' WHERE id='$id'";
    mysqli_query($conn, $sql);

    // check if may existing na
    $enddate = date("Y-m-t");
    $campus = $_SESSION['campus'];
    //kunin medcase type
    $med_case = $transaction;
    $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_array($result)) {
            if ($data['medcase'] != 'Others:') {
                $medcase =  $data['medcase'];
                $medcase_type = $data['type'];
                $medcase_others = $purpose;
            } else {
                $medcase_type = "others";
                $medcase_others = $transaction;
                $medcase = $purpose;
            }
        }
    } else {
        $medcase_type = "others";
        $medcase_others = $transaction;
        $medcase = $purpose;
    }

    $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate' AND campus='$campus'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // fetch data ng existing entry

        $enddate = date("Y-m-t");
        $campus = $_SESSION['campus'];

        //kunin medcase type
        $med_case = $transaction;
        $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_array($result)) {
                if ($data['medcase'] != 'Others:') {
                    $medcase =  $data['medcase'];
                    $medcase_type = $data['type'];
                    $medcase_others = $purpose;
                } else {
                    $medcase_type = "others";
                    $medcase_others = $transaction;
                    $medcase = $purpose;
                }
            }
        } else {
            $medcase_type = "others";
            $medcase_others = $transaction;
            $medcase = $purpose;
        }


        $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate' AND campus='$campus'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            // check san sya i-add na column sa database
            switch (true) {
                case ($designation == "STUDENT" and $sex == "MALE"): {
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
                    }
                case ($designation == "STUDENT" and $sex == "FEMALE"): {
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
                    }
                case ($designation != "STUDENT" and $sex == "MALE"): {
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
                    }
                case ($designation != "STUDENT" and $sex == "FEMALE"): {
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
                    }
                default: {
                        break;
                    }
            }
        }
        // update if meron
        $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
        $result = mysqli_query($conn, $sql);
    } else {
        // add pag wala

        $campus = $_SESSION['campus'];
        // check san sya i-add na column sa database
        switch (true) {
            case ($designation == "STUDENT" and $sex == "MALE"): {
                    $sm = 1;
                    $sf = 0;
                    $st = 1;
                    $pm = 0;
                    $pf = 0;
                    $pt = 0;
                    $gm = 1;
                    $gf = 0;
                    $gt = 1;
                    break;
                }
            case ($designation == "STUDENT" and $sex == "FEMALE"): {
                    $sm = 0;
                    $sf = 1;
                    $st = 1;
                    $pm = 0;
                    $pf = 0;
                    $pt = 0;
                    $gm = 0;
                    $gf = 1;
                    $gt = 1;
                    break;
                }
            case ($designation != "STUDENT" and $sex == "MALE"): {
                    $sm = 0;
                    $sf = 0;
                    $st = 0;
                    $pm = 1;
                    $pf = 0;
                    $pt = 1;
                    $gm = 1;
                    $gf = 0;
                    $gt = 1;
                    break;
                }
            case ($designation != "STUDENT" and $sex == "FEMALE"): {
                    $sm = 0;
                    $sf = 0;
                    $st = 0;
                    $pm = 0;
                    $pf = 1;
                    $pt = 1;
                    $gm = 0;
                    $gf = 1;
                    $gt = 1;
                    break;
                }
            default: {
                    break;
                }
        }
        $enddate = date("Y-m-t");
        $med_case = $transaction;
        $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            if ($data['medcase'] != 'Others:') {
                $medcase =  $data['medcase'];
                $medcase_type = $data['type'];
                $medcase_others = $purpose;
            } else {
                $medcase_type = "others";
                $medcase_others = $transaction;
                $medcase = $purpose;
            }
        }

        $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$campus', '$medcase_type', '$medcase', '$sm', '$sf', '$st', '$pm', '$pf', '$pt', '$gm', '$gf', '$gt', '$enddate')";
        $result = mysqli_query($conn, $sql);
    }
    $sql = "UPDATE time_pickup SET isSelected = 'No' WHERE time IN ('$time_from', '$time_to')";
    mysqli_query($conn, $sql);
    // Audit trail 
    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = "Appointment has been added."
?>
        <script>
            setTimeout(function() {
                window.location = "../appointment?tab=approved";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Appointment has been added."
    ?>
        <script>
            setTimeout(function() {
                window.location = "../appointment?tab=approved";
            });
        </script>
<?php
    }
}
mysqli_close($conn);
