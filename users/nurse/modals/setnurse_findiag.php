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
        $_SESSION['alert'] = "Findings/Diagnosis already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../findings";
            });
            </script>
        <?php
    }
    else
    {
        $query = "INSERT INTO findiag SET findiag='$findiag'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a findings/diagnosis', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                $_SESSION['alert'] = "Findings/Diagnosis has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../findings";
                    });
                    </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Findings/Diagnosis has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../findings";
                    });
                    </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Findings/Diagnosis was not added.";
?>
<script>
    setTimeout(function() {
        window.location = "../findings";
    });
    </script>
<?php
}}
mysqli_close($conn);