<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $type = $_POST['type'];
    $unit_measure = $_POST['unit_measure'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];

    $query = "UPDATE unit_measure SET type='$type', unit_measure='$unit_measure' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'updated a unit measure entry', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../umeasure_set.php";
                });
                </script>
            <?php
            // modal message box saying "Unit Measure added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../umeasure_set.php";
                });
                </script>
            <?php
            // modal message box saying "Unit Measure added."
        }
    }
    else
    {
        // modal message box saying "Unit Measure was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../umeasure_set.php";
    });
    </script>
<?php
}
mysqli_close($conn);