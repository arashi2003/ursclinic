<?php

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database_name = "dburs_usu";

// Get conection object and set the charset
$con = mysqli_connect($host, $username, $password, $database_name);
$con->set_charset('utf8');

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
    // Define the directory where the backup files will be saved
    $backup_directory = dirname('__FILE__') . '../../../../../backup/';

    // Check if the backup directory exists, if not, create it
    if (!is_dir($backup_directory)) {
        mkdir($backup_directory, 0777, true);
    }

    // Construct the file path within the backup directory
    $backup_file_name = $backup_directory . $database_name . '_backup_' . date('Ymd') . '.sql';

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
