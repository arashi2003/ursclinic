<?php
session_start();
if (isset($_POST['update'])) {

    include('connection.php');

    $id = $_POST['patientid'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $status = $_POST['status'];

    $sql = "UPDATE patient_info SET firstname='$firstname', middlename='$middlename', lastname='$lastname',`age`='$age',`gender`='$gender', status='$status' WHERE patient_id='$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        //select data from usertb for audit trail
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM account WHERE lastname='$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
        $campus = $row['campus'];
        $userno = $row['accountid'];

        //audit trail
        $sql = "INSERT INTO audit_trail SET campus='$campus', user='$userno', fullname='$fullname', activity='Edit an patient'";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
        <script>
            setTimeout(function() {
                window.location = "../nursepatient.php";
            });
        </script>
<?php
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
mysqli_close($conn);
?>