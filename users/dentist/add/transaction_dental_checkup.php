<?php
session_start();
include('../connection.php');
$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added a dental health record for " . $_POST['patientid'];
$au_status = "unread";

//patient info
$patientid = $_POST['patientid'];
$civil_status = $_POST['civil_status'];

//logbook info
$type = "Walk-In";
$transaction = "Medical History";
$purpose = "Dental Checkup";
$med_case = "Others:";
$medcase_others = "";
$pod_nod = $fullname;
$dentist = $fullname;
$enddate = date("Y-m-t");

// get patient info
$sql = "SELECT * FROM patient_info p INNER JOIN account a on a.accountid=p.patientid WHERE patientid='$patientid'";
$result = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($result)) {
    //kukunin sa db
    $firstname = strtoupper($data['firstname']);
    $middlename = strtoupper($data['middlename']);
    $lastname = strtoupper($data['lastname']);
    $designation = strtoupper($data['designation']);
    $sex = strtoupper($data['sex']);
    $department = $data['department'];
    $college = $data['college'];
    $campus = $data['campus'];
    $age = floor((time() - strtotime($data['birthday'])) / 31556926);
    $program = $data['program'];
    $yearlevel = $data['yearlevel'];
    $section = $data['section'];
    $block = $data['block'];
    $address = $data['address'];
    $birthday = $data['birthday'];
}

$sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
$result = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($result)) {
    $birthday = $data['birthday'];
}

//kunin medcase as text
$sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_array($result)) {
        if ($data['medcase'] != 'Others:') {
            $medcase =  "Dental Checkup";
            $medcase_type = $data['type'];
            $medcase_others = $purpose;
        } else {
            $medcase_type = "others";
            $medcase_others = "";
            $medcase = $purpose;
        }
    }
} else {
    $medcase_type = "others";
    $medcase_others = "";
    $medcase = $purpose;
}

//date related info
$year = date("Y-m-d");
$doe = date("Y-m-d");
$alb = floor((time() - strtotime($birthday)) / 31556926); // ung number is total seconds in a year

// add record to transaction_history
$sql = "INSERT transaction_history (patient, firstname, middlename, lastname, designation, age, sex, birthday, department, college, program, yearlevel, section, block, type, transaction, purpose, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname',' $designation', '$age', '$sex', '$birthday', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
if ($result = mysqli_query($conn, $sql)) {
    // check if may existing record na sa dental record
    $sql = "SELECT patientid FROM dental_record_2 WHERE patientid='$patientid' AND ((year_1 = '' OR year_1 IS NULL) OR (year_2 = '' OR year_2 IS NULL) OR (year_3 = '' OR year_3 IS NULL) OR (year_4 = '' OR year_4 IS NULL) OR (year_5 = '' OR year_5 IS NULL))";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // if meron check if may entry na sa year 1 (swtich case na for number)
        // then update

        //patient info
        $patientid = $_POST['patientid'];
        $civil_status = $_POST['civil_status'];

        //logbook info
        $type = "Walk-In";
        $transaction = "Medical History";
        $purpose = "Dental Checkup";
        $med_case = "Others:";
        $medcase_others = "";
        $pod_nod = $fullname;
        $dentist = $fullname;
        $enddate = date("Y-m-t");

        // get patient info
        $sql = "SELECT * FROM patient_info p INNER JOIN account a on a.accountid=p.patientid WHERE patientid='$patientid'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            //kukunin sa db
            $firstname = strtoupper($data['firstname']);
            $middlename = strtoupper($data['middlename']);
            $lastname = strtoupper($data['lastname']);
            $designation = strtoupper($data['designation']);
            $sex = strtoupper($data['sex']);
            $department = $data['department'];
            $college = $data['college'];
            $campus = $data['campus'];
            $program = $data['program'];
            $yearlevel = $data['yearlevel'];
            $section = $data['section'];
            $block = $data['block'];
            $address = $data['address'];
            $birthday = $data['birthday'];
        }

        // dental info
        $t_55 = $_POST['t_55'];
        $t_54 = $_POST['t_54'];
        $t_53 = $_POST['t_53'];
        $t_52 = $_POST['t_52'];
        $t_51 = $_POST['t_51'];
        $t_61 = $_POST['t_61'];
        $t_62 = $_POST['t_62'];
        $t_63 = $_POST['t_63'];
        $t_64 = $_POST['t_64'];
        $t_65 = $_POST['t_65'];
        $t_18 = $_POST['t_18'];
        $t_17 = $_POST['t_17'];
        $t_16 = $_POST['t_16'];
        $t_15 = $_POST['t_15'];
        $t_14 = $_POST['t_14'];
        $t_13 = $_POST['t_13'];
        $t_12 = $_POST['t_12'];
        $t_11 = $_POST['t_11'];
        $t_21 = $_POST['t_21'];
        $t_22 = $_POST['t_22'];
        $t_23 = $_POST['t_23'];
        $t_24 = $_POST['t_24'];
        $t_25 = $_POST['t_25'];
        $t_26 = $_POST['t_26'];
        $t_27 = $_POST['t_27'];
        $t_28 = $_POST['t_28'];
        $t_48 = $_POST['t_48'];
        $t_47 = $_POST['t_47'];
        $t_46 = $_POST['t_46'];
        $t_45 = $_POST['t_45'];
        $t_44 = $_POST['t_44'];
        $t_43 = $_POST['t_43'];
        $t_42 = $_POST['t_42'];
        $t_41 = $_POST['t_41'];
        $t_31 = $_POST['t_31'];
        $t_32 = $_POST['t_32'];
        $t_33 = $_POST['t_33'];
        $t_34 = $_POST['t_34'];
        $t_35 = $_POST['t_35'];
        $t_36 = $_POST['t_36'];
        $t_37 = $_POST['t_37'];
        $t_38 = $_POST['t_38'];
        $t_85 = $_POST['t_85'];
        $t_84 = $_POST['t_84'];
        $t_83 = $_POST['t_83'];
        $t_82 = $_POST['t_82'];
        $t_81 = $_POST['t_81'];
        $t_71 = $_POST['t_71'];
        $t_72 = $_POST['t_72'];
        $t_73 = $_POST['t_73'];
        $t_74 = $_POST['t_74'];
        $t_75 = $_POST['t_75'];
        $b_55 = $_POST['b_55'];
        $b_54 = $_POST['b_54'];
        $b_53 = $_POST['b_53'];
        $b_52 = $_POST['b_52'];
        $b_51 = $_POST['b_51'];
        $b_61 = $_POST['b_61'];
        $b_62 = $_POST['b_62'];
        $b_63 = $_POST['b_63'];
        $b_64 = $_POST['b_64'];
        $b_65 = $_POST['b_65'];
        $b_18 = $_POST['b_18'];
        $b_17 = $_POST['b_17'];
        $b_16 = $_POST['b_16'];
        $b_15 = $_POST['b_15'];
        $b_14 = $_POST['b_14'];
        $b_13 = $_POST['b_13'];
        $b_12 = $_POST['b_12'];
        $b_11 = $_POST['b_11'];
        $b_21 = $_POST['b_21'];
        $b_22 = $_POST['b_22'];
        $b_23 = $_POST['b_23'];
        $b_24 = $_POST['b_24'];
        $b_25 = $_POST['b_25'];
        $b_26 = $_POST['b_26'];
        $b_27 = $_POST['b_27'];
        $b_28 = $_POST['b_28'];
        $b_48 = $_POST['b_48'];
        $b_47 = $_POST['b_47'];
        $b_46 = $_POST['b_46'];
        $b_45 = $_POST['b_45'];
        $b_44 = $_POST['b_44'];
        $b_43 = $_POST['b_43'];
        $b_42 = $_POST['b_42'];
        $b_41 = $_POST['b_41'];
        $b_31 = $_POST['b_31'];
        $b_32 = $_POST['b_32'];
        $b_33 = $_POST['b_33'];
        $b_34 = $_POST['b_34'];
        $b_35 = $_POST['b_35'];
        $b_36 = $_POST['b_36'];
        $b_37 = $_POST['b_37'];
        $b_38 = $_POST['b_38'];
        $b_85 = $_POST['b_85'];
        $b_84 = $_POST['b_84'];
        $b_83 = $_POST['b_83'];
        $b_82 = $_POST['b_82'];
        $b_81 = $_POST['b_81'];
        $b_71 = $_POST['b_71'];
        $b_72 = $_POST['b_72'];
        $b_73 = $_POST['b_73'];
        $b_74 = $_POST['b_74'];
        $b_75 = $_POST['b_75'];

        $sql = "UPDATE dental_record_1 SET firstname= '$firstname', middlename= '$middlename', lastname= '$lastname', designation= '$designation', sex= '$sex', birthday= '$birthday', department= '$department', college= '$college', program= '$program', yearlevel= '$yearlevel', section= '$section', block= '$block', address= '$address', civil_status= '$civil_status', t_55 = '$t_55', t_54 = '$t_54', t_53 = '$t_53', t_52 = '$t_52', t_51 = '$t_51', t_61 = '$t_61', t_62 = '$t_62', t_63 = '$t_63', t_64 = '$t_64', t_65 = '$t_65', t_18 = '$t_18', t_17 = '$t_17', t_16 = '$t_16', t_15 = '$t_15', t_14 = '$t_14', t_13 = '$t_13', t_12 = '$t_12', t_11 = '$t_11', t_21 = '$t_21', t_22 = '$t_22', t_23 = '$t_23', t_24 = '$t_24', t_25 = '$t_25', t_26 = '$t_26', t_27 = '$t_27', t_28 = '$t_28', t_48 = '$t_48', t_47 = '$t_47', t_46 = '$t_46', t_45 = '$t_45', t_44 = '$t_44', t_43 = '$t_43', t_42 = '$t_42', t_41 = '$t_41', t_31 = '$t_31', t_32 = '$t_32', t_33 = '$t_33', t_34 = '$t_34', t_35 = '$t_35', t_36 = '$t_36', t_37 = '$t_37', t_38 = '$t_38', t_85 = '$t_85', t_84 = '$t_84', t_83 = '$t_83', t_82 = '$t_82', t_81 = '$t_81', t_71 = '$t_71', t_72 = '$t_72', t_73 = '$t_73', t_74 = '$t_74', t_75 = '$t_75', b_55 = '$b_55', b_54 = '$b_54', b_53 = '$b_53', b_52 = '$b_52', b_51 = '$b_51', b_61 = '$b_61', b_62 = '$b_62', b_63 = '$b_63', b_64 = '$b_64', b_65 = '$b_65', b_18 = '$b_18', b_17 = '$b_17', b_16 = '$b_16', b_15 = '$b_15', b_14 = '$b_14', b_13 = '$b_13', b_12 = '$b_12', b_11 = '$b_11', b_21 = '$b_21', b_22 = '$b_22', b_23 = '$b_23', b_24 = '$b_24', b_25 = '$b_25', b_26 = '$b_26', b_27 = '$b_27', b_28 = '$b_28', b_48 = '$b_48', b_47 = '$b_47', b_46 = '$b_46', b_45 = '$b_45', b_44 = '$b_44', b_43 = '$b_43', b_42 = '$b_42', b_41 = '$b_41', b_31 = '$b_31', b_32 = '$b_32', b_33 = '$b_33', b_34 = '$b_34', b_35 = '$b_35', b_36 = '$b_36', b_37 = '$b_37', b_38 = '$b_38', b_85 = '$b_85', b_84 = '$b_84', b_83 = '$b_83', b_82 = '$b_82', b_81 = '$b_81', b_71 = '$b_71', b_72 = '$b_72', b_73 = '$b_73', b_74 = '$b_74', b_75 = '$b_75' WHERE patientid = '$patientid'";
        if ($result = mysqli_query($conn, $sql)) {
            $sql = "SELECT * FROM dental_record_2 WHERE patientid = '$patientid'";
            $result = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($result)) {
                // $no
                switch (true) {
                    case ($data['year_1'] != "" or $data['year_1'] != NULL): {
                            $no = 2;
                            break;
                        }
                    case ($data['year_2'] != "" or $data['year_2'] != NULL): {
                            $no = 2;
                            break;
                        }
                    case ($data['year_3'] != "" or $data['year_3'] != NULL): {
                            $no = 3;
                            break;
                        }
                    case ($data['year_4'] != "" or $data['year_4'] != NULL): {
                            $no = 4;
                            break;
                        }
                    case ($data['year_5'] != "" or $data['year_5'] != NULL): {
                            $no = 1;
                            break;
                        }
                    default: {
                            break;
                        }
                }
            }

            $posc = $_POST['posc'];
            $pgp = $_POST['pgp'];
            $ppp = $_POST['ppp'];
            $pdfa = $_POST['pdfa'];
            $toothbrush = $_POST['toothbrush'];
            $ciff_t = $_POST['ciff_t'];
            $ciff_p = $_POST['ciff_p'];
            $cife_t = $_POST['cife_t'];
            $cife_p = $_POST['cife_p'];
            $rf_t = $_POST['rf_t'];
            $rf_p = $_POST['rf_p'];
            $mdtc_p = $_POST['mdtc_p'];
            $for_t = $_POST['for_t'];
            $for_p = $_POST['for_p'];
            $tdmfdf_t = $_POST['tdmfdf_t'];
            $tdmfdf_p = $_POST['tdmfdf_p'];
            $fa = $_POST['fa'];

            $dentist = $_SESSION['name'];

            // get bday
            $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
            $result = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($result)) {
                $birthday = $data['birthday'];
            }

            //date related info
            $year = date("Y-m-d");
            $doe = date("Y-m-d");
            $alb = floor((time() - strtotime($birthday)) / 31556926); // ung number is total seconds in a year

            $sql = "UPDATE dental_record_2 SET year_$no = '$year', doe_$no = '$doe', alb_$no = '$alb', posc_$no = '$posc', pgp_$no = '$pgp', ppp_$no = '$ppp', pdfa_$no = '$pdfa', toothbrush_$no = '$toothbrush', ciff_t_$no = '$ciff_t', ciff_p_$no = '$ciff_p', cife_t_$no = '$cife_t', cife_p_$no = '$cife_p', rf_t_$no = '$rf_t', rf_p_$no = '$rf_p', mdtc_p_$no = '$mdtc_p', for_t_$no = '$for_t', for_p_$no = '$for_p', tdmfdf_t_$no = '$tdmfdf_t', tdmfdf_p_$no = '$tdmfdf_p', fa_$no = '$fa', dentist='$fullname', datetime_updated=now() WHERE patientid='$patientid'";
            if ($result = mysqli_query($conn, $sql)) {
                // check if may existing na sa medcase report
                $enddate = date("Y-m-t");
                $med_case = "Others:";
                $medcase_others = "";

                //kunin medcase as text
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
                            $medcase_others = "";
                            $medcase = $purpose;
                        }
                    }
                } else {
                    $medcase_type = "others";
                    $medcase_others = "";
                    $medcase = $purpose;
                }
                $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // fetch data ng existing entry

                    $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
                    $result = mysqli_query($conn, $sql);
                    while ($data = mysqli_fetch_array($result)) {
                        $designation = $data['designation'];
                        $sex = $data['sex'];
                    }
                    $enddate = date("Y-m-t");
                    $med_case = "Others:";
                    $medcase_others = "";

                    //kunin medcase as text
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
                                $medcase_others = "";
                                $medcase = $purpose;
                            }
                        }
                    } else {
                        $medcase_type = "others";
                        $medcase_others = "";
                        $medcase = $purpose;
                    }

                    $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
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
                    $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND campus='$campus' AND date='$enddate'";
                    if ($result = mysqli_query($conn, $sql)) {
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                        if ($result = mysqli_query($conn, $sql)) {
                            $_SESSION['alert'] = "Checkup has been recorded.";
?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        } else {
                            $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        }
                    } else {
                        $_SESSION['alert'] = "Checkup was not recorded.";
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_checkup";
                            });
                        </script>
                        <?php
                    }
                } else {
                    // add pag wala

                    $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
                    $result = mysqli_query($conn, $sql);
                    while ($data = mysqli_fetch_array($result)) {
                        $designation = $data['designation'];
                        $sex = $data['sex'];
                    }
                    $enddate = date("Y-m-t");
                    $med_case = "Others:";
                    $medcase_others = "";
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
                    //kunin medcase as text
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
                                $medcase_others = "";
                                $medcase = $purpose;
                            }
                        }
                    } else {
                        $medcase_type = "others";
                        $medcase_others = "";
                        $medcase = $purpose;
                    }

                    $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$campus', '$medcase_type', '$medcase', '$sm', '$sf', '$st', '$pm', '$pf', '$pt', '$gm', '$gf', '$gt', '$enddate')";
                    if ($result = mysqli_query($conn, $sql)) {
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                        if ($result = mysqli_query($conn, $sql)) {
                            $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        } else {
                            $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        }
                    } else {
                        $_SESSION['alert'] = "Checkup was not recorded.";
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_checkup";
                            });
                        </script>
                <?php
                    }
                }
            } else {
                $_SESSION['alert'] = "Checkup has been recorded, but some of the data were not saved.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../transaction_dental_checkup";
                    });
                </script>
            <?php
            }
        } else {
            $_SESSION['alert'] = "Checkup was not recorded.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../transaction_dental_checkup";
                });
            </script>
            <?php
        }
    } else {
        // if wala insert record
        //patient info
        $patientid = $_POST['patientid'];
        $civil_status = $_POST['civil_status'];

        //logbook info
        $type = "Walk-In";
        $transaction = "Medical History";
        $purpose = "Dental Checkup";
        $med_case = "Others:";
        $medcase_others = "";
        $pod_nod = $fullname;
        $dentist = $fullname;
        $enddate = date("Y-m-t");

        // get patient info
        $sql = "SELECT * FROM patient_info p INNER JOIN account a on a.accountid=p.patientid WHERE patientid='$patientid'";
        $result = mysqli_query($conn, $sql);
        while ($data = mysqli_fetch_array($result)) {
            //kukunin sa db
            $firstname = strtoupper($data['firstname']);
            $middlename = strtoupper($data['middlename']);
            $lastname = strtoupper($data['lastname']);
            $designation = strtoupper($data['designation']);
            $sex = strtoupper($data['sex']);
            $department = $data['department'];
            $college = $data['college'];
            $campus = $data['campus'];
            $program = $data['program'];
            $yearlevel = $data['yearlevel'];
            $section = $data['section'];
            $block = $data['block'];
            $address = $data['address'];
            $birthday = $data['birthday'];
        }

        // dental info
        $t_55 = $_POST['t_55'];
        $t_54 = $_POST['t_54'];
        $t_53 = $_POST['t_53'];
        $t_52 = $_POST['t_52'];
        $t_51 = $_POST['t_51'];
        $t_61 = $_POST['t_61'];
        $t_62 = $_POST['t_62'];
        $t_63 = $_POST['t_63'];
        $t_64 = $_POST['t_64'];
        $t_65 = $_POST['t_65'];
        $t_18 = $_POST['t_18'];
        $t_17 = $_POST['t_17'];
        $t_16 = $_POST['t_16'];
        $t_15 = $_POST['t_15'];
        $t_14 = $_POST['t_14'];
        $t_13 = $_POST['t_13'];
        $t_12 = $_POST['t_12'];
        $t_11 = $_POST['t_11'];
        $t_21 = $_POST['t_21'];
        $t_22 = $_POST['t_22'];
        $t_23 = $_POST['t_23'];
        $t_24 = $_POST['t_24'];
        $t_25 = $_POST['t_25'];
        $t_26 = $_POST['t_26'];
        $t_27 = $_POST['t_27'];
        $t_28 = $_POST['t_28'];
        $t_48 = $_POST['t_48'];
        $t_47 = $_POST['t_47'];
        $t_46 = $_POST['t_46'];
        $t_45 = $_POST['t_45'];
        $t_44 = $_POST['t_44'];
        $t_43 = $_POST['t_43'];
        $t_42 = $_POST['t_42'];
        $t_41 = $_POST['t_41'];
        $t_31 = $_POST['t_31'];
        $t_32 = $_POST['t_32'];
        $t_33 = $_POST['t_33'];
        $t_34 = $_POST['t_34'];
        $t_35 = $_POST['t_35'];
        $t_36 = $_POST['t_36'];
        $t_37 = $_POST['t_37'];
        $t_38 = $_POST['t_38'];
        $t_85 = $_POST['t_85'];
        $t_84 = $_POST['t_84'];
        $t_83 = $_POST['t_83'];
        $t_82 = $_POST['t_82'];
        $t_81 = $_POST['t_81'];
        $t_71 = $_POST['t_71'];
        $t_72 = $_POST['t_72'];
        $t_73 = $_POST['t_73'];
        $t_74 = $_POST['t_74'];
        $t_75 = $_POST['t_75'];
        $b_55 = $_POST['b_55'];
        $b_54 = $_POST['b_54'];
        $b_53 = $_POST['b_53'];
        $b_52 = $_POST['b_52'];
        $b_51 = $_POST['b_51'];
        $b_61 = $_POST['b_61'];
        $b_62 = $_POST['b_62'];
        $b_63 = $_POST['b_63'];
        $b_64 = $_POST['b_64'];
        $b_65 = $_POST['b_65'];
        $b_18 = $_POST['b_18'];
        $b_17 = $_POST['b_17'];
        $b_16 = $_POST['b_16'];
        $b_15 = $_POST['b_15'];
        $b_14 = $_POST['b_14'];
        $b_13 = $_POST['b_13'];
        $b_12 = $_POST['b_12'];
        $b_11 = $_POST['b_11'];
        $b_21 = $_POST['b_21'];
        $b_22 = $_POST['b_22'];
        $b_23 = $_POST['b_23'];
        $b_24 = $_POST['b_24'];
        $b_25 = $_POST['b_25'];
        $b_26 = $_POST['b_26'];
        $b_27 = $_POST['b_27'];
        $b_28 = $_POST['b_28'];
        $b_48 = $_POST['b_48'];
        $b_47 = $_POST['b_47'];
        $b_46 = $_POST['b_46'];
        $b_45 = $_POST['b_45'];
        $b_44 = $_POST['b_44'];
        $b_43 = $_POST['b_43'];
        $b_42 = $_POST['b_42'];
        $b_41 = $_POST['b_41'];
        $b_31 = $_POST['b_31'];
        $b_32 = $_POST['b_32'];
        $b_33 = $_POST['b_33'];
        $b_34 = $_POST['b_34'];
        $b_35 = $_POST['b_35'];
        $b_36 = $_POST['b_36'];
        $b_37 = $_POST['b_37'];
        $b_38 = $_POST['b_38'];
        $b_85 = $_POST['b_85'];
        $b_84 = $_POST['b_84'];
        $b_83 = $_POST['b_83'];
        $b_82 = $_POST['b_82'];
        $b_81 = $_POST['b_81'];
        $b_71 = $_POST['b_71'];
        $b_72 = $_POST['b_72'];
        $b_73 = $_POST['b_73'];
        $b_74 = $_POST['b_74'];
        $b_75 = $_POST['b_75'];

        $sql = "INSERT INTO dental_record_1 SET patientid='$patientid', firstname= '$firstname', middlename= '$middlename', lastname= '$lastname', designation= '$designation', sex= '$sex', birthday= '$birthday', department= '$department', college= '$college', program= '$program', yearlevel= '$yearlevel', section= '$section', block= '$block', address= '$address', civil_status= '$civil_status', t_55 = '$t_55', t_54 = '$t_54', t_53 = '$t_53', t_52 = '$t_52', t_51 = '$t_51', t_61 = '$t_61', t_62 = '$t_62', t_63 = '$t_63', t_64 = '$t_64', t_65 = '$t_65', t_18 = '$t_18', t_17 = '$t_17', t_16 = '$t_16', t_15 = '$t_15', t_14 = '$t_14', t_13 = '$t_13', t_12 = '$t_12', t_11 = '$t_11', t_21 = '$t_21', t_22 = '$t_22', t_23 = '$t_23', t_24 = '$t_24', t_25 = '$t_25', t_26 = '$t_26', t_27 = '$t_27', t_28 = '$t_28', t_48 = '$t_48', t_47 = '$t_47', t_46 = '$t_46', t_45 = '$t_45', t_44 = '$t_44', t_43 = '$t_43', t_42 = '$t_42', t_41 = '$t_41', t_31 = '$t_31', t_32 = '$t_32', t_33 = '$t_33', t_34 = '$t_34', t_35 = '$t_35', t_36 = '$t_36', t_37 = '$t_37', t_38 = '$t_38', t_85 = '$t_85', t_84 = '$t_84', t_83 = '$t_83', t_82 = '$t_82', t_81 = '$t_81', t_71 = '$t_71', t_72 = '$t_72', t_73 = '$t_73', t_74 = '$t_74', t_75 = '$t_75', b_55 = '$b_55', b_54 = '$b_54', b_53 = '$b_53', b_52 = '$b_52', b_51 = '$b_51', b_61 = '$b_61', b_62 = '$b_62', b_63 = '$b_63', b_64 = '$b_64', b_65 = '$b_65', b_18 = '$b_18', b_17 = '$b_17', b_16 = '$b_16', b_15 = '$b_15', b_14 = '$b_14', b_13 = '$b_13', b_12 = '$b_12', b_11 = '$b_11', b_21 = '$b_21', b_22 = '$b_22', b_23 = '$b_23', b_24 = '$b_24', b_25 = '$b_25', b_26 = '$b_26', b_27 = '$b_27', b_28 = '$b_28', b_48 = '$b_48', b_47 = '$b_47', b_46 = '$b_46', b_45 = '$b_45', b_44 = '$b_44', b_43 = '$b_43', b_42 = '$b_42', b_41 = '$b_41', b_31 = '$b_31', b_32 = '$b_32', b_33 = '$b_33', b_34 = '$b_34', b_35 = '$b_35', b_36 = '$b_36', b_37 = '$b_37', b_38 = '$b_38', b_85 = '$b_85', b_84 = '$b_84', b_83 = '$b_83', b_82 = '$b_82', b_81 = '$b_81', b_71 = '$b_71', b_72 = '$b_72', b_73 = '$b_73', b_74 = '$b_74', b_75 = '$b_75'";
        if ($result = mysqli_query($conn, $sql)) {
            $posc = $_POST['posc'];
            $pgp = $_POST['pgp'];
            $ppp = $_POST['ppp'];
            $pdfa = $_POST['pdfa'];
            $toothbrush = $_POST['toothbrush'];
            $ciff_t = $_POST['ciff_t'];
            $ciff_p = $_POST['ciff_p'];
            $cife_t = $_POST['cife_t'];
            $cife_p = $_POST['cife_p'];
            $rf_t = $_POST['rf_t'];
            $rf_p = $_POST['rf_p'];
            $mdtc_p = $_POST['mdtc_p'];
            $for_t = $_POST['for_t'];
            $for_p = $_POST['for_p'];
            $tdmfdf_t = $_POST['tdmfdf_t'];
            $tdmfdf_p = $_POST['tdmfdf_p'];
            $fa = $_POST['fa'];

            $dentist = $_SESSION['name'];

            // get bday
            $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
            $result = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($result)) {
                $birthday = $data['birthday'];
            }

            //date related info
            $year = date("Y-m-d");
            $doe = date("Y-m-d");
            $alb = floor((time() - strtotime($birthday)) / 31556926); // ung number is total seconds in a year

            $sql = "INSERT INTO dental_record_2 SET patientid='$patientid', year_1 = '$year', doe_1 = '$doe', alb_1 = '$alb', posc_1 = '$posc', pgp_1 = '$pgp', ppp_1 = '$ppp', pdfa_1 = '$pdfa', toothbrush_1 = '$toothbrush', ciff_t_1 = '$ciff_t', ciff_p_1 = '$ciff_p', cife_t_1 = '$cife_t', cife_p_1 = '$cife_p', rf_t_1 = '$rf_t', rf_p_1 = '$rf_p', mdtc_p_1 = '$mdtc_p', for_t_1 = '$for_t', for_p_1 = '$for_p', tdmfdf_t_1 = '$tdmfdf_t', tdmfdf_p_1 = '$tdmfdf_p', fa_1 = '$fa', dentist = '$dentist', datetime_created=now(), datetime_updated=now()";
            if ($result = mysqli_query($conn, $sql)) {
                // check if may existing na sa medcase report
                $enddate = date("Y-m-t");
                $med_case = "Others:";
                $medcase_others = "";

                //kunin medcase as text
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
                            $medcase_others = "";
                            $medcase = $purpose;
                        }
                    }
                } else {
                    $medcase_type = "others";
                    $medcase_others = "";
                    $medcase = $purpose;
                }

                $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate' AND campus='$campus'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    // fetch data ng existing entry


                    $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
                    $result = mysqli_query($conn, $sql);
                    while ($data = mysqli_fetch_array($result)) {
                        $designation = $data['designation'];
                        $sex = $data['sex'];
                    }
                    $enddate = date("Y-m-t");
                    $med_case = "Others:";
                    $medcase_others = "";

                    //kunin medcase as text
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
                                $medcase_others = "";
                                $medcase = $purpose;
                            }
                        }
                    } else {
                        $medcase_type = "others";
                        $medcase_others = "";
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
                    $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND campus ='$campus' AND date='$enddate'";
                    if ($result = mysqli_query($conn, $sql)) {
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                        if ($result = mysqli_query($conn, $sql)) {
                            $_SESSION['alert'] = "Checkup has been recorded.";
            ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        } else {
                            $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        }
                    } else {
                        $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_checkup";
                            });
                        </script>
                        <?php
                    }
                } else {
                    // add pag wala

                    $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
                    $result = mysqli_query($conn, $sql);
                    while ($data = mysqli_fetch_array($result)) {
                        $designation = $data['designation'];
                        $sex = $data['sex'];
                    }
                    $enddate = date("Y-m-t");
                    $med_case = "Others:";
                    $medcase_others = "";

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
                    //kunin medcase as text
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
                                $medcase_others = "";
                                $medcase = $purpose;
                            }
                        }
                    } else {
                        $medcase_type = "others";
                        $medcase_others = "";
                        $medcase = $purpose;
                    }

                    $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$campus', '$medcase_type', '$medcase', '$sm', '$sf', '$st', '$pm', '$pf', '$pt', '$gm', '$gf', '$gt', '$enddate')";
                    if ($result = mysqli_query($conn, $sql)) {
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                        if ($result = mysqli_query($conn, $sql)) {
                            
                            $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        } else {
                            $_SESSION['alert'] = "Checkup has been recorded.";
                        ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../transaction_dental_checkup";
                                });
                            </script>
                        <?php
                        }
                    } else {
                        $_SESSION['alert'] = "Checkup was not recorded.";
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_checkup";
                            });
                        </script>
                <?php
                    }
                }
            } else {
                $_SESSION['alert'] = "Checkup has been recorded but some of the data were not saved.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../transaction_dental_checkup";
                    });
                </script>
            <?php
            }
        } else {
            $_SESSION['alert'] = "Checkup was not recorded.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../transaction_dental_checkup";
                });
            </script>
    <?php
        }
    }
} else {
    $_SESSION['alert'] = "Checkup was not recorded.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../transaction_dental_checkup";
        });
    </script>
<?php
}
mysqli_close($conn);
