<?php
$b4 = $_POST['b4'];
if ($b4 == "Print Prescription") {
    include('reports_pres_med.php');
} elseif ($b4 == "Print Medical Record") {
    include('reports_medrecref.php');
}
?>