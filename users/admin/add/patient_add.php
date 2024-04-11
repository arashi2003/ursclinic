<?php
session_start();
include('connection.php');
date_default_timezone_set("Asia/Manila");
$accountid = $_POST['patientid'];
$designation = $_POST['designation'];
$age  = floor((time() - strtotime($_POST['birthday'])) / 31556926);
$sex = strtoupper($_POST['sex']);
$birthday = date("Y-m-d", strtotime($_POST['birthday']));
$department = $_POST['department'];
if (!empty($_POST['college'])) {
    $college = $_POST['college'];
} else{
    $college = "";
}
if (!empty($_POST['program'])) {
    $program = $_POST['program'];
} else{
    $program = "";
}
if (!empty($_POST['yearlevel'])) {
    $yearlevel = $_POST['yearlevel'];
} else{
    $yearlevel = "";
}
if (!empty($_POST['section'])) {
    $section = $_POST['section'];
} else{
    $section = "";
}
if (!empty($_POST['block'])) {
    $block = $_POST['block'];
} else{
    $block = "";
}
$address = $_POST['address'];
$emcon_name = $_POST['emcon_name']; 
$emcon_number = $_POST['emcon_number'];

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added a patient information";
$au_status = "unread";

$sql = "SELECT accountid, email, contactno FROM account WHERE accountid = '$accountid'";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    while($tss = mysqli_fetch_array($result)){
        $email = $tss['email'];
        $contactno = $tss['contactno'];
    }
    $sql = "INSERT INTO patient_info SET patientid = '$accountid', designation = '$designation', sex = '$sex', birthday = '$birthday', department = '$department', block='$block', campus = '$au_campus', college = '$college', program = '$program', yearlevel = '$yearlevel', section = '$section', email = '$email', contactno = '$contactno', address='$address', emcon_name = '$emcon_name', emcon_number = '$emcon_number', datetime_updated = now(), datetime_created = now()";
    if (mysqli_query($conn, $sql)) {
        $doc = "INSERT INTO `meddoc` (`type`, `applicant`, `doc_desc`, `document`, `status`, `remarks`, `dt_uploaded`, `dt_updated`) VALUES
        ('ATHLETE', '$accountid', 'X-Ray', 'nofile.png', 'Pending', '', now(), now()),
        ('ATHLETE', '$accountid', 'Pregnancy Test', 'nofile.png', 'Pending', '', now(), now()),
        ('ATHLETE', '$accountid', 'Urinalysis', 'nofile.png', 'Pending', '', now(), now()),
        ('ATHLETE', '$accountid', 'CBC', 'nofile.png', 'Pending', '', now(), now()),
        ('FRESHMEN', '$accountid', 'X-Ray', 'nofile.png', 'Pending', '', now(), now()),
        ('FRESHMEN', '$accountid', 'CBC', 'nofile.png', 'Pending', '', now(), now()),
        ('FRESHMEN', '$accountid', 'DRUG TEST', 'nofile.png', 'Pending', '', now(), now()),
        ('OJT', '$accountid', 'CBC', 'nofile.jpg', 'Pending', '', now(), now()),
        ('OJT', '$accountid', 'Urinalysis', 'nofile.png', 'Pending', '', now(), now()),
        ('OJT', '$accountid', 'Pregnancy Test', 'nofile.png', 'Pending', '', now(), now()),
        ('OJT', '$accountid', 'X-Ray', 'nofile.png', 'Pending', '', now(), now());";
        if (mysqli_query($conn, $doc)) {
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
    $_SESSION['alert'] = "Account ID does not exist.";
    ?>
    <script>
        setTimeout(function() {
            window.location = "../patients";
        });
    </script>
<?php
}
mysqli_close($conn);
