<?php
include('../../connection.php');

if (isset($_POST['type'])) {
    $type = $_POST['type'];

    if ($type == 'department') {
        $output = '';
        $sql = "SELECT * FROM yearlevel WHERE department = '" . $_POST['did'] . "'";
        $result = mysqli_query($conn, $sql);
        $output .= '<option value="" disabled selected>-Select Year Level-</option>';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '<option value="' . $row['yearlevel'] . '">' . $row['yearlevel'] . '</option>';
        }
        echo $output;
    }
} else {
    $sql = "SELECT * FROM program WHERE college = '" . $_POST['cid'] . "'";
    $output = '';
    $result = mysqli_query($conn, $sql);
    $output .= '<option value="" disabled selected>-Select Program-</option>';
    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value="' . $row['abbrev'] . '">' . $row['program'] . '</option>';
    }
    echo $output;
}
