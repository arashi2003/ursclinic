<?php
    session_start();
    include('connection.php');
    $accountid = $_SESSION['accountid'];
    $campus = $_SESSION['campus'];
    $type = $_POST['type'];
    $unit_measure = $_POST['unit_measure'];
    $fullname = strtoupper($_SESSION['name']);

    $query = "SELECT * FROM unit_measure WHERE type = '$type' AND unit_measure = '$unit_measure'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        ?>
        <script>
            setTimeout(function() {
                window.location = "../umeasure_set.php";
            });
            </script>
        <?php
        // modal message box saying "Unit Measure already exists."
    }
    else
    {
        $query = "INSERT INTO unit_measure (type, unit_measure) VALUES ('$type', '$unit_measure')";
        if($result = mysqli_query($conn, $query))
        {
            $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'added a unit measure', now())";
            if($result = mysqli_query($conn, $query))
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../umeasure_set.php";
                    });
                    </script>
                <?php
                // modal message box saying "Unit Measure added."
            }
            else
            {
                ?>
                <script>
                    setTimeout(function() {
                        window.location = "../umeasure_set.php";
                    });
                    </script>
                <?php
                // modal message box saying "Unit Measure added."
            }
        }
        else
        {
            // modal message box saying "Unit Measure was not added."
?>
<script>
    setTimeout(function() {
        window.location = "../umeasure_set.php";
    });
    </script>
<?php
}}
mysqli_close($conn);