<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $med_admin = $_POST['med_admin'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];

    $query = "UPDATE med_admin SET med_admin='$med_admin' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, '$fullname', activity, datetime) VALUES ('$accountid', '$fullname', 'updated a medicine administration entry', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../medadmin_set.php";
                });
                </script>
            <?php
            // modal message box saying "Medicine Administration added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../medadmin_set.php";
                });
                </script>
            <?php
            // modal message box saying "Medicine Administration was not added."
        }
    }
    else
    {
        // modal message box saying "Medicine Administration was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../medadmin_set.php";
    });
    </script>
<?php
}
mysqli_close($conn);