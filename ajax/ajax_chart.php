<?php
include_once('../mdl/stats.php');
include('../config/dbconn.php');

$stats = new stats();
// $calcul_taille = $stats->calcul_taille_by_period(10);

$dateobj = new DateTime(); //crée un objet PHP dateTime à l'instant T

$now = $dateobj->format('Y-m-d H:i:s'); //stocke la date maintenant au bon format
$dateobj->modify('minus 12 hour'); //modifie l'objet datetime en retirant 12 heures
$before = $dateobj->format('Y-m-d H:i:s');


$liste_stats = $stats->get_stats($before, $now);

if(!empty($liste_stats)){

    $clicked = filter_input(INPUT_POST, 'clicked', FILTER_VALIDATE_BOOLEAN);

    foreach($liste_stats as $row)
    {

        // $heure = $row['heure'];
        // $periode = date('%H:', strtotime($heure)) . str_pad(floor(date('i', strtotime($heure)) / 30) * 30, 2, '0', STR_PAD_LEFT);

        if ($clicked) {
            $data[] = array(
                'periode' => $row['heure'],
                'total_taille' =>  round(($row['taille'] / 1000000000) * 8, 3));  
        } else {
            $data[] = array(
                'periode' => $row['heure'],
                'total_taille' =>  round($row['taille'] / 1000000000, 3)); 
        }
    }
}

echo json_encode($data);
?>
