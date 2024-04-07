<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['restoreBtn'])) {
    // Target database configuration
    $target_host = "localhost";
    $target_username = "u442253511_dburs_usu"; //"root";//
    $target_password = 'Ursclinic1.'; //"" ;//
    $target_database_name = "u442253511_dburs_usu"; //"dburs_usu";//

    // Connect to MySQL server
    $con = mysqli_connect($target_host, $target_username, $target_password);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "<div class='container mt-3 alert alert-danger' role='alert'>";
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        echo "</div>";
        exit();
    }

    // Check if the target database exists
    $database_exist_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$target_database_name'";
    $result = mysqli_query($con, $database_exist_query);

    if (mysqli_num_rows($result) == 0) {
        // If the target database does not exist, create it
        $create_database_query = "CREATE DATABASE $target_database_name";
        if (mysqli_query($con, $create_database_query)) {
            $_SESSION['alert'] .= "Database '$target_database_name' created successfully.";
        } else {
            echo "<div class='container mt-3 alert alert-danger' role='alert'>";
            echo "Error creating database: " . mysqli_error($con);
            echo "</div>";
            exit();
        }
    }

    // Close the connection to MySQL server
    mysqli_close($con);

    // Connect to the target database
    $con = mysqli_connect($target_host, $target_username, $target_password, $target_database_name);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "<div class='container mt-3 alert alert-danger' role='alert'>";
        echo "Failed to connect to the target database: " . mysqli_connect_error();
        echo "</div>";
        exit();
    }

    // Check if file is uploaded successfully
    if (isset($_FILES['backupFile']) && $_FILES['backupFile']['error'] === UPLOAD_ERR_OK) {
        $backup_file = $_FILES['backupFile']['tmp_name'];

        // Read SQL file
        $sql = file_get_contents($backup_file);

        // Split SQL file into individual queries
        $queries = explode(";\n", $sql);

        // Execute each query
        foreach ($queries as $query) {
            // Modify SQL to use IF NOT EXISTS clause for CREATE TABLE statements
            $query = preg_replace('/CREATE TABLE ([^\s(]+)/', 'CREATE TABLE IF NOT EXISTS $1', $query);
            // Execute query
            if (!empty(trim($query))) {
                if (!mysqli_query($con, $query)) {
                    echo "<div class='container mt-3 alert alert-danger' role='alert'>";
                    echo "Error executing query: " . mysqli_error($con);
                    echo "</div>";
                    exit();
                }
            }
        }

        $_SESSION['alert'] .= ' Database has been restored';
    } else {
        $_SESSION['alert'] .= ' Database was not restored';
    }
    header('location: index');
    // Close connection
    mysqli_close($con);
}
