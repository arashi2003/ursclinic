<?php
    session_start();
    include('connection.php');
    $apptype = $_POST['apptype'];
    $id=$_POST['id'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an appointment type entry";
    
     $sql = "UPDATE appointment_type SET type='$apptype' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../apptype_set.php";
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
                    window.location = "../apptype_set.php";
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
        window.location = "../apptype_set.php";
    });
</script>
<?php
}
mysqli_close($conn);