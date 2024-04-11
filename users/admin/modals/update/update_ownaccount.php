<?php
    session_start();
    include('../../add/connection.php');
    $accountid = $_SESSION['userid'];
    $cupassword = $_POST['cupassword'];
    $password = $_POST['npassword'];
    $copassword = $_POST['copassword'];
    $usertype = $_POST['usertype'];
    $firstname = strtoupper($_POST['firstname']);
    $middlename = strtoupper($_POST['middlename']);
    $lastname = strtoupper($_POST['lastname']);
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $campus = $_POST['campus'];
    $status = $_POST['status'];

    $user = $_SESSION['userid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated their account details";
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
    if ($password != "")
    {
        //check current pass na in-enter is same sa db
        $sql = "SELECT password from account WHERE accountid = '$accountid' AND password = '$cupassword'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0)
        {
            if($password == $copassword)
            {
                $sql= "UPDATE account SET campus='$campus', status = '$status', password='$password', usertype='$usertype', firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contactno='$contactno', datetime_updated=now() WHERE accountid='$accountid'";
                if (mysqli_query($conn, $sql))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                    if($result = mysqli_query($conn, $sql))
                    {
                $_SESSION['alert'] = "Account has been updated.";
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../../profile";
                            });
                        </script>
                        <?php
                    }
                    else
                    {
                        $_SESSION['alert'] = "Account has been updated.";
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../../profile";
                            });
                        </script>
                        <?php
                    }
                }
                else
                {
                    $_SESSION['alert'] = "Account was not updated.";
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../../profile";
                        });
                    </script>
                    <?php
                }
            }
            else
            {
                $_SESSION['alert'] = "New Password and Confirm Password does not match.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile";
                    });
                </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Current Password input does not match the current password.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../profile";
                });
            </script>
            <?php
        }
    } 
    else
    {
        $sql= "UPDATE account SET usertype='$usertype', firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contactno='$contactno', campus='$campus', status='$status', datetime_updated=now() WHERE accountid='$accountid'";
        if (mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "Account has been updated.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile";
                    });
                </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Account has been updated.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile";
                    });
                </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Account was not updated.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../profile";
    });
</script>
<?php
}}
mysqli_close($conn);