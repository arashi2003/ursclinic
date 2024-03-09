<?php
    session_start();
    include('connection.php');
    $te = $_POST['te'];
    $unit = $_POST['unit_measure'];

    $user = $_SESSION['accountid'];
    $fullname = $_SESSION['name'];
    $activity = "added a tool/equipment entry";
    $campus = $_SESSION['campus'];

    $query = "SELECT * FROM tools_equip WHERE tools_equip = '$te' AND unit_measure = '$unit'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../te_entry.php";
            });
            </script>
        <?php
        // modal message box saying "Tool/Equipment already exists."
    }
    else
    {
        $query = "INSERT INTO tools_equip (te, unit_measure, datetime) VALUES ('$te', '$unit', now())";
        if($result = mysqli_query($conn, $query))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', now())";
            if($result = mysqli_query($conn, $sql))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../te_entry.php";
                    });
                    </script>
                <?php
                // modal message box saying "Tool/Equipment added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../te_entry.php";
                    });
                    </script>
                <?php
                // modal message box saying "Tool/Equipment added."
            }
        }
        else
        {
            // modal message box saying "Tool/Equipment was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../te_entry.php";
    });
    </script>
<?php
}}
mysqli_close($conn);