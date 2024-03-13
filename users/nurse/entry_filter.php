<?php
    $entry = $_POST['entry'];

    switch($entry)
    {
        case "medicine":
            header('Location: med_entry.php');
            break;
        case "supply":
            header('Location: sup_entry.php');
            break;
        case "te":
            header('Location: te_entry.php');
            break;
        default:
            header('Location: entry.php');
            break;
    }
?>