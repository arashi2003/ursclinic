<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $fullname= $_SESSION['name'];
    $transaction = $_POST['transaction'];
    $service = $_POST['service'];
    $au_status = "unread";
    
    $query = "SELECT * FROM transaction WHERE transaction_type = '$transaction' AND service = '$service'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../services";
            });
            </script>
        <?php
        // modal message box saying "Transaction already exists."
    }
    else
    {
        $query = "INSERT INTO transaction (transaction_type, service) VALUES ('$transaction', '$service')";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a transaction and service', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../services";
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
                        window.location = "../services";
                    });
                    </script>
                <?php 
                // modal message box saying "Transaction added."
            }
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../services";
                });
                </script>
            <?php 
            // modal message box saying "Transaction was not added."
        }
}
mysqli_close($conn);