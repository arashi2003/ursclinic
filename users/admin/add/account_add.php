<?php
    session_start();
    include('connection.php');
    $accountid = strtoupper($_POST['accountid']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $usertype = $_POST['usertype'];
    $firstname = strtoupper($_POST['firstname']);
    $middlename = strtoupper($_POST['middlename']);
    $lastname = strtoupper($_POST['lastname']);
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $status = $_POST['status'];
    $campus = $_POST['campus'];
    
    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added an account";
    $au_status = "unread";

    if ($middlename == "" || $middlename == NULL)
    {
        $middle = "";
    }
    else
    {
        $middle = $middlename;
    }
    
    $sql[0] = "SELECT * FROM account WHERE accountid = '$accountid'";
    $result = mysqli_query($conn, $sql[0]);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../account_users";
            });
        </script>
        <?php
        // modal na accountid already exists
        
    }
    elseif ($password != $cpassword)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../account_users";
            });
        </script>
        <?php
        // modal na password and confirm password does not match
    }
    else
    {
        $sql[1] = "INSERT INTO account (accountid, password, usertype, firstname, middlename, lastname, email, contactno, campus, status, datetime_created, datetime_updated) VALUES ('$accountid', '$password', '$usertype', '$firstname', '$middle', '$lastname', '$email', '$contactno', '$campus', '$status', now(), now())";
        if (mysqli_query($conn, $sql[1]))
        {
            if($_POST['usertype'] == 'NURSE')
            {
                $sql = "INSERT INTO organization (campus, adminid, firstname, middlename, lastname, title, extension) VALUES ('$campus', '$accountid', '$firstname', '$middle', '$lastname', 'Campus Nurse', 'RN')";
                if($result = mysqli_query($conn, $sql))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', 'added an entry to the organization', '$au_status', now())";
                    mysqli_query($conn, $sql);
                }
            }

            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../account_users";
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
                        window.location = "../account_users";
                    });
                </script>
                <?php
                // modal Entry has been added
            }
        }
        else
        {
            // modal na password and confirm password does not match
    ?>
<script>
    setTimeout(function() {
        window.location = "../account_users";
    });
</script>
<?php
}
    }
mysqli_close($conn);