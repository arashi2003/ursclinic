<?php
    session_start();
    include('../../add/connection.php');
    $cupassword = $_POST['cupassword'];
    $password = $_POST['npassword'];
    $copassword = $_POST['copassword'];
    $firstname = strtoupper($_POST['firstname']);
    $middlename = strtoupper($_POST['middlename']);
    $lastname = strtoupper($_POST['lastname']);
    
    // MAG CONDITIONAL FOR PATIENT INFO
    $birthday = date("Y-m-d", strtotime($_POST['birthday']));
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $emcon_name = $_POST['emcon_name'];
    $emcon_number = $_POST['emcon_number'];

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
    
    $sql[0] = "SELECT * FROM account WHERE accountid = '$user'";
    $result = mysqli_query($conn, $sql[0]);
    $resultCheck = mysqli_num_rows($result);
    if ($password != "")
    {
        //check current pass na in-enter is same sa db
        $sql = "SELECT password from account WHERE accountid = '$user' AND password = '$cupassword'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0)
        {
            if($password == $copassword)
            {
                $sql= "UPDATE account SET password='$password', usertype='$usertype', firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contactno='$contactno', campus='$campus', status='$status', datetime_updated=now() WHERE accountid='$user'";
                if (mysqli_query($conn, $sql))
                {
                    $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
                    if($result = mysqli_query($conn, $sql))
                    {
                        ?>
                        <script>
                            setTimeout(function() {
                                window.location = "../../profile";
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
                                window.location = "../../profile";
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
                            window.location = "../../profile";
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
                        window.location = "../../profile";
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
                    window.location = "../../profile";
                });
            </script>
            <?php
            // modal na current password does not match the account's password in the database
        }
    } 
    else
    {
        $sql= "UPDATE account SET accountid='$user', campus='$campus', status = '$status', usertype='$usertype', firstname='$firstname', middlename='$middlename', lastname='$lastname', email='$email', contactno='$contactno', campus='$campus', status='$status', datetime_updated=now() WHERE accountid='$user'";
        if (mysqli_query($conn, $sql))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../../profile";
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
                        window.location = "../../profile";
                    });
                </script>
                <?php
                // modal account details has been updated
            }
        }
        else
        {
            // modal na account details has not been updated
    ?>
<script>
    setTimeout(function() {
        window.location = "../../profile";
    });
</script>
<?php
}}
mysqli_close($conn);