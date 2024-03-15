<?php
    $entry = $_POST['entry'];

    switch($entry)
    {
        case "medicine":
            header('Location: med_entry');
            break;
        case "supply":
            header('Location: sup_entry');
            break;
        case "te":
            header('Location: te_entry');
            break;
        default:
            header('Location: entry');
            break;
    }
?>