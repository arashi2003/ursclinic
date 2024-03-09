<?php
    session_start();
    include('connection.php');

    //session accountid of nurse
    $accountid = $_SESSION['userid'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = $_SESSION['name'];
    $au_status = "unread";
    $activity = "added medicine ID " . $_POST['medicine'] . " inventory stocks";
    $adminid = $_POST['admin'];
    $batchid = "B" . date("Ymd");
    $medid = $_POST['medicine'];
    $qty = $_POST['opened'] + $_POST['close'];
    $o = $_POST['opened'];
    $c = $_POST['close'];
    $cost = $_POST['unit_cost'];
    $exp = $_POST['expiration'];
    
    //medicine
    $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
    while($data=mysqli_fetch_array($query))
    {
        $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
    }
    //medadmin
    $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
    while($data=mysqli_fetch_array($query))
    {
        $medad = $data['med_admin'];
    }

    // last day of this month
    $date = date("Y-m-t");
    
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added medicine id " . $medid . " stocks in medicine inventory";

    //add inventory expiration
    $query0 = "INSERT INTO inventory_medicine (campus, medid, closed, open, qty, unit_cost, expiration, date, time) VALUES ('$campus', '$medid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
    if(mysqli_query($conn, $query0))
    {
        $query = "SELECT * FROM inv_total WHERE stockid = '$medid' AND type = 'medicine' AND campus='$au_campus'";
        $result=mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0)
        {
            $query = "SELECT * FROM inv_total WHERE stockid = '$medid' AND type = 'medicine' AND campus='$au_campus'";
            $result=mysqli_query($conn, $query);
            foreach($result as $data)
            {
                $ucost = (($cost*$qty) + ($data['unit_cost'] * $data['qty'])) / ($data['qty'] + $qty);
            }
            
            // add inventory total
            $query = "UPDATE inv_total SET open=open + '$o', closed= closed + '$c', qty=qty + '$qty', datetime=now(), unit_cost='$ucost' WHERE stockid='$medid'";
            if(mysqli_query($conn, $query))
            {
                //add inventory by batch
                $query1 = "INSERT INTO inventory (campus, stock_type, batchid, stockid, closed, opened, qty, unit_cost, expiration, date, time) VALUES ('$campus', 'medicine', '$batchid', '$medid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
                if(mysqli_query($conn, $query1))
                {
                    // last day of this month
                    $enddate = date("Y-m-t");
                    $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$adminid' AND type = 'med_admin' AND date = '$enddate'";    
                    $result = mysqli_query($conn, $query0);
                    $resultCheck = mysqli_num_rows($result);
                    // if may existing entry ung medicine administration sa reports
                    if($resultCheck > 0)
                    {   
                        $accountid = $_SESSION['userid'];
                        $campus = $_SESSION['campus'];
                        $adminid = $_POST['admin'];
                        $batchid = "B" . date("Ymd");
                        $medid = $_POST['medicine'];
                        $qty = $_POST['opened'] + $_POST['close'];
                        $o = $_POST['opened'];
                        $c = $_POST['close'];
                        $cost = $_POST['unit_cost'];
                        $exp = $_POST['expiration'];
                        $qty = $_POST['opened'] + $_POST['close'];
                        $cost = $_POST['unit_cost'];
                        
                        //medicine
                        $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                        while($data=mysqli_fetch_array($query))
                        {
                            $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                        }

                        //medadmin
                        $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                        while($data=mysqli_fetch_array($query))
                        {
                            $medad = $data['med_admin'];
                        }

                        // last day of this month
                        $enddate = date("Y-m-t");

                        $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                        $result = mysqli_query($conn, $query0);
                        $resultCheck = mysqli_num_rows($result);
                        if($resultCheck > 0) // if may existing entry ung medicine sa reports
                        {   
                            $campus = $_SESSION['campus'];
                            $adminid = $_POST['admin'];
                            $batchid = "B" . date("Ymd");
                            $medid = $_POST['medicine'];
                            
                            $o = $_POST['opened'];
                            $c = $_POST['close'];
                            $cost = $_POST['unit_cost'];
                            $exp = $_POST['expiration'];
                            $enddate = date("Y-m-t");
                            
                            $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                            $result = mysqli_query($conn, $query0);
                            // kunin values from row
                            foreach($result as $data)
                            {
                                $qty = $_POST['opened'] + $_POST['close'];
                                $aobqty = $data['bqty'];
                                $aorqty = $data['rqty'];
                                $aotqty = $data['tqty'];
                                $aieqty = $data['eqty'];
                                $aieamt = $data['eamt'];
                                
                                $arqty = $aorqty + $qty;
                                $tqty = $aotqty + $qty;
                                $eqty = $qty + $aieqty;

                                if ($data['bqty'] == 0 )
                                {
                                    $aobuc = 0;
                                    $abuc = number_format($aobuc, 2, ".");
                                }
                                else
                                {
                                    $aobuc = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                    $abuc = number_format($aobuc, 2, ".");
                                }

                                $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                $aieamt = $ucost * $eqty;
                                $aeamt = number_format($aieamt, 2, ".");
                                
                                $query = "UPDATE report_medsupinv SET campus = '$campus', buc = '$abuc', rqty = '$arqty', tqty = '$tqty', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'medicine'";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }

                            
                        }
                        // if walang existing entry ung medicine sa reports
                        else
                        {
                            $lastdate = date("Y-m-t", strtotime("- 1 month"));
                            $accountid = $_SESSION['userid'];
                            $campus = $_SESSION['campus'];
                            $adminid = $_POST['admin'];
                            $batchid = "B" . date("Ymd");
                            $medid = $_POST['medicine'];
                            $qty = $_POST['opened'] + $_POST['close'];
                            $o = $_POST['opened'];
                            $c = $_POST['close'];
                            $cost = $_POST['unit_cost'];
                            $exp = $_POST['expiration'];

                            $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                            $result = mysqli_query($conn, $query0);
                            $resultCheck = mysqli_num_rows($result);
                            if($resultCheck > 0)// if may remaining stocks pa from previous month
                            {
                                $accountid = $_SESSION['userid'];
                                $campus = $_SESSION['campus'];
                                $adminid = $_POST['admin'];
                                $batchid = "B" . date("Ymd");
                                $medid = $_POST['medicine'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $o = $_POST['opened'];
                                $c = $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                $exp = $_POST['expiration'];
                                $enddate = date("Y-m-t");

                                $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                                $result = mysqli_query($conn, $query0);
                                // kunin values from row
                                foreach($result as $data)
                                {
                                    $obqty = $data['eqty'];
                                    $nobuc = $data['eamt'];

                                    $orqty = $qty;
                                    $otqty = $qty;
                                    $aeqty = $obqty + $qty; 
                                    $ucost = ($nobuc + ($qty * $cost)) / $aeqty;
                                    $obuc = number_format($ucost, 2, ".");
                                    $ieamt = $ucost * $aeqty;
                                    $aeamt = number_format($ieamt, 2, ".");
                                }

                                //medadmin
                                $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                while($data=mysqli_fetch_array($query))
                                {
                                    $medad = $data['med_admin'];
                                }

                                $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine','$medad', '$medid', '$medicine', '$obqty', '$obuc', '$orqty', '$otqty', 0, '0.00', '$aeqty', '$aeamt', '$date')";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }
                            else // no remaining stocks from last month
                            {
                                $date = date("Y-m-t");
                                $accountid = $_SESSION['userid'];
                                $campus = $_SESSION['campus'];
                                $adminid = $_POST['admin'];
                                $batchid = "B" . date("Ymd");
                                $medid = $_POST['medicine'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $o = $_POST['opened'];
                                $c = $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                $exp = $_POST['expiration'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                
                                $bqty = 0;
                                $buc = 0;
                                $rqty = $qty;
                                $tqty = $qty;
                                $iqty = 0;
                                $iamt = 0;
                                $eqty = $qty;
                                $eamt = $qty * $cost;

                                //medicine
                                $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                                while($data=mysqli_fetch_array($query))
                                {
                                    $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                                }
                                
                                //med_admin
                                $query0 = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                while($data=mysqli_fetch_array($query0))
                                {
                                    $medad = $data['med_admin'];
                                }

                                $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine', '$medad', '$medid', '$medicine', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../med_stocks_batch.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }
                        }
                    }
                    
                    else // if wala pang existing entry ung medicine administration sa reports
                    {
                        $accountid = $_SESSION['userid'];
                        $campus = $_SESSION['campus'];
                        $adminid = $_POST['admin'];
                        $batchid = "B" . date("Ymd");
                        $medid = $_POST['medicine'];
                        $qty = $_POST['opened'] + $_POST['close'];
                        $o = $_POST['opened'];
                        $c = $_POST['close'];
                        $cost = $_POST['unit_cost'];
                        $exp = $_POST['expiration'];
                        $enddate = date("Y-m-t");
                        $lastdate = date("Y-m-t", strtotime("- 1 month"));

                        $query0 = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                        while($data=mysqli_fetch_array($query0))
                        {
                            $medad = $data['med_admin'];
                        }

                        $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'med_admin', '$medad', '$adminid', '$medad', '', '', '', '', '', '', '', '', '$enddate')";
                        if(mysqli_query($conn, $query))
                        {
                            $accountid = $_SESSION['userid'];
                            $campus = $_SESSION['campus'];
                            $adminid = $_POST['admin'];
                            $batchid = "B" . date("Ymd");
                            $medid = $_POST['medicine'];
                            $qty = $_POST['opened'] + $_POST['close'];
                            $o = $_POST['opened'];
                            $c = $_POST['close'];
                            $cost = $_POST['unit_cost'];
                            $exp = $_POST['expiration'];
                            
                            //medicine
                            $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                            }

                            //medadmin
                            $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $medad = $data['med_admin'];
                            }

                            // last day of this month
                            $enddate = date("Y-m-t");
                            $medid = $_POST['medicine'];

                            $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                            $result = mysqli_query($conn, $query0);
                            $resultCheck = mysqli_num_rows($result);
                            // if may existing entry ung medicine sa reports
                            if($resultCheck > 0)
                            {   
                                $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                                $result = mysqli_query($conn, $query0);
                                // kunin values from row
                                foreach($result as $data)
                                {
                                    $aorqty = $data['rqty'];
                                    $aotqty = $data['tqty'];
                                    $aiqty = $data['iqty'];
                                    $aiamt = $data['iamt'];
                                    $aeqty = $data['eqty'];
                                    $aeamt = $data['eamt'];
                                    $arqty = $aorqty + $qty;
                                    $tqty = $aotqty + $qty;
                                    $eqty = $aeqty + $qty;

                                    if ($data['bqty'] == 0 )
                                    {
                                        $aobuc = 0;
                                    }
                                    else
                                    {
                                        $aobuc = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                    }

                                    $abuc = number_format($aobuc, 2, ".");
                                    $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                    $aieamt = $ucost * $eqty;
                                    $aeamt = number_format($aieamt, 2, ".");
                                }
                                $accountid = $_SESSION['userid'];
                                $campus = $_SESSION['campus'];
                                $adminid = $_POST['admin'];
                                $batchid = "B" . date("Ymd");
                                $medid = $_POST['medicine'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $o = $_POST['opened'];
                                $c = $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                $exp = $_POST['expiration'];
                                $enddate = date("Y-m-t");

                                $query = "UPDATE report_medsupinv SET campus = '$campus', buc = '$abuc', rqty = '$arqty', tqty = '$tqty', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'medicine'";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }
                            // if walang existing entry ung medicine sa reports
                            else
                            {
                                $lastdate = date("Y-m-t", strtotime("- 1 month"));
                                $medid = $_POST['medicine'];

                                $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                                $result = mysqli_query($conn, $query0);
                                $resultCheck = mysqli_num_rows($result);
                                if($resultCheck > 0) // if may remaining stocks pa from previous month
                                {   
                                    $accountid = $_SESSION['userid'];
                                    $campus = $_SESSION['campus'];
                                    $adminid = $_POST['admin'];
                                    $batchid = "B" . date("Ymd");
                                    $medid = $_POST['medicine'];
                                    $qty = $_POST['opened'] + $_POST['close'];
                                    $o = $_POST['opened'];
                                    $c = $_POST['close'];
                                    $cost = $_POST['unit_cost'];
                                    $exp = $_POST['expiration'];
                                    
                                    $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                                    $result = mysqli_query($conn, $query0);
                                    // kunin values from row
                                    foreach($result as $data)
                                    {
                                        $obqty = $data['eqty'];
                                        $nobuc = $data['eamt'];

                                        $orqty = $qty;
                                        $tqty = $qty;

                                        $eqty = $obqty + $qty;
                                        $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                        $obuc = number_format($ucost, 2, ".");
                                        $ieamt = ($data['eamt'] + ($qty * $cost));
                                        $aeamt = number_format($ieamt, 2, ".");
                                    }
                                    
                                    $enddate = date("Y-m-t");
                                    //medadmin
                                    $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                    while($data=mysqli_fetch_array($query))
                                    {
                                        $medad = $data['med_admin'];
                                    }

                                    $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine', '$medad', '$medid', '$medicine', '$obqty', '$obuc', '$orqty', '$tqty', 0, '0.00', '$eqty', '$aeamt', '$enddate')";
                                    if(mysqli_query($conn, $query))
                                    {
                                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                        if($result = mysqli_query($conn, $sql))
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                        else
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else // no remaining stocks from last month
                                {
                                    
                                    $date = date("Y-m-t");
                                    $accountid = $_SESSION['userid'];
                                    $campus = $_SESSION['campus'];
                                    $adminid = $_POST['admin'];
                                    $batchid = "B" . date("Ymd");
                                    $medid = $_POST['medicine'];
                                    $qty = $_POST['opened'] + $_POST['close'];
                                    $o = $_POST['opened'];
                                    $c = $_POST['close'];
                                    $cost = $_POST['unit_cost'];
                                    $exp = $_POST['expiration'];
                                    
                                    $bqty = 0;
                                    $buc = 0;
                                    $rqty = $qty;
                                    $tqty = $qty;
                                    $iqty = 0;
                                    $iamt = 0;
                                    $eqty = $qty;
                                    $eamt = $qty * $cost;

                                    //medicine
                                    $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                                    while($data=mysqli_fetch_array($query))
                                    {
                                        $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                                    }
                                    
                                    //med_admin
                                    $query0 = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                    while($data=mysqli_fetch_array($query0))
                                    {
                                        $medad = $data['med_admin'];
                                    }

                                    $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine', '$medad', '$medid', '$medicine', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                                    if(mysqli_query($conn, $query))
                                    {
                                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                        if($result = mysqli_query($conn, $sql))
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                        else
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                            }
                        }
                        else
                        {
                            ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../med_stocks_batch.php";
                                });
                            </script>
                            <?php
                            // modal message box saying "Medicine stocks was added."
                        }
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../med_stocks_batch.php";
                        });
                    </script>
                    <?php
                    // modal message box saying "Medicine stocks was added."
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../med_stocks_batch.php";
                    });
                </script>
                <?php
                // modal message box saying "Medicine stocks added."
            }
        }
        else
        {
            // add inventory total
            $query = "INSERT INTO inv_total (campus, type, stockid, stock_name, open, closed, qty, unit_cost, datetime) VALUES ('$au_campus', 'medicine', '$medid', '$medicine', '$o', '$c', '$qty', '$cost', now())";
            if(mysqli_query($conn, $query))
            {
                //add inventory by batch
                $query1 = "INSERT INTO inventory (campus, stock_type, batchid, stockid, closed, opened, qty, unit_cost, expiration, date, time) VALUES ('$campus', 'medicine', '$batchid', '$medid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
                if(mysqli_query($conn, $query1))
                {
                    // last day of this month
                    $enddate = date("Y-m-t");
                    $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$adminid' AND type = 'med_admin' AND date = '$enddate'";    
                    $result = mysqli_query($conn, $query0);
                    $resultCheck = mysqli_num_rows($result);
                    // if may existing entry ung medicine administration sa reports
                    if($resultCheck > 0)
                    {   
                        $accountid = $_SESSION['userid'];
                        $campus = $_SESSION['campus'];
                        $adminid = $_POST['admin'];
                        $batchid = "B" . date("Ymd");
                        $medid = $_POST['medicine'];
                        $qty = $_POST['opened'] + $_POST['close'];
                        $o = $_POST['opened'];
                        $c = $_POST['close'];
                        $cost = $_POST['unit_cost'];
                        $exp = $_POST['expiration'];
                        $qty = $_POST['opened'] + $_POST['close'];
                        $cost = $_POST['unit_cost'];
                        
                        //medicine
                        $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                        while($data=mysqli_fetch_array($query))
                        {
                            $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                        }

                        //medadmin
                        $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                        while($data=mysqli_fetch_array($query))
                        {
                            $medad = $data['med_admin'];
                        }

                        // last day of this month
                        $enddate = date("Y-m-t");

                        $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                        $result = mysqli_query($conn, $query0);
                        $resultCheck = mysqli_num_rows($result);
                        if($resultCheck > 0) // if may existing entry ung medicine sa reports
                        {   
                            $campus = $_SESSION['campus'];
                            $adminid = $_POST['admin'];
                            $batchid = "B" . date("Ymd");
                            $medid = $_POST['medicine'];
                            
                            $o = $_POST['opened'];
                            $c = $_POST['close'];
                            $cost = $_POST['unit_cost'];
                            $exp = $_POST['expiration'];
                            $enddate = date("Y-m-t");
                            
                            $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                            $result = mysqli_query($conn, $query0);
                            // kunin values from row
                            foreach($result as $data)
                            {
                                $qty = $_POST['opened'] + $_POST['close'];
                                $aobqty = $data['bqty'];
                                $aorqty = $data['rqty'];
                                $aotqty = $data['tqty'];
                                $aieqty = $data['eqty'];
                                $aieamt = $data['eamt'];
                                
                                $arqty = $aorqty + $qty;
                                $tqty = $aotqty + $qty;
                                $eqty = $qty + $aieqty;

                                if ($data['bqty'] == 0 )
                                {
                                    $aobuc = 0;
                                    $abuc = number_format($aobuc, 2, ".");
                                }
                                else
                                {
                                    $aobuc = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                    $abuc = number_format($aobuc, 2, ".");
                                }

                                $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                $aieamt = $ucost * $eqty;
                                $aeamt = number_format($aieamt, 2, ".");
                                
                                $query = "UPDATE report_medsupinv SET campus = '$campus', buc = '$abuc', rqty = '$arqty', tqty = '$tqty', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'medicine'";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }

                            
                        }
                        // if walang existing entry ung medicine sa reports
                        else
                        {
                            $lastdate = date("Y-m-t", strtotime("- 1 month"));
                            $accountid = $_SESSION['userid'];
                            $campus = $_SESSION['campus'];
                            $adminid = $_POST['admin'];
                            $batchid = "B" . date("Ymd");
                            $medid = $_POST['medicine'];
                            $qty = $_POST['opened'] + $_POST['close'];
                            $o = $_POST['opened'];
                            $c = $_POST['close'];
                            $cost = $_POST['unit_cost'];
                            $exp = $_POST['expiration'];

                            $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                            $result = mysqli_query($conn, $query0);
                            $resultCheck = mysqli_num_rows($result);
                            if($resultCheck > 0)// if may remaining stocks pa from previous month
                            {
                                $accountid = $_SESSION['userid'];
                                $campus = $_SESSION['campus'];
                                $adminid = $_POST['admin'];
                                $batchid = "B" . date("Ymd");
                                $medid = $_POST['medicine'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $o = $_POST['opened'];
                                $c = $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                $exp = $_POST['expiration'];
                                $enddate = date("Y-m-t");

                                $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                                $result = mysqli_query($conn, $query0);
                                // kunin values from row
                                foreach($result as $data)
                                {
                                    $obqty = $data['eqty'];
                                    $nobuc = $data['eamt'];

                                    $orqty = $qty;
                                    $otqty = $qty;
                                    $aeqty = $obqty + $qty; 
                                    $ucost = ($nobuc + ($qty * $cost)) / $aeqty;
                                    $obuc = number_format($ucost, 2, ".");
                                    $ieamt = $ucost * $aeqty;
                                    $aeamt = number_format($ieamt, 2, ".");
                                }

                                //medadmin
                                $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                while($data=mysqli_fetch_array($query))
                                {
                                    $medad = $data['med_admin'];
                                }

                                $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine','$medad', '$medid', '$medicine', '$obqty', '$obuc', '$orqty', '$otqty', 0, '0.00', '$aeqty', '$aeamt', '$date')";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }
                            else // no remaining stocks from last month
                            {
                                $date = date("Y-m-t");
                                $accountid = $_SESSION['userid'];
                                $campus = $_SESSION['campus'];
                                $adminid = $_POST['admin'];
                                $batchid = "B" . date("Ymd");
                                $medid = $_POST['medicine'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $o = $_POST['opened'];
                                $c = $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                $exp = $_POST['expiration'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                
                                $bqty = 0;
                                $buc = 0;
                                $rqty = $qty;
                                $tqty = $qty;
                                $iqty = 0;
                                $iamt = 0;
                                $eqty = $qty;
                                $eamt = $qty * $cost;

                                //medicine
                                $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                                while($data=mysqli_fetch_array($query))
                                {
                                    $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                                }
                                
                                //med_admin
                                $query0 = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                while($data=mysqli_fetch_array($query0))
                                {
                                    $medad = $data['med_admin'];
                                }

                                $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine', '$medad', '$medid', '$medicine', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../med_stocks_batch.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }
                        }
                    }
                    
                    else // if wala pang existing entry ung medicine administration sa reports
                    {
                        $accountid = $_SESSION['userid'];
                        $campus = $_SESSION['campus'];
                        $adminid = $_POST['admin'];
                        $batchid = "B" . date("Ymd");
                        $medid = $_POST['medicine'];
                        $qty = $_POST['opened'] + $_POST['close'];
                        $o = $_POST['opened'];
                        $c = $_POST['close'];
                        $cost = $_POST['unit_cost'];
                        $exp = $_POST['expiration'];
                        $enddate = date("Y-m-t");
                        $lastdate = date("Y-m-t", strtotime("- 1 month"));

                        $query0 = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                        while($data=mysqli_fetch_array($query0))
                        {
                            $medad = $data['med_admin'];
                        }

                        $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'med_admin', '$medad', '$adminid', '$medad', '', '', '', '', '', '', '', '', '$enddate')";
                        if(mysqli_query($conn, $query))
                        {
                            $accountid = $_SESSION['userid'];
                            $campus = $_SESSION['campus'];
                            $adminid = $_POST['admin'];
                            $batchid = "B" . date("Ymd");
                            $medid = $_POST['medicine'];
                            $qty = $_POST['opened'] + $_POST['close'];
                            $o = $_POST['opened'];
                            $c = $_POST['close'];
                            $cost = $_POST['unit_cost'];
                            $exp = $_POST['expiration'];
                            
                            //medicine
                            $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                            }

                            //medadmin
                            $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $medad = $data['med_admin'];
                            }

                            // last day of this month
                            $enddate = date("Y-m-t");
                            $medid = $_POST['medicine'];

                            $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                            $result = mysqli_query($conn, $query0);
                            $resultCheck = mysqli_num_rows($result);
                            // if may existing entry ung medicine sa reports
                            if($resultCheck > 0)
                            {   
                                $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate'";    
                                $result = mysqli_query($conn, $query0);
                                // kunin values from row
                                foreach($result as $data)
                                {
                                    $aorqty = $data['rqty'];
                                    $aotqty = $data['tqty'];
                                    $aiqty = $data['iqty'];
                                    $aiamt = $data['iamt'];
                                    $aeqty = $data['eqty'];
                                    $aeamt = $data['eamt'];
                                    $arqty = $aorqty + $qty;
                                    $tqty = $aotqty + $qty;
                                    $eqty = $aeqty + $qty;

                                    if ($data['bqty'] == 0 )
                                    {
                                        $aobuc = 0;
                                    }
                                    else
                                    {
                                        $aobuc = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                    }

                                    $abuc = number_format($aobuc, 2, ".");
                                    $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                    $aieamt = $ucost * $eqty;
                                    $aeamt = number_format($aieamt, 2, ".");
                                }
                                $accountid = $_SESSION['userid'];
                                $campus = $_SESSION['campus'];
                                $adminid = $_POST['admin'];
                                $batchid = "B" . date("Ymd");
                                $medid = $_POST['medicine'];
                                $qty = $_POST['opened'] + $_POST['close'];
                                $o = $_POST['opened'];
                                $c = $_POST['close'];
                                $cost = $_POST['unit_cost'];
                                $exp = $_POST['expiration'];
                                $enddate = date("Y-m-t");

                                $query = "UPDATE report_medsupinv SET campus = '$campus', buc = '$abuc', rqty = '$arqty', tqty = '$tqty', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'medicine'";
                                if(mysqli_query($conn, $query))
                                {
                                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                    if($result = mysqli_query($conn, $sql))
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                    else
                                    {
                                        ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else
                                {
                                    ?>
                                        <script>
                                            setTimeout(function() {
                                                window.location = "../med_stocks_batch.php";
                                            });
                                        </script>
                                        <?php
                                    // modal message box saying "Medicine stocks was added."
                                }
                            }
                            // if walang existing entry ung medicine sa reports
                            else
                            {
                                $lastdate = date("Y-m-t", strtotime("- 1 month"));
                                $medid = $_POST['medicine'];

                                $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                                $result = mysqli_query($conn, $query0);
                                $resultCheck = mysqli_num_rows($result);
                                if($resultCheck > 0) // if may remaining stocks pa from previous month
                                {   
                                    $accountid = $_SESSION['userid'];
                                    $campus = $_SESSION['campus'];
                                    $adminid = $_POST['admin'];
                                    $batchid = "B" . date("Ymd");
                                    $medid = $_POST['medicine'];
                                    $qty = $_POST['opened'] + $_POST['close'];
                                    $o = $_POST['opened'];
                                    $c = $_POST['close'];
                                    $cost = $_POST['unit_cost'];
                                    $exp = $_POST['expiration'];
                                    
                                    $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$lastdate' AND eqty != 0";    
                                    $result = mysqli_query($conn, $query0);
                                    // kunin values from row
                                    foreach($result as $data)
                                    {
                                        $obqty = $data['eqty'];
                                        $nobuc = $data['eamt'];

                                        $orqty = $qty;
                                        $tqty = $qty;

                                        $eqty = $obqty + $qty;
                                        $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                        $obuc = number_format($ucost, 2, ".");
                                        $ieamt = ($data['eamt'] + ($qty * $cost));
                                        $aeamt = number_format($ieamt, 2, ".");
                                    }
                                    
                                    $enddate = date("Y-m-t");
                                    //medadmin
                                    $query = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                    while($data=mysqli_fetch_array($query))
                                    {
                                        $medad = $data['med_admin'];
                                    }

                                    $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine', '$medad', '$medid', '$medicine', '$obqty', '$obuc', '$orqty', '$tqty', 0, '0.00', '$eqty', '$aeamt', '$enddate')";
                                    if(mysqli_query($conn, $query))
                                    {
                                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                        if($result = mysqli_query($conn, $sql))
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                        else
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                                else // no remaining stocks from last month
                                {
                                    
                                    $date = date("Y-m-t");
                                    $accountid = $_SESSION['userid'];
                                    $campus = $_SESSION['campus'];
                                    $adminid = $_POST['admin'];
                                    $batchid = "B" . date("Ymd");
                                    $medid = $_POST['medicine'];
                                    $qty = $_POST['opened'] + $_POST['close'];
                                    $o = $_POST['opened'];
                                    $c = $_POST['close'];
                                    $cost = $_POST['unit_cost'];
                                    $exp = $_POST['expiration'];
                                    
                                    $bqty = 0;
                                    $buc = 0;
                                    $rqty = $qty;
                                    $tqty = $qty;
                                    $iqty = 0;
                                    $iamt = 0;
                                    $eqty = $qty;
                                    $eamt = $qty * $cost;

                                    //medicine
                                    $query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
                                    while($data=mysqli_fetch_array($query))
                                    {
                                        $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
                                    }
                                    
                                    //med_admin
                                    $query0 = mysqli_query($conn, "SELECT * FROM med_admin WHERE id = '$adminid'");
                                    while($data=mysqli_fetch_array($query0))
                                    {
                                        $medad = $data['med_admin'];
                                    }

                                    $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'medicine', '$medad', '$medid', '$medicine', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                                    if(mysqli_query($conn, $query))
                                    {
                                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                        if($result = mysqli_query($conn, $sql))
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                        else
                                        {
                                            ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                            // modal message box saying "Medicine stocks was added."
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                            <script>
                                                setTimeout(function() {
                                                    window.location = "../med_stocks_batch.php";
                                                });
                                            </script>
                                            <?php
                                        // modal message box saying "Medicine stocks was added."
                                    }
                                }
                            }
                        }
                        else
                        {
                            ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../med_stocks_batch.php";
                                });
                            </script>
                            <?php
                            // modal message box saying "Medicine stocks was added."
                        }
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../med_stocks_batch.php";
                        });
                    </script>
                    <?php
                    // modal message box saying "Medicine stocks was added."
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../med_stocks_batch.php";
                    });
                </script>
                <?php
                // modal message box saying "Medicine stocks added."
            }
        }
    }
    else
    {
        // modal message box saying "Medicine stocks was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../med_stocks_batch.php";
    });
    </script>
<?php
}
mysqli_close($conn);