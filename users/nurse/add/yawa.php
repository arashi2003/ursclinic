<?php
    include('../../../connection.php');
    //$issued = "";//pa sentence na qty + medsup
    //$qty_s = $_POST['quantity_sup'];
    //$qm = implode($_POST['quantity_med']);
    //$qs = implode($_POST['quantity_sup']);
    //$m = implode($_POST['medicine']);
    //$supply = $_POST['supply'];
    //$s = implode($_POST['supply']);

    $qty_m = $_POST['quantity_med'];
    $medicine = $_POST['medicine'];
    $issued ="";
    $qty_s = $_POST['quantity_sup'];
    $supply = $_POST['supply'];

    if($medicine != "" AND $supply != "")
    {
        for($a = 0; $a < count($medicine); $a++)
        {
            echo $qty_m[$a] . " " . $medicine[$a] . "<br>";
        }
        for($b = 0; $b < count($supply); $b++)
        {
            echo $qty_s[$b] . " " . $supply[$b] . "<br>";
        }
    }
    elseif($medicine == "" AND $supply != "")
    {
        for($b = 0; $b < count($supply); $b++)
        {
            $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $sup = $data['supply'].  $data['volume'] .  $data['unit_measure']; 
            }
            $issued .= $qty_s[$b] . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    elseif($medicine != "" AND $supply == "")
    {
        $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
        }
        $issued .= $qty_m[$a] . " " . $med;
        $issued .= $qty_s[$b] . " " . $sup;
        if($b < count($medicine) - 1)
        {
            $issued .= ", ";
        }
    }



    /*

    if($medicine != "" AND $supply != "")
    {
        for($a = 0; $a < count($medicine); $a++)
        {
            $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
            }
            $issued .= $qty_m[$a] . " " . $med . ", ";
        }
        for($b = 0; $b < count($supply); $b++)
        {
            $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $sup = $data['supply']. " " . $data['volume'] .  $data['unit_measure']; 
            }
            $issued .= $qty_s[$b] . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    elseif($medicine == "" AND $supply != "")
    {
        for($b = 0; $b < count($supply); $b++)
        {
            $sql = "SELECT * FROM supply WHERE supid='$supply[$b]'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $sup = $data['supply'].  $data['volume'] .  $data['unit_measure']; 
            }
            $issued .= $qty_s[$b] . " " . $sup;
            if($b < count($supply) - 1)
            {
                $issued .= ", ";
            }
        }
    }
    elseif($medicine != "" AND $supply == "")
    {
        $sql = "SELECT * FROM medicine WHERE medid='$medicine[$a]'";
        $result = mysqli_query($conn, $sql);
        while($data=mysqli_fetch_array($result))
        {
            $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
        }
        $issued .= $qty_m[$a] . " " . $med;
        $issued .= $qty_s[$b] . " " . $sup;
        if($b < count($medicine) - 1)
        {
            $issued .= ", ";
        }
    }

    echo $issued;















    
    /*if (isset($_POST['medicine'])) 
    {
        foreach($medicine as $x)
        {
            $sql = "SELECT * FROM medicine WHERE medid='$m'";
            $result = mysqli_query($conn, $sql);
            while($data=mysqli_fetch_array($result))
            {
                $med = $data['medicine'].  $data['dosage'] .  $data['unit_measure']; 
                echo $med . " " . $qty_m . " pcs. <p>";
            }
        }
            
        
    }
    elseif (isset($_POST['medical'])) 
    {
        echo $supply . " " . $qty_s . " pcs. <p>";
    }*/

    mysqli_close($conn);