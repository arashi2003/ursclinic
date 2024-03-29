<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed expired stocks from the inventory";
    $au_status = "unread";
    
    // Update inventory_supply
    $sql = "SELECT * FROM inventory_supply WHERE id = '$id' AND campus='$campus' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    foreach($result as $data)
    {
        $exp_open = $data['open'];
        $exp_closed = $data['closed'];
        $exp_qty = $data['qty'];
        $supply = $data['supid'];
        $exp = $data['expiration'];
        $enddate=date('Y-m-t');

        // Update inventory_supply
        $query0 = "UPDATE inventory_supply SET open = 0, closed = 0, qty = 0 WHERE id = '$id' AND campus='$campus' AND expiration = '$exp'";
        mysqli_query($conn, $query0);
        // Update inv_total
        $query1 = "UPDATE inv_total SET open = open - '$exp_open', closed = closed - '$exp_closed', qty = qty - '$exp_qty' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
        mysqli_query($conn, $query1);
        // Update inventory
        $query2 = "UPDATE inventory SET opened=opened - '$exp_open', closed = closed - '$exp_closed', qty = qty - '$exp_qty' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration = '$exp'";
        mysqli_query($conn, $query2);
        // Update report_medsupinv
        $query3 = "SELECT * FROM report_medsupinv WHERE supid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus'";
        $result = mysqli_query($conn, $query3);
        while ($data = mysqli_fetch_array($result)) {
            // Update report_medsupinv
            $amount=$data['eamt'];
            $ending=$data['eqty'];
            $cost = $amount / $ending;

            $eqty = $ending - $exp_qty;
            $eamt = $cost * $eqty;

            $query4 = "UPDATE report_medsupinv SET eqty = '$eqty', eamt = '$eamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
            mysqli_query($conn, $query4);
        }
        
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Expired stocks has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_stocks_exp";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Expired stocks has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_stocks_exp";
                });
            </script>
            <?php
        }
    }
mysqli_close($conn);