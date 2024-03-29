<?php
session_start();
include('connection.php');
$apppurpose = $_POST['apppurpose'];
$type = $_POST['type'];

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added an appointment purpose";
$au_status = "unread";

$sql = "SELECT * FROM appointment_purpose WHERE purpose = '$apppurpose' AND type = '$type'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $_SESSION['alert'] = "Request already exists.";
?>
    <script>
        setTimeout(function() {
            window.location = "../apppurpose_set";
        });
    </script>
    <?php
} else {
    $sql = "INSERT INTO appointment_purpose (purpose, type) VALUES ('$apppurpose', '$type')";
    if ($result = mysqli_query($conn, $sql)) {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if ($result = mysqli_query($conn, $sql)) {
            $_SESSION['alert'] = "Request has been added.";
    ?>
            <script>
                setTimeout(function() {
                    window.location = "../apppurpose_set";
                });
            </script>
        <?php
        } else {
            $_SESSION['alert'] = "Request has been added.";
        ?>
            <script>
                setTimeout(function() {
                    window.location = "../apppurpose_set";
                });
            </script>
        <?php
        }
    } else {
        $_SESSION['alert'] = "Request was not added.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../apppurpose_set";
            });
        </script>
<?php
    }
}
mysqli_close($conn);
