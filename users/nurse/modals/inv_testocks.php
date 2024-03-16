<?php
    session_start();
    include('connection.php');

    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = $_SESSION['name'];
    $activity = "added tool/equipment ID " . $_POST['te'] . " inventory stocks";
    $batchid = "B" . date("Ymd");
    $teid = $_POST['te'];
    $qty = 1;
    $o = 0;
    $c = 0;
    $cost = $_POST['unit_cost'];
    $exp = "";
    $status = $_POST['status'];
    $au_status = "unread";
    
    //te
    $query = mysqli_query($conn, "SELECT * FROM tools_equip WHERE teid = '$teid'");
    while($data=mysqli_fetch_array($query))
    {
        $te = $data['tools_equip'];
    }
    //te_status id
    $query = mysqli_query($conn, "SELECT * FROM te_status WHERE id = '$status'");
    while($data=mysqli_fetch_array($query))
    {
        $statusid = $data['te_status'];
    }


    // last day of this month
    $date = date("Y-m-t");

    //add inventory total
    $query0 = "INSERT INTO inventory_te (campus, teid, qty, unit_cost, status, date, time) VALUES ('$campus', '$teid', '$qty', '$cost', '$status', now(), now())";
    if(mysqli_query($conn, $query0))
    {
        //add inventory by batch
        $query1 = "INSERT INTO inventory (campus, stock_type, batchid, stockid, closed, opened, qty, unit_cost, expiration, date, time)VALUES ('$campus', 'te', '$batchid', '$teid', '$c', '$o', '$qty', '$cost', '$exp', now(), now())";
        if(mysqli_query($conn, $query1))
        {
            $accountid = $_SESSION['userid'];
            $campus = $_SESSION['campus'];
             
            $qty = 1;
            $cost = $_POST['unit_cost'];
            $status = $_POST['status'];

            //te
            $query = mysqli_query($conn, "SELECT * FROM tools_equip WHERE teid = '$teid'");
            while($data=mysqli_fetch_array($query))
            {
                $te = $data['tools_equip'];
            }
            
            // last day of this month
            $enddate = date("Y-m-t");
             

            $query0 = "SELECT * FROM report_teinv  WHERE teid = '$teid' AND date = '$enddate' AND campus = '$campus'";    
            $result = mysqli_query($conn, $query0);
            $resultCheck = mysqli_num_rows($result);
            // if may existing entry ung te sa reports

            if($resultCheck > 0)
            {   
                // kunin values from row
                while($data=mysqli_fetch_array($result))
                {
                    $bnw = $data['bnw'];
                    $bum = $data['bum'];
                    $bgc = $data['bgc'];
                    $bd = $data['bd'];

                    if ($status == 1) //Good Condition
                    {
                        $rgc = $data['rgc'] + $qty;
                        $egc = $data['egc'] + $qty;

                        $rnw = $data['rnw'];
                        $rum = $data['rum'];
                        $rd = $data['rd'];
                        $enw = $data['enw'];
                        $eum = $data['eum'];
                        $ed = $data['ed'];
                    }
                    else if ($status == 2) //Not Working
                    {
                        $rnw = $data['rnw'] + $qty;
                        $enw = $data['enw'] + $qty;

                        $rum = $data['rum'];
                        $rgc = $data['rgc'];
                        $rd = $data['rd'];
                        $eum = $data['eum'];
                        $egc = $data['egc'];
                        $ed = $data['ed'];
                    }
                    else if ($status == 3) //Damaged
                    {
                        $rd = $data['rd'] + $qty;
                        $ed = $data['ed'] + $qty;

                        $rnw = $data['rnw'];
                        $rum = $data['rum'];
                        $rgc = $data['rgc'];
                        $enw = $data['enw'];
                        $eum = $data['eum'];
                        $egc = $data['egc'];
                    }
                    else //Under Maintenance
                    {
                        $rum = $data['rum'] + $qty;
                        $eum = $data['eum'] + $qty;

                        $rnw = $data['rnw'];
                        $rgc = $data['rgc'];
                        $rd = $data['rd'];
                        $enw = $data['enw'];
                        $egc = $data['egc'];
                        $ed = $data['ed'];
                    }

                    $rtqty = $data['rtqty'] + $qty;
                    $no_btqty = $data['btqty'];
                    $etqty = $data['etqty'] + $qty;

                    if ($data['btqty'] == 0 )
                    {
                        $buc = 0;
                        $no_buc = ($data['eamt'] + ($qty * $cost)) / $etqty;
                        $eamt = $no_buc * $etqty;
                    }
                    else
                    {
                        $buc = $data['buc'];
                        $no_buc = (($buc * $no_btqty) + ($qty * $cost)) / $etqty;
                        $eamt = $no_buc * $etqty;
                    }
                }
                 
                $enddate = date("Y-m-t");

                $query = "UPDATE report_teinv SET bnw = '$bnw', bum = '$bum', bgc = '$bgc', bd = '$bd', btqty = '$no_btqty', buc = '$buc', rnw = '$rnw', rum = '$rum', rgc = '$rgc', rd = '$rd', rtqty = '$rtqty', enw = '$enw', eum = '$eum', egc = '$egc', ed = '$ed', etqty = '$etqty', eamt = '$eamt' WHERE teid = '$teid' AND date = '$enddate' AND campus = '$campus'";
                if(mysqli_query($conn, $query))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                    if($result = mysqli_query($conn, $sql))
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../te_stocks.php";
                            });
                            </script>
                        <?php
                        // modal message box saying "Tool/Equipment stocks added."
                    }
                    else
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../te_stocks.php";
                            });
                            </script>
                        <?php
                        //modal message box saying "Tool/Equipment stocks added."
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../te_stocks.php";
                        });
                        </script>
                    <?php
                    // modal message box saying "Tool/Equipment stocks added."
                }
            }

            // if walang existing entry ung te sa reports
            else
            {
                $lastdate = date("Y-m-t", strtotime("- 1 month"));
                
                $query0 = "SELECT * FROM report_teinv  WHERE teid = '$teid' AND date = '$lastdate' AND etqty != 0";    
                $result = mysqli_query($conn, $query0);
                $resultCheck = mysqli_num_rows($result);
                // if may remaining stocks pa from previous month

                if($resultCheck > 0)
                {   
                    $qty = 1;
                    $cost = $_POST['unit_cost'];
                    
                    // kunin values from row
                    while($data=mysqli_fetch_array($result))
                    {
                        $bnw = $data['enw'];
                        $bum = $data['eum'];
                        $bgc = $data['egc'];
                        $bd = $data['ed'];

                        if ($status == 1) //Good Condition
                        {
                            $rgc = $data['rgc'] + $qty;
                            $egc = $data['egc'] + $qty;

                            $rnw = $data['rnw'];
                            $rum = $data['rum'];
                            $rd = $data['rd'];
                            $enw = $data['enw'];
                            $eum = $data['eum'];
                            $ed = $data['ed'];
                        }
                        else if ($status == 2) //Not Working
                        {
                            $rnw = $data['rnw'] + $qty;
                            $enw = $data['enw'] + $qty;

                            $rum = $data['rum'];
                            $rgc = $data['rgc'];
                            $rd = $data['rd'];
                            $eum = $data['eum'];
                            $egc = $data['egc'];
                            $ed = $data['ed'];
                        }
                        else if ($status == 3) //Damaged
                        {
                            $rd = $data['rd'] + $qty;
                            $ed = $data['ed'] + $qty;

                            $rnw = $data['rnw'];
                            $rum = $data['rum'];
                            $rgc = $data['rgc'];
                            $enw = $data['enw'];
                            $eum = $data['eum'];
                            $egc = $data['egc'];
                        }
                        else //Under Maintenance
                        {
                            $rum = $data['rum'] + $qty;
                            $eum = $data['eum'] + $qty;

                            $rnw = $data['rnw'];
                            $rgc = $data['rgc'];
                            $rd = $data['rd'];
                            $enw = $data['enw'];
                            $egc = $data['egc'];
                            $ed = $data['ed'];
                        }

                        $rtqty = $qty;
                        $etqty = $data['etqty'] + $qty;
                        $btqty = $data['etqty'];

                        $no_buc = $data['eamt'];
                        $ucost = (($no_buc * $no_btqty) + ($qty * $cost)) / $etqty;
                        $buc = number_format($ucost, 2, ".");
                        $aieamt = $ucost * $etqty;
                        $eamt = number_format($aieamt, 2, ".");
                    }
                     
                    $enddate = date("Y-m-t");

                    $query = "INSERT INTO report_teinv (campus, teid, tools_equip, bnw, bum, bgc, bd, btqty, buc, rnw, rum, rgc, rd, rtqty, enw, eum, egc, ed, etqty, eamt, date) VALUES ('$campus', '$teid', '$te', '$bnw', '$bum', '$bgc', '$bd', '$btqty', '$buc', '$rnw', '$rum', '$rgc', '$rd', '$rtqty', '$enw', '$eum', '$egc', '$ed', '$etqty', '$eamt', '$enddate')";
                    if(mysqli_query($conn, $query))
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../te_stocks.php";
                            });
                            </script>
                        <?php
                        // modal message box saying "Tool/Equipment stocks added."
                    }
                    else
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../te_stocks.php";
                            });
                            </script>
                        <?php
                        //modal message box saying "Tool/Equipment stocks added"
                    }
                }
                else
                {
                    // no remaining stocks from last month
                    $date = date("Y-m-t");
                     
                    $qty = 1;
                    $cost = $_POST['unit_cost'];
                    $status = $_POST['status'];
                    $bnw = 0;
                    $bum = 0;
                    $bgc = 0;
                    $bd = 0;

                    if ($status == 1) //Good Condition
                    {
                        $rgc = $qty;
                        $egc = $qty;

                        $rnw = 0;
                        $rum = 0;
                        $rd = 0;
                        $enw = 0;
                        $eum = 0;
                        $ed = 0;
                    }
                    else if ($status == 2) //Not Working
                    {
                        $rnw = $qty;
                        $enw = $qty;

                        $rum = 0;
                        $rgc = 0;
                        $rd = 0;
                        $eum = 0;
                        $egc = 0;
                        $ed = 0;
                    }
                    else if ($status == 3) //Damaged
                    {
                        $rd = $qty;
                        $ed = $qty;

                        $rnw = 0;
                        $rum = 0;
                        $rgc = 0;
                        $enw = 0;
                        $eum = 0;
                        $egc = 0;
                    }
                    else //Under Maintenance
                    {
                        $rum = $qty;
                        $eum = $qty;

                        $rnw = 0;
                        $rgc = 0;
                        $rd = 0;
                        $enw = 0;
                        $egc = 0;
                        $ed = 0;
                    }

                    $rtqty = $qty;
                    $btqty = 0;
                    $etqty = $qty;
                    $buc = $cost;
                    $eamt = $cost * $qty;

                    //te
                    $query = mysqli_query($conn, "SELECT * FROM tools_equip WHERE teid = '$teid'");
                    while($data=mysqli_fetch_array($query))
                    {
                        $te = $data['tools_equip'];
                    }
                    
                    $query = "INSERT INTO report_teinv (campus, teid, tools_equip, bnw, bum, bgc, bd, btqty, buc, rnw, rum, rgc, rd, rtqty, enw, eum, egc, ed, etqty, eamt, date) VALUES ('$campus', '$teid', '$te', '$bnw', '$bum', '$bgc', '$bd', '$btqty', 0, '$rnw', '$rum', '$rgc', '$rd', '$rtqty', '$enw', '$eum', '$egc', '$ed', '$etqty', '$eamt', '$enddate')";
                    if(mysqli_query($conn, $query))
                    {
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                        if($result = mysqli_query($conn, $sql))
                        {
                            ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../te_stocks.php";
                                });
                                </script>
                            <?php
                            // modal message box saying "Tool/Equipment stocks added."
                        }
                        else
                        {
                            ?>
                            <script>
                                setTimeout(function() {
                                    window.location = "../te_stocks.php";
                                });
                                </script>
                            <?php
                            //modal message box saying "Tool/Equipment stocks added."
                        }
                    }
                    else
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../te_stocks.php";
                            });
                            </script>
                        <?php
                        // modal message box saying "Tool/Equipment was not stocks added."
                    }
                }
            }
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../te_stocks.php";
                });
                </script>
            <?php
            // modal message box saying "Tool/Equipment was not stocks added."
        }
    }
    else
    {
        // modal message box saying "Tool/Equipment was not stocks added."
?>
<script>
    setTimeout(function() {
        window.location = "../te_stocks.php";
    });
    </script>
<?php
    }
mysqli_close($conn);