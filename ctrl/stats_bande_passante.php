<?php

$test = $stats->calcul_moyenne();

if(!empty($test))
{
    foreach($test as $row)
    {
        echo $row['periode'] .  " --- total_taille: " . round($row['total_taille'] / 1000000)  . " Mo</br>";
    }
}
?>