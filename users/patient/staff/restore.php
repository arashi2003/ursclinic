<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['restoreBtn'])) {
    // Target database configuration
    $target_host = "localhost";
    $target_username = "root";
    $target_password = "";
    $target_database_name = "db_usu_backup";

    // Connect to the target MySQL server
    $con = mysqli_connect($target_host, $target_username, $target_password, $target_database_name);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "<div class='container mt-3 alert alert-danger' role='alert'>";
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        echo "</div>";
        exit();
    }

    // Check if file is uploaded successfully
    if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] === UPLOAD_ERR_OK) {
        $backup_file = $_FILES['backupFile']['tmp_name'];

        // Read SQL file
        $sql = file_get_contents($backup_file);

        // Modify SQL to use IF NOT EXISTS clause for CREATE TABLE statements
        $sql = preg_replace('/CREATE TABLE ([^\s(]+)/', 'CREATE TABLE IF NOT EXISTS $1', $sql);

        // Execute SQL queries
        if (mysqli_multi_query($con, $sql)) {
            echo "<div class='container mt-3 alert alert-success' role='alert'>";
            echo "Database restored successfully.";
            echo "</div>";
        } else {
            echo "<div class='container mt-3 alert alert-danger' role='alert'>";
            echo "Error restoring database: " . mysqli_error($con);
            echo "</div>";
        }
    } else {
        echo "<div class='container mt-3 alert alert-danger' role='alert'>";
        echo "Failed to upload file. Please try again.";
        echo "</div>";
    }

    // Close connection
    mysqli_close($con);
}
