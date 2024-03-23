<?php
session_start();
include('connection.php');

// CHANGE VARIABLES HOYYYYYYYYYY !!!!!!!!!!!!!!!!!!!!

//$campus = $_SESSION['campus'];
$today = date("Y-m-d");
//$endmonth = date("Y-m-t");
//$lastmonth = date("Y-m-t", strtotime("- 1 month"));
//$month = "January 2024";
$month = "March 2024";
$endmonth =  date("Y-m-t", strtotime($month));
$lastmonth = date("Y-m-t", strtotime("$endmonth - 1 month"));

//$campus = "ANGONO";
//$campus = "ANTIPOLO";
//$campus = "CAINTA";
//$campus = "CARDONA";
$campus = "BINANGONAN";
//$campus = "MORONG";
//$campus = "PILILLA";
//$campus = "RODRIGUEZ";
//$campus = "TANAY";
//$campus = "TAYTAY";


//truncate muna lahat bago i-run ng official !!!!!!!!!!!


//auto report supply in medsupinv
$query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND eqty > 0 AND type = 'supply' AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    echo "meron ";
    foreach ($result as $data) {
        $medid = $data['medid'];
        $medicine = $data['medicine'];
        echo "which is " . $medicine;
        $query = "SELECT * FROM report_medsupinv WHERE date = '$endmonth' AND medid = '$medid' AND type = 'supply' AND campus='$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND medid = '$medid' AND type = 'supply' AND campus='$campus'";
            $result = mysqli_query($conn, $query);
            while ($data = mysqli_fetch_array($result)) {
                $bqty = $data['eqty'];
                $buc = $data['eamt'] / $data['eqty'];
                $eqty = $data['eqty'];
                $eamt = $data['eamt'];
                $admin = 0;

                $sql = "INSERT INTO report_medsupinv SET campus = '$campus', type = 'supply', admin = '$admin', medid = '$medid', medicine = '$medicine', bqty = '$bqty', buc = '$buc', eqty = '$eqty', eamt = '$eamt', date = '$endmonth'";
                //mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql)) {
                    echo ", nalagyan na ng entry ";
                } else {
                    echo ", di nalagyan na ng entry <p>";
                }
            }
        }
        echo " for this month <p>";
    }
} else {
    echo "yow sup <p>";
}


//auto report med in medsupinv
$query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND eqty > 0 AND type = 'medicine' AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    echo "meron ";
    foreach ($result as $data) {
        $medid = $data['medid'];
        $medicine = $data['medicine'];
        $admin = $data['admin'];
        echo "which is " . $medicine;

        $query = "SELECT * FROM report_medsupinv WHERE date = '$endmonth' AND medid = '$medid' AND type = 'medicine' AND campus='$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND medid = '$medid' AND type = 'medicine' AND eqty !=0 AND eamt !=0 AND campus='$campus'";
            $result = mysqli_query($conn, $query);
            while ($data = mysqli_fetch_array($result)) {
                $bqty = $data['eqty'];
                $buc = $data['eamt'] / $data['eqty'];
                echo $eqty = $data['eqty'];
                echo $eamt = $data['eamt'];
                $admin = $data['admin'];

                $sql = "INSERT INTO report_medsupinv SET campus = '$campus', type = 'medicine', admin = '$admin', medid = '$medid', medicine = '$medicine', bqty = '$bqty', buc = '$buc', eqty = '$eqty', eamt = '$eamt', date = '$endmonth'";
                //mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql)) {
                    echo ", nalagyan na ng entry ";
                } else {
                    echo ", di nalagyan na ng entry <p>";
                }
            }
        }
        echo "for this month <p>";
    }
} else {
    echo "yow med <p>";
}

//auto report teinv
$query = "SELECT * FROM report_teinv WHERE date = '$lastmonth' AND etqty > 0 AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    echo "meron ";
    foreach ($result as $data) {
        $teid = $data['teid'];
        $tools_equip = $data['tools_equip'];
        echo "which is " . $tools_equip;
        $query = "SELECT * FROM report_teinv WHERE date = '$endmonth' AND teid = '$teid' AND campus='$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $query = "SELECT * FROM report_teinv WHERE date = '$lastmonth' AND teid = '$teid' AND campus='$campus'";
            $result = mysqli_query($conn, $query);
            while ($data = mysqli_fetch_array($result)) {
                $bnw = $data['enw'];
                $bum = $data['eum'];
                $bgc = $data['egc'];
                $bd = $data['ed'];
                $btqty = $data['etqty'];
                $buc = $data['eamt'] / $data['etqty'];
                $enw = $data['enw'];
                $eum = $data['eum'];
                $egc = $data['egc'];
                $ed = $data['ed'];
                $etqty = $data['etqty'];
                $eamt = $data['eamt'];
                $teid = $data['teid'];
                $tcampus = $data['campus'];
            }

            $sql = "INSERT INTO report_teinv SET campus = '$tcampus', teid = '$teid', tools_equip = '$tools_equip', bnw = '$bnw', bum = '$bum', bgc = '$bgc', bd = '$bd', btqty = '$btqty', buc = '$buc', enw = '$enw', eum = '$eum', egc = '$egc', ed = '$ed', etqty = '$etqty', eamt = '$eamt', date = '$endmonth'";
            //mysqli_query($conn, $sql);
            if (mysqli_query($conn, $sql)) {
                echo ", nalagyan na ng entry  $tcampus $teid ";
            } else {
                echo ", di nalagyan na ng entry <p>";
            }
        }
        echo "for this month <p>";
    }
} else {
    echo "yow";
}

