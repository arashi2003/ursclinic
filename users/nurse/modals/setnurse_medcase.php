<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $type = $_POST['type'];
    $medcase = $_POST['medcase'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    $query = "SELECT * FROM med_case WHERE medcase = '$medcase' AND type='$type'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        $_SESSION['alert'] = "Medical Case already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../medcase_set";
            });
            </script>
        <?php
    }
    else
    {
        $query = "INSERT INTO med_case SET medcase='$medcase', type='$type'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a medical case', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                $_SESSION['alert'] = "Medical Case has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medcase_set";
                    });
                    </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Medical Case has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medcase_set";
                    });
                    </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Medical Case was not added.";
?>
<script>
    setTimeout(function() {
        window.location = "../medcase_set";
    });
    </script>
<?php
}}
mysqli_close($conn);