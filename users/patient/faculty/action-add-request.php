<?php

session_start();

include('../../../connection.php');

$patient = $_POST['patient'];
$date = $_POST['date'];
$time = $_POST['time'];
$quantity = $_POST['quantity'];
$request = $_POST['request'];
$purpose = $_POST['purpose'];

if (isset($_POST['medicine'])) {
    foreach ($_POST['medicine'] as $key => $value) {
        $stmt = $conn->prepare('INSERT INTO transaction_request (patient, request_type, medid, qty, purpose, date_pickup, time_pickup, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $patient,
            $request,
            $value,
            $_POST['quantity'][$key],
            $purpose,
            $date,
            $time,
            'Pending'
        ]);
    }
} elseif (isset($_POST['medical'])) {
    foreach ($_POST['medical'] as $key => $value) {
        $stmt = $conn->prepare('INSERT INTO transaction_request (patient, request_type, supid, qty, purpose, date_pickup, time_pickup, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $patient,
            $request,
            $value,
            $_POST['quantity'][$key],
            $purpose,
            $date,
            $time,
            'Pending'
        ]);
    }
}