/*
//update auidit trail about expired stocks
$query = "SELECT * FROM inventory_medicine WHERE expiration <= '$today' AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    // YOW EDIT DIS VARIABLES
    $user = "URSN-001"; //$_SESSION['userid'];
    //$campus = $_SESSION['campus'];
    $fullname = "DIOSA A. SALVADOR"; //strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = 'there are inventory stocks that already expired';
    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
    mysqli_query($conn, $sql);
}

//done status for doc sched
$query = "SELECT * FROM schedule WHERE date < '$today'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    foreach ($result as $data) {
        $query = "SELECT * FROM schedule WHERE date < '$today'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            $sql = "UPDATE schedule SET status='DONE' WHERE date < '$today'";
            mysqli_query($conn, $sql);
        }
    }
}

//auto dismiss appointment
$query = "SELECT * FROM appointment WHERE appointment.status='PENDING' AND date <= '$today'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    foreach ($result as $data) {
        $today = date("Y-m-d");

        $query = "SELECT * FROM appointment WHERE appointment.status='PENDING' AND date <= '$today'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            foreach ($result as $data) {
                $sql = "UPDATE appointment SET status='DISMISSED', reason='Dismissed due to exceeding the requested date.', created_at='$today' WHERE status='PENDING' AND date <= '$today'";
                if (mysqli_query($conn, $sql)) {
                    $query = "SELECT * FROM appointment WHERE appointment.status='DISMISSED' AND created_at = '$today'";
                    $result = mysqli_query($conn, $query);
                    while ($data = mysqli_fetch_array($result)) {
                        // YOW EDIT DIS VARIABLES
                        $user = "URSN-001"; //$_SESSION['userid'];
                        //$campus = $_SESSION['campus'];
                        $fullname = "DIOSA A. SALVADOR"; //strtoupper($_SESSION['name']);
                        $au_status = "unread";
                        $patient = $data['patient'];
                        $activity = 'dismissed a request of ' . $patient;
                        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
                        mysqli_query($conn, $sql);
                    }
                }
            }
        }
    }
}

//medcase auto monthly reports
$query = "SELECT * FROM med_case";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    foreach ($result as $data) {
        $endmonth = date("Y-m-t");
        $medcase = $data['medcase'];
        $medcase_type = $data['type'];

        $query = "SELECT * FROM reports_medcase WHERE date = '$endmonth' AND medcase LIKE '$medcase' AND type = '$medcase_type' AND campus = '$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$campus', '$medcase_type', '$medcase', 0, 0, 0, 0, 0, 0, 0, 0, 0, '$endmonth')";
            mysqli_query($conn, $sql);
        }
    }
}







/*
$campus = $_POST['campus'];
$date = date("Y-m-d", strtotime($_POST['date']));
$time_from = date("h:i:s", strtotime($_POST['time_from']));
$time_to = date("h:i:s", strtotime($_POST['time_to']));
$maxp = $_POST['maxp'];
$campus = $_POST['campus'];

$userid = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added a walk-in schedule for " . $campus;
$au_status = "unread";

$query = "SELECT * FROM schedule WHERE date = '$date' AND physician = '$userid'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
?>
    <script>
        setTimeout(function() {
            window.location = "../doc_visit_schedpage";
        });
    </script>
    <?php
    // modal message box saying "A schedule has already been set on that date."
} else {
    $query = "INSERT INTO schedule(physician, date, time_from, time_to, maxp, campus) VALUES ('$userid', '$date', '$time_from', '$time_to', '$maxp', '$campus')";
    if ($result = mysqli_query($conn, $query)) {
        $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
        if ($result = mysqli_query($conn, $query)) {
    ?>
            <script>
                setTimeout(function() {
                    window.location = "../doc_visit_schedpage";
                });
            </script>
        <?php
            // modal message box saying "Walk-In Schedule has been added."
        } else {
        ?>
            <script>
                setTimeout(function() {
                    window.location = "../doc_visit_schedpage";
                });
            </script>
        <?php
            // modal message box saying "Walk-In Schedule has been added."
        }
    } else {
        // modal message box saying "Walk-In Schedule was not added."
        ?>
        <script>
            setTimeout(function() {
                window.location = "../doc_visit_schedpage";
            });
        </script>
<?php
    }
}
*/
mysqli_close($conn);
