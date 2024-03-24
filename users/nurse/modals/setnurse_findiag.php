<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $findiag = $_POST['findiag'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    $query = "SELECT * FROM findiag WHERE findiag = '$findiag'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../findings";
            });
            </script>
        <?php
        // modal message box saying "Findings/Diagnosis already exists."
    }
    else
    {
        $query = "INSERT INTO findiag SET findiag='$findiag'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a findings/diagnosis', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../findings";
                    });
                    </script>
                <?php
                // modal message box saying "Findings/Diagnosis added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../findings";
                    });
                    </script>
                <?php
                // modal message box saying "Findings/Diagnosis was not added."
            }
        }
        else
        {
            // modal message box saying "Findings/Diagnosis was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../findings";
    });
    </script>
<?php
}}
mysqli_close($conn);