<?php

echo $_POST['time_top'];
/*
// TIME SETTINGS FOR APPOINTMENT



// Function to generate time increments
function generateTimeIncrements($time_from, $time_to, $interval) {
    $result = array();
    $current_time = new DateTime($time_from);
    $end_time = new DateTime($time_to);

    while ($current_time <= $end_time) {
        $result[] = $current_time->format('H:i:s');
        $current_time->add(new DateInterval('PT' . $interval)); // Add interval
    }

    return $result;
}

// Example usage
$time_from = '08:00:00'; // Starting time
$time_to = '18:00:00';   // Ending time
$interval = '70' . 'M';       // Interval in minutes

$time_increments = generateTimeIncrements($time_from, $time_to, $interval);

// Output the generated time increments
foreach ($time_increments as $time) {
    echo $time . "\n";
}
*/
?>
