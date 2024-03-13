<?php
    session_start();
    include('../connection.php');
    
    $accountid = $_SESSION['userid'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = $_SESSION['name'];
    $au_status = "unread";
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
    $activity = "updated supply id " . $medid . " stocks in medical supply inventory";
 
    //supply
    $query = mysqli_query($conn, "SELECT * FROM supply WHERE supid = '$medid'");
    while($data=mysqli_fetch_array($query))
    {
        $supply = $data['supply'] . " " . $data['volume'] . $data['unit_measure'];
    }

    // last day of this month
    $date = date("Y-m-t");
    $today = date("Y-m-d");

    //update inventory total
    $query0 = "UPDATE inventory_supply SET closed = '$c', open = '$o', qty = '$qty' WHERE campus = '$campus' AND supid = '$medid' AND expiration > '$today' AND closed != 0 AND open != 0 AND qty != 0 LIMIT 1";
    if(mysqli_query($conn, $query0))
    {
        // update inventory total
        $query = "UPDATE inv_total SET open='$o', closed='$c', qty='$qty' WHERE stockid='$medid'";
        if(mysqli_query($conn, $query))
        {
            //update inventory by batch
            $query1 = "UPDATE inventory SET opened='$o', closed='$c', qty='$qty' WHERE campus = '$campus' AND stockid = '$medid' AND expiration > '$today' AND closed != 0 AND open != 0 AND qty != 0 LIMIT 1";
            if(mysqli_query($conn, $query1))
            {
                $accountid = $_SESSION['userid'];
                $medid = $_POST['supply'];
                $qty = $_POST['opened'] + $_POST['close'];
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
                                    window.location = "../../sup_stocks_total.php";
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
                                    window.location = "../../sup_stocks_total.php";
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
                                    window.location = "../../sup_stocks_total.php";
                                });
                            </script>
                            <?php
                        // modal message box saying "Medical Supply stocks was added."
                    }
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../sup_stocks_total.php";
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
                    window.location = "../../sup_stocks_total.php";
                });
            </script>
            <?php
            // modal message box saying "Medical Supply stocks was added."
        }
    }
    else
    {
        // modal message box saying "Medical Supply stocks was not added."  
?>
<script>
    setTimeout(function() {
        window.location = "../../sup_stocks_total.php";
    });
    </script>
<?php
    }
mysqli_close($conn);