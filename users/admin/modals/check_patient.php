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
        // Account exists in the account table
        $account = $result->fetch_assoc(); // Fetch the account details
        if (count(explode(" ", $account['middlename'])) > 1) {
            $middle = explode(" ", $account['middlename']);
            $letter = !empty($middle[0][0]) . !empty($middle[1][0]);
            $middleinitial = $letter . ".";
        } else {
            $middle = $account['middlename'];
            if ($middle == "" or $middle == " ") {
                $middleinitial = "";
            } else {
                $middleinitial = substr($middle, 0, 1) . ".";
            }
        }

        $fullname = ucwords(strtolower($account['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($account['lastname'])); // Get the full name
        $email = $account['email'];
        $contactno = $account['contactno'];

        // Perform a database query to check if patient info exists
        $query1 = "SELECT * FROM patient_info WHERE patientid = ?";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bind_param("s", $patientId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        // Check if patient info exists
        if ($result1->num_rows > 0) {
            // Patient info already exists
            echo json_encode(array('error' => 'Patient Information already exists.'));
            exit; // Exit the script to prevent further execution
        } else {
            // Patient info does not exist
            $response = array(
                'success' => true,
                'fullname' => $fullname,
                'email' => $email,
                'contactno' => $contactno
            );
            echo json_encode($response);
        }

        // Close statement for patient info check
        $stmt1->close();
    } else {
        // Account does not exist
        echo json_encode(array('error' => 'Account ID does not exist.'));
    }

    // Close statement for account check
    $stmt->close();

    // Close database connection
    $conn->close();
}
