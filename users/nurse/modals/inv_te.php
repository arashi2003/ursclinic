<?php
    session_start();
    include('connection.php');
    
    $te = $_POST['tools_equip'];
    $unit = $_POST['unit_measure'];

    $user = $_SESSION['userid'];
    $fullname = $_SESSION['name'];
    $activity = "added a tool/equipment entry";
    $campus = $_SESSION['campus'];
    $au_status = "unread";

    $query = "SELECT * FROM tools_equip WHERE tools_equip = '$te' AND unit_measure = '$unit'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        $_SESSION['alert'] = "Tool/Equipment already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../te_entry";
            });
            </script>
        <?php
    }
    else
    {
        $query = "INSERT INTO tools_equip (tools_equip, unit_measure, datetime) VALUES ('$te', '$unit', now())";
        if($result = mysqli_query($conn, $query))
        {
            $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
            if($result = mysqli_query($conn, $sql))
            {
                $_SESSION['alert'] = "Tool/Equipment has been added as an entry.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../te_entry";
                    });
                    </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Tool/Equipment has been added as an entry.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../te_entry";
                    });
                    </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Tool/Equipment was not added as an entry.";
?>
<script>
    setTimeout(function() {
        window.location = "../te_entry";
    });
    </script>
<?php
}}
mysqli_close($conn);