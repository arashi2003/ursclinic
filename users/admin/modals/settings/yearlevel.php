<?php
    session_start();
    include('../../add/connection.php');
    $yearlevel = $_POST['yearlevel'];
    $department = $_POST['department'];
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a year level";
    
    $sql = "SELECT * FROM yearlevel WHERE department = '$department' AND yearlevel = '$yearlevel'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        // modal Entry already exists
    }
    else
    {
        $sql = "INSERT INTO yearlevel (department, yearlevel) VALUES ('$department', '$yearlevel')";
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
        }
    ?>
<script>
    setTimeout(function() {
        window.location = "../../yearlevel.php";
    });
</script>
<?php
}
mysqli_close($conn);