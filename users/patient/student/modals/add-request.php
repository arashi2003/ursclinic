<?php
session_start();
include('connection.php');
$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$au_status = "unread";
$patient = $_POST['patient'];
$date = date("Y-m-d", strtotime($_POST['date']));
$time = $_POST['time'];
$request = $_POST['request'];
$quantity = $_POST['quantity'];
$purpose = $_POST['purpose'];

$sql = "SELECT request_type FROM request_type WHERE id='$request'";
$result=mysqli_query($conn, $sql);
while($data=mysqli_num_rows($result))
{
  $type=$data['request_type'];
}


if (isset($_POST['medicine'])) {
  $activity = "sent a request for medicine";
  $medicine = $_POST['medicine'];
  $sql = "INSERT INTO transaction_request SET patient='$patient', request_type='$request', medid='$medicine', qty='$quantity', purpose='$purpose', date_pickup='$date', time_pickup='$time', status='PENDING', datetime=now()";
  if (mysqli_query($conn, $sql)) 
  {
    $sql = "UPDATE inventory_medicine SET qty = qty - $quantity WHERE medid='$medicine'";
    mysqli_query($conn, $sql);
    $activity = "sent a request for medicince";
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
  }
  else
  {
    //request was not sent.
    ?>
      <script>
        setTimeout(function() {
          window.location = "../request";
        });
      </script>
    <?php
  }
} elseif (isset($_POST['medical'])) {
  $medical = $_POST['medical'];
  $sql = "INSERT INTO transaction_request SET patient='$patient', request_type='$request', supid='$medical', qty='$quantity', purpose='$purpose', date_pickup='$date', time_pickup='$time', status='PENDING', datetime=now()";
  if (mysqli_query($conn, $sql)) {
    $sql = "UPDATE inventory_supply SET qty = qty - $quantity WHERE supid='$medical'";
    mysqli_query($conn, $sql);
    $activity = "sent a request for medical supply";
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
  }
  else
  {
    //request was not sent.
    ?>
      <script>
        setTimeout(function() {
          window.location = "../request";
        });
      </script>
    <?php
  }
}
else{
  $medical = $_POST['medical'];
  $sql = "INSERT INTO transaction_request SET patient='$patient', request_type='$type', purpose='$purpose', date_pickup='$date', time_pickup='$time', status='PENDING', datetime=now()";
  if(mysqli_query($conn, $sql))
  {
    $request = $_POST['request'];

    $sql = "SELECT request_type FROM request_type WHERE id='$request'";
    $result=mysqli_query($conn, $sql);
    while($data=mysqli_num_rows($result))
    {
      $type=$data['request_type'];
    }
    $activity = "sent a request for $type";
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
    // request was not sent.
  }
}
mysqli_close($conn);
