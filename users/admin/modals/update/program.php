<?php
    session_start();
    include('../../add/connection.php');
    $id = $_POST['programid'];
    $program = strtoupper($_POST['program']);
    $department = strtoupper($_POST['department']);
    $college = strtoupper($_POST['college']);
    $abbrev = strtoupper($_POST['abbrev']);
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a program entry";
    $au_status = "unread";

    $sql = "UPDATE program SET department = '$department', college = '$college', program = '$program', abbrev='$abbrev' WHERE id='$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../program";
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
                    window.location = "../../program";
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
                window.location = "../../program";
            });
        </script>
        <?php
        // modal Entry has not been added
        
    ?>
<script>
    setTimeout(function() {
        window.location = "../../program";
    });
</script>
<?php
}
mysqli_close($conn);