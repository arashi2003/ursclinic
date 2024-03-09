<?php
    $app = $_POST['app'];

    switch($app)
    {
        case "cc":
            header('Location: appcc_set.php');
            break;
        case "type":
            header('Location: apptype_set.php');
            break;
        case "purpose":
            header('Location: apppurpose_set.php');
            break;
        default:
            header('Location: app.php');
            break;
    }
?>