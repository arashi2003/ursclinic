<?php
include('../../../connection.php');

$type = $_POST['type'];

if ($type == 'purpose') {
    $output = '';
    $sql = "SELECT * FROM appointment_cc WHERE purpose = '" . $_POST['pid'] . "'";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disabled selected>-Select Chief Complaint-</option>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row['chief_complaint'] . '">' . $row['chief_complaint'] . '</option>';
    }
    echo $output;
} else if ($type == 'physician') {
    $output = '';
    $sql = "SELECT * FROM appointment_physician WHERE purpose = '" . $_POST['pid'] . "'";
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disabled selected>-Select Physician-</option>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row['physician'] . '">' . $row['physician'] . '</option>';
    }
    echo $output;
} else if ($type == 'date') {
    $today = date("Y-m-d");
        $output = '';
        $sql = "SELECT * FROM schedule WHERE name = '" . $_POST['pid'] . "' AND date > '$today' ORDER BY date DESC";
        $result = mysqli_query($conn, $sql);
        $output .= '<option value="" disabled selected>-Select Date-</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="' . $row['date'] . '">' . date("F d, Y", strtotime($row['date'])) . '</option>';
        }
        echo $output;
} else {
    $sql = "SELECT * FROM appointment_purpose WHERE type = '" . $_POST['aid'] . "'";
    $output = '';
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disabled selected>-Select Purpose-</option>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row['id'] . '">' . $row['purpose'] . '</option>';
    }
    echo $output;
}
