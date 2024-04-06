<?php
session_start();
include('connection.php');

$patient  = $_SESSION['userid'];
$type  = $_POST['appointment'];
$purpose = $_POST['purpose'];
$chiefcomplaint  = $_POST['chiefcomplaint'];
$others = $_POST['others'];
$status   = "PENDING";

if (!empty($_POST['medicine']) && isset($_POST['medicine'])) {
  $count = 1;
  $physician  = "NONE";
  $date = date("Y-m-d", strtotime($_POST['datem']));
  $time_from = date("H:i:s", strtotime($_POST['time_fromm']));
  $time_to =  date("H:i:s", strtotime($_POST['time_tom']));
  foreach ($_POST['medicine'] as $key => $medicine) {
    $mqty = $_POST['quantity'][$key];
    $rmed[] = "med_$count = '$medicine', mqty_$count = '$mqty'";
    $count++;
  }
  $medsup1 = implode(", ", $rmed);
  $ms = rtrim($medsup1, " , ");
  $medsup = "$ms,";
} elseif (!empty($_POST['supply']) && isset($_POST['supply'])) {
  $count = 1;
  $physician  = "NONE";
  $date = date("Y-m-d", strtotime($_POST['datem']));
  $time_from = date("H:i:s", strtotime($_POST['time_fromm']));
  $time_to =  date("H:i:s", strtotime($_POST['time_tom']));
  foreach ($_POST['supply'] as $key => $supply) {
    $sqty = $_POST['quantity'][$key];
    $rsup[] = "sup_$count = '$supply', sqty_$count = '$sqty'";
    $count++;
  }
  $medsup1 = implode(", ", $rsup);
  $ms = rtrim($medsup1, " , ");
  $medsup = "$ms,";
} else {
  $medsup = "";
}

if (!empty($_POST['physician']) and $_POST['physician'] != 'NONE') {
  $physician  = $_POST['physician'];
  $date = date("Y-m-d", strtotime($_POST['datep']));
  $time_from = date("H:i:s", strtotime($_POST['time_fromp']));
  $time_to =  date("H:i:s", strtotime($_POST['time_top']));
} elseif (!empty($_POST['physician']) and $_POST['physician'] == 'NONE') {
  $physician  = "NONE";
  $date = date("Y-m-d", strtotime($_POST['daten']));
  $time_from = date("H:i:s", strtotime($_POST['time_fromn']));
  $time_to =  date("H:i:s", strtotime($_POST['time_ton']));
}

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$au_status = "unread";
$activity = "sent a request for appointment";

$sql = "INSERT INTO appointment SET date='$date', time_from='$time_from', time_to= '$time_to', physician='$physician', patient='$patient', type='$type', purpose='$purpose', chiefcomplaint='$chiefcomplaint', others='$others', $medsup status='$status', created_at=now()";
if (mysqli_query($conn, $sql)) {
  $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
  if ($result = mysqli_query($conn, $query)) {
    $sql = "UPDATE time_pickup SET isSelected = 'Yes' WHERE time IN ('$time_from', '$time_to')";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
?>
    <script>
      setTimeout(function() {
        window.location = "../appointment";
      });
    </script>
  <?php
    $_SESSION['alert'] = 'Request was sent. Nurse has been notified.';
  } else {
  ?>
    <script>
      setTimeout(function() {
        window.location = "../appointment";
      });
    </script>
  <?php
    $_SESSION['alert'] = 'Request was sent.';
  }
} else {
  $_SESSION['alert'] = 'Request was not sent.';
  ?>
  <script>
    setTimeout(function() {
      window.location = "../appointment.php";
    });
  </script>
<?php
}

mysqli_close($conn);
