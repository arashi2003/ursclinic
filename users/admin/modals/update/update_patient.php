<?php
    session_start();
    include('../../add/connection.php');
    $accountid = $_POST['patientid'];
    $designation = $_POST['designation'];
    $age  = $_POST['age'];
    $sex = $_POST['sex'];
    $birthday = date("Y-m-d", strtotime($_POST['birthday']));
    $department = $_POST['department'];
    $college = $_POST['college'];
    $program = $_POST['program'];
    $yearlevel = $_POST['yearlevel'];
    $section = $_POST['section'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $emcon_name = $_POST['emcon_name'];
    $emcon_number = $_POST['emcon_number'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated the patient information of " . $accountid;

    $sql= "UPDATE patient_info SET designation = '$designation', age = '$age', sex = '$sex', birthday = '$birthday', department = '$department', college = '$college', program = '$program', yearlevel = '$yearlevel', section = '$section', email = '$email', contactno = '$contactno', emcon_name = '$emcon_name', emcon_number = '$emcon_number', datetime_updated = now() WHERE patientid='$accountid'";
    if (mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../patients.php";
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
        window.location = "../../patients.php";
    });
</script>
<?php 
        }
mysqli_close($conn);