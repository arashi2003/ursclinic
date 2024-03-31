<?php
session_start();
include('connection.php');
$accountid = $_POST['patientid'];
$designation = $_POST['designation'];
$firstname  = strtoupper($_POST['firstname']);
$middlename = strtoupper($_POST['middlename']);
$lastname  = strtoupper($_POST['lastname']);
$age  = floor((time() - strtotime($_POST['birthday'])) / 31556926);
$sex = strtoupper($_POST['sex']);
$birthday = date("Y-m-d", strtotime($_POST['birthday']));
$department = $_POST['department'];
$college = $_POST['college'];
$program = $_POST['program'];
$yearlevel = $_POST['yearlevel'];
$section = $_POST['section'];
$block = $_POST['block'];
$email = $_POST['email'];
$contactno = $_POST['contactno'];
$address = $_POST['address'];
$emcon_name = $_POST['emcon_name'];
$emcon_number = $_POST['emcon_number'];

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added a patient information";
$au_status = "unread";

$sql = "SELECT accountid, firstname, lastname FROM account WHERE accountid = '$accountid' AND firstname = '$firstname' AND lastname='$lastname'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    $sql = "INSERT INTO patient_info SET patientid = '$accountid', designation = '$designation', age = '$age', sex = '$sex', birthday = '$birthday', department = '$department', block='$block', campus = '$au_campus', college = '$college', program = '$program', yearlevel = '$yearlevel', section = '$section', email = '$email', contactno = '$contactno', address='$address', emcon_name = '$emcon_name', emcon_number = '$emcon_number', datetime_updated = now(), datetime_created = now()";
    if (mysqli_query($conn, $sql)) {
        $sql = "INSERT INTO patient_image (patient_id, image,created_at) VALUES ('$accountid', 'noprofile.png', now())";
        if (mysqli_query($conn, $sql)) {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if ($result = mysqli_query($conn, $sql)) {
                $_SESSION['alert'] = "Patient Information has been added.";
?>
                <script>
                    setTimeout(function() {
                        window.location = "../patients";
                    });
                </script>
            <?php
            } else {
                $_SESSION['alert'] = "Patient Information has been added.";
            ?>
                <script>
                    setTimeout(function() {
                        window.location = "../patients";
                    });
                </script>
            <?php
            }
        } else {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if ($result = mysqli_query($conn, $sql)) {
                $_SESSION['alert'] = "Patient Information has been added.";
            ?>
                <script>
                    setTimeout(function() {
                        window.location = "../patients";
                    });
                </script>
            <?php
            } else {
                $_SESSION['alert'] = "Patient Information has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../patients";
                    });
                </script>
        <?php
            }
        }
    } else {
        $_SESSION['alert'] = "Patient Information was not added.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../patients";
            });
        </script>
    <?php
    }
} else {
    $_SESSION['alert'] = "Account ID has been used. Patient Information was not added.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../patients";
        });
    </script>
<?php
}
mysqli_close($conn);
