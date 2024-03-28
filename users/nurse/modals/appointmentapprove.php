<?php
session_start();
include('connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader

require '../../../phpmailer/src/Exception.php';
require '../../../phpmailer/src/PHPMailer.php';
require '../../../phpmailer/src/SMTP.php';

$date = $_POST['date'];
$time = $_POST['time'];
$email = $_POST['email'];
$physician = $_POST['pod_nod'];

$id = $_GET['no'];
$sql = "UPDATE appointment SET status='APPROVED' WHERE id='$id'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Select data from usertb for audit trail
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = "approved a request for appointment";

    // Insert audit trail
    $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Email content
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'urshealthservice@gmail.com'; // Your SMTP username
    $mail->Password = 'viwnydtwfagjlzyy'; // Your SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465; // TCP port to connect to
    $mail->setFrom('urshealthservice@gmail.com', 'URS Health Service'); // Replace with your company name and email
    $mail->addAddress($email); // Recipient's email
    $mail->isHTML(true);
    $mail->Subject = 'Appointment Approved';
    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Template</title>
        <style>
            /* Add your custom CSS styles here */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #052659; /* Header background color */
                padding: 20px;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
                text-align: center; /* Center align text */
                color: #fff; /* Header text color */
            }
            .body {
                background-color: #f2f2f2; /* Body background color */
                padding: 20px;
            }
            .footer {
                background-color: #f9f9f9; /* Footer background color */
                padding: 20px;
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
                text-align: center; /* Center align text */
                color: #666; /* Footer text color */
            }
            h1, h2 {
                margin-top: 0;
            }
            ul {
                margin-top: 0;
                padding-left: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1 style="margin: 0;">URS Health Service</h1>
            </div>
            <div class="body">
                <h2>Appointment Approved</h2>
                <p>Dear ' . $fullname . ',</p>
                <p>We are pleased to inform you that your appointment has been approved.</p>
                <p><strong>Appointment Details:</strong></p>
                <ul>
                    <li><strong>Date:</strong> ' . $date . '</li>
                    <li><strong>Time:</strong> ' . $time . '</li>
                    <li><strong>Physician:</strong> ' . $physician . '</li>
                </ul>
            </div>
            <div class="footer">
                <p>Please feel free to reach out to us at <a href="mailto:urshealthservice@gmail.com">urshealthservice@gmail.com</a> for any further assistance.</p>
            </div>
        </div>
    </body>
    </html>';

    // Send email
    if ($mail->send()) {
        $_SESSION['alert'] = 'You have approved an appointment and an email has been sent.';
    } else {
        $_SESSION['alert'] = 'You have approved an appointment, but the email could not be sent.';
    }

    // Redirect
    echo '<script>window.location = "../appointment";</script>';
} else {
    echo "Failed: " . mysqli_error($conn);
}
