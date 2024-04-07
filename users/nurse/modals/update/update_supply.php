<?php
    session_start();
    include('../connection.php');
    $supply = $_POST['supply'];
    $unit = $_POST['unit_measure'];
    $state = $_POST['state'];
    $id=$_POST['supid'];
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    if ($_POST['volume'] == 0 || $_POST['volume'] == "")
    {
        $volume = '';
    }
    else
    {
        $volume = $_POST['volume'];
    }
    
    $query = "UPDATE supply SET supply='$supply', volume='$volume', unit_measure='$unit', datetime=now() WHERE supid='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a medical supply entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Medical Supply has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_entry";
                });
            </script>
            <?php       
        }
        else
        {
            $_SESSION['alert'] = "Medical Supply has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../sup_entry";
                });
            </script>
            <?php       
        }
    }
    else
    {
        $_SESSION['alert'] = "Medical Supply was not updated.";
    ?>
<script>
    setTimeout(function() {
        window.location = "../../sup_entry";
    });
</script>
<?php
}
mysqli_close($conn);