<?php
session_start();
include('connection.php');

$id = $_POST['id'];

$sql = "UPDATE appointment SET status='APPROVED' WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$sql = "SELECT patient FROM appointment WHERE id='$id'";
$result = mysqli_query($conn, $sql);
while($data=mysqli_fetch_array($result))
{
    $patientid=$data['patient'];
}

if ($result) {
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = "approved a request for appointment of " . $patientid;

    $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    $_SESSION['alert'] = "You have successfully approved an appointment!"
?>
    <script>
        setTimeout(function() {
            window.location = "../appointment?tab=approved";
        });
    </script>
<?php
} else {
    echo "Failed: " . mysqli_error($conn);
}
?>