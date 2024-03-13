<?php
session_start();
//connection
include('connection.php');

// Initialize login attempts counter
if (!isset($_SESSION['login_attempts'])) {
  $_SESSION['login_attempts'] = 0;
}

// Initialize timer
if (!isset($_SESSION['timer_start'])) {
  $_SESSION['timer_start'] = 0;
}

// Initialize error message
$error = '';

if (isset($_SESSION['usertype']) == "NURSE") {
  header('location:users/nurse/dashboard');
} elseif (isset($_SESSION['usertype']) == "STUDENT") {
  header('location:users/patient/student/studentappointment');
} elseif (isset($_SESSION['usertype']) == "DOCTOR") {
  header('location:users/doctor-dentist/dashboard');
} elseif (isset($_SESSION['usertype']) == "DENTIST") {
  header('location:users/doctor-dentist/dashboard');
} elseif (isset($_SESSION['usertype']) == "ADMIN") {
  header('location:users/admin/profile');
} elseif (isset($_SESSION['usertype']) == "FACULTY") {
  header('location:users/patient/faculty/facultyappointment');
} elseif (isset($_SESSION['usertype']) == "STAFF") {
  header('location:users/patient/faculty/facultyappointment');
}

//form validation
if (isset($_POST['submit'])) {
  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //get data from input
  $username = validate($_POST['username']);
  $password = validate($_POST['password']);

  // Increment login attempts counter
  $_SESSION['login_attempts']++;

  //error trapping
  if (empty($username) || empty($password)) {
    $error = "Username and password are required.";
  } else {

    $sql = "select * from account where BINARY accountid = '$username' and BINARY password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);

    if ($count == 1 && $row['usertype'] == "NURSE") {

      //select data from usertb for audit trail
      $sql = "SELECT * FROM account WHERE accountid='$username'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $campus = $row['campus'];

      //audit trail
      $sql = "INSERT INTO audit_trail SET campus='$campus', user='$username', fullname='$fullname', activity='Logged In'";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));

      //redirect to dashboard
      $_SESSION['username'] = $row['lastname'];
      $_SESSION['campus'] = $row['campus'];
      $_SESSION['userid'] = $row['accountid'];
      $_SESSION['usertype'] = $row['usertype'];
      $_SESSION['name'] = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $_SESSION['alert'] = 'You have successfully logged in!';
    ?>
      <script>
        setTimeout(function() {
          window.location = "users/nurse/dashboard";
        });
      </script>
    <?php

    } elseif ($count == 1 && $row['usertype'] == "DOCTOR") {

      //select data from usertb for audit trail
      $sql = "SELECT * FROM account WHERE accountid='$username'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $campus = $row['campus'];

      //audit trail
      $sql = "INSERT INTO audit_trail SET campus='$campus', user='$username', fullname='$fullname', activity='Logged In'";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));

      //redirect to dashboard
      $_SESSION['username'] = $row['lastname'];
      $_SESSION['usertype'] = $row['usertype'];
      $_SESSION['campus'] = $row['campus'];
      $_SESSION['accountid'] = $row['accountid'];
      $_SESSION['name'] = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $_SESSION['alert'] = 'You have successfully logged in!';
    ?>
      <script>
        setTimeout(function() {
          window.location = "users/doctor/dashboard";
        });
      </script>
    <?php


    } elseif ($count == 1 && $row['usertype'] == "DENTIST") {

      //select data from usertb for audit trail
      $sql = "SELECT * FROM account WHERE accountid='$username'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $campus = $row['campus'];

      //audit trail
      $sql = "INSERT INTO audit_trail SET campus='$campus', user='$username', fullname='$fullname', activity='Logged In'";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));

      //redirect to dashboard
      $_SESSION['username'] = $row['lastname'];
      $_SESSION['usertype'] = $row['usertype'];
      $_SESSION['campus'] = $row['campus'];
      $_SESSION['userid'] = $row['accountid'];
      $_SESSION['name'] = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $_SESSION['alert'] = 'You have successfully logged in!';
    ?>
      <script>
        setTimeout(function() {
          window.location = "users/dentist/dashboard";
        });
      </script>
    <?php


    } elseif ($count == 1 && $row['usertype'] == "STUDENT") {

      //select data from usertb for audit trail
      $sql = "SELECT * FROM account WHERE accountid='$username'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $campus = $row['campus'];

      //audit trail
      $sql = "INSERT INTO audit_trail SET campus='$campus', user='$username', fullname='$fullname', activity='Logged In'";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));

      //redirect to dashboard
      $_SESSION['userid'] = $row['accountid'];
      $_SESSION['username'] = $row['lastname'];
      $_SESSION['usertype'] = $row['usertype'];
      $_SESSION['campus'] = $row['campus'];
      $_SESSION['name'] = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $_SESSION['alert'] = 'You have successfully logged in!';
    ?>
      <script>
        setTimeout(function() {
          window.location = "users/patient/student/appointment";
        });
      </script>
    <?php

    } elseif ($count == 1 && $row['usertype'] == "FACULTY") {

      //select data from usertb for audit trail
      $sql = "SELECT * FROM account WHERE accountid='$username'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $campus = $row['campus'];

      //audit trail
      $sql = "INSERT INTO audit_trail SET campus='$campus', user='$username', fullname='$fullname', activity='Logged In'";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));

      //redirect to dashboard
      $_SESSION['userid'] = $row['accountid'];
      $_SESSION['username'] = $row['lastname'];
      $_SESSION['usertype'] = $row['usertype'];
      $_SESSION['campus'] = $row['campus'];
      $_SESSION['name'] = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $_SESSION['alert'] = 'You have successfully logged in!';
    ?>
      <script>
        setTimeout(function() {
          window.location = "users/patient/faculty-staff/appointment";
        });
      </script>
    <?php

    } elseif ($count == 1 && $row['usertype'] == "ADMIN") {

      //select data from usertb for audit trail
      $sql = "SELECT * FROM account WHERE accountid='$username'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);

      $fullname = $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname'];
      $campus = $row['campus'];

      //audit trail
      $sql = "INSERT INTO audit_trail SET campus='$campus', user='$username', fullname='$fullname', activity='Logged In'";
      mysqli_query($conn, $sql) or die(mysqli_error($conn));


      if (count(explode(" ", $row['middlename'])) > 1) {
        $middle = explode(" ", $row['middlename']);
        $letter = $middle[0][0] . $middle[1][0];
        $middleinitial = $letter . ".";
      } else {
        $middle = $row['middlename'];
        if ($middle == "" or $middle == " ") {
          $middleinitial = "";
        } else {
          $middleinitial = substr($middle, 0, 1) . ".";
        }
      }

      //redirect to dashboard
      $_SESSION['userid'] = $row['accountid'];
      $_SESSION['username'] = $row['lastname'];
      $_SESSION['usertype'] = $row['usertype'];
      $_SESSION['campus'] = $row['campus'];
      $_SESSION['name'] = $row['firstname'] . ' ' . $middleinitial . ' ' . $row['lastname'];
      $_SESSION['alert'] = 'You have successfully logged in!';
    ?>
      <script>
        setTimeout(function() {
          window.location = "users/admin/profile";
        });
      </script>
<?php

    } else {
      $error = "Incorrect username or password.";

      // Check if login attempts exceed 3, if yes, start timer
      if ($_SESSION['login_attempts'] >= 3 && $_SESSION['timer_start'] == 0) {
        $_SESSION['timer_start'] = time();
      }
    }
  }
}

