<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a medicine administration";
    $au_status = "unread";
    
    $sql = "DELETE FROM med_admin WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Medicine Administration has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medadmin_set";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Medicine Administration has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medadmin_set";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Medicine Administration was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../medadmin_set";
    });
</script>
<?php
}
mysqli_close($conn);