<?php
session_start();
//form validation
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username == 'superadmin' and $password == 'superadmin') {
    $_SESSION['username'] = $username;
    header('location: users/superadmin/index');
    exit(0);
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

      <div class="input-box">
        <input type="text" id="username" placeholder="Enter your username" name="username" autocomplete="off">
        <i class='bx bxs-user'></i>
      </div>

      <div class="input-box">
        <input type="password" id="password" placeholder="Enter your password" name="password" autocomplete="off">
        <i class='bx bxs-lock-alt'></i>
      </div>

      <button type="submit" class="login-btn" name="submit">Login</button>
    </form>
  </div>
</body>

</html>