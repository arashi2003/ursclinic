<?php
session_start();
include('connection.php');

$patient = $_POST['patient'];
$appointment = $_POST['appointment'];
$purpose = $_POST['purpose'];
$chiefcomplaint = $_POST['chiefcomplaint'];
$others = $_POST['others'];
$physician = $_POST['physician'];

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$au_status = "unread";


$sql = "INSERT INTO appointment SET  date='2024-01-30', time_from='10:30:00', time_to='11:00:00', physician='$physician', patient='$patient', type='$appointment',   purpose='$purpose', chiefcomplaint='$chiefcomplaint', others='$others', status='PENDING'";

if (mysqli_query($conn, $sql)) {
  $activity = "sent a request for appointment";
    $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    if($result = mysqli_query($conn, $query))
    {
      ?>
        <script>
          setTimeout(function() {
            window.location = "../request";
          });
        </script>
      <?php
      // request was sent. Nurse has been notified.
    }
    else
    {
      ?>
        <script>
          setTimeout(function() {
            window.location = "../request";
          });
        </script>
      <?php
      // request was sent.
    }
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
