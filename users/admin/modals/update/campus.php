<?php
    session_start();
    include('../../add/connection.php');
    $id = $_REQUEST['id'];
    $campus = $_POST['campus'];
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a campus entry";
    
    $sql = "UPDATE campus SET campus='$campus' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../campus.php";
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
                    window.location = "../../campus.php";
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
        window.location = "../../campus.php";
    });
</script>
<?php
}
mysqli_close($conn);