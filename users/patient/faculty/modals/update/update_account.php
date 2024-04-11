<?php
session_start();
include('../connection.php');
$cupassword = $_POST['cupassword'];
$password = $_POST['npassword'];
$copassword = $_POST['copassword'];
date_default_timezone_set("Asia/Manila");

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "updated their password";
$au_status = "unread";

//check current pass na in-enter is same sa db
$sql = "SELECT password from account WHERE accountid = '$user' AND password = '$cupassword'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    if ($password == $copassword) {
        $sql0 = "UPDATE account SET password='$password', datetime_updated=now() WHERE accountid='$user'";
        if (mysqli_query($conn, $sql0)) {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if ($result = mysqli_query($conn, $sql)) {
                $_SESSION['alert'] = "Password has been updated.";
?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile";
                    });
                </script>
            <?php
            } else {
                $_SESSION['alert'] = "Password has been updated.";
            ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile";
                    });
                </script>
            <?php
            }
        } else {
            $_SESSION['alert'] = "Password was not updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../profile";
                });
            </script>
        <?php
        }
    } else {
        $_SESSION['alert'] = "New Password and Confirm Password did not match.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../profile";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Current Password input does not match the current password.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../../profile";
        });
    </script>
<?php
}

mysqli_close($conn);
