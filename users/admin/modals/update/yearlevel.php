<?php
    session_start();
    include('../../add/connection.php');
    $id = $_POST['ylid'];
    $yearlevel = $_POST['yearlevel'];
    $department = $_POST['department'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a year level entry";

    $sql = "UPDATE yearlevel SET department='$department', yearlevel='$yearlevel' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../yearlevel.php";
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
                    window.location = "../../yearlevel.php";
                });
            </script>
            <?php
            // modal Entry has been added
        }
    }
    else
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../yearlevel.php";
            });
        </script>
        <?php
        // modal Entry has not been added
    ?>
<script>
    setTimeout(function() {
        window.location = "../../yearlevel.php";
    });
</script>
<?php
}
mysqli_close($conn);