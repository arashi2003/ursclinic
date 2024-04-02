<?php
    session_start();
    include('../add/connection');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a department";
    $au_status = "unread";
    
    $sql = "DELETE FROM department WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Department has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../department";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Department has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../department";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Department was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../department.php";
    });
</script>
<?php
}
mysqli_close($conn);