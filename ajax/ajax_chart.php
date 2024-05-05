<?php
include_once('../mdl/stats.php');
include('../config/dbconn.php');
include('../config/fonctions.php');

$stats = new stats();
// $calcul_taille = $stats->calcul_taille_by_period(10);

//intervalle souhaité en h
$intervalle = 12;


$dateobj = new DateTime(); //crée un objet PHP dateTime à l'instant T
$now = $dateobj->format('Y-m-d H:i:s'); //stocke la date maintenant au bon format
$before = $dateobj;
$before->modify('- '.$intervalle.' hour'); //on soustrait 24h
$before = $before->format("Y-m-d H:i:s"); //on le met au bon format

$liste_stats = $stats->get_stats($before, $now);


$origine = new DateTime(); 
$minutes = $origine->format('i');
$minutes = $minutes % 10;
if($minutes != 0)
{
    // différence
    $diff = 10 - $minutes;
    // Ajouter la difference
    $origine->add(new DateInterval("PT".$diff."M"));
}
$heuresupp = $origine->format('Y-m-d H:i:00');

$data = array(); //on prépare un tableau
$i = 0;
//à chaque intervalle de dix minutes
while($origine->format('Y-m-d H:i:s') >= $before){
    $heureinf = $origine->modify('-10 minute'); //on retire 10 minutes
    //faire la requete de stats
    $bp = $stats->get_stats($heureinf->format('Y-m-d H:i:00'), $heuresupp);
    $data[$i]['periode'] = $heureinf->format('H:i');
    if(!empty($bp)){
        foreach($bp as $b){
            if($_POST['state'] == 'go'){
                $data[$i][$b['type']] = ($b['volume'] / 1073741824);
            }elseif($_POST['state'] == 'mbps'){
                //10 minutes = 600secondes
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
$data = array_reverse($data); //il faut inverser le tableau pour avoir l'heure la plus récente à droite
echo json_encode($data);
?>
