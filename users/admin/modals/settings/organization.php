<?php
    session_start();
    include('../../add/connection.php');
    $campus = strtoupper($_POST['campus']);
    $firstname = strtoupper($_POST['firstname']);
    $lastname = strtoupper($_POST['lastname']);
    $extension = $_POST['extension'];
    $title = $_POST['title'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added an entry to organization";
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
    

    $sql = "SELECT * FROM organization WHERE title = '$title' AND campus = '$campus'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../../organization.php";
            });
        </script>
        <?php
        // modal This position already exists
    }
    else
    {
        $sql = "INSERT INTO organization (campus, adminid, firstname, middlename, lastname, extension, title) VALUES ('$campus', '$adminid', '$firstname', '$middle', '$lastname', '$extension', '$title')";
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
            // modal Entry has not been added
    ?>
<script>
    setTimeout(function() {
        window.location = "../../organization.php";
    });
</script>
<?php
}}
mysqli_close($conn);