<?php
    session_start();
    include('connection.php');
    $apptype = $_POST['apptype'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added an appointment type";
    $au_status = "unread";
    
    $sql = "SELECT * FROM appointment_type WHERE type = '$apptype'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['alert'] = "Type of Appointment already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../apptype_set";
            });
        </script>
        <?php
        // modal Entry already exists
    }
    else
    {
        $sql = "INSERT INTO appointment_type (type) VALUES ('$apptype')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "Type of Appointment has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../apptype_set";
                    });
                </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Type of Appointment has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../apptype_set";
                    });
                </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Type of Appointment was not added.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../apptype_set";
    });
</script>
<?php
}}
mysqli_close($conn);