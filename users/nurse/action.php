<?php
include('../../../connection.php');
$type = $_POST['type'];

if ($type == 'purpose') {
    $output = '';
    $sql = "SELECT * FROM appointment_cc WHERE purpose = '" . $_POST['pid'] . "'";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disable selected>-Select Chief Complaint-</option>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row['chief_complaint'] . '">' . $row['chief_complaint'] . '</option>';
    }
    echo $output;
} else {
    $sql = "SELECT * FROM appointment_purpose WHERE type = '" . $_POST['aid'] . "'";
    $output = '';
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disable selected>-Select Purpose-</option>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row['id'] . '">' . $row['purpose'] . '</option>';
    }
    echo $output;
}
