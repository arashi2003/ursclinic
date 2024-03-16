<?php
include('../../connection.php');

$sql = "SELECT * FROM medicine WHERE med_admin = '" . $_POST['medadmin'] . "'";
$output = '';
$result = mysqli_query($conn, $sql);
$output .= '<option value="" disable selected>-Select Medicine-</option>';
while ($row = mysqli_fetch_array($result)) {
    $output .= '<option value="' . $row['medicine'] . '">' . $row['medicine'] . '</option>';
}
echo $output;
