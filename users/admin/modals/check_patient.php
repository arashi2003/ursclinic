<?php
// Include database connection
include('connection.php');

// Handle the AJAX request to check if the account ID exists
if (isset($_POST['patientid'])) {
    $patientId = $_POST['patientid'];

    // Perform a database query to check if the account ID exists
    $query = "SELECT * FROM account WHERE accountid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching account is found
    if ($result->num_rows > 0) {
        // Account exists
        // Return a success response
        echo json_encode(array('success' => true));
    } else {
        // Account does not exist
        // Return an error message
        echo json_encode(array('error' => 'Account ID does not exist.'));
    }

    // Close database connections and resources
    $stmt->close();
    $conn->close();
}
