<?php
    session_start();
    include('connection.php');
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
    $activity = "added a patient information";

    $sql= "INSERT INTO patient_info SET patientid = '$accountid', designation = '$designation', age = '$age', sex = '$sex', birthday = '$birthday', department = '$department', campus = '$au_campus', college = '$college', program = '$program', yearlevel = '$yearlevel', section = '$section', email = '$email', contactno = '$contactno', emcon_name = '$emcon_name', emcon_number = '$emcon_number', datetime_added = now(), datetime_created = now() WHERE patientid='$accountid'";
    if (mysqli_query($conn, $sql))
        {
            $sql= "INSERT INTO patient_image (patient_id, image,created_at) VALUES ('$accountid', 'noptofile.png', now())";
            if (mysqli_query($conn, $sql))
            {
                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
                if($result = mysqli_query($conn, $sql))
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../../patient_add.php";
                        });
                    </script>
                    <?php
                    // modal na profile information has been added
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../../patient_add.php";
                        });
                    </script>
                    <?php
                    // modal na profile information has been added
                }
            }
            else
            {
                $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
                if($result = mysqli_query($conn, $sql))
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../../patient_add.php";
                        });
                    </script>
                    <?php
                    // modal na profile information has been added
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../../patient_add.php";
                        });
                    </script>
                    <?php
                    // modal na profile information has been added
                }
            }
        }
        else
        {
            // modal na profile information has not been added
        
    ?>
<script>
    setTimeout(function() {
        window.location = "../../patient_add.php";
    });
</script>
<?php 
        }
mysqli_close($conn);