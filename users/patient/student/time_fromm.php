<?php
include('modals/connection.php');
session_start();
$campus = $_SESSION['campus'];

// Check if the POST data is set
if (isset($_POST['date'])) {
    $date = $_POST['date'];
    $today = date("Y-m-d");
    $now = date("H:i:s", strtotime("+ 8 hours"));

    if ($date == $today) {
        // Perform SQL injection prevention here if necessary
        $sql = "SELECT * FROM time_pickup WHERE time < '$now' AND campus = '$campus'";
        $output = '';
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Loop through the results and generate the options
            while ($row = mysqli_fetch_array($result)) {
                $output .= '<option value="' . date("H:i:s", strtotime($row['time'])) . '">' . date('g:i A', strtotime($row['time'])) .  '</option>';
            }
            echo $output;
        } else {
            // If query fails, log the error
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Perform SQL injection prevention here if necessary
        $sql = "SELECT * FROM time_pickup WHERE campus = '$campus'";
        $output = '';
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Loop through the results and generate the options
            while ($row = mysqli_fetch_array($result)) {
                $output .= '<option value="' . date("H:i:s", strtotime($row['time'])) . '">' . date('g:i A', strtotime($row['time'])) .  '</option>';
            }
            echo $output;
        } else {
            // If query fails, log the error
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
} else {
    // If POST data is not set, return an error message
    echo "Error: No data received";
}
