<?php
//$o = $_POST['opened'];
//$c = $_POST['close'];


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
?>