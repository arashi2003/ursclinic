<?php
session_start();
include('../../connection.php');

$hehe = "SELECT applicant FROM meddoc WHERE id='$id'";
$result = mysqli_query($conn, $hehe);
if(mysqli_num_rows($result) > 0){
    while($fr = mysqli_fetch_array($result)){
        $patientid = $fr['applicant'];
    }
}

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "added a new remark for an uploaded medical document of " . $patientid;
$au_status = "unread";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if remarks, status, and id are set
    if (isset($_POST["remarks"]) && isset($_POST["status"]) && isset($_POST["id"])) {
        // Sanitize input to prevent SQL injection
        $remarks = mysqli_real_escape_string($conn, $_POST["remarks"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);
        $id = $_POST["id"];

        $today = date('Y-m-d h:i:s');
        // Update remarks and status in the database
        $sql = "UPDATE meddoc SET remarks='$remarks', dt_remarks='$today', status='$status' WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            $result = mysqli_query($conn, $sql);
            if($result){
                // If update successful, send success response
                $_SESSION['alert'] = 'Remarks and Status updated successfully!';
            }
        } else {
            // If update failed, send error response
            echo "Error updating remarks and status: " . mysqli_error($conn);
        }
    } else {
        // If remarks, status, or id is not set, send error response
        echo "Invalid request!";
    }
} else {
    // If request method is not POST, send error response
    echo "Invalid request method!";
}
