<?php
session_start();
include('connection.php');
$purpose = $_POST['purpose'];
$physician = $_POST['physician'];

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added an appointment physician]";
$au_status = "unread";

$sql = "SELECT * FROM appointment_physician WHERE purpose = '$purpose' AND physician = '$physician'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $_SESSION['alert'] = "Physician already exists.";
?>
    <script>
        setTimeout(function() {
            window.location = "../appphysician_set";
        });
    </script>
    <?php
} else {
    $sql = "INSERT INTO appointment_physician (purpose, physician) VALUES ('$purpose', '$physician')";
    if ($result = mysqli_query($conn, $sql)) {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if ($result = mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = "Physician for Appointment has been added.";
    ?>
            <script>
                setTimeout(function() {
                    window.location = "../appphysician_set";
                });
            </script>
        <?php
        } else {
            $_SESSION['alert'] = "Physician for Appointment has been added.";
        ?>
            <script>
                setTimeout(function() {
                    window.location = "../appphysician_set";
                });
            </script>
        <?php
        }
    } else {
        $_SESSION['alert'] = "Physician for Appointment was not added.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../appphysician_set";
            });
        </script>
<?php
    }
}
mysqli_close($conn);
