<?php
    $stocks = $_POST['stocks'];

    switch($stocks)
    {
        case "medicine":
            header('Location: med_stocks_total');
            break;
        case "supply":
            header('Location: sup_stocks_total');
            break;
        case "te":
            header('Location: te_stocks');
            break;
        default:
            header('Location: stocks');
            break;
    }
?>