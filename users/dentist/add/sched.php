<?php
session_start();
include('../connection.php');
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

$query = "SELECT * FROM schedule WHERE date = '$date' AND physician = '$userid' AND status != 'CANCELLED'";
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
mysqli_close($conn);
