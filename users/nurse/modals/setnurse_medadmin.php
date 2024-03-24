<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $med_admin = $_POST['med_admin'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    $query = "SELECT * FROM med_admin WHERE med_admin = '$med_admin'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../medadmin_set";
            });
            </script>
        <?php
        // modal message box saying "Medicine Administration already exists."
    }
    else
    {
        $query = "INSERT INTO med_admin SET med_admin='$med_admin'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, '$fullname', activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a medicine administration', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medadmin_set";
                    });
                    </script>
                <?php
                // modal message box saying "Medicine Administration added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../medadmin_set";
                    });
                    </script>
                <?php
                // modal message box saying "Medicine Administration was not added."
            }
        }
        else
        {
            // modal message box saying "Medicine Administration was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../medadmin_set";
    });
    </script>
<?php
}}
mysqli_close($conn);