<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $med_admin = $_POST['med_admin'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];
    $au_status = "unread";

    $query = "UPDATE med_admin SET med_admin='$med_admin' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, '$fullname', activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a medicine administration entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medadmin_set";
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
                    window.location = "../../medadmin_set";
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
        window.location = "../../medadmin_set";
    });
    </script>
<?php
}
mysqli_close($conn);