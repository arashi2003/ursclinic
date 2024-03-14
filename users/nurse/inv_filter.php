<?php
    $inv = $_POST['inv'];

    switch($inv)
    {
        case "medadmin":
            header('Location: medadmin_set');
            break;
        case "dform":
            header('Location: dform_set.php');
            break;
        case "um":
            header('Location: umeasure_set');
            break;
        default:
            header('Location: inv');
            break;
    }
?>