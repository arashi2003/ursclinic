<?php
// Include database connection and other necessary files
include('../modals/connection.php');

// Handle the AJAX request to fetch patient data
if (isset($_POST['action']) && $_POST['action'] === 'fetch_patient_data' && isset($_POST['patientid'])) {
    // Fetch patient data if a patient ID is provided
    $patientid = $_POST['patientid'];

    // Perform a database query to retrieve patient data based on the provided ID
    $query = "SELECT * FROM patient_info p INNER JOIN account a ON a.accountid=p.patientid WHERE patientid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $patientid);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching patient is found
    if ($result->num_rows > 0) {
        // Fetch the patient data
        $patientData = $result->fetch_assoc();

        // Return the patient data as JSON
        echo json_encode($patientData);
    } else {
        // Patient not found
        // Return an error message as JSON
        echo json_encode(array('error' => 'Patient not found'));
    }

    // Close database connections and resources
    $stmt->close();
    $conn->close();
}
