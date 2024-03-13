<?php
    $stocks = $_POST['stocks'];

    switch($stocks)
    {
        case "medicine":
            header('Location: med_stocks_total.php');
            break;
        case "supply":
            header('Location: sup_stocks_total.php');
            break;
        case "te":
            header('Location: te_stocks.php');
            break;
        default:
            header('Location: stocks.php');
            break;
    }
?>