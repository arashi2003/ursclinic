<?php
    session_start();
    include('../../add/connection.php');
    $department = strtoupper($_POST['department']);
    $abbrev = strtoupper($_POST['abbrev']);
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a department";
    $au_status = "unread";
    
    $sql = "SELECT * FROM department WHERE department = '$department'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../department";
            });
        </script>
        <?php
        // modal Entry already exists
    }
    else
    {
        $sql = "INSERT INTO department (department, abbrev) VALUES ('$department', '$abbrev')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../department";
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
                        window.location = "../../department";
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
        window.location = "../../department";
    });
</script>
<?php
}}
mysqli_close($conn);