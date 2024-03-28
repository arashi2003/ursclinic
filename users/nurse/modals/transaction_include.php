<?php
if($_POST['type'] == "Walk-In") {
    require('../add/transaction.php');
} else {
    require('../add/transaction_medhist.php');
}
