<?php

if (!isset($_SESSION['usertype'])) {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    header('Refresh: 3; URL=../../index');
    exit(0);
} else {
    if ($_SESSION['usertype'] != "STAFF") {
        header("location:javascript://history.go(-1)");
        exit(0);
    }
}