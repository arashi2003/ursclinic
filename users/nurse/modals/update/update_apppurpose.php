<?php
    session_start();
    include('../connection.php');
    $id=$_POST['id'];
    $apppurpose = $_POST['apppurpose'];
    $type = $_POST['type'];

    $user = $_SESSION['accountid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an appointment purpose entry";
    
    $sql = "UPDATE appointment_purpose SET purpose='$apppurpose', type='$type' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../apppurpose_set.php";
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
                    window.location = "../../apppurpose_set.php";
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
        window.location = "../../apppurpose_set.php";
    });
</script>
<?php
}
mysqli_close($conn);