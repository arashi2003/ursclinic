<?php
    $medrec = $_POST['medrec'];

    switch($medrec)
    {
        case "cc":
            header('Location: chiefcomplaint');
            break;
        case "findings":
            header('Location: findings');
            break;
        case "medcase":
            header('Location: medcase_set');
            break;
        case "designation":
            header('Location: designation');
            break;
        default:
            header('Location: medrec');
            break;
    }
?>