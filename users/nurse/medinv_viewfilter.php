<?php
    $filter = $_POST['medinv_view'];

    switch($filter)
    {
        case "expiration":
            header('Location: med_stocks.php');
            break;
        case "batch":
            header('Location: med_stocks_batch.php');
            break;
        default:
            header('Location: med_stocks_total.php');
            break;
    }
?>