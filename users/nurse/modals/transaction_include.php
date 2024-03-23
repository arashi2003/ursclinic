<?php
$type = $_POST['type'];

if($type == "Walk-In") {
    include('../add/transaction.php');
} else {
    include('../add/transaction_medhist.php');
}
