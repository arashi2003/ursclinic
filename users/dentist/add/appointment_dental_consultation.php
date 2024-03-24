<?php
    session_start();
    include('../connection.php');
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a Treatment Record for " . $_POST['patientid'];
    $au_status = "unread";

    //patient info
    $patientid = $_POST['patientid'];
    $civil_status = $_POST['civil_status'];

    //logbook info
    $type = "Appointment";
    $transaction = "Consultation";
    $purpose = "Dental";
    $medcase = $_POST['medcase'];
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
            $age = floor((time() - strtotime($data['birthday'])) / 31556926); 
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
        $age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
        $program = $_POST['program'];
        $yearlevel = $_POST['yearlevel'];
        $section = $_POST['section'];
        $block = $_POST['block'];
        $address = $_POST['address'];
        $birthday = $_POST['birthday']; 
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


    // add record to transaction_history
    $sql = "INSERT transaction_history (patient, firstname, middlename, lastname, designation, sex, birthday, department, college, program, yearlevel, section, block, type, transaction, purpose, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname',' $designation', '$age', '$sex', '$birthday', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
    if($result = mysqli_query($conn, $sql))
    {
        if(isset($_POST['tooth_no']))
        {
            // treatment record info
            $date_1 =  date("Y-m-d");
            $diagnosis_1 =  $_POST['diagnosis'];
            $toothno_1 =  $_POST['toothno'];
            $treatment_1 =  $_POST['treatment'];
            $dentist_1 =  $fullname;
            
            foreach ($toothno_1 as $key => $tooth) {
                // if insert treatment record
                $sql = "INSERT INTO treatment_record SET patientid = '$patientid', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', department = '$department', college = '$college', program = '$program', year = '$year', section = '$section', block = '$block', birthday = '$birthday', civil_status = '$civil_status', sex = '$sex', address = '$address', 
                date = '$date_1', diagnosis = '{$diagnosis_1[$key]}', toothno = '{$tooth}', treatment = '{$treatment_1[$key]}', dentist = '$dentist_1'";
                $result = mysqli_query($conn, $sql);
            }
        }
        else
        {
            // treatment record info
            $date_1 =  date("Y-m-d");
            $diagnosis_1 =  $_POST['diagnosis'];
            $toothno_1 =  $_POST['toothno'];
            $treatment_1 =  $_POST['treatment'];
            $dentist_1 =  $fullname;
            
            foreach ($toothno_1 as $key => $tooth) {
                // if insert treatment record
                $sql = "INSERT INTO treatment_record SET patientid = '$patientid', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', department = '$department', college = '$college', program = '$program', year = '$year', section = '$section', block = '$block', birthday = '$birthday', civil_status = '$civil_status', sex = '$sex', address = '$address', 
                date = '$date_1', diagnosis = '{$diagnosis_1[$key]}', toothno = '{$tooth}', treatment = '{$treatment_1[$key]}', dentist = '$dentist_1'";
                $result = mysqli_query($conn, $sql);
            }
        }
    
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