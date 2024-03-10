<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $transaction = $_POST['transaction'];
    $service = $_POST['service'];
    $id = $_POST['id'];
    
    $query = "UPDATE transaction SET transaction_type='$transaction', service='$service' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a transaction and service entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../services.php";
                });
                </script>
            <?php
            // modal message box saying "Transaction added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../services.php";
                });
                </script>
            <?php
            // modal message box saying "Transaction added."
        }
    }
    else
    {
        // modal message box saying "Transaction was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../../services.php";
    });
    </script>
<?php
}
mysqli_close($conn);