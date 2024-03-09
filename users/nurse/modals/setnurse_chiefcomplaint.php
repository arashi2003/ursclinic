<?php
    session_start();
    include('connection.php');

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added a chief complaint";
    $chief_complaint = $_POST['chief_complaint'];

    $query = "SELECT * FROM chief_complaint WHERE chief_complaint = '$chief_complaint'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../chiefcomplaint.php";
            });
        </script>
        <?php
        // modal message box saying "Chief Complaint already exists."
    }
    else
    {
        $query = "INSERT INTO chief_complaint SET chief_complaint='$chief_complaint'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../chiefcomplaint.php";
                    });
                </script>
                <?php
                // modal message box saying "Chief Complaint was added."            
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../chiefcomplaint.php";
                    });
                </script>
                <?php
                // modal message box saying "Chief Complaint was added."
            }
        }
        else
        {
            // modal message box saying "Chief Complaint was not added."
        
?>
<script>
    setTimeout(function() {
        window.location = "../chiefcomplaint.php";
    });
    </script>
<?php
}}
mysqli_close($conn);