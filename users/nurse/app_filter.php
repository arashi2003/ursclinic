<?php
$app = $_POST['app'];

switch ($app) {
    case "cc":
        header('Location: appcc_set');
        break;
    case "type":
        header('Location: apptype_set');
        break;
    case "purpose":
        header('Location: apppurpose_set');
        break;
    case "physician":
        header('Location: appphysician_set');
        break;
    default:
        header('Location: app');
        break;
}
