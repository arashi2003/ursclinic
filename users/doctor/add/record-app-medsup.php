<?php
session_start();
include('../connection.php');

// Patient info
$id = $_POST['id'];
$remarks = $_POST['remarks'];
date_default_timezone_set("Asia/Manila");

$doot = "SELECT * FROM appointment WHERE id='$id'";
$result0 = mysqli_query($conn, $doot);
while ($row = mysqli_fetch_array($result0)) {
    $patientid = $row['patient'];
    $trans = $row['type'];
    $purp = $row['purpose'];
    $chief_complaint = $row['chiefcomplaint'] . " " . $row['others'];
    $med_1 = $row['med_1'];
    $mqty_1 = $row['mqty_1'];
    $med_2 = $row['med_2'];
    $mqty_2 = $row['mqty_2'];
    $med_3 = $row['med_3'];
    $mqty_3 = $row['mqty_3'];
    $med_4 = $row['med_4'];
    $mqty_4 = $row['mqty_4'];
    $med_5 = $row['med_5'];
    $mqty_5 = $row['mqty_5'];
    $sup_1 = $row['sup_1'];
    $sqty_1 = $row['sqty_1'];
    $sup_2 = $row['sup_2'];
    $sqty_2 = $row['sqty_2'];
    $sup_3 = $row['sup_3'];
    $sqty_3 = $row['sqty_3'];
    $sup_4 = $row['sup_4'];
    $sqty_4 = $row['sqty_4'];
    $sup_5 = $row['sup_5'];
    $sqty_5 = $row['sqty_5'];

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
        $campus = $data['campus'];
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
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = 'added a medical record for  of ' . $patientid;
    $pod_nod = $fullname;

    // Logbook info
    $type = "Appointment";
    $datenow = date("Y-m-d");
    $enddate = date("Y-m-t");
    $medsup0 = "";

    if (!empty($med_1)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$med_1' AND type = 'medicine'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $medicine = $data['stock_name'];
            $medsup0 .= "$mqty_1 $medicine,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($med_2)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$med_2' AND type = 'medicine'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $medicine = $data['stock_name'];
            $medsup0 .= "$mqty_2 $medicine,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($med_3)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$med_3' AND type = 'medicine'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $medicine = $data['stock_name'];
            $medsup0 .= "$mqty_3 $medicine,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($med_4)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$med_4' AND type = 'medicine'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $medicine = $data['stock_name'];
            $medsup0 .= "$mqty_4 $medicine,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($med_5)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$med_5' AND type = 'medicine'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $medicine = $data['stock_name'];
            $medsup0 .= "$mqty_5 $medicine,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($sup_1)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_1' AND type = 'supply'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $supply = $data['stock_name'];
            $medsup0 .= "$sqty_1 $supply,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($sup_2)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_2' AND type = 'supply'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $supply = $data['stock_name'];
            $medsup0 .= "$sqty_2 $supply,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($sup_3)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_3' AND type = 'supply'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $supply = $data['stock_name'];
            $medsup0 .= "$sqty_3 $supply,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($sup_4)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_4' AND type = 'supply'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $supply = $data['stock_name'];
            $medsup0 .= "$sqty_4 $supply,";
        }
    } else {
        $medsup0 .= "";
    }
    if (!empty($sup_5)) {
        $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_5' AND type = 'supply'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            $supply = $data['stock_name'];
            $medsup0 .= "$sqty_5 $supply,";
        }
    } else {
        $medsup0 .= "";
    }

    //$medsup1 = implode(", ", $medsup0);
    $medsup = rtrim($medsup0, " , ");


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
    $query = "INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction, purpose, chief_complaint, remarks, medsup, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$chief_complaint', '$remarks', '$medsup', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
    $result = mysqli_query($conn, $query);

    $sql = "UPDATE appointment SET status='COMPLETED' WHERE id='$id'";
    mysqli_query($conn, $sql);

    // check if may existing na
    $enddate = date("Y-m-t");
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

    // Audit trail 
    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = "Appointment has been recorded."
?>
        <script>
            setTimeout(function() {
                window.location = "../appointment?tab=approved";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Appointment has been recorded."
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
