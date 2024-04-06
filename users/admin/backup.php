<?php
session_start();
// Database configuration
$host = "localhost";
$username = "u442253511_dburs_usu";
$password = "Ursclinic1.";
$database_name = "u442253511_dburs_usu";

// Get conection object and set the charset
$con = mysqli_connect($host, $username, $password, $database_name);
$con->set_charset('utf8');


$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "backed up the database";
$au_status = "unread";
$query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
mysqli_query($con, $query);

// Get all tables names from database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {

    // Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);

    $sqlScript .= "\n\n" . $row[1] . ";\n\n";

    $query = "SELECT * FROM $table";
    $result = mysqli_query($con, $query);

    $columnCount = mysqli_num_fields($result);
    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                $row[$j] = $row[$j];

                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    $sqlScript .= "\n";
}

if (!empty($sqlScript)) {

    // Construct the file path within the backup directory
    $backup_file_name = $database_name . '_backup_' . date('Ymd') . '.sql';

    // Save the SQL script to the backup file
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);

    // Download the SQL backup file to the browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    exec('rm ' . $backup_file_name);
}
