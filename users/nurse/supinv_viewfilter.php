<?php
    $filter = $_POST['supinv_view'];

    switch($filter)
    {
        case "expiration":
            header('Location: sup_stocks_exp');
            break;
        case "batch":
            header('Location: sup_stocks_batch');
            break;
        default:
            header('Location: sup_stocks_total');
            break;
    }
?>