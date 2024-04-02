<?php
session_start();
include('modals/connection.php');

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

if (isset($_POST['app_disapproved'])) {
    $all_id = explode(',', $_POST['disapprovedIDs']);
    $reason = $_POST['reason'];

    foreach ($all_id as $id) {
        $query = "SELECT * FROM appointment WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_array($result);

        $date = date("F d, Y", strtotime($data['date']));
        $time = $data['time_from'] . " - " . $data['time_to'];
        $time_from = $data['time_from'];
        $time_to = $data['time_to'];
        $physician = $data['physician'];
        $patientid = $data['patient'];

        $sql = "UPDATE appointment SET status='DISAPPROVED', reason = '$reason' WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);

        // Fetch patient details
        $query = "SELECT * FROM account WHERE accountid = '$patientid'";
        $result = mysqli_query($conn, $query);
        $brr = mysqli_fetch_array($result);

        if (count(explode(" ", $brr['middlename'])) > 1) {
            $middle = explode(" ", $brr['middlename']);
            $letter = $middle[0][0] . $middle[1][0];
            $middleinitial = $letter . ".";
        } else {
            $middle = $brr['middlename'];
            if ($middle == "" or $middle == " ") {
                $middleinitial = "";
            } else {
                $middleinitial = substr($middle, 0, 1) . ".";
            }
        }
        $name = ucwords(strtolower($brr['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($brr['lastname']));
        $email = $brr['email'];

        $userid = $_SESSION['userid'];
        $au_campus = $_SESSION['campus'];
        $fullname = strtoupper($_SESSION['name']);
        $au_status = "unread";
        $activity = "disapproved an appointment of " . $patientid;

        $query = "INSERT INTO audit_trail (user, campus, fullname, activity, status, datetime) VALUES ('$userid', '$au_campus', '$fullname', '$activity', '$au_status', now())";
        mysqli_query($conn, $query) or die(mysqli_error($conn));


        // Update time pickup
        $sql = "UPDATE time_pickup SET isSelected = 'No' WHERE time IN ('$time_from', '$time_to')";
        mysqli_query($conn, $sql);

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
        $mail->addAddress($email);
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
    }

    $_SESSION['alert'] = "Appointment has been disapproved!";

    if ($mail->send()) {
        // Email sent successfully
        $_SESSION['alert'] .= " An email has been sent to the patient.";
    } else {
        // Email sending failed
        $_SESSION['alert'] .= " Email could not be sent to the patient.";
    }
    // Redirect after processing all disapproved appointments
?>
    <script>
        setTimeout(function() {
            window.location = "appointment?tab=pending";
        });
    </script>
<?php
}
?>