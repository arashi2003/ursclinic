<?php
    $report = $_POST['reports'];

    switch($report)
    {
        case "appointment":
            header('Location: reports_appointment.php');
            break;
        case "docvisit":
            header('Location: reports_doc_visit.php');
            break;
        case "medcase":
            header('Location: reports_medcase.php');
            break;
        case "medinv":
            header('Location: reports_medinv.php');
            break;
        case "supinv":
            header('Location: reports_supinv.php');
            break;
        case "teinv":
            header('Location: reports_teinv.php');
            break;
        case "tecalimain":
            header('Location: reports_tecalimain.php');
            break;
        case "transaction":
            header('Location: reports_trans.php');
            break;
        default:
            header('Location: reports.php');
            break;
    }
?>