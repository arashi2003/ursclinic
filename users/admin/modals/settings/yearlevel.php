<?php
    session_start();
    include('../../add/connection.php');
    $yearlevel = strtoupper($_POST['yearlevel']);
    $department = strtoupper($_POST['department']);
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a year level";
    $au_status = "unread";
    
    $sql = "SELECT * FROM yearlevel WHERE department = '$department' AND yearlevel = '$yearlevel'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['alert'] = "Year Level for this department already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../yearlevel";
            });
        </script>
        <?php
    }
    else
    {
        $sql = "INSERT INTO yearlevel (department, yearlevel) VALUES ('$department', '$yearlevel')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "Year Level has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../yearlevel";
                    });
                </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Year Level has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../yearlevel";
                    });
                </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Year Level was not added.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../yearlevel";
    });
</script>
<?php
}}
mysqli_close($conn);