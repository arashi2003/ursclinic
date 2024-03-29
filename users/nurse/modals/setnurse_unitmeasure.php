<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['userid'];
    $campus = $_SESSION['campus'];
    $type = $_POST['type'];
    $unit_measure = $_POST['unit_measure'];
    $fullname = strtoupper($_SESSION['name']);
    $au_status = "unread";

    $query = "SELECT * FROM unit_measure WHERE type = '$type' AND unit_measure = '$unit_measure'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        $_SESSION['alert'] = "Unit Measure already exists.";
        ?>
        <script>
            setTimeout(function() {
                window.location = "../umeasure_set";
            });
            </script>
        <?php
    }
    else
    {
        $query = "INSERT INTO unit_measure (type, unit_measure) VALUES ('$type', '$unit_measure')";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, status, datetime) VALUES ('$accountid', '$fullname', 'added a unit measure', '$au_status', now())";
            if($result = mysqli_query($conn, $query))
            {
                $_SESSION['alert'] = "Unit Measure has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../umeasure_set";
                    });
                    </script>
                <?php
            }
            else
            {
                $_SESSION['alert'] = "Unit Measure has been added.";
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../umeasure_set";
                    });
                    </script>
                <?php
            }
        }
        else
        {
            $_SESSION['alert'] = "Unit Measure was not added.";
?>
<script>
    setTimeout(function() {
        window.location = "../umeasure_set";
    });
    </script>
<?php
}}
mysqli_close($conn);