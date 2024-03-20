<?php
session_start();
include('connection.php');
$id = $_GET['no'];
$sql = "UPDATE appointment SET status='APPROVED' WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    //select data from usertb for audit trail
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = "approved a request for appointment";

    $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
    <script>
        setTimeout(function() {
            window.location = "../appointment.php";
        });
    </script>
<?php
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>