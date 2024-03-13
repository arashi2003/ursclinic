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
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medcase_set.php";
                });
                </script>
            <?php
            // modal message box saying "Medical Case added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../medcase_set.php";
                });
                </script>
            <?php
            // modal message box saying "Medical Case was not added."
        }
    }
    else
    {
        // modal message box saying "Medical Case was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../../medcase_set.php";
    });
    </script>
<?php
}
mysqli_close($conn);