<?php
session_start();
include('../../add/connection.php');
$id = $_POST['ylid'];
$yearlevel = $_POST['yearlevel'];
$department = strtoupper($_POST['department']);
$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "updated a year level entry";
$au_status = "unread";

$sql = "UPDATE yearlevel SET department='$department', yearlevel='$yearlevel' WHERE id='$id'";
if ($result = mysqli_query($conn, $sql)) {
    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = "Year Level has been updated.";
?>
        <script>
            setTimeout(function() {
                window.location = "../../yearlevel";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Year Level has been updated.";
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../yearlevel";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Year Level was not updated.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../yearlevel";
        });
    </script>
<?php
}
mysqli_close($conn);
