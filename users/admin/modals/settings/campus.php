<?php
    session_start();
    include('../../add/connection.php');
    $campus = strtoupper($_POST['campus']);
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a campus";
    $au_status = "unread";
    
    $sql = "SELECT * FROM campus WHERE campus = '$campus'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        // modal Entry already exists
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../campus.php";
            });
        </script>
        <?php
    }
    else
    {
        $sql = "INSERT INTO campus (campus) VALUES ('$campus')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
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
}}
mysqli_close($conn);