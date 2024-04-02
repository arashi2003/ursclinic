<?php
    session_start();
    include('../add/connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a college";
    $au_status = "unread";
    
    $sql = "DELETE FROM college WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "College has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../college";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "College has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../college";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "College was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../college";
    });
</script>
<?php
}
mysqli_close($conn);