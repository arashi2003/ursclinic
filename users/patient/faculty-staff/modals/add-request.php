<?php
session_start();
include('connection.php');


$patient = $_POST['patient'];
$date = $_POST['date'];
$time = $_POST['time'];
$request = $_POST['request'];
$quantity = $_POST['quantity'];
$purpose = $_POST['purpose'];

if (isset($_POST['medicine'])) {

  $medicine = $_POST['medicine'];

  $sql = "INSERT INTO transaction_request SET patient='$patient', request_type='$request', medid='$medicine', qty='$quantity', purpose='$purpose', date_pickup='$date', time_pickup='$time', status='Pending'";

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
    $sql = "UPDATE inventory_medicine SET qty = qty - $quantity WHERE medid='$medicine'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
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

  $sql = "INSERT INTO transaction_request SET patient='$patient', request_type='$request', supid='$medical', qty='$quantity', purpose='$purpose', date_pickup='$date', time_pickup='$time', status='Pending'";

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
    $sql = "UPDATE inventory_supply SET qty = qty - $quantity WHERE supid='$medical'";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));


  ?>
    <script>
      setTimeout(function() {
        window.location = "../request";
      });
    </script>
<?php
  }
}
mysqli_close($conn);
