<?php
    session_start();
    include('../connection.php');
    $accountid = $_SESSION['userid'];
    $fullname = strtoupper($_SESSION['name']);
    $campus = $_SESSION['campus'];
    $id=$_POST['id'];
    $designation = $_POST['designation'];
    $au_status = "unread";

    $query = "UPDATE designation SET designation='$designation' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'updated a designation entry', '$au_status', now())";
        if($result = mysqli_query($conn, $query))
        {
            
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../../designation";
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
}
mysqli_close($conn);