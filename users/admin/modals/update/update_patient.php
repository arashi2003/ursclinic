<?php
    session_start();
    include('../../add/connection.php');
    $accountid = $_POST['patientid'];
    $designation = $_POST['designation'];
    $age = floor((time() - strtotime($_POST['birthday'])) / 31556926); 
    $sex = $_POST['sex'];
    $birthday = date("Y-m-d", strtotime($_POST['birthday']));
    $department = $_POST['department'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $address=$_POST['address'];
    $emcon_name = $_POST['emcon_name'];
    $emcon_number = $_POST['emcon_number'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated the patient information of " . $accountid;
    $au_status = "unread";

    $sql= "UPDATE patient_info SET designation = '$designation', age = '$age', sex = '$sex', birthday = '$birthday', department = '$department', college = '$college', program = '$program', yearlevel = '$yearlevel', section = '$section', email = '$email', contactno = '$contactno', address='$address', emcon_name = '$emcon_name', emcon_number = '$emcon_number', datetime_updated = now() WHERE patientid='$accountid'";
    if (mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../patients";
                    });
                </script>
                <?php
                // modal na profile information has been updated
            }
            else
            {
                // modal na profile information has been updated
            }
        }
        else
        {
            // modal na profile information has not been updated
        
    ?>
<script>
    setTimeout(function() {
        window.location = "../../patients";
    });
</script>
<?php 
        }
mysqli_close($conn);