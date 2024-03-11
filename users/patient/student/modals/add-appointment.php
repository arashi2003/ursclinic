<?php
session_start();
include('connection.php');

$patient = $_POST['patient'];
$appointment = $_POST['appointment'];
$purpose = $_POST['purpose'];
$chiefcomplaint = $_POST['chiefcomplaint'];
$others = $_POST['others'];
$physician = $_POST['physician'];


$sql = "INSERT INTO appointment SET  date='2024-01-30', time_from='10:30:00', time_to='11:00:00', physician='$physician', patient='$patient', type='$appointment',   purpose='$purpose', chiefcomplaint='$chiefcomplaint', others='$others', status='PENDING'";

if (mysqli_query($conn, $sql)) {
  //select data from usertb for audit trail
  //$username = $_SESSION['username'];
  //$sql = "SELECT * FROM usertbl WHERE lastname='$username'";
  //$result = mysqli_query($conn, $sql);
  //$row = mysqli_fetch_array($result);

  //$fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
  //$campus = $row['campus'];
  //$userno = $row['user_no'];

  //audit trail
  //$sql = "INSERT INTO activitylogtbl SET campus='$campus', account_no='$userno', fullname='$fullname', activity='Add an appointment'";
  //mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $_SESSION['alert'] = 'You have successfully request an appointment!';
?>
  <script>
    setTimeout(function() {
      window.location = "../appointment.php";
    });
  </script>
<?php
}
mysqli_close($conn);
