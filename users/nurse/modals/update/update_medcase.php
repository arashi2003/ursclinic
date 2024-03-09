<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $medcase = $_POST['medcase'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];

    $query = "UPDATE med_case SET medcase='$medcase' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'updated a medical case entry', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../medcase_set.php";
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
                    window.location = "../medcase_set.php";
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
        window.location = "../medcase_set.php";
    });
    </script>
<?php
}
mysqli_close($conn);