<?php
session_start();
include('../../connection.php');

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
            // If update successful, send success response
            echo "Remarks and Status updated successfully!";
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
