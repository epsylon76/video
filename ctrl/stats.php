<?php
include('vue/nav.php');
$dossier = new dossier();
$limite = 100000;
$percent = 0;

$zip_folder="./zip/";
$listefichiers = scandir($zip_folder);
$taille = 0;
foreach($listefichiers as $fichier){
  if($fichier != '.' && $fichier != '..'){
    $temp = floor(filesize($data.'../zip/'.$fichier) / 1048576);
    $taille = $taille + $temp;
  }
}

$percent=100 / $limite;
$percent = $percent * $taille;

$vol = $dossier->espace_disque($data);

$net_iface = $params['net_iface'];

include('vue/stats.php');
