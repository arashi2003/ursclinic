<?php
session_start();
include('connection.php');

$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$lastname = $_POST['lastname'];
$age = $_POST['age'];
$gender = $_POST['gender'];


$sql = "INSERT INTO patienttbl SET firstname='$firstname', middlename='$middlename', lastname='$lastname', age='$age', gender='$gender', status='Active'";

if (mysqli_query($conn, $sql)) {
  //select data from usertb for audit trail
  $username = $_SESSION['username'];
  $sql = "SELECT * FROM usertbl WHERE lastname='$username'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);

  $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
  $campus = $row['campus'];
  $userno = $row['user_no'];

  //audit trail
  $sql = "INSERT INTO activitylogtbl SET campus='$campus', account_no='$userno', fullname='$fullname', activity='Add an patient'";
  mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
  <script>
    setTimeout(function() {
      window.location = "nursepatient.php";
    });
  </script>
<?php
}
mysqli_close($conn);
