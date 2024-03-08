<?php
    session_start();
    include('connection.php');
    $supply = $_POST['supply'];
    $unit = $_POST['unit_measure'];
    $state = "open-close";

    if ($_POST['volume'] == 0 || $_POST['volume'] == "")
    {
        $volume = '';
    }
    else
    {
        $volume = $_POST['volume'];
    }
    
    $query = "SELECT * FROM supply WHERE supply = '$supply' AND volume = '$volume' AND unit_measure = '$unit'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        // modal message box saying "Medical Supply already exists."
    }
    else
    {
        $query = "INSERT INTO supply (supply, volume, unit_measure, datetime, state) VALUES ('$supply', '$volume', '$unit', now(), '$state')";
        if($result = mysqli_query($conn, $query))
        {
            // modal message box saying "Medical Supply added."
            // audit trail
        }
        else
        {
            // modal message box saying "Medical Supply was not added."
        }
    ?>
<script>
    setTimeout(function() {
        window.location = "../sup_entry.php";
    });
</script>
<?php
}
mysqli_close($conn);