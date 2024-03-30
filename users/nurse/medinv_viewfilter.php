<?php
$filter = $_POST['medinv_view'];

switch ($filter) {
    case "expiration":
        header('Location: med_stocks');
        break;
    case "batch":
        header('Location: med_stocks_batch');
        break;
    case "total":
        header('Location: med_stocks_total');
        break;
}
