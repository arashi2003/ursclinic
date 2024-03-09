<?php
    session_start();
    include('connection.php');

    $user = $_SESSION['userid'];
    $id=$_POST['id'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a chief complaint entry";
    $chief_complaint = $_POST['chief_complaint'];

    $query = "UPDATE chief_complaint SET chief_complaint='$chief_complaint' WHERE id='$id'";
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
}
mysqli_close($conn);