<?php
    session_start();
    include('connection.php');
    $accountid = $_POST['accountid'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $usertype = $_POST['usertype'];
    $firstname = strtoupper($_POST['firstname']);
    $middlename = strtoupper($_POST['middlename']);
    $lastname = strtoupper($_POST['lastname']);
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $campus = $_POST['campus'];
    $status = $_POST['status'];
    $datetime = date("Y-m-d h:i:s");
    
    $user = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $activity = "added an account";

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
                window.location = "../account_add.php";
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
                window.location = "../account_add.php";
            });
        </script>
        <?php
        // modal na password and confirm password does not match
    }
    else
    {
        $sql[1] = "INSERT INTO account (accountid, password, usertype, firstname, middlename, lastname, email, contactno, campus, status, datetime_created, datetime_updated) VALUES ('$accountid', '$password', '$usertype', '$firstname', '$middle', '$lastname', '$email', '$contactno', '$campus', '$status', '$datetime', '$datetime')";
        if (mysqli_query($conn, $sql[1]))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../account_add.php";
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
                        window.location = "../account_add.php";
                    });
                </script>
                <?php
                // modal Entry has been added
            }
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../account_add.php";
                });
            </script>
            <?php
            // modal na password and confirm password does not match
        }
    ?>
<script>
    setTimeout(function() {
        window.location = "../account_add.php";
    });
</script>
<?php
}
mysqli_close($conn);