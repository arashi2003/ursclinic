<?php
    session_start();
    include('connection.php');
    $apppurpose = $_POST['apppurpose'];
    $type = $_POST['type'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added an appointment purpose";
    
    $sql = "SELECT * FROM appointment_purpose WHERE purpose = '$apppurpose' AND type = '$type'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../apppurpose_set.php";
            });
        </script>
        <?php
        // modal Entry already exists
    }
    else
    {
        $sql = "INSERT INTO appointment_purpose (purpose, type) VALUES ('$apppurpose', '$type')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../apppurpose_set.php";
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
                        window.location = "../apppurpose_set.php";
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
        window.location = "../apppurpose_set.php";
    });
</script>
<?php
}}
mysqli_close($conn);