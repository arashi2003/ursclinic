<?php
session_start();
include('connection.php');

$patientname = $_POST['patientname'];
$date = $_POST['date'];
$time = $_POST['time'];
$purpose = $_POST['purposes'];
$complaint = $_POST['complaint'];


$sql = "INSERT INTO appointmenttbl SET patient_name='$patientname', appointment_date='$date', appointment_time='$time', purpose='$purpose', chief_complaint='$complaint', status='Pending'";

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
  $sql = "INSERT INTO activitylogtbl SET campus='$campus', account_no='$userno', fullname='$fullname', activity='Add an appointment'";
  mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
  <script>
    setTimeout(function() {
      window.location = "nurseappointment.php";
    });
  </script>
<?php
}
mysqli_close($conn);
