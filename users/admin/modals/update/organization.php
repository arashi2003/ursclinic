<?php
    session_start();
    include('../../add/connection.php');
    $id = $_POST['adminid'];
    $campus = strtoupper($_POST['campus']);
    $firstname = strtoupper($_POST['firstname']);
    $lastname = strtoupper($_POST['lastname']);
    $extension = $_POST['extension'];
    $title = $_POST['title'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated an organization entry";
    $au_status = "unread";

    if($_POST['middlename'] == "")
    {
        $middle = NULL;
    }
    else
    {
        $middle = $_POST['middlename'];
    }

    if($_POST['accountid'] == "")
    {
        $adminid = NULL;
    }
    else
    {
        $adminid = $_POST['accountid'];
    }
    

    $sql = "UPDATE organization SET campus='$campus', adminid='$adminid', firstname='$firstname', middlename='$middle', lastname='$lastname', extension='$extension', title= '$title' WHERE id = '$id'";
    if($result = mysqli_query($conn, $sql))
    {
        $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
        if($result = mysqli_query($conn, $sql))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../organization.php";
                });
            </script>
            <?php
            // modal Entry has been added
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../organization.php";
                });
            </script>
            <?php
            // modal Entry has been added but activity was not recorded
        }
    }
    else
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../organization.php";
            });
        </script>
        <?php
        // modal Entry has not been added
    ?>
<script>
    setTimeout(function() {
        window.location = "../../organization.php";
    });
</script>
<?php
}
mysqli_close($conn);