<?php
    session_start();
    include('../../../connection.php');
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a Treatment Record for " . $_POST['patientid'];
    $au_status = "unread";

    //patient info
    $patientid = $_POST['patientid'];
    $civil_status = $_POST['civil_status'];

    //logbook info
    $type = "Walk-In";
    $transaction = "Checkup";
    $purpose = "Dental Consultation";
    $medcaseid = $_POST['medcase'];
    $medcase_others = $_POST['medcase_others'];
    $pod_nod = $fullname;
    $dentist = $fullname;
    $enddate = date("Y-m-t");

    // get patient info
    if($patientid != "")
    {
        $sql = "SELECT * FROM patient_info p INNER JOIN account a on a.accountid=p.patientid WHERE patientid='$patientid'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            //kukunin sa db
            $firstname = strtoupper($data['firstname']);
            $middlename = strtoupper($data['middlename']);
            $lastname = strtoupper($data['lastname']);
            $designation = strtoupper($data['designation']);
            $sex = strtoupper($data['sex']);
            $department = $data['department'];
            $college = $data['college'];
            $campus = $data['campus'];
            $age = $data['age'];
            $program = $data['program'];
            $yearlevel = $data['yearlevel'];
            $section = $data['section'];
            $block = $data['block'];
            $address = $data['address'];
            $birthday = $data['birthday']; 
        }
    }
    else
    {
        $firstname = strtoupper($_POST['firstname']);
        $middlename = strtoupper($_POST['middlename']);
        $lastname = strtoupper($_POST['lastname']);
        $designation = strtoupper($_POST['designation']);
        $sex = strtoupper($_POST['sex']);
        $department = $_POST['department'];
        $college = $_POST['college'];
        $campus = $_POST['campus'];
        $age = $_POST['age'];
        $program = $_POST['program'];
        $yearlevel = $_POST['yearlevel'];
        $section = $_POST['section'];
        $block = $_POST['block'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday']; 
    }

    $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
    $result = mysqli_query($conn, $sql);
    while($data=mysqli_fetch_array($result))
    {
        $birthday = $data['birthday']; 
    }

    //kunin medcase as text
    $sql = "SELECT * FROM med_case WHERE id='$medcaseid'";
    $result = mysqli_query($conn, $sql);
    while($data=mysqli_fetch_array($result))
    {
        if($data['medcase'] != 'Others:')
        {
            $medcase_type = $data['type'];
            $medcase = $data['medcase'];
        }
        else
        {
            $medcase_type = "others";
            $medcase = $medcase_others;
        }
    }

    //date related info
    $year = date("Y-m-d");
    $doe= date("Y-m-d");
    $alb = floor((time() - strtotime($birthday)) / 31556926); // ung number is total seconds in a year

    // treatment record info
    $date_1 =  date("Y-m-d");
    $diagnosis_1 =  $_POST['diagnosis_1'];
    $toothno_1 =  $_POST['toothno_1'];
    $treatment_1 =  $_POST['treatment_1'];
    $dentist_1 =  $fullname;
    $date_2 =  date("Y-m-d");
    $diagnosis_2 =  $_POST['diagnosis_2'];
    $toothno_2 =  $_POST['toothno_2'];
    $treatment_2 =  $_POST['treatment_2'];
    $dentist_2 =  $fullname;
    $date_3 =  date("Y-m-d");
    $diagnosis_3 =  $_POST['diagnosis_3'];
    $toothno_3 =  $_POST['toothno_3'];
    $treatment_3 =  $_POST['treatment_3'];
    $dentist_3 =  $fullname;
    $date_4 =  date("Y-m-d");
    $diagnosis_4 =  $_POST['diagnosis_4'];
    $toothno_4 =  $_POST['toothno_4'];
    $treatment_4 =  $_POST['treatment_4'];
    $dentist_4 =  $fullname;
    $date_5 =  date("Y-m-d");
    $diagnosis_5 =  $_POST['diagnosis_5'];
    $toothno_5 =  $_POST['toothno_5'];
    $treatment_5 =  $_POST['treatment_5'];
    $dentist_5 =  $fullname;
    $date_6 = date("Y-m-d");
    $diagnosis_6 =  $_POST['diagnosis_6'];
    $toothno_6 =  $_POST['toothno_6'];
    $treatment_6 =  $_POST['treatment_6'];
    $dentist_6 =  $fullname;
    $date_7 =  date("Y-m-d");
    $diagnosis_7 =  $_POST['diagnosis_7'];
    $toothno_7 =  $_POST['toothno_7'];
    $treatment_7 =  $_POST['treatment_7'];
    $dentist_7 =  $fullname;
    $date_8 =  date("Y-m-d");
    $diagnosis_8 =  $_POST['diagnosis_8'];
    $toothno_8 =  $_POST['toothno_8'];
    $treatment_8 =  $_POST['treatment_8'];
    $dentist_8 =  $fullname;
    $date_9 =  date("Y-m-d");
    $diagnosis_9 =  $_POST['diagnosis_9'];
    $toothno_9 =  $_POST['toothno_9'];
    $treatment_9 =  $_POST['treatment_9'];
    $dentist_9 =  $fullname;
    $date_10 =  date("Y-m-d");
    $diagnosis_10 =  $_POST['diagnosis_10'];
    $toothno_10 =  $_POST['toothno_10'];
    $treatment_10 =  $_POST['treatment_10'];
    $dentist_10 =  $fullname;
    $date_11 =  date("Y-m-d");
    $diagnosis_11 =  $_POST['diagnosis_11'];
    $toothno_11 =  $_POST['toothno_11'];
    $treatment_11 =  $_POST['treatment_11'];
    $dentist_11 =  $fullname;
    $date_12 =  date("Y-m-d");
    $diagnosis_12 =  $_POST['diagnosis_12'];
    $toothno_12 =  $_POST['toothno_12'];
    $treatment_12 =  $_POST['treatment_12'];
    $dentist_12 =  $fullname;
    $date_13 =  date("Y-m-d");
    $diagnosis_13 =  $_POST['diagnosis_13'];
    $toothno_13 =  $_POST['toothno_13'];
    $treatment_13 =  $_POST['treatment_13'];
    $dentist_13 =  $fullname;
    $date_14 =  date("Y-m-d");
    $diagnosis_14 =  $_POST['diagnosis_14'];
    $toothno_14 =  $_POST['toothno_14'];
    $treatment_14 =  $_POST['treatment_14'];
    $dentist_14 =  $fullname;
    $date_15 =  date("Y-m-d");
    $diagnosis_15 =  $_POST['diagnosis_15'];
    $toothno_15 =  $_POST['toothno_15'];
    $treatment_15 =  $_POST['treatment_15'];
    $dentist_15 =  $fullname;
    $date_16 =  date("Y-m-d");
    $diagnosis_16 =  $_POST['diagnosis_16'];
    $toothno_16 =  $_POST['toothno_16'];
    $treatment_16 =  $_POST['treatment_16'];
    $dentist_16 =  $fullname;
    $date_17 =  date("Y-m-d");
    $diagnosis_17 =  $_POST['diagnosis_17'];
    $toothno_17 =  $_POST['toothno_17'];
    $treatment_17 =  $_POST['treatment_17'];
    $dentist_17 =  $fullname;
    $date_18 =  date("Y-m-d");
    $diagnosis_18 =  $_POST['diagnosis_18'];
    $toothno_18 =  $_POST['toothno_18'];
    $treatment_18 =  $_POST['treatment_18'];
    $dentist_18 =  $fullname;
    $date_19 =  date("Y-m-d");
    $diagnosis_19 =  $_POST['diagnosis_19'];
    $toothno_19 =  $_POST['toothno_19'];
    $treatment_19 =  $_POST['treatment_19'];
    $dentist_19 =  $fullname;
    $date_20 =  date("Y-m-d");
    $diagnosis_20 =  $_POST['diagnosis_20'];
    $toothno_20 =  $_POST['toothno_20'];
    $treatment_20 = $_POST['treatment_20'];
    $dentist_20 = $fullname;


    // add record to transaction_history
    $sql = "INSERT transaction_history (patient, firstname, middlename, lastname, designation, age, sex, birthday, department, college, program, yearlevel, section, block, type, transaction, purpose, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname',' $designation', '$age', '$sex', '$birthday', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
    if($result = mysqli_query($conn, $sql))
    {
        // if insert treatment record
        $sql = "INSERT INTO treatment_record SET 
        patientid = '$patientid', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', department = '$department', college = '$college', program = '$program', year = '$year', section = '$section', block = '$block', birthday = '$birthday', civil_status = '$civil_status', sex = '$sex', address = '$address', 
        date_1 = '$date_1', diagnosis_1 = '$diagnosis_1', toothno_1 = '$toothno_1', treatment_1 = '$treatment_1', dentist_1 = '$dentist_1', date_2 = '$date_2', diagnosis_2 = '$diagnosis_2', toothno_2 = '$toothno_2', treatment_2 = '$treatment_2', dentist_2 = '$dentist_2', date_3 = '$date_3', diagnosis_3 = '$diagnosis_3', toothno_3 = '$toothno_3', treatment_3 = '$treatment_3', dentist_3 = '$dentist_3', date_4 = '$date_4', diagnosis_4 = '$diagnosis_4', toothno_4 = '$toothno_4', treatment_4 = '$treatment_4', dentist_4 = '$dentist_4', date_5 = '$date_5', diagnosis_5 = '$diagnosis_5', toothno_5 = '$toothno_5', treatment_5 = '$treatment_5', dentist_5 = '$dentist_5', date_6 = '$date_6', diagnosis_6 = '$diagnosis_6', toothno_6 = '$toothno_6', treatment_6 = '$treatment_6', dentist_6 = '$dentist_6', date_7 = '$date_7', diagnosis_7 = '$diagnosis_7', toothno_7 = '$toothno_7', treatment_7 = '$treatment_7', dentist_7 = '$dentist_7', date_8 = '$date_8', diagnosis_8 = '$diagnosis_8', toothno_8 = '$toothno_8', treatment_8 = '$treatment_8', dentist_8 = '$dentist_8', date_9 = '$date_9', diagnosis_9 = '$diagnosis_9', toothno_9 = '$toothno_9', treatment_9 = '$treatment_9', dentist_9 = '$dentist_9', date_10 = '$date_10', diagnosis_10 = '$diagnosis_10', toothno_10 = '$toothno_10', treatment_10 = '$treatment_10', dentist_10 = '$dentist_10', date_11 = '$date_11', diagnosis_11 = '$diagnosis_11', toothno_11 = '$toothno_11', treatment_11 = '$treatment_11', dentist_11 = '$dentist_11', date_12 = '$date_12', diagnosis_12 = '$diagnosis_12', toothno_12 = '$toothno_12', treatment_12 = '$treatment_12', dentist_12 = '$dentist_12', date_13 = '$date_13', diagnosis_13 = '$diagnosis_13', toothno_13 = '$toothno_13', treatment_13 = '$treatment_13', dentist_13 = '$dentist_13', date_14 = '$date_14', diagnosis_14 = '$diagnosis_14', toothno_14 = '$toothno_14', treatment_14 = '$treatment_14', dentist_14 = '$dentist_14', date_15 = '$date_15', diagnosis_15 = '$diagnosis_15', toothno_15 = '$toothno_15', treatment_15 = '$treatment_15', dentist_15 = '$dentist_15', date_16 = '$date_16', diagnosis_16 = '$diagnosis_16', toothno_16 = '$toothno_16', treatment_16 = '$treatment_16', dentist_16 = '$dentist_16', date_17 = '$date_17', diagnosis_17 = '$diagnosis_17', toothno_17 = '$toothno_17', treatment_17 = '$treatment_17', dentist_17 = '$dentist_17', date_18 = '$date_18', diagnosis_18 = '$diagnosis_18', toothno_18 = '$toothno_18', treatment_18 = '$treatment_18', dentist_18 = '$dentist_18', date_19 = '$date_19', diagnosis_19 = '$diagnosis_19', toothno_19 = '$toothno_19', treatment_19 = '$treatment_19', dentist_19 = '$dentist_19', date_20 = '$date_20', diagnosis_20 = '$diagnosis_20', toothno_20 = '$toothno_20', treatment_20 = '$treatment_20', dentist_20 = '$dentist_20'";
        if($result = mysqli_query($conn, $sql))
        {
            // check if may existing na sa medcase report
            $enddate = date("Y-m-t");
            $medcase_others = $_POST['medcase_others'];

            //kunin medcase as text
            $sql = "SELECT * FROM med_case WHERE id='$medcaseid'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                if($data['medcase'] != 'Others:')
                {
                    $medcase_type = $data['type'];
                    $medcase = $data['medcase'];
                }
                else
                {
                    $medcase_type ="others";
                    $medcase = $medcase_others;
                }
            }

            $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0)
            {
                // fetch data ng existing entry

                
                $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    $designation = $data['designation']; 
                    $sex = $data['sex']; 
                }
                $enddate = date("Y-m-t");
                $medcase_others = $_POST['medcase_others'];

                //kunin medcase as text
                $sql = "SELECT * FROM med_case WHERE id='$medcaseid'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    if($data['medcase'] != 'Others:')
                    {
                        $medcase_type = $data['type'];
                        $medcase = $data['medcase'];
                    }
                    else
                    {
                        $medcase_type ="others";
                        $medcase = $medcase_others;
                    }
                }

                $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    // check san sya i-add na column sa database
                    switch(true)
                    {
                        case ($designation == "STUDENT" AND $sex == "MALE"):
                        {
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
                        case ($designation == "STUDENT" AND $sex == "FEMALE"):
                        {
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
                        case ($designation != "STUDENT" AND $sex == "MALE"):
                        {
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
                        case ($designation != "STUDENT" AND $sex == "FEMALE"):
                        {
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
                        default:
                        {
                            break;
                        }
                    }
                }
                // update if meron
                $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
                if($result = mysqli_query($conn, $sql))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                    if($result = mysqli_query($conn, $sql))
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_consultation";
                            });
                        </script>
                        <?php
                        // Treatment Record was recorded
                    }
                    else
                    { 
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_consultation";
                            });
                        </script>
                        <?php
                        // Treatment Record was recorded
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../transaction_dental_consultation";
                        });
                    </script>
                    <?php
                    // Treatment Record was recorded
                }
            }
            else
            {
                // add pag wala
                
                $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    $designation = $data['designation']; 
                    $sex = $data['sex']; 
                }
                $enddate = date("Y-m-t");
                $medcase_others = $_POST['medcase_others'];

                // check san sya i-add na column sa database
                switch(true)
                {
                    case ($designation == "STUDENT" AND $sex == "MALE"):
                    {
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
                    case ($designation == "STUDENT" AND $sex == "FEMALE"):
                    {
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
                    case ($designation != "STUDENT" AND $sex == "MALE"):
                    {
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
                    case ($designation != "STUDENT" AND $sex == "FEMALE"):
                    {
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
                    default:
                    {
                        break;
                    }
                }
                //kunin medcase as text
                $sql = "SELECT * FROM med_case WHERE id='$medcaseid'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    if($data['medcase'] != 'Others:')
                    {
                        $medcase_type = $data['type'];
                        $medcase = $data['medcase'];
                    }
                    else
                    {
                        $medcase_type ="others";
                        $medcase = $medcase_others;
                    }
                }

                $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$au_campus', '$medcase_type', '$medcase', '$sm', '$sf', '$st', '$pm', '$pf', '$pt', '$gm', '$gf', '$gt', '$enddate')";
                if($result = mysqli_query($conn, $sql))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                    if($result = mysqli_query($conn, $sql))
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_consultation";
                            });
                        </script>
                        <?php
                        // Treatment Record was recorded
                    }
                    else
                    { 
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../transaction_dental_consultation";
                            });
                        </script>
                        <?php
                        // Treatment Record was recorded
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../transaction_dental_consultation";
                        });
                    </script>
                    <?php
                    // Treatment Record was recorded
                }
            }
        }
        else
        {
            // Treatment Record was incomplete but saved.
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../transaction_dental_consultation";
                });
            </script>
            <?php
        }
        
    }
    else
    {
        // Treatment Record was not recorded
    ?>
<script>
    setTimeout(function() {
        window.location = "../transaction_dental_consultation";
    });
</script>
<?php
}
mysqli_close($conn);