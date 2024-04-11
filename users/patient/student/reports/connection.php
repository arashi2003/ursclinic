<?php
$host = "localhost";
$user = "u442253511_dburs_usu";
$password = 'Ursclinic1.';
$db_name = "u442253511_dburs_usu";
date_default_timezone_set("Asia/Manila");

$conn = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}
