<?php
// update_status.php

// Assuming you have established a database connection earlier

include('../../connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    echo $id; // Log ID for debugging

    $updateQuery = "UPDATE audit_trail SET status = 'read' WHERE id = $id";
    echo $updateQuery; // Log SQL query for debugging
    mysqli_query($conn, $updateQuery);

} else {
    // Handle invalid request
    echo "Invalid request";
}
