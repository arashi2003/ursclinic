<?php
    $filter = $_POST['supinv_view'];

    switch($filter)
    {
        case "expiration":
            header('Location: sup_stocks_exp.php');
            break;
        case "batch":
            header('Location: sup_stocks_batch.php');
            break;
        default:
            header('Location: sup_stocks_total.php');
            break;
    }
?>