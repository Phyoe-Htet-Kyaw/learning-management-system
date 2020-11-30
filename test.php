<?php

    $start_date = new DateTime('2020-11-30');
    $end_date = new DateTime('2020-12-05');

    $date_arr = [];

    $date1 = strtotime('2020-11-30');
    $date2 = strtotime('2020-12-05');

    $diff = abs($date2 - $date1);  
    $years = floor($diff / (365*60*60*24));  
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 

    // printf("%d days", $days);  
    echo $days;

    $i = 0;
    array_push($date_arr, $start_date->format('Y-m-d'));
    do{
        $start_date->modify('+1 day');
        // echo $start_date->format('Y-m-d')."\n";
        array_push($date_arr, $start_date->format('Y-m-d'));
        $i++;
    }while($i < $days);

    echo "<pre>";
    print_r($date_arr);
    echo "</pre>";
?>