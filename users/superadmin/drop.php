<?php
session_start();
$target_host = "localhost";
$target_username = "u442253511_dburs_usu"; //"root";//
$target_password = 'Ursclinic1.'; //"" ;//
$target_database_name = "u442253511_dburs_usu"; //"dburs_usu";//

// Create connection
$conn = new mysqli($target_host, $target_username, $target_password, $target_database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS=0");

// Get a list of tables in the database
$tables_result = $conn->query("SHOW TABLES");
if ($tables_result) {
    while ($table_row = $tables_result->fetch_row()) {
        $table_name = $table_row[0];
        // Drop each table
        $drop_table_sql = "DROP TABLE $table_name";
        if ($conn->query($drop_table_sql) === TRUE) {
            $_SESSION['alert'] .= "Table $table_name has been dropped<br>";
        } else {
            $_SESSION['alert'] .= "Error dropping table $table_name: " . $conn->error . "<br>";
        }
    }
} else {
    $_SESSION['alert'] = 'Error getting list of tables: ' . $conn->error;
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS=1");

$conn->close();

header('location: index.php');
