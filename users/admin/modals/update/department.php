<?php
    session_start();
    include('../../add/connection.php');
    $id = $_POST['departmentid'];
    $department = strtoupper($_POST['department']);
    $abbrev = strtoupper($_POST['abbrev']);
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a department entry";
    $au_status = "unread";
    
    $sql = "UPDATE department SET department='$department', abbrev='$abbrev' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../department.php";
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
                    window.location = "../../department.php";
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
                window.location = "../../department.php";
            });
        </script>
        <?php
        // modal Entry has not been added
    ?>
<script>
    setTimeout(function() {
        window.location = "../../department.php";
    });
</script>
<?php
}
mysqli_close($conn);