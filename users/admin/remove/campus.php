<?php
    session_start();
    include('../add/connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a campus";
    $au_status = "unread";
    
    $sql = "DELETE FROM campus WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Campus has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../campus";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Campus has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../campus";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Campus was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../campus";
    });
</script>
<?php
}
mysqli_close($conn);