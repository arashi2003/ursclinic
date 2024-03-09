<?php
    session_start();
    include('connection.php');

    $accountid = $_SESSION['accountid'];
    $fullname = strtoupper($_SESSION['name']);
    $campus = $_SESSION['campus'];
    $designation = $_POST['designation'];

    
    $query = "SELECT * FROM designation WHERE designation = '$designation'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../designation.php";
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
            $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'added a designation', now())";
            if($result = mysqli_query($conn, $query))
            {
                
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../designation.php";
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
                        window.location = "../designation.php";
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
        window.location = "../designation.php";
    });
    </script>
<?php
}}
mysqli_close($conn);