// Check if timer is active
if ($_SESSION['timer_start'] > 0) {
  $timer_duration = 10; // 10 seconds
  $remaining_time = $timer_duration - (time() - $_SESSION['timer_start']);

  if ($remaining_time <= 0) {
    // Reset timer and login attempts counter
    $_SESSION['timer_start'] = 0;
    $_SESSION['login_attempts'] = 0;
    header('location: index'); // Redirect to index after timer ends
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <link rel="shortcut icon" type="x-icon" href="images/university-seal.png">
  <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
  <div class="wrapper">
    <form action="" method="POST" id="loginForm">
      <div class="urs-icon">
        <img src="images/university-seal.png" alt="icon" class="icon">
      </div>

      <h1>University of Rizal System</h1>
      <hr>
      <h1>Login</h1>

      <?php if (!empty($error)) : ?>
        <p class="error"><?php echo $error; ?></p>
      <?php endif; ?>

      <?php if ($_SESSION['timer_start'] > 0) : ?>
        <p id="countdown" class="error">Please wait for <?php echo $remaining_time; ?> seconds</p>
      <?php endif; ?>

      <div class="input-box">
        <input type="text" id="username" placeholder="Enter your username" name="username" autocomplete="off" <?php if ($_SESSION['timer_start'] > 0) echo 'disabled'; ?>>
        <i class='bx bxs-user'></i>
      </div>

      <div class="input-box">
        <input type="password" id="password" placeholder="Enter your password" name="password" autocomplete="off" <?php if ($_SESSION['timer_start'] > 0) echo 'disabled'; ?>>
        <i class='bx bxs-lock-alt'></i>
      </div>

      <button type="submit" class="login-btn <?php if ($_SESSION['timer_start'] > 0) echo 'disabled'; ?>" name="submit" <?php if ($_SESSION['timer_start'] > 0) echo 'disabled'; ?>>Login</button>
    </form>
  </div>

  <!-- Add your JavaScript links here -->
  <script>
    // JavaScript code for countdown timer
    <?php if ($_SESSION['timer_start'] > 0) : ?>
      var timer = <?php echo $remaining_time; ?>;
      var countdownElement = document.getElementById('countdown');
      var interval = setInterval(function() {
        timer--;
        countdownElement.innerText = 'Please wait for ' + timer + ' seconds';
        if (timer <= 0) {
          clearInterval(interval);
          window.location = 'index';
        }
      }, 1000);
    <?php endif; ?>
  </script>
</body>


</html>