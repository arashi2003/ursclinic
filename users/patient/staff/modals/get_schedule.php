<?php

include('connection.php');

$sql = "SELECT * FROM schedule WHERE physician = '" . $_POST['pid'] . "'";
$output = '';
$result = mysqli_query($conn, $sql);
$output .= '<option value="" disabled selected>-Select Date-</option>';
while ($row = mysqli_fetch_array($result)) {
    $output .= '<option value="' . $row['date'] . '">' . $row['date'] . '</option>';
}
echo $output;
