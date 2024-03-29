<?php
session_start();
include('../../connection.php');
$time_from = date("h:i:s", strtotime($_POST['time_from']));
$time_to = date("h:i:s", strtotime($_POST['time_to']));
$maxp = $_POST['maxp'];
$id = $_POST['id'];
$campus = $_POST['campus'];

$userid = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "updated a walk-in schedule for " . $campus;
$au_status = "unread";

$query = "UPDATE schedule SET time_from = '$time_from', time_to = '$time_to', maxp = '$maxp' WHERE physician = '$userid' AND id = '$id'";
if ($result = mysqli_query($conn, $query)) {
    $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $query)) {
        $_SESSION['alert'] = "Walk-In Schedule Details has been updated."
?>
        <script>
            setTimeout(function() {
                window.location = "../../doc_visit_schedpage";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Walk-In Schedule Details has been updated."
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../doc_visit_schedpage";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Walk-In Schedule Details was not updated."
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../doc_visit_schedpage";
        });
    </script>
<?php
}

mysqli_close($conn);
