<?php
include('../../connection.php');

$sql0 = "SELECT * FROM med_admin WHERE id = '" . $_POST['medadmin'] . "'";
$result = mysqli_query($conn, $sql0);
while ($data = mysqli_fetch_array($result)) {
    $medadminid=$data['med_admin'];
}

$sql = "SELECT * FROM medicine WHERE med_admin = '" . $medadminid . "'";
$output = '';
$result = mysqli_query($conn, $sql);
$output .= '<option value="" disable selected>-Select Medicine-</option>';
while ($row = mysqli_fetch_array($result)) {
    $output .= '<option value="' . $row['medid'] . '">' . $row['medicine'] . " ". $row['dosage'] . $row['unit_measure'] . '</option>';
}
echo $output;
