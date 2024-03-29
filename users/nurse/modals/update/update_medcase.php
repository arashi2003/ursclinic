<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $medcase = $_POST['medcase'];
    $id=$_POST['id'];

    $query = "UPDATE med_case SET medcase='$medcase' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a medical case entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Medical Case has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medcase_set";
                });
                </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Medical Case has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medcase_set";
                });
                </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Medical Case was not updated.";
?>
<script>
    setTimeout(function() {
        window.location = "../../medcase_set";
    });
    </script>
<?php
}
mysqli_close($conn);