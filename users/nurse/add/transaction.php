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
    $firstname = strtoupper($_POST['firstname']);
    $middlename = strtoupper($_POST['middlename']);
    $lastname = strtoupper($_POST['lastname']);
    $designation = strtoupper($_POST['designation']);
    $age = $_POST['age'];
    $sex = strtoupper($_POST['sex']);
    $department = $_POST['department'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $block = strtoupper($_POST['block']);

    //logbook info
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
   
    $issued = "";
    //$qty_m = $_POST['quantity_med'];
    //$medicine = $_POST['medicine'];

    if(isset($_POST['medicine']))
    {
        //$med_array = $_POST['medicine'];

        //for($a = 0; $a < count($med_array); $a++)
        //{
            //$qty_m = implode($_POST['quantity_med']);
            //$medicine = implode($_POST['medicine']);


            $query0 = "SELECT state FROM medicine WHERE medid = '$medicine'";
            $result = mysqli_query($conn, $query0);
            while ($data = mysqli_fetch_assoc($result)) 
            {
                $mstat = $data['state'];
            }
            if ($mstat == 'per piece') 
            {
                $sql = "SELECT * FROM medicine WHERE medid='$medicine'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
                    $issued = $qty_m . " " . $med;
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

                $query = "INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction,	purpose, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) 
                VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', 
                '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction',	'$purpose', 
                '$chief_complaint', '$findiag', '$remarks', '$referral', '$issued', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";    
                $result = mysqli_query($conn, $query);
                if($result)
                {
                    $datenow = date("Y-m-d");
                    $enddate = date("Y-m-t");
                    $sql = "SELECT * FROM medicine WHERE medid='$medicine'";
                    $result = mysqli_query($conn, $sql);
                    while($data=mysqli_fetch_array($result))
                    {
                        $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
                        $issued = $qty_m . " " . $med;
                    }
                    // Update inventory_medicine
                    $query0 = "UPDATE inventory_medicine SET closed = closed - '$qty_m', qty = qty - '$qty_m' WHERE campus='$campus' AND medid='$medicine' AND date='$enddate' AND expiration > '$datenow' AND qty > 0";
                    mysqli_query($conn, $query0);
            
                    // Update inv_total
                    $query1 = "UPDATE inv_total SET closed = closed - '$qty_m', qty = qty - '$qty_m' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
                    mysqli_query($conn, $query1);
            
                    // Update inventory
                    $query2 = "UPDATE inventory SET closed = closed - '$qty_m', qty = qty - '$qty_m' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
                    mysqli_query($conn, $query2);
            
                    // Update report_medsupinv
                    $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus AND eqty > 0'";
                    $result = mysqli_query($conn, $query3);
                    while ($data = mysqli_fetch_assoc($result)) 
                    {
                        $qty = $qty_m;
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
                        }$query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                    mysqli_query($conn, $query4);
                    }
                    
                }
            }
        //}
    }
    elseif(isset($_POST['supply']))
    {
        for($a = 0; $b < count($sup_array); $b++)
        {
            $qty_s = implode($_POST['quantity_sup']);
            $supply = implode($_POST['supply']);
        
            $query0 = "SELECT state FROM medicine WHERE medid = '$supply'";
            $result = mysqli_query($conn, $query0);
            $mstat = '';
            while ($data = mysqli_fetch_assoc($result)) 
            {
                $mstat = $data['state'];
            }
            if ($mstat != 'open-close') 
            {
                $datenow = date("Y-m-d");
                $enddate = date("Y-m-t");
                $sql = "SELECT * FROM supply WHERE supid='$supply'";
                $result = mysqli_query($conn, $sql);
                while($data=mysqli_fetch_array($result))
                {
                    $sup = $data['supply']. " " . $data['volume'] .  $data['unit_measure']; 
                    $issued = $qty_s . " " . $sup;
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

                $query = "INSERT INTO transaction_history (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction,	purpose, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) 
                VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', 
                '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction',	'$purpose', 
                '$chief_complaint', '$findiag', '$remarks', '$referral', '$issued', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";    
                $result = mysqli_query($conn, $query);
                if($result)
                {
                    // Update inventory_supply
                    $query0 = "UPDATE inventory_supply SET closed = closed - '$qty_s', qty = qty - '$qty_s' WHERE campus='$campus' AND supid='$supply' AND date='$enddate' AND expiration > '$datenow' AND qty > 0";
                    mysqli_query($conn, $query0);
            
                    // Update inv_total
                    $query1 = "UPDATE inv_total SET closed = closed - '$qty_s', qty = qty - '$qty_s' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
                    mysqli_query($conn, $query1);
            
                    // Update inventory
                    $query2 = "UPDATE inventory SET closed = closed - '$qty_s', qty = qty - '$qty_s' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
                    mysqli_query($conn, $query2);
            
                    // Update report_medsupinv
                    $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty <0";
                    $result = mysqli_query($conn, $query3);
                    while ($data = mysqli_fetch_assoc($result)) 
                    {
                        $qty = $qty_s;
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
                    $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                    mysqli_query($conn, $query4);
                    }
                }
            }
        }
    }

    // medcase report
    $enddate = date("Y-m-t");
    $designation = strtoupper($_POST['designation']);
    $sex = strtoupper($_POST['sex']);

    $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
    $result = mysqli_query($conn, $sql);
    foreach($result as $data)
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
        $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
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

mysqli_close($conn);