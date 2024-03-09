<?php
    session_start();
    include('../../add/connection.php');
    $id = $_POST['collegeid'];
    $college = $_POST['college'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a college entry";
    $au_status = "unread";
    
    $sql = "UPDATE college SET college='$college' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../college.php";
                });
            </script>
            <?php
            // modal Entry has been added
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../college.php";
                });
            </script>
            <?php
            // modal Entry has been added
        }
    }
    else
    {
        // modal Entry has not been added
    ?>
<script>
    setTimeout(function() {
        window.location = "../../college.php";
    });
</script>
<?php
}
mysqli_close($conn);