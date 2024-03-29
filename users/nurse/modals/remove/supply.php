<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a supply entry";
    $au_status = "unread";
    
    $sql = "DELETE FROM supply WHERE supid = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Medical Supply has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_entry";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Medical Supply has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_entry";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Medical Supply was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../sup_entry";
    });
</script>
<?php
}
mysqli_close($conn);