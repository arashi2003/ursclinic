<?php
    include('../../../connection.php');
    // code for issued
    $issued = "";
    $qty_m = $_POST['quantity_med'];
    $medicine = $_POST['medicine'];
    $qty_s = $_POST['quantity_sup'];
    $supply = $_POST['supply'];
    for($a = 0; $a < count($medicine); $a++)
    {
        $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
            $issued .= $qty_m[$a] . " " . $med . ", ";
            if($a < count($medicine) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    for($b = 0; $b < count($supply); $b++)
    {
        $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $sup = $data['supply']. " " . $data['volume'] .  $data['unit_measure']; 
            $quantity =$qty_s[$b];
            $issued .= $quantity . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    echo  rtrim($issued, ", ");
    mysqli_close($conn);

















    