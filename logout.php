<?php
session_start();
include('connection.php');

// Destroy Sessions
if (session_destroy()) {
  //redirect to login
?>
  <script>
    setTimeout(function() {
      window.location = "index";
    });
  </script>
<?php
}

//select data from usertb for audit trail
$username = $_SESSION['username'];
$sql = "SELECT * FROM account WHERE lastname='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
$campus = $row['campus'];
$userno = $row['accountid'];

//audit trail
$sql = "INSERT INTO audit_trail SET campus='$campus', user='$userno', fullname='$fullname', activity='Logged Out'";
mysqli_query($conn, $sql) or die(mysqli_error($conn));

?>