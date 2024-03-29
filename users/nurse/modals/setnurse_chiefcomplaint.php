<?php
session_start();
include('connection.php');

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added a chief complaint";
$chief_complaint = $_POST['chief_complaint'];
$au_status = "unread";

$query = "SELECT * FROM chief_complaint WHERE chief_complaint = '$chief_complaint'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    $_SESSION['alert'] = "Chief Complaint already exists.";
?>
    <script>
        setTimeout(function() {
            window.location = "../chiefcomplaint";
        });
    </script>
    <?php
} else {
    $query = "INSERT INTO chief_complaint SET chief_complaint='$chief_complaint'";
    if ($result = mysqli_query($conn, $query)) {
        $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if ($result = mysqli_query($conn, $query)) {
            $_SESSION['alert'] = "Chief Complaint has been added.";
    ?>
            <script>
                setTimeout(function() {
                    window.location = "../chiefcomplaint";
                });
            </script>
        <?php
        } else {
            $_SESSION['alert'] = "Chief Complaint has been added.";
        ?>
            <script>
                setTimeout(function() {
                    window.location = "../chiefcomplaint";
                });
            </script>
        <?php
        }
    } else {
        $_SESSION['alert'] = "Chief Complaint was not added.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../chiefcomplaint";
            });
        </script>
<?php
    }
}
mysqli_close($conn);
