<?php
    session_start();
    include('../../../connection.php');
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    if($_POST['patientid'] != "" || $_POST['patientid'] != " ")
    {
        $activity = 'added a transaction record for ' . $_POST['type'] . " to " . $_POST['patientid'];
    }
    else
    {
        $activity = 'added a transaction record for ' . $_POST['type'];
    }

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

    $issued = "";
    $qty_m = $_POST['quantity_med'];
    $medicine = $_POST['medicine'];
    $qty_s = $_POST['quantity_sup'];
    $supply = $_POST['supply'];
    for($a = 0; $a < count($medicine); $a++)
    {
        $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
            $issued .= $qty_m[$a] . " " . $med . ", ";
            if($a < count($medicine) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    for($b = 0; $b < count($supply); $b++)
    {
        $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $sup = $data['supply']. " " . $data['volume'] .  $data['unit_measure']; 
            $quantity =$qty_s[$b];
            $issued .= $quantity . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    $issued = rtrim($issued, ", ");
    
    $query = "INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction,	purpose, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction',	'$purpose', '$chief_complaint', '$findiag', '$remarks', '$referral', '$issued', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";    
    $result = mysqli_query($conn, $query);
    if($result)
    { 
        for($a = 0; $a < count($medicine); $a++)
        {
            for ($a = 0; $a < count($medicine); $a++) 
            {
                $query0 = "SELECT state FROM medicine WHERE medid = '$medicine[$a]'";
                $result = mysqli_query($conn, $query0);
                $mstat = '';
                while ($data = mysqli_fetch_assoc($result)) {
                    $mstat = $data['state'];
                }
                if ($mstat != 'open-close') {
                    $datenow = date("Y-m-d");
                    $enddate = date("Y-m-t");
            
                    // Update inventory_medicine
                    $query0 = "UPDATE inventory_medicine SET closed = closed - '$qty_m[$a]', qty = qty - '$qty_m[$a]' WHERE campus='$campus' AND medid='$medicine[$a]' AND date='$enddate' AND expiration < '$datenow' AND qty > 0";
                    mysqli_query($conn, $query0);
            
                    // Update inv_total
                    $query1 = "UPDATE inv_total SET closed = closed - '$qty_m[$a]', qty = qty - '$qty_m[$a]' WHERE stockid='$medicine[$a]'";
                    mysqli_query($conn, $query1);
            
                    // Update inventory
                    $query2 = "UPDATE inventory SET closed = closed - '$qty_m[$a]', qty = qty - '$qty_m[$a]' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine[$a]' AND qty != 0 AND expiration > $datenow ORDER BY date LIMIT 1";
                    mysqli_query($conn, $query2);
            
                    // Update report_medsupinv
                    $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine[$a]' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus AND eqty < 0'";
                    $result = mysqli_query($conn, $query3);
                    while ($data = mysqli_fetch_assoc($result)) 
                    {
                        $qty = $qty_m[$a];
                        $aotqty = $data['tqty'];
                        $aieqty = $data['eqty'];
                        $aiiamt = $data['iamt'];
                        $aiiqty = $data['iqty'];
                        $aieamt = $data['eamt']; //buc
                        $cost = $data['eamt'] / $data['eqty'];
            
                        $tqty = $aotqty - $qty;
                        $eqty = $data['eqty']; - $qty;
            
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
                            $iamt = $iqty * ($aeamt/$eqty);
                        }
                    }
                    $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medicine[$a]' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                    mysqli_query($conn, $query4);
                }
            }
        }

        for($b = 0; $b < count($supply); $b++)
        {
            for ($b = 0; $b < count($supply); $b++) 
            {
                $query0 = "SELECT state FROM medicine WHERE medid = '$supply[$b]'";
                $result = mysqli_query($conn, $query0);
                $mstat = '';
                while ($data = mysqli_fetch_assoc($result)) {
                    $mstat = $data['state'];
                }
                if ($mstat != 'open-close') {
                    $datenow = date("Y-m-d");
                    $enddate = date("Y-m-t");
            
                    // Update inventory_medicine
                    $query0 = "UPDATE inventory_medicine SET closed = closed - '$qty_s[$b]', qty = qty - '$qty_s[$b]' WHERE campus='$campus' AND medid='$supply[$b]' AND date='$enddate' AND expiration < '$datenow' AND qty > 0";
                    mysqli_query($conn, $query0);
            
                    // Update inv_total
                    $query1 = "UPDATE inv_total SET closed = closed - '$qty_s[$b]', qty = qty - '$qty_s[$b]' WHERE stockid='$supply[$b]'";
                    mysqli_query($conn, $query1);
            
                    // Update inventory
                    $query2 = "UPDATE inventory SET closed = closed - '$qty_s[$b]', qty = qty - '$qty_s[$b]' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$supply[$b]' AND qty != 0 AND expiration > $datenow ORDER BY date LIMIT 1";
                    mysqli_query($conn, $query2);
            
                    // Update report_medsupinv
                    $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply[$b]' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty <0";
                    $result = mysqli_query($conn, $query3);
                    while ($data = mysqli_fetch_assoc($result)) 
                    {
                        $qty = $qty_s[$b];
                        $aotqty = $data['tqty'];
                        $aieqty = $data['eqty'];
                        $aiiamt = $data['iamt'];
                        $aiiqty = $data['iqty'];
                        $aieamt = $data['eamt']; //buc
                        $cost = $data['eamt'] / $data['eqty'];
            
                        $tqty = $aotqty - $qty;
                        $eqty = $data['eqty']; - $qty;
            
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
                            $iamt = $iqty * ($aeamt/$eqty);
                        }
                    }
                    $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply[$b]' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                    mysqli_query($conn, $query4);
                }
            }
        }

        // medcase report
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
                }
            }
            // update if meron
            $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
            $result = mysqli_query($conn, $sql);
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
                    $sm = 0;
                    $sf = 0;
                    $st = 0;
                    $pm = 0;
                    $pf = 0;
                    $pt = 0;
                    $gm = 0;
                    $gf = 0;
                    $gt = 0;
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
            $result = mysqli_query($conn, $sql);
        }
        
        //audit trail 
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = " ../transaction_add.php";
                });
            </script>
            <?php
            // modal message box saying "Transaction was recorded."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = " ../transaction_add.php";
                });
            </script>
            <?php
            // modal message box saying "Transaction was recorded."
        }
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