<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a tool/equipment entry";
    $au_status = "unread";
    
    $sql = "DELETE FROM tools_equip WHERE teid = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Tool/Equipment has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../te_entry";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Tool/Equipment has been removed.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../te_entry";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Tool/Equipment was not removed.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../te_entry";
    });
</script>
<?php
}
mysqli_close($conn);