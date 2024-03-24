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
        ?>
        <script>
            setTimeout(function() {
                window.location = "../medcase_set";
            });
            </script>
        <?php
        // modal message box saying "Medical Case already exists."
    }
    else
    {
        $query = "INSERT INTO med_case SET medcase='$medcase', type='$type'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a medical case', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medcase_set";
                    });
                    </script>
                <?php
                // modal message box saying "Medical Case added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medcase_set";
                    });
                    </script>
                <?php
                // modal message box saying "Medical Case was not added."
            }
        }
        else
        {
            // modal message box saying "Medical Case was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../medcase_set";
    });
    </script>
<?php
}}
mysqli_close($conn);