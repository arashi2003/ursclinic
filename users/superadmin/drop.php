<?php
session_start();
$target_host = "localhost";
$target_username = "root";
$target_password = "";
$target_database_name = "dburs_usu";

// Create connection
$conn = new mysqli($target_host, $target_username, $target_password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists
$result = $conn->query("SHOW DATABASES LIKE '$target_database_name'");
if ($result->num_rows == 1) {
    // Database exists, drop it
    $sql = "DROP DATABASE $target_database_name";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['alert'] = 'Database has been dropped';
    } else {
        $_SESSION['alert'] = 'Error dropping database: ' . $conn->error;
    }
} else {
    // Database does not exist
    $_SESSION['alert'] = 'Database does not exist';
}

$conn->close();

header('location: index.php');
