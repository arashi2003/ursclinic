<?php
$host = "localhost";
$user = "u442253511_dburs_usu";
$password = 'Ursclinic1.';
$db_name = "u442253511_dburs_usu";

$conn = mysqli_connect($host, $user, $password, $db_name);
if (mysqli_connect_errno()) {
    die("Failed to connect with MySQL: " . mysqli_connect_error());
}
