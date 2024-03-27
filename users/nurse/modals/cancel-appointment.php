<?php
session_start();
include('../../connection.php');
$id = $_POST['id'];
$reason = $_POST['reason'];

$id = $_POST['id'];
$sql = "UPDATE appointment SET status='DISAPPROVED', reason = '$reason' WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$query = "SELECT * FROM appointment WHERE id = '$id'";
$result = mysqli_query($conn, $query);
while ($data = mysqli_fetch_array($result)) {
    $patientid = $data['patient'];
}

if ($result) {
    $userid = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = "disapproved an appointment of " . $patientid;

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
} else {
    echo "Failed: " . mysqli_error($conn);
}
