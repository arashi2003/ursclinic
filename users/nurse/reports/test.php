<?php

session_start();
include('connection.php');
echo $_SESSION['userid'] . "<p>";
echo $_SESSION['campus'] . "<p>";
echo $_POST['physician'] . "<p>";
echo $_POST['status'] . "<p>";
echo $_POST['date_from'] . "<p>";
echo $_POST['date_to'] . "<p>";
