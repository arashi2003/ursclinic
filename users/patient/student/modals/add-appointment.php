<?php
session_start();
include('connection.php');

$date = date("Y-m-d", strtotime($_POST['date']));
$time_from = date("h:i:s", strtotime($_POST['time_from']));
$time_to =  date("h:i:s", strtotime($_POST['time_to']));
$physician	= $_POST['physician'];
$patient	= $_SESSION['userid'];
$type	= $_POST['appointment'];
$purpose = $_POST['purpose'];
$chiefcomplaint	= $_POST['chiefcomplaint'];
$others = $_POST['others'];
$med_1 = $_POST['med_1'];
$med_2 = $_POST['med_2'];
$med_3 = $_POST['med_3'];
$med_4 = $_POST['med_4'];
$med_5 = $_POST['med_5'];
$mqty_1 = $_POST['mqty_1'];
$mqty_2 = $_POST['mqty_2'];
$mqty_3 = $_POST['mqty_3'];
$mqty_4 = $_POST['mqty_4'];
$mqty_5 = $_POST['mqty_5'];
$sup_1 = $_POST['sup_1'];
$sup_2 = $_POST['sup_2'];
$sup_3 = $_POST['sup_3'];
$sup_4 = $_POST['sup_4'];
$sup_5 = $_POST['sup_5'];
$sqty_1 = $_POST['sqty_1'];
$sqty_2 = $_POST['sqty_2'];
$sqty_3 = $_POST['sqty_3'];
$sqty_4 = $_POST['sqty_4'];
$sqty_5 = $_POST['sqty_5'];
$status	 = "PENDING";

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$au_status = "unread";
$activity = "sent a request for appointment";


$sql = "INSERT INTO appointment (date, time_from, time_to, physician, patient, type, purpose, chiefcomplaint, others, med_1, med_2, med_3, med_4, med_5, mqty_1, mqty_2, mqty_3, mqty_4, mqty_5, sup_1, sup_2, sup_3, sup_4, sup_5, sqty_1, sqty_2, sqty_3, sqty_4, sqty_5, status, created_at) VALUES ('$date', '$time_from', '$time_to', '$physician', '$patient', '$type', '$purpose', '$chiefcomplaint', '$others', '$med_1', '$med_2', '$med_3', '$med_4', '$med_5', '$mqty_1', '$mqty_2', '$mqty_3', '$mqty_4', '$mqty_5', '$sup_1', '$sup_2', '$sup_3', '$sup_4', '$sup_5', '$sqty_1', '$sqty_2', '$sqty_3', '$sqty_4', '$sqty_5', '$status', now())";
if (mysqli_query($conn, $sql)) {
    $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    if($result = mysqli_query($conn, $query))
    {
      ?>
        <script>
          setTimeout(function() {
            window.location = "../appointment";
          });
        </script>
      <?php
      $_SESSION['alert'] = 'Request was sent. Nurse has been notified.';
    }
    else
    {
      ?>
        <script>
          setTimeout(function() {
            window.location = "../appointment";
          });
        </script>
      <?php
      $_SESSION['alert'] = 'Request was sent.';
    }
}
else
{
  ?>
  <script>
    setTimeout(function() {
      window.location = "../appointment.php";
    });
  </script>
<?php
$_SESSION['alert'] = 'Request was not sent.';
}
mysqli_close($conn);
