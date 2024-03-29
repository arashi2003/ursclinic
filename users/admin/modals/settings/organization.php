<?php
    session_start();
    include('../../add/connection.php');
    $firstname = strtoupper($_POST['firstname']);
    $lastname = strtoupper($_POST['lastname']);
    $extension = $_POST['extension'];
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
    $activity = "added an entry to organization";
    $au_status = "unread";

    $middle = $_POST['middlename'];
    $adminid = $_POST['accountid'];
    

    $sql = "SELECT * FROM organization WHERE title = '$title' AND campus = '$campus'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['alert'] = "This position already exists.";
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
        $sql = "INSERT INTO organization (campus, adminid, firstname, middlename, lastname, extension, title) VALUES ('$campus', '$adminid', '$firstname', '$middle', '$lastname', '$extension', '$title')";
        if($result = mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "Entry has been added.";
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
                $_SESSION['alert'] = "Entry has been added.";
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
            $_SESSION['alert'] = "Entry was not added.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../organization";
    });
</script>
<?php
}}
mysqli_close($conn);