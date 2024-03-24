<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $dosage_form = $_POST['dosage_form'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";
    
    $query = "SELECT * FROM dosage_form WHERE dosage_form = '$dosage_form'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../dform_set";
            });
            </script>
        <?php
        // modal message box saying "Dosage Form already exists."
    }
    else
    {
        $query = "INSERT INTO dosage_form SET dosage_form='$dosage_form'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a dosage form', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../dform_set";
                    });
                    </script>
                <?php
                // modal message box saying "Dosage Form added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../dform_set";
                    });
                    </script>
                <?php
                // modal message box saying "Dsoage Form was not added."
            }
        }
        else
        {
            // modal message box saying "Dosage Form was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../dform_set";
    });
    </script>
<?php
}}
mysqli_close($conn);