<?php
    session_start();
    include('../connection.php');
    
    $te = $_POST['tools_equip'];
    $unit = $_POST['unit_measure'];
    $teid=$_POST['teid'];
    
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    $query = "UPDATE tools_equip SET tools_equip='$te', unit_measure='$unit', datetime=now() WHERE teid='$teid'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a tool/equipment entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Tool/Equipment has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../te_entry";
                });
                </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Tool/Equipment has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../te_entry";
                });
                </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Tool/Equipment was not updated.";
?>
<script>
    setTimeout(function() {
        window.location = "../../te_entry";
    });
    </script>
<?php
}
mysqli_close($conn);