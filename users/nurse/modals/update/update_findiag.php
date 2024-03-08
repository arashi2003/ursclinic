<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $findiag = $_POST['findiag'];
    $fullname = strtoupper($_SESSION['name']);
    $id=$_POST['id'];

    $query = "UPDATE findiag SET findiag='$findiag' WHERE id='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'updated a findings/diagnosis entry', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../findings.php";
                });
                </script>
            <?php
            // modal message box saying "Findings/Diagnosis added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../findings.php";
                });
                </script>
            <?php
            // modal message box saying "Findings/Diagnosis was not added."
        }
    }
    else
    {
            
        // modal message box saying "Findings/Diagnosis was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../findings.php";
    });
    </script>
<?php
}
mysqli_close($conn);