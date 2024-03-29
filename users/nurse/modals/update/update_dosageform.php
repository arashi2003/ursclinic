<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $dosage_form = $_POST['dosage_form'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];
    $au_status = "unread";
    
    $query = "UPDATE dosage_form SET dosage_form='$dosage_form' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a dosage form entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Dosage Form has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../dform_set";
                });
                </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Dosage Form has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../dform_set";
                });
                </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Dosage Form has been updated.";
?>
<script>
    setTimeout(function() {
        window.location = "../../dform_set";
    });
    </script>
<?php
}
mysqli_close($conn);