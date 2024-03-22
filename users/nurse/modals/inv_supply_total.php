<?php
    session_start();
    include('connection.php');
    
    $accountid = $_SESSION['userid'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = $_SESSION['name'];
    $au_status = "unread";
    $activity = "added supply ID " . $_POST['supply'] . " inventory stocks";
    $batchid = "B" . date("Ymd");
    $medid = $_POST['supply'];
    $o = implode($_POST['opened']);
    $c = implode($_POST['close']);
    $qty = floatval($o) + floatval($c);
    $cost = $_POST['unit_cost'];
    $exp = date("Y-m-t", strtotime($_POST['expiration']));

    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added supply id " . $medid . " stocks in medical supply inventory";
 
    //supply
    $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
    while($data=mysqli_fetch_array($query))
    {
        $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
    }

    // last day of this month
    $date = date("Y-m-t");

    //add inventory total
    $query0 = "INSERT INTO inventory_supply (campus, supid, closed, open, qty, unit_cost, expiration, date, time) VALUES ('$campus', '$medid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
    if(mysqli_query($conn, $query0))
    {
        $query = "SELECT * FROM inv_total WHERE stockid = '$medid' AND type = 'supply' AND campus='$au_campus'";
        $result=mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0)
        {
            $query = "SELECT * FROM inv_total WHERE stockid = '$medid' AND type = 'supply' AND campus='$au_campus' LIMIT 1";
            $result=mysqli_query($conn, $query);
            foreach($result as $data)
            {
                $ucost = (($cost*$qty) + ($data['unit_cost'] * $data['qty'])) / ($data['qty'] + $qty);
            }
            
            // add inventory total
            $query = "UPDATE inv_total SET open=open + '$o', closed= closed + '$c', qty=qty + '$qty', unit_cost='$ucost', datetime=now() WHERE stockid='$medid'";
            if(mysqli_query($conn, $query))
            {
                //add inventory by batch
                $query1 = "INSERT INTO inventory (campus, stock_type, batchid, stockid, closed, opened, qty, unit_cost, expiration, date, time)VALUES ('$campus', 'supply', '$batchid', '$medid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
                if(mysqli_query($conn, $query1))
                {
                    //session accountid of nurse
                    $accountid = $_SESSION['userid'];
                    $medid = $_POST['supply'];
                    $o = implode($_POST['opened']);
                    $c = implode($_POST['close']);
                    $qty = floatval($o) + floatval($c);
                    $cost = $_POST['unit_cost'];
                    
                    //supply
                    $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                    while($data=mysqli_fetch_array($query))
                    {
                        $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                    }
                    
                    $campus = $_SESSION['campus'];
                    // last day of this month
                    $enddate = date("Y-m-t");
                    $medid = $_POST['supply'];

                    $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'supply' AND date = '$enddate'";    
                    $result = mysqli_query($conn, $query0);
                    $resultCheck = mysqli_num_rows($result);
                    
                    if($resultCheck > 0) // if may existing entry ung supply sa reports
                    {   
                        $campus = $_SESSION['campus'];
                        $medid = $_POST['supply'];
                        
                        $o = implode($_POST['opened']);
                        $c = implode($_POST['close']);
                        $cost = $_POST['unit_cost'];
                        $exp = $_POST['expiration'];
                        $enddate = date("Y-m-t");
                        
                        $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'supply' AND date = '$enddate'";    
                        $result = mysqli_query($conn, $query0);
                        // kunin values from row
                        foreach($result as $data)
                        {
                            $o = implode($_POST['opened']);
                            $c = implode($_POST['close']);
                            $qty = floatval($o) + floatval($c);
                            $aobqty = $data['bqty'];
                            $aorqty = $data['rqty'];
                            $aotqty = $data['tqty'];
                            $aieqty = $data['eqty'];
                            $aieamt = $data['eamt'];
                            $aiiqty = $data['iqty'];
                            $aiiamt = $data['iamt'];
                            
                            $arqty = $aorqty + $qty;
                            $tqty = $aotqty + $qty;
                            $eqty = $qty + $data['eqty'];

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
                            
                            if($data['iqty'] == 0)
                            {
                                $iamt = 0;
                                $iqty = 0;
                            }
                            else
                            {
                                $iamt = $data['iqty'] * $aobuc;
                                $iqty = $data['iqty'];
                            }
                        }

                        $query1 = "SELECT unit_cost FROM inv_total WHERE stockid = '$medid' AND type = 'supply'";    
                        $result = mysqli_query($conn, $query1);
                        // kunin values from row
                        foreach($result as $data)
                        {
                            $aeamt = $data['unit_cost'] * $eqty;
                        }

                        $medid = $_POST['supply'];
                        $enddate = date("Y-m-t");
                        //supply
                        $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                        while($data=mysqli_fetch_array($query))
                        {
                            $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                        }

                        $query = "UPDATE report_medsupinv SET buc = '$abuc', rqty = '$arqty', tqty = '$tqty', iqty='$iqty', 
                        iamt='$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                        if(mysqli_query($conn, $query))
                        {
                            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                            if($result = mysqli_query($conn, $sql))
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                            else
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                        }
                        else
                        {
                            ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                            // modal message box saying "Medical Supply stocks was added."
                        }
                    }
                    // if walang existing entry ung supply sa reports
                    else
                    {
                        $lastdate = date("Y-m-t", strtotime("- 1 month"));
                        $medid = $_POST['supply'];

                        $query = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'supply' AND date = '$lastdate' AND eqty != 0 AND admin = 0 AND campus = '$campus'";    
                        $result = mysqli_query($conn, $query);
                        $resultCheck = mysqli_num_rows($result);
                        
                        if($resultCheck > 0) // if may remaining stocks pa from previous month
                        {   
                            // kunin values from row
                            while($data=mysqli_fetch_array($result))
                            {
                                $o = implode($_POST['opened']);
                                $c = implode($_POST['close']);
                                $qty = floatval($o) + floatval($c);
                                $cost = $_POST['unit_cost'];
                                $obqty = $data['eqty'];
                                $nobuc = $data['eamt'];

                                $orqty = $qty;
                                $tqty = $qty;

                                $eqty = $obqty + $qty;
                                $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                $obuc = number_format($ucost, 2, ".");
                                $ieamt = $obuc * $eqty;
                            }

                            $medid = $_POST['supply'];
                            $enddate = date("Y-m-t");

                            $query = "INSERT INTO report_medsupinv 
                            (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES 
                            ('$campus', 'supply', 0, '$medid', '$supply', '$obqty', '$obuc', '$orqty', '$tqty', 0, '0.00', '$eqty', '$ieamt', '$date')";
                            if(mysqli_query($conn, $query))
                            {
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                                else
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                            }
                            else
                            {
                                ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                        }
                        else // no remaining stocks from last month
                        {
                            $date = date("Y-m-t");
                            $medid = $_POST['supply'];
                            $o = implode($_POST['opened']);
                            $c = implode($_POST['close']);
                            $qty = floatval($o) + floatval($c);
                            $cost = $_POST['unit_cost'];
                            
                            $bqty = 0;
                            $buc = 0;
                            $rqty = $qty;
                            $tqty = $qty;
                            $iqty = 0;
                            $iamt = 0;
                            $eqty = $qty;
                            $eamt = $qty * $cost;

                            //supply
                            $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                            }
                            
                            $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'supply', '0', '$medid', '$supply', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                            if(mysqli_query($conn, $query))
                            {
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                                else
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                            }
                            else
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                        }
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../sup_stocks_total.php";
                        });
                    </script>
                    <?php
                    // modal message box saying "Medical Supply stocks was added."
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../sup_stocks_total.php";
                    });
                </script>
                <?php
                // modal message box saying "Medical Supply stocks was added."
            }
        }
        else
        {
            //add inventory total
            $query = "INSERT INTO inv_total (campus, type, stockid, stock_name, open, closed, qty, unit_cost, datetime) VALUES ('$au_campus', 'supply', '$medid', '$supply', '$o', '$c', '$qty', '$cost', now())";
            if(mysqli_query($conn, $query))
            {
                //add inventory by batch
                $query1 = "INSERT INTO inventory (campus, stock_type, batchid, stockid, closed, opened, qty, unit_cost, expiration, date, time)VALUES ('$campus', 'supply', '$batchid', '$medid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
                if(mysqli_query($conn, $query1))
                {
                    //session accountid of nurse
                    $accountid = $_SESSION['userid'];
                    $medid = $_POST['supply'];
                    $o = implode($_POST['opened']);
                    $c = implode($_POST['close']);
                    $qty = floatval($o) + floatval($c);
                    $cost = $_POST['unit_cost'];
                    
                    //supply
                    $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                    while($data=mysqli_fetch_array($query))
                    {
                        $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                    }
                    
                    $campus = $_SESSION['campus'];
                    // last day of this month
                    $enddate = date("Y-m-t");
                    $medid = $_POST['supply'];

                    $query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'supply' AND date = '$enddate'";    
                    $result = mysqli_query($conn, $query0);
                    $resultCheck = mysqli_num_rows($result);
                    
                    if($resultCheck > 0) // if may existing entry ung supply sa reports
                    {   
                        while(($data=mysqli_fetch_array($result)))
                        {
                            // kunin values from row
                            $o = implode($_POST['opened']);
                            $c = implode($_POST['close']);
                            $qty = floatval($o) + floatval($c);
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

                            if($data['iqty'] == 0)
                            {
                                $iamt = 0;
                                $iqty = 0;
                            }
                            else
                            {
                                $iamt = $data['iqty'] * $aobuc;
                                $iqty = $data['iqty'];
                            }

                            $ucost = ($data['eamt'] + ($qty * $cost));
                            $aeamt = number_format($ucost, 2, ".");
                        }

                        $medid = $_POST['supply'];
                        $enddate = date("Y-m-t");
                        //supply
                        $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                        while($data=mysqli_fetch_array($query))
                        {
                            $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                        }

                        $query = "UPDATE report_medsupinv SET buc = '$abuc', rqty = '$arqty', tqty = '$tqty', iqty='$iqty', iamt='$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                        if(mysqli_query($conn, $query))
                        {
                            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                            if($result = mysqli_query($conn, $sql))
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                            else
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                        }
                        else
                        {
                            ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                            // modal message box saying "Medical Supply stocks was added."
                        }
                    }
                    // if walang existing entry ung supply sa reports
                    else
                    {
                        $lastdate = date("Y-m-t", strtotime("- 1 month"));
                        $medid = $_POST['supply'];

                        $query = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'supply' AND date = '$lastdate' AND eqty != 0 AND admin = 0";    
                        $result = mysqli_query($conn, $query);
                        $resultCheck = mysqli_num_rows($result);
                        
                        if($resultCheck > 0) // if may remaining stocks pa from previous month
                        {   
                            // kunin values from row
                            while($data=mysqli_fetch_array($result))
                            {
                                $o = implode($_POST['opened']);
                                $c = implode($_POST['close']);
                                $qty = floatval($o) + floatval($c);
                                $cost = $_POST['unit_cost'];
                                $obqty = $data['eqty'];
                                $nobuc = $data['eamt'];

                                $orqty = $qty;
                                $tqty = $qty;

                                $eqty = $obqty + $qty;
                                $ucost = ($data['eamt'] + ($qty * $cost)) / $eqty;
                                $obuc = number_format($ucost, 2, ".");
                                $ieamt = $obuc * $eqty;
                            }

                            $medid = $_POST['supply'];
                            $enddate = date("Y-m-t");

                            $query = "INSERT INTO report_medsupinv 
                            (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES 
                            ('$campus', 'supply', 0, '$medid', '$supply', '$obqty', '$obuc', '$orqty', '$tqty', 0, '0.00', '$eqty', '$ieamt', '$date')";
                            if(mysqli_query($conn, $query))
                            {
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                                else
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                            }
                            else
                            {
                                ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                        }
                        else // no remaining stocks from last month
                        {
                            $date = date("Y-m-t");
                            $medid = $_POST['supply'];
                            $o = implode($_POST['opened']);
                            $c = implode($_POST['close']);
                            $qty = floatval($o) + floatval($c);
                            $cost = $_POST['unit_cost'];
                            
                            $bqty = 0;
                            $buc = 0;
                            $rqty = $qty;
                            $tqty = $qty;
                            $iqty = 0;
                            $iamt = 0;
                            $eqty = $qty;
                            $eamt = $qty * $cost;

                            //supply
                            $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                            }
                            
                            $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'supply', '0', '$medid', '$supply', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                            if(mysqli_query($conn, $query))
                            {
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                                else
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_total.php";
                                        });
                                    </script>
                                    <?php
                                    // modal message box saying "Medical Supply stocks was added."
                                }
                            }
                            else
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_total.php";
                                    });
                                </script>
                                <?php
                                // modal message box saying "Medical Supply stocks was added."
                            }
                        }
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../sup_stocks_total.php";
                        });
                    </script>
                    <?php
                    // modal message box saying "Medical Supply stocks was added."
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../sup_stocks_total.php";
                    });
                </script>
                <?php
                // modal message box saying "Medical Supply stocks was added."
            }
        }
    }
    else
    {
        // modal message box saying "Medical Supply stocks was not added."  
?>
<script>
    setTimeout(function() {
        window.location = "../sup_stocks_total.php";
    });
    </script>
<?php
    }
mysqli_close($conn);