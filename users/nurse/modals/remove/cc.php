<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a chief complaint";
    $au_status = "unread";
    
    $sql = "DELETE FROM chief_complaint WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../chiefcomplaint.php";
                });
            </script>
            <?php
            // modal Entry has been removed
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../chiefcomplaint.php";
                });
            </script>
            <?php
            // modal Entry has been removed but activity was not recorded
        }
    }
    else
    {
        // modal Entry has not been removed
    ?>
<script>
    setTimeout(function() {
        window.location = "../../chiefcomplaint.php";
    });
</script>
<?php
}
mysqli_close($conn);