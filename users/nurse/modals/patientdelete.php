<?php
session_start();
include('connection.php');
$id = $_GET['no'];
$sql = "DELETE FROM patienttbl WHERE id='$id'";
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
    $sql = "INSERT INTO audit_trail SET campus='$campus', user='$userno', fullname='$fullname', activity='Delete an patient'";
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
?>