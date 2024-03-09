<?php
    session_start();
    include('../connection.php');
    $accountid = $_POST['accountid'];
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

    $user = $_SESSION['accountid'];
    $au_campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "updated their account details";

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
                $sql= "UPDATE account SET password='$password', usertype='$usertype', firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contactno='$contactno', campus='$campus', status='$status', datetime_updated=now() WHERE accountid='$accountid'";
                if (mysqli_query($conn, $sql))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
                    if($result = mysqli_query($conn, $sql))
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../../profile.php";
                            });
                        </script>
                        <?php
                        // modal na account details has been updated
                    }
                    else
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../../profile.php";
                            });
                        </script>
                        <?php
                        // modal na account details has been updated
                    }
                }
                else
                {
                    ?>
                    <script>
                        setTimeout(function() {
                            window.location = "../../profile.php";
                        });
                    </script>
                    <?php
                    // modal na account details has not been updated
                }
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile.php";
                    });
                </script>
                <?php
                // modal na password and confirm password does not match
            }
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../profile.php";
                });
            </script>
            <?php
            // modal na current password does not match the account's password in the database
        }
    } 
    else
    {
        $sql= "UPDATE account SET usertype='$usertype', firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contactno='$contactno', campus='$campus', status='$status', datetime_updated=now() WHERE accountid='$accountid'";
        if (mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile.php";
                    });
                </script>
                <?php
                // modal na account details has been updated
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile.php";
                    });
                </script>
                <?php
                // modal Entry has been removed 
            }
        }
        else
        {
            // modal na account details has not been updated
    ?>
<script>
    setTimeout(function() {
        window.location = "../../profile.php";
    });
</script>
<?php
}}
mysqli_close($conn);