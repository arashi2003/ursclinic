<?php
    session_start();
    include('../../connection.php');
    $userid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    $transaction = $_POST['transaction'];
    $service = $_POST['service'];
    $id = $_POST['id'];
    
    $query = "UPDATE transaction SET transaction_type='$transaction', service='$service' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$userid', '$fullname', 'updated a transaction and service entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            $_SESSION['alert'] = "Service has been updated."
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../services";
                });
                </script>
            <?php
        }
        else
        {
            $_SESSION['alert'] = "Service has been updated."
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../services";
                });
                </script>
            <?php
        }
    }
    else
    {
        $_SESSION['alert'] = "Service was not updated."
?>
<script>
    setTimeout(function() {
        window.location = "../../services";
    });
    </script>
<?php
}
mysqli_close($conn);