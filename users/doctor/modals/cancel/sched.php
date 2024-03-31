<?php
session_start();
include('../../connection.php');
$id = $_POST['id'];
$reason = $_POST['reason'];
$campus = $_POST['campus'];

$userid = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "cancelled a walk-in schedule for " . $campus;
$au_status = "unread";

$query = "UPDATE schedule SET status='CANCELLED', reason = '$reason' WHERE physician = '$userid' AND id = '$id'";
if ($result = mysqli_query($conn, $query)) {
    $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $query)) {
        $_SESSION['alert'] = "Walk-In Schedule has been cancelled."
?>
        <script>
            setTimeout(function() {
                window.location = "../../doc_visit_schedpage";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Walk-In Schedule has been cancelled."
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../doc_visit_schedpage";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Walk-In Schedule was not cancelled."
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../doc_visit_schedpage";
        });
    </script>
<?php
}

mysqli_close($conn);
