<?php
    session_start();
    include('../../add/connection.php');
    $program = strtoupper($_POST['program']);
    $department = strtoupper($_POST['department']);
    $college = strtoupper($_POST['college']);
    $abbrev = strtoupper($_POST['abbrev']);
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a program";
    $au_status = "unread";
    
    $sql = "SELECT * FROM program WHERE department = '$department' AND program = '$program' AND college = '$college'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['alert'] = "Program already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../program";
            });
        </script>
        <?php
    }
    else
    {
        $sql = "INSERT INTO program (department, college, program, abbrev) VALUES ('$department', '$college', '$program', '$abbrev')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "Program has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../program";
                    });
                </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Program has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../program";
                    });
                </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Program was not added.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../program";
    });
</script>
<?php
}}
mysqli_close($conn);