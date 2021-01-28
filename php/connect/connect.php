<?php

    $connect = mysqli_connect("std-mysql", "std_926_php", "12345678", "std_926_php");

    if(!$connect){
        die("No connection to database!");
    }

?>