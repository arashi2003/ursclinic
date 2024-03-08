<?php
    session_start();
    include('connection.php');
    $te = $_POST['te'];
    $unit = $_POST['unit_measure'];

    $query = "SELECT * FROM tools_equip WHERE tools_equip = '$te' AND unit_measure = '$unit'";    
    $result = mysqli_query($conn, $query);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0)
    {
        // modal message box saying "Tool/Equipment already exists."
    }
    else
    {
        $query = "INSERT INTO tools_equip (te, unit_measure, datetime) VALUES ('$te', '$unit', now())";
        if($result = mysqli_query($conn, $query))
        {
            // modal message box saying "Tool/Equipment added."
            // audit trail
        }
        else
        {
            // modal message box saying "Tool/Equipment was not added."
        }
?>
<script>
    setTimeout(function() {
        window.location = "../te_entry.php";
    });
    </script>
<?php
}
mysqli_close($conn);