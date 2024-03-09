<?php
    session_start();
    include('connection.php');
    
    $accountid = $_SESSION['accountid'];
    $user = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $fullname = $_SESSION['name'];
    $activity = "added supply ID " . $_POST['supply'] . " inventory stocks";
    $batchid = "B" . date("Ymd");
    $medid = $_POST['supply'];
    $qty = $_POST['opened'] + $_POST['close'];
    $o = $_POST['opened'];
    $c = $_POST['close'];
    $cost = $_POST['unit_cost'];
    $exp = $_POST['expiration'];

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
            $query = "SELECT * FROM inv_total WHERE stockid = '$medid' AND type = 'medicine' AND campus='$au_campus'";
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
                    $accountid = 'URSN-001';
                    $medid = $_POST['supply'];
                    $qty = $_POST['opened'] + $_POST['close'];
                    $cost = $_POST['unit_cost'];
                    
                    $conn = mysqli_connect("localhost","root","","dburs_usu");
                    if ($conn==false) 
                    {
                        echo "ERROR: Failed to connect to the database,". mysqli_connect_error();
                    }

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

                        $query = "UPDATE report_medsupinv SET campus = '$campus', buc = '$abuc', rqty = '$arqty', tqty = '$tqty', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'supply'";
                        if(mysqli_query($conn, $query))
                        {
                            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
                            if($result = mysqli_query($conn, $sql))
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_batch.php";
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
                                        window.location = "../sup_stocks_batch.php";
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
                                        window.location = "../sup_stocks_batch.php";
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
                                $qty = $_POST['opened'] + $_POST['close'];
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
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_batch.php";
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
                                            window.location = "../sup_stocks_batch.php";
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
                                            window.location = "../sup_stocks_batch.php";
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

                            //supply
                            $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                            }
                            
                            $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'supply', '0', '$medid', '$supply', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                            if(mysqli_query($conn, $query))
                            {
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_batch.php";
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
                                            window.location = "../sup_stocks_batch.php";
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
                                        window.location = "../sup_stocks_batch.php";
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
                            window.location = "../sup_stocks_batch.php";
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
                        window.location = "../sup_stocks_batch.php";
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
                    $accountid = 'URSN-001';
                    $medid = $_POST['supply'];
                    $qty = $_POST['opened'] + $_POST['close'];
                    $cost = $_POST['unit_cost'];
                    
                    $conn = mysqli_connect("localhost","root","","dburs_usu");
                    if ($conn==false) 
                    {
                        echo "ERROR: Failed to connect to the database,". mysqli_connect_error();
                    }

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

                        $query = "UPDATE report_medsupinv SET campus = '$campus', buc = '$abuc', rqty = '$arqty', tqty = '$tqty', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'supply'";
                        if(mysqli_query($conn, $query))
                        {
                            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
                            if($result = mysqli_query($conn, $sql))
                            {
                                ?>
                                <script>
                                    setTimeout(function() {
                                        window.location = "../sup_stocks_batch.php";
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
                                        window.location = "../sup_stocks_batch.php";
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
                                        window.location = "../sup_stocks_batch.php";
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
                                $qty = $_POST['opened'] + $_POST['close'];
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
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_batch.php";
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
                                            window.location = "../sup_stocks_batch.php";
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
                                            window.location = "../sup_stocks_batch.php";
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

                            //supply
                            $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
                            while($data=mysqli_fetch_array($query))
                            {
                                $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
                            }
                            
                            $query = "INSERT INTO report_medsupinv (campus, type, admin, medid, medicine, bqty, buc, rqty, tqty, iqty, iamt, eqty, eamt, date) VALUES ('$campus', 'supply', '0', '$medid', '$supply', '$bqty', '$buc', '$rqty', '$tqty', '$iqty', '$iamt', '$eqty', '$eamt', '$date')";
                            if(mysqli_query($conn, $query))
                            {
                                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
                                if($result = mysqli_query($conn, $sql))
                                {
                                    ?>
                                    <script>
                                        setTimeout(function() {
                                            window.location = "../sup_stocks_batch.php";
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
                                            window.location = "../sup_stocks_batch.php";
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
                                        window.location = "../sup_stocks_batch.php";
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
                            window.location = "../sup_stocks_batch.php";
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
                        window.location = "../sup_stocks_batch.php";
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
        window.location = "../sup_stocks_batch.php";
    });
    </script>
<?php
    }
mysqli_close($conn);