<?php
    session_start();
    include('connection.php');
    $supply = $_POST['supply'];
    $unit = $_POST['unit_measure'];
    $state = "open-close";
    $id=$_POST['supid'];

    if ($_POST['volume'] == 0 || $_POST['volume'] == "")
    {
        $volume = '';
    }
    else
    {
        $volume = $_POST['volume'];
    }
    
    $query = "INSERT INTO supply SET supply='$supply', volume='$volume', unit_measure=,'$unit' datetime=now() WHERE supid='$id'";
    if($result = mysqli_query($conn, $query))
    {
        $query = "INSERT INTO audit_trail (user, fullname, activity, datetime) VALUES ('$accountid', '$fullname', 'updated a medical supply entry', now())";
        if($result = mysqli_query($conn, $query))
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../sup_entry.php";
                });
            </script>
            <?php       
            // modal message box saying "Medical Supply added."
        }
        else
        {
            ?>
            <script>
                setTimeout(function() {
                    window.location = "../sup_entry.php";
                });
            </script>
            <?php       
            // modal message box saying "Medical Supply added."
        }
    }
    else
    {
        // modal message box saying "Medical Supply was not added."
    ?>
<script>
    setTimeout(function() {
        window.location = "../sup_entry.php";
    });
</script>
<?php
}
mysqli_close($conn);