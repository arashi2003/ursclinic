<?php
session_start();
include('../connection.php');
$id = $_POST['id'];
$reason = $_POST['reason'];
$time_from = $_POST['time_from'];
$time_to = $_POST['time_to'];

$query = "SELECT * FROM appointment WHERE id = '$id'";
$result = mysqli_query($conn, $query);
while ($data = mysqli_fetch_array($result)) {
    $patientid = $data['patient'];
}

$userid = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "cancelled an appointment";
$au_status = "unread";

$query = "UPDATE appointment SET status='CANCELLED', reason = '$reason' WHERE id = '$id'";
if ($result = mysqli_query($conn, $query)) {
    $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $query)) {
        $_SESSION['alert'] = "Appointment has been cancelled.";

        $sql = "UPDATE time_pickup SET isSelected = 'No' WHERE time IN ('$time_from', '$time_to')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
        <script>
            setTimeout(function() {
                window.location = "../../appointment";
            });
        </script>
    <?php
    } else {
        $_SESSION['alert'] = "Appointment has been cancelled.";
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../appointment";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Appointment was not cancelled.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../appointment";
        });
    </script>
<?php
}

mysqli_close($conn);
