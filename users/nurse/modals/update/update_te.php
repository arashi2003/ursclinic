<?php
    session_start();
    include('connection.php');
    $te = $_POST['te'];
    $unit = $_POST['unit_measure'];
    $id=$_POST['teid'];
    
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    $query = "UPDATE tools_equip SET te='$te', unit_measure='$unit', datetime=now() WHERE teid='$teid'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a tool/equipment entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../te_entry.php";
                });
                </script>
            <?php
            // modal message box saying "Tool/Equipment added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../te_entry.php";
                });
                </script>
            <?php
            // modal message box saying "Tool/Equipment added."
        }
    }
    else
    {
        // modal message box saying "Tool/Equipment was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../te_entry.php";
    });
    </script>
<?php
}
mysqli_close($conn);