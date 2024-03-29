<?php
    session_start();
    include('../../add/connection.php');
    $college = strtoupper($_POST['college']);
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a college";
    $au_status = "unread";
    
    $sql = "SELECT * FROM college WHERE college = '$college'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['alert'] = "College already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../college";
            });
        </script>
        <?php
    }
    else
    {
        $sql = "INSERT INTO college (college) VALUES ('$college')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "College has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../college";
                    });
                </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "College has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../college";
                    });
                </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "College was not added.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../college";
    });
</script>
<?php
}}
mysqli_close($conn);