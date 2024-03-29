<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $findiag = $_POST['findiag'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];
    $au_status = "unread";

    $query = "UPDATE findiag SET findiag='$findiag' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a findings/diagnosis entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Findings/Diagnosis has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../findings";
                });
                </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Findings/Diagnosis has been updated.";
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../findings";
                });
                </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Findings/Diagnosis was not updated.";
?>
<script>
    setTimeout(function() {
        window.location = "../../findings";
    });
    </script>
<?php
}
mysqli_close($conn);