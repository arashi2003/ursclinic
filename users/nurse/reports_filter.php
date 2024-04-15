<?php
    $report = $_POST['reports'];

    switch($report)
    {
        case "appointment":
            header('Location: reports_appointment');
            break;
        case "docvisit":
            header('Location: reports_doc_visit');
            break;
        case "medcase":
            header('Location: reports_medcase');
            break;
        case "medinv":
            header('Location: reports_medinv');
            break;
        case "supinv":
            header('Location: reports_supinv');
            break;
        case "teinv":
            header('Location: reports_teinv');
            break;
        case "tecalimain":
            header('Location: reports_tecalimain');
            break;
        case "transaction":
            header('Location: reports_trans');
            break;
        case "patinfo":
            header('Location: reports_patinfo');
            break;
        case "meddoc":
            header('Location: reports_meddoc');
            break;
        default:
            break;
    }
?>