<?php
    session_start();
    include('../connection.php');
    $id=$_POST['id'];
    $apppurpose = $_POST['apppurpose'];
    $type = $_POST['type'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an appointment purpose entry";
    $au_status = "unread";
    
    $sql = "UPDATE appointment_purpose SET purpose='$apppurpose', type='$type' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Request has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../apppurpose_set";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Request has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../apppurpose_set";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Request was not updated.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../apppurpose_set";
    });
</script>
<?php
}
mysqli_close($conn);