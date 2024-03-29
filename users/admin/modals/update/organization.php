<?php
    session_start();
    include('../../add/connection.php');
    $id = $_POST['id'];
    $firstname = strtoupper($_POST['firstname']);
    $middle = $_POST['middlename'];
    $lastname = strtoupper($_POST['lastname']);
    $extension = $_POST['extension'];
    $adminid = $_POST['adminid'];
    $title = $_POST['position'];

    if($_POST['campus'] == "ALL")
    {
        $campus = "UNIVERSITY";
    }
    else
    {
        $campus = $_POST['campus'];
    }

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an organization entry";
    $au_status = "unread";


    $sql = "UPDATE organization SET campus='$campus', adminid='$adminid', firstname='$firstname', middlename='$middle', lastname='$lastname', extension='$extension', title= '$title' WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            $_SESSION['alert'] = "Entry has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../organization";
                });
            </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Entry has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../organization";
                });
            </script>
            <?php 
        }
    }
    else
    {
        $_SESSION['alert'] = "Entry was not updated.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../organization";
            });
        </script>
        <?php
    ?>
<script>
    setTimeout(function() {
        window.location = "../../organization";
    });
</script>
<?php
}
mysqli_close($conn);