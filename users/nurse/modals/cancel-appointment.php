<?php
session_start();
include('../../connection.php');
$id = $_POST['id'];
$reason = $_POST['reason'];

$query = "SELECT * FROM appointment WHERE id = '$id'";
$result = mysqli_query($conn, $query);
while($data=mysqli_fetch_array($result)){
    $patientid=$data['patient'];
}

$userid = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "disapproved an appointment of " . $patientid;
$au_status = "unread";

$query = "UPDATE appointment SET status='DISAPPROVED', reason = '$reason' WHERE id = '$id'";
if ($result = mysqli_query($conn, $query)) {
    $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $query)) {
?>
        <script>
            setTimeout(function() {
                window.location = "../../appoinment";
            });
        </script>
    <?php
        // modal message box saying "Appointment has been disapproved."
    } else {
    ?>
        <script>
            setTimeout(function() {
                window.location = "../../appoinment";
            });
        </script>
    <?php
        // modal message box saying "Appointment has been disapproved."
    }
} else {
    // modal message box saying "Appointment was not disapproved."
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../appoinment";
        });
    </script>
<?php
}

mysqli_close($conn);
