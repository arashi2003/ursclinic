<?php
    session_start();
    include('../connection.php');
    $user = $_SESSION['userid'];
    $id=$_POST['id'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated a chief complaint entry";
    $chief_complaint = $_POST['chief_complaint'];
    $au_status = "unread";

    $query = "UPDATE chief_complaint SET chief_complaint='$chief_complaint' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Chief Complaint has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../chiefcomplaint";
                });
            </script>
            <?php         
        }
        else
        {
            $_SESSION['alert'] = "Chief Complaint has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../chiefcomplaint";
                });
            </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Chief Complaint was not updated.";
?>
<script>
    setTimeout(function() {
        window.location = "../../chiefcomplaint";
    });
    </script>
<?php
}
mysqli_close($conn);