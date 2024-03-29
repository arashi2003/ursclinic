<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a medicine entry";
    $au_status = "unread";
    
    $sql = "DELETE FROM medicine WHERE medid = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Medicine has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../med_entry";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Medicine has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../med_entry";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Medicine was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../med_entry";
    });
</script>
<?php
}
mysqli_close($conn);