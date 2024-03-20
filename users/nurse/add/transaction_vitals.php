<?php
    session_start();
    include('../../../connection.php');
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a transaction record for vitals of " . $_POST['patientid'];
    $au_status = "unread";
    
    //patient info
    $patientid = $_POST['patientid'];
    $firstname = strtoupper($_POST['firstname']);
    $middlename = strtoupper($_POST['middlename']);
    $lastname = strtoupper($_POST['lastname']);
    //$birthday = date("Y-m-d", strtotime($_POST['birthday']));
    $designation = strtoupper($_POST['designation']);
    $age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
    $sex = strtoupper($_POST['sex']);
    $department = $_POST['department'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $block = $_POST['block'];

    //logbook info
    $bp = $_POST['bp'];
    $pr = $_POST['pr'];
    $temp = $_POST['temp'];
    $respiratory = $_POST['respiratory'];
    $oxygen = $_POST['oxygen'];
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
    $enddate = date("Y-m-t");

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

    $sql = "INSERT transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction, purpose, bp, pr, temp, respiratory, oxygen_saturation, chief_complaint, findiag, remarks, referral, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname','$designation', '$age', '$sex', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$bp', '$pr', '$temp', '$respiratory', '$oxygen', '$chief_complaint', '$findiag', '$remarks', '$referral', '$pod_nod', '$medcase', '$medcase_others', '$au_campus', now())";
    if($result = mysqli_query($conn, $sql))
    {
        // check if may existing na

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

            $enddate = date("Y-m-t");
            $designation = strtoupper($_POST['designation']);
            $sex = strtoupper($_POST['sex']);
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
                            window.location = "../transaction_history";
                        });
                    </script>
                    <?php
                    // Transaction record was recorded
                }
                else
                { 
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../transaction_history";
                        });
                    </script>
                    <?php
                    // Transaction record was recorded
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../transaction_history";
                    });
                </script>
                <?php
                // Transaction record was recorded
            }
        }
        else
        {
            // add pag wala
            
            $designation = strtoupper($_POST['designation']);
            $sex = strtoupper($_POST['sex']);
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

            $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$au_campus', '$medcase_type', '$medcase', '$sm', '$sf', '$st', '$pm', '$pf', '$pt', '$gm', '$gf', '$gt', '$enddate')";
            if($result = mysqli_query($conn, $sql))
            {
                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                if($result = mysqli_query($conn, $sql))
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../transaction_history";
                        });
                    </script>
                    <?php
                    // Transaction record was recorded
                }
                else
                { 
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../transaction_history";
                        });
                    </script>
                    <?php
                    // Transaction record was recorded
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../transaction_history";
                    });
                </script>
                <?php
                // Transaction record was recorded
            }
        }
    }
    else
    {
        // Transaction record was not recorded
    ?>
<script>
    setTimeout(function() {
        window.location = "../transaction_history";
    });
</script>
<?php
}
mysqli_close($conn);