<?php
    session_start();
    include('../add/connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed an entry to the organization";
    $au_status = "unread";
    
    $sql = "DELETE FROM organization WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Entry has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../organization";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Entry has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../organization";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Entry was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../organization";
    });
</script>
<?php
}
mysqli_close($conn);