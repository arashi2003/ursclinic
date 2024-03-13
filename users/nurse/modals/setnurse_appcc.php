<?php
    session_start();
    include('connection.php');
    $purpose = $_POST['purpose'];
    $appcc = $_POST['appcc'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added an appointment chief complaint";
    $au_status = "unread";
    
    $sql = "SELECT * FROM appointment_cc WHERE purpose = '$purpose' AND chief_complaint = '$appcc'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../appcc_set.php";
            });
        </script>
        <?php
        // modal Entry already exists
    }
    else
    {
        $sql = "INSERT INTO appointment_cc (purpose, chief_complaint) VALUES ('$purpose', '$appcc')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../appcc_set.php";
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
                        window.location = "../appcc_set.php";
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
                    window.location = "../appcc_set.php";
                });
            </script>
            <?php
            // modal Entry has not been added
        }
    ?>
<script>
    setTimeout(function() {
        window.location = "../appcc_set.php";
    });
</script>
<?php
}
mysqli_close($conn);