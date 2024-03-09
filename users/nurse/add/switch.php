<?php 
    $a = "Student";
    $b = "Female";

    switch(true)
    {
        case ($a == "Student" AND $b == "Female"):
        {
            echo "sf";
            break;
        }
        default:
        {
            echo "wala";
            break;
        }
    }
?>