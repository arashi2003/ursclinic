<?php
include('connection.php');

$sql = "SELECT * FROM time_pickup WHERE time > '" . $_POST['time_from'] . "'";
$output = '';
$result = mysqli_query($conn, $sql);
//$output .= '<option value="" disabled selected>-:-- --</option>';
while ($row = mysqli_fetch_array($result)) {
    $output .= '<option value="' . $row['time'] . '">' . date('g:i A', strtotime($row['time'])) .  '</option>';
}
echo $output;
?>