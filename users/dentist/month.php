<?php
//$o = $_POST['opened'];
//$c = $_POST['close'];

$o = implode($_POST['opened']);
$c = implode($_POST['close']);
$qty = $c + $o;
$exp = $_POST['expiration'];
echo $o . " declare lang open<p>";
echo $c . " declare lang close <p>";
echo $qty . " declare lang nung qty <p>";
echo $o + $c .  " addition<p>";
echo $o * $c .  " multiplication<p>";

echo $exp . "<p>";
?>