<?php
session_start();
include('../connection.php');

$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$fullname = $_SESSION['name'];
$au_status = "unread";
$activity = "added medicine ID " . $_POST['medid'] . " inventory stocks";
$batchid = "B" . date("Ymd");
$medid = $_POST['medid'];
$qty = $_POST['quantity'];
$o = $_POST['opened'];
$c = $_POST['close'];

$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "updated medicine id " . $medid . " stocks in Medicine inventory";

//medicine
$query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
while ($data = mysqli_fetch_array($query)) {
    $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
}

// last day of this month
$date = date("Y-m-t");
$today = date("Y-m-d");

//update inventory total
$query0 = "UPDATE inventory_medicine SET closed = '$c', open = '$o', qty = '$qty' WHERE campus = '$campus' AND medid = '$medid' AND expiration > '$today' AND closed != 0 AND open != 0 AND qty != 0 LIMIT 1";
mysqli_query($conn, $query0);
// update inventory total
$query = "UPDATE inv_total SET open='$o', closed='$c', qty='$qty' WHERE stockid='$medid'";
mysqli_query($conn, $query);

//update inventory by batch
$query1 = "UPDATE inventory SET opened='$o', closed='$c', qty='$qty' WHERE campus = '$campus' AND stockid = '$medid' AND expiration > '$today' AND closed != 0 AND opened != 0 AND qty != 0 LIMIT 1";
mysqli_query($conn, $query1);

$medid = $_POST['medid'];
$qty = $_POST['opened'] + $_POST['close'];

//medicine
$query = mysqli_query($conn, "SELECT * FROM medicine WHERE medid = '$medid'");
while ($data = mysqli_fetch_array($query)) {
    $medicine = $data['medicine'] . " " . $data['dosage'] . $data['unit_measure'];
}

$campus = $_SESSION['campus'];
// last day of this month
$enddate = date("Y-m-t");
$medid = $_POST['medid'];

$query0 = "SELECT * FROM report_medsupinv WHERE medid = '$medid' AND type = 'medicine' AND date = '$enddate' AND campus='$campus'";
$result = mysqli_query($conn, $query0);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) // if may existing entry ung medicine sa reports
{
    while (($data = mysqli_fetch_array($result))) {
        // kunin values from row
        $qty = $_POST['opened'] + $_POST['close'];
        $aieamt = $data['eamt'];
        $cost = $data['buc'];

        if ($data['buc'] == 0) {
            $aobuc = 0;
            $abuc = number_format($aobuc, 2, ".");
        } else {
            $aobuc = $data['eamt'] / $data['eqty'];
            $abuc = number_format($aobuc, 2, ".");
        }

        if ($qty < $data['rqty']) {
            $iqty = $data['rqty'] - $qty;
            $iamt = $iqty * $aobuc;

            $arqty = $data['rqty'];
            $tqty = $data['tqty'];
            $eqty = $data['eqty'] - $qty;
            $aeamt = $data['eamt'] - $iamt;
        } elseif ($qty > $data['rqty']) {
            $iqty = $data['iqty'];
            $iamt = $data['iamt'];

            $arqty = $data['rqty'] + ($qty - $data['rqty']);
            $tqty = $data['tqty'] + $qty;

            $aieqty = $data['eqty'];

            $eqty = $qty + $aieqty;
            $ucost = $eqty * $aobuc;
            $aeamt = number_format($ucost, 2, ".");
        } else {
            $iamt = $data['iamt'];
            $iqty = $data['iqty'];

            $arqty = $data['rqty'];
            $tqty = $data['tqty'];
            $eqty = $data['eqty'] - $qty;
            $aeamt = $data['eamt'] - $iamt;
        }
    }

    $medid = $_POST['medid'];
    $enddate = date("Y-m-t");

    $query = "UPDATE report_medsupinv SET rqty = '$arqty', tqty = '$tqty', iqty='$iqty', iamt='$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$medid' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
    if (mysqli_query($conn, $query)) {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if ($result = mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = "Medicine Stocks has been updated.";
?>
            <script>
                setTimeout(function() {
                    window.location = "../../med_stocks_total";
                });
            </script>
        <?php
        } else {
            $_SESSION['alert'] = "Medicine Stocks has been updated.";
        ?>
            <script>
                setTimeout(function() {
                    window.location = "../../med_stocks_total";
                });
            </script>
        <?php
        }
    } else {
        $_SESSION['alert'] = "Medicine Stocks has been updated.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../med_stocks_total";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Medicine Stocks was not updated.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../med_stocks_total";
        });
    </script>
<?php
}
mysqli_close($conn);
