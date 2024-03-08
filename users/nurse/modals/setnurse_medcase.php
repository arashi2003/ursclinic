<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $medcase = $_POST['medcase'];
    $fullname = strtoupper($_SESSION['name']);

    $query = "SELECT * FROM med_case WHERE medcase = '$medcase'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../medcase_set.php";
            });
            </script>
        <?php
        // modal message box saying "Medical Case already exists."
    }
    else
    {
        $query = "INSERT INTO med_case SET medcase='$medcase'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'added a medical case', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medcase_set.php";
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
                        window.location = "../medcase_set.php";
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
        window.location = "../medcase_set.php";
    });
    </script>
<?php
}}
mysqli_close($conn);