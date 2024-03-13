<?php
    $medrec = $_POST['medrec'];

    switch($medrec)
    {
        case "cc":
            header('Location: chiefcomplaint.php');
            break;
        case "findings":
            header('Location: findings.php');
            break;
        case "medcase":
            header('Location: medcase_set.php');
            break;
        case "designation":
            header('Location: designation.php');
            break;
        default:
            header('Location: medrec.php');
            break;
    }
?>