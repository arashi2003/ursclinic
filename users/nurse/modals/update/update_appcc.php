<?php
    session_start();
    include('../connection.php');
    $id = $_POST['id'];
    $purpose = $_POST['purpose'];
    $appcc = $_POST['appcc'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an appointment chief complaint entry";
    $au_status = "unread";
    
    $sql = "UPDATE appointment_cc SET purpose='$purpose', chief_complaint='$appcc' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Chief Complaint for Appointment has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../appcc_set";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Chief Complaint for Appointment has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../appcc_set";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Chief Complaint for Appointment has been updated.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../appcc_set";
    });
</script>
<?php
}
mysqli_close($conn);