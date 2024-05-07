<?php
include_once('../mdl/stats.php');
include('../config/dbconn.php');
include('../config/fonctions.php');

$stats = new stats();
// $calcul_taille = $stats->calcul_taille_by_period(10);

//intervalle souhaité en h, on peut les changer !

if(isset($_POST['heure'])){
    $intervalle = $_POST['heure'];
}
else{
    $intervalle = 12;
}



//Date de fin du graphique -> Maintenant
$origine = new DateTime(); //crée un objet PHP dateTime à l'instant T
$now = $origine->format('Y-m-d H:i:s'); //stocke la date maintenant au bon format


//Date de début du graphique
$before = new DateTime(); //un deuxième objet date pour la date de début
$before->modify('- '.$intervalle.' hour'); //on soustrait 24h
$before = $before->format("Y-m-d H:i:s"); //on le met au bon format

//on reprend la date de fin du graphique qu'on soustraira de chaque intervalle
$minutes = $origine->format('i');
$minutes = $minutes % 10; //modulo 10
if($minutes != 0)
{
    // différence pour arriver à 10
    $diff = 10 - $minutes;
    // Ajouter la difference pour arriver à dix
    $origine->add(new DateInterval("PT".$diff."M"));
}
$heuresupp = $origine->format('Y-m-d H:i:00'); //zéro secondes

$data = array(); //on prépare un tableau pour les résultats
$i = 0;
//boucle pour chaque intervalle de dix minutes
while($origine->format('Y-m-d H:i:s') >= $before){
    $heureinf = $origine->modify('-10 minute'); //on retire 10 minutes
    //faire la requete de stats
    $bp = $stats->get_stats($heureinf->format('Y-m-d H:i:00'), $heuresupp);
    $data[$i]['periode'] = $heureinf->format('H:i');
    if(!empty($bp)){
        foreach($bp as $b){
            if($_POST['state'] == 'go'){
                $data[$i][$b['type']] = ($b['volume'] / 1024 / 1024 / 1024);
            }elseif($_POST['state'] == 'mbps'){
                // 10 minutes = 600secondes
                // 1 octet = 8 bits
                // 1 Giga = 1 milliard
                $data[$i][$b['type']] = ($b['volume'] * 8 / 1000000 / 600);
            }
        }    
    }

    if(empty($data[$i]['dl_video'])){
        $data[$i]['dl_video'] = 0;
    }
    if(empty($data[$i]['play_videos'])){
        $data[$i]['play_videos'] = 0;
    } 
    if(empty($data[$i]['dl_photos'])){
        $data[$i]['dl_photos'] = 0;
    } 
    if(empty($data[$i]['defile_photo'])){
        $data[$i]['defile_photo'] = 0;
    } 

    //heureinf replace heure supp
    $heuresupp = $heureinf->format('Y-m-d H:i:00');
    $i++;
}
//les résultats sont inversés : on est partis de l'heure de maintenant et on a soustrait des minutes à chaque fois, on doit donc inverser le tableau pour avoir le graphique dans le bon sens
$data = array_reverse($data);

echo json_encode($data);
?>
