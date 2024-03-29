<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $type = $_POST['type'];
    $unit_measure = $_POST['unit_measure'];
    $id=$_POST['id'];

    $query = "UPDATE unit_measure SET type='$type', unit_measure='$unit_measure' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a unit measure entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Unit Measure has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../umeasure_set";
                });
                </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Unit Measure has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../umeasure_set";
                });
                </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Unit Measure was not updated.";
?>
<script>
    setTimeout(function() {
        window.location = "../../umeasure_set";
    });
    </script>
<?php
}
mysqli_close($conn);