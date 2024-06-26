<?php
include('modals/connection.php');
session_start();
$campus = $_SESSION['campus'];

// Check if the POST data is set
if(isset($_POST['time_fromn'])) {
    $time_fromn = $_POST['time_fromn'];

    // Perform SQL injection prevention here if necessary
    $sql = "SELECT * FROM time_pickup WHERE time > '$time_fromn' AND campus = '$campus'";
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
    // If POST data is not set, return an error message
    echo "Error: No data received";
}
