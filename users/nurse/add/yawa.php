<?php
    include('../../../connection.php');
    
    $a = 1;
    $b = 2;

    if($a = 1)
    {
        echo "yes to " . $a . "<br>";
        if($b = 2)
        {
            echo "row to " . $b . "<br>";
        }
    }
    else
    {
        echo "not " . $b;
    }

    if($b = 2)
    {
        echo "hey to " . $b . "<br>";
    }

    mysqli_close($conn);