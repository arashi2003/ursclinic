<?php
session_start();
include('../../add/connection.php');
$id = $_POST['departmentid'];
$department = strtoupper($_POST['department']);
$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "updated a department entry";
$au_status = "unread";

$sql = "UPDATE department SET department='$department' WHERE id='$id'";
if ($result = mysqli_query($conn, $sql)) {
    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = "Department has been updated.";
?>
        <script>
            setTimeout(function() {
                window.location = "../../department";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Department has been updated.";
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../department";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Department was not updated.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../department";
        });
    </script>
<?php
}
mysqli_close($conn);
