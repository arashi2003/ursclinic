<?php
include('modals/connection.php');

// Check if the POST data is set
if (isset($_POST['time_fromp'])) {
    $time_fromp = $_POST['time_fromp'];
    $physician = $_POST['physician'];
    $date = $_POST['date'];
    $sched = date("Y-m-d", strtotime($date));
    $time = $_POST['time_fromp'];
    $sched_time = date("H:i:s", strtotime($time)); // Fix: Changed variable name from $sched to $sched_time

    $sks = "SELECT * FROM schedule WHERE name = '$physician' AND date = '$sched'";
    $result = mysqli_query($conn, $sks);
    while ($brrt = mysqli_fetch_array($result)) {
        $tfp = $brrt['time_from'];
        $ttp = $brrt['time_to'];
    }

    // Perform SQL injection prevention here if necessary
    $sql = "SELECT * FROM time_pickup WHERE time > '$sched_time' AND time <= '$ttp' "; // Fix: Changed $time_from to $sched_time
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
?>