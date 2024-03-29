<?php
session_start();
include('../../add/connection.php');
$id = $_POST['id'];
$campus = strtoupper($_POST['campus']);
$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "updated a campus Campus";
$au_status = "unread";

$sql = "UPDATE campus SET campus='$campus' WHERE id='$id'";
if ($result = mysqli_query($conn, $sql)) {
    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = "Campus has been updated added.";
?>
        <script>
            setTimeout(function() {
                window.location = "../../campus";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Campus has been updated added.";
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../campus";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Campus was not updated added.";

    ?>
    <script>
        setTimeout(function() {
            window.location = "../../campus";
        });
    </script>
<?php
}
mysqli_close($conn);
