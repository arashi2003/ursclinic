<?php
    session_start();
    include('../connection.php');
    $id = $_GET['no'];
    $user = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "removed a supply entry";
    
    $sql = "DELETE FROM supply WHERE supid = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_entry.php";
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
                    window.location = "../../sup_entry.php";
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
        window.location = "../../sup_entry.php";
    });
</script>
<?php
}
mysqli_close($conn);