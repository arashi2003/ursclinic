<?php
    session_start();
    include('connection.php');

    $accountid = $_SESSION['userid'];
    $fullname = strtoupper($_SESSION['name']);
    $campus = $_SESSION['campus'];
    $designation = $_POST['designation'];
    $au_status = "unread";

    $query = "SELECT * FROM designation WHERE designation = '$designation'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../designation";
            });
        </script>
        <?php
        // modal message box saying "Designation already exists."
    }
    else
    {
        $query = "INSERT INTO designation SET designation='$designation'";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a designation', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../designation";
                    });
                </script>
                <?php
                // modal message box saying "Designation added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../designation";
                    });
                </script>
                <?php
                // modal message box saying "Designation was added."
            }
            
        }
        else
        {
            // modal message box saying "Designation was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../designation";
    });
    </script>
<?php
}}
mysqli_close($conn);