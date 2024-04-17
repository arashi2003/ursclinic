<?php
session_start();
include('../connection.php');
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
$medsup = $_POST['medicine'];

$doot = "SELECT * FROM appointment WHERE id='$id'";
$result0 = mysqli_query($conn, $doot);
while ($row = mysqli_fetch_array($result0)) {
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
        $campus = $data['campus'];
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
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = 'added a medical record for  of ' . $patientid;
    $pod_nod = $fullname;

    // Logbook info
    $type = "Appointment";
    $datenow = date("Y-m-d");
    $enddate = date("Y-m-t");
    $medsup0 = "";

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
