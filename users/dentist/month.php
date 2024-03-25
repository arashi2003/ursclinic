<?php
session_start();
include('connection.php');

$time_from = "10:00:00";

$sql = "SELECT * FROM time_pickup WHERE time > '$time_from'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
echo $row['time'] . "<br>";
    }

/*
//$endmonth =  date("Y-m-t");
$month = "April 2024";
$endmonth =  date("Y-m-t", strtotime($month));
$lastmonth = date("Y-m-t", strtotime("$endmonth - 1 month"));

//$campus = "ANGONO";
//$campus = "ANTIPOLO";
//$campus = "CAINTA";
//$campus = "CARDONA";
$campus = "BINANGONAN";
//$campus = "MORONG";
//$campus = "PILILLA";
//$campus = "RODRIGUEZ";
//$campus = "TANAY";
//$campus = "TAYTAY";


//truncate muna lahat bago i-run ng official !!!!!!!!!!!


//auto report supply in medsupinv
$query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND eqty > 0 AND type = 'supply' AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    foreach ($result as $data) {
       
        echo "meron ";
        echo $data['medicine'] . " <p>";
    }
} else {
    echo "yow sup <p>";
}





/*

if(!empty($_POST['opened']))
{
    $o = implode($_POST['opened']);
}
else{
    $o = "";
}
$c = implode($_POST['close']);
$qty = floatval($c) + floatval($o);
$exp = $_POST['expiration'];
echo $_POST['supply'] . " supply<p>";
echo $o . " declare lang open<p>";
echo $c . " declare lang close <p>";
echo $qty . " declare lang nung qty <p>";
echo $qty .  " addition<p>";
echo floatval($o) * floatval($c) .  " multiplication<p>";




/*
$month = "January 2024";
$endmonth =  date("Y-m-t", strtotime($month));
$lastmonth = date("Y-m-t", strtotime("$endmonth - 1 month"));

//$campus = "ANGONO";
//$campus = "ANTIPOLO";
//$campus = "CAINTA";
//$campus = "CARDONA";
$campus = "BINANGONAN";
//$campus = "MORONG";
//$campus = "PILILLA";
//$campus = "RODRIGUEZ";
//$campus = "TANAY";
//$campus = "TAYTAY";


$query = "SELECT * FROM report_medsupinv WHERE date = '$endmonth' AND admin LIKE '%$admin%' AND type='med_admin' AND medicine='$admin' AND medid != 0 AND campus='$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $sql = "INSERT INTO report_medsupinv SET campus = '$campus', type = 'med_admin', admin = '$admin', medicine = '$admin', date = '$endmonth'";
            //mysqli_query($conn, $sql);
            if (mysqli_query($conn, $sql)) {
                echo ", nalagyan na ng entry tong " . $admin;
            } else {
                echo ", di nalagyan na ng entry tong " . $admin;
            }
        }



/*

//auto report med in medsupinv
$query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND eqty > 0 AND type = 'medicine' AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    foreach ($result as $data) {
        echo "meron ";
        $medid = $data['medid'];
        $admin = $data['admin'];
        $medicine = $data['medicine'];

        $query = "SELECT * FROM report_medsupinv WHERE date = '$endmonth' AND admin LIKE '%$admin%' AND type='med_admin' AND campus='$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $sql = "INSERT INTO report_medsupinv SET campus = '$campus', type = 'med_admin', admin = '$admin', medicine = '$admin', date = '$endmonth'";
            //mysqli_query($conn, $sql);
            if (mysqli_query($conn, $sql)) {
                echo ", nalagyan na ng entry tong " . $admin;
            } else {
                echo ", di nalagyan na ng entry tong " . $admin;
            }
        }
    }
} else {
    echo "yow med <p>";
}

/*

//auto report med in medsupinv
$query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND eqty > 0 AND type = 'medicine' AND campus='$campus'";
$result = mysqli_query($conn, $query);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0) {
    echo "meron ";
    foreach ($result as $data) {
        $medid = $data['medid'];
        $medicine = $data['medicine'];
        echo "which is " . $medicine;
        $query = "SELECT * FROM report_medsupinv WHERE date = '$endmonth' AND medid = '$medid' AND type = 'medicine' AND campus='$campus'";
        $result = mysqli_query($conn, $query);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            $query = "SELECT * FROM report_medsupinv WHERE date = '$lastmonth' AND medid = '$medid' AND type = 'medicine' AND campus='$campus'";
            $result = mysqli_query($conn, $query);
            while ($data = mysqli_fetch_array($result)) {
                $bqty = $data['eqty'];
                $buc = $data['eamt'] / $data['eqty'];
                $eqty = $data['eqty'];
                $eamt = $data['eamt'];
                $admin = $data['admin'];

                $query = "SELECT * FROM med_admin WHERE id='$admin'";
                $result = mysqli_query($conn, $query);
                while ($data = mysqli_fetch_array($result)) {
                    $medad = $data['med_admin'];

                    $query = "SELECT * FROM report_medsupinv WHERE date = '$endmonth' AND admin = '$medad' AND campus='$campus'";
                    $result = mysqli_query($conn, $query);
                    $resultCheck = mysqli_num_rows($result);
                    if ($resultCheck == 0) {
                        $sql = "INSERT INTO report_medsupinv SET campus = '$campus', type = 'med_admin', admin = '$medad', medid = '$admin', medicine = '$medad', date = '$endmonth'";
                    }
                }

                $sql = "INSERT INTO report_medsupinv SET campus = '$campus', 
                type = 'medicine', admin = '$admin', medid = '$medid', 
                medicine = '$medicine', 
                bqty = '$bqty', buc = '$buc', 
                eqty = '$eqty', 
                eamt = '$eamt', date = '$endmonth'";
                //mysqli_query($conn, $sql);
                if (mysqli_query($conn, $sql)) {
                    echo ", nalagyan na ng entry ";
                } else {
                    echo ", di nalagyan na ng entry <p>";
                }
            }
        }
        echo "for this month <p>";
    }
} else {
    echo "yow med <p>";
}


//$o = $_POST['opened'];
//$c = $_POST['close'];

/*
$endmonth =  "January 2024";
echo $lastmonth = date("Y-m-t", strtotime("$endmonth - 1 month"));
/*
echo $_POST['supply'] . " supply<p>";
$o = implode($_POST['opened']);
$c = implode($_POST['close']);
$qty = $c + $o;
$exp = $_POST['expiration'];
echo $_POST['supply'] . " supply<p>";
echo $o . " declare lang open<p>";
echo $c . " declare lang close <p>";
echo $qty . " declare lang nung qty <p>";
echo $o + $c .  " addition<p>";
echo $o * $c .  " multiplication<p>";

/*
// Check if the 'opened' and 'close' arrays are set in the POST data
if(isset($_POST['opened']) && isset($_POST['close'])) {
    // Fetch the 'opened' and 'close' arrays from the POST data
    $openedArray = $_POST['opened'];
    $closeArray = $_POST['close'];
    
    // Initialize variables to hold the sum of opened and close quantities
    $openedSum = 0;
    $closeSum = 0;
    
    // Loop through the 'opened' array to calculate the sum
    foreach($openedArray as $opened) {
        // Convert each value to an integer and add it to the sum
        $openedSum += intval($opened);
    }
    
    // Loop through the 'close' array to calculate the sum
    foreach($closeArray as $close) {
        // Convert each value to an integer and add it to the sum
        $closeSum += intval($close);
    }
    
    // Calculate the total quantity
    $qty = $openedSum + $closeSum;
    
    // Fetch other form data
    $supply = $_POST['supply'];
    $exp = $_POST['expiration'];
    $unit_cost = $_POST['unit_cost'];
    
    // Output the results
    echo $supply . " supply<p>";
    echo $openedSum . " declare lang open<p>";
    echo $closeSum . " declare lang close <p>";
    echo $qty . " declare lang nung qty <p>";
    echo $openedSum + $closeSum .  " addition<p>";
    echo $openedSum * $closeSum .  " multiplication<p>";
    echo $exp . "<p>";
}

/*
$o = implode($_POST['opened']);
$c = implode($_POST['close']);
$qty = $c + $o;
$exp = $_POST['expiration'];
echo $_POST['supply'] . " supply<p>";
echo $o . " declare lang open<p>";
echo $c . " declare lang close <p>";
echo $qty . " declare lang nung qty <p>";
echo $o + $c .  " addition<p>";
echo $o * $c .  " multiplication<p>";

echo $exp . "<p>";*/
