<?php
session_start();
include('connection.php');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../../phpmailer/src/Exception.php';
require '../../../phpmailer/src/PHPMailer.php';
require '../../../phpmailer/src/SMTP.php';

$name = $_POST['name'];
$date = $_POST['date'];
$time = $_POST['time'];
$email = $_POST['email'];
$physician = $_POST['physician'];
$reason = $_POST['reason'];

$id = $_POST['id'];
$sql = "UPDATE appointment SET status='DISAPPROVED', reason = '$reason' WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$query = "SELECT * FROM appointment WHERE id = '$id'";
$result = mysqli_query($conn, $query);
while ($data = mysqli_fetch_array($result)) {
    $patientid = $data['patient'];
}

if ($result) {
    $userid = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $activity = "disapproved an appointment of " . $patientid;

    $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    $_SESSION['alert'] = "Appointment has been disapproved!";

    // Send email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = 'urshealthservice@gmail.com'; // Your SMTP username
    $mail->Password = 'viwnydtwfagjlzyy'; // Your SMTP password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465; // TCP port to connect to
    $mail->setFrom('urshealthservice@gmail.com', 'URS Health Service Unit');
    $mail->addAddress($email); // Assuming you have user's email in session
    $mail->isHTML(true);
    $mail->Subject = 'Appointment Disapproved';
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

    <div class="container">
            <div class="header">
                <h1 style="margin: 0;">URS Health Services Unit</h1>
            </div>
            <div class="body">
                <h2>Appointment Disapproved</h2>
                <p>Dear ' . $name . ',</p>
                <p>Your appointment has been disapproved due to ' . $reason . '</p>
                <p><strong>Appointment Details:</strong></p>
                <ul>
                    <li><strong>Date:</strong> ' . $date . '</li>
                    <li><strong>Time:</strong> ' . $time . '</li>
                    <li><strong>Physician:</strong> ' . $physician . '</li>
                </ul>
            </div>
            <div class="footer">
                <p>Please feel free to reach out to us at <a href="mailto:urshealthservice@gmail.com">urshealthservice@gmail.com</a>
                for any further assistance.</p>
            </div>
        </div>

    </html>
    ';

    if ($mail->send()) {
        // Email sent successfully
        $_SESSION['alert'] .= " An email has been sent to the patient.";
    } else {
        // Email sending failed
        $_SESSION['alert'] .= " Email could not be sent to the patient.";
    }
?>
    <script>
        setTimeout(function() {
            window.location = "../appointment?tab=pending";
        });
    </script>
<?php
} else {
    echo "Failed: " . mysqli_error($conn);
}
