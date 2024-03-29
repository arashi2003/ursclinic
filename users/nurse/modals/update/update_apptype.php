<?php
    session_start();
    include('../connection.php');
    $apptype = $_POST['apptype'];
    $id=$_POST['id'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an appointment type entry";
    $au_status = "unread";
    
    $sql = "UPDATE appointment_type SET type='$apptype' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Type of Appointment has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../apptype_set";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Type of Appointment has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../apptype_set";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Type of Appointment was not updated.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../apptype_set";
    });
</script>
<?php
}
mysqli_close($conn);