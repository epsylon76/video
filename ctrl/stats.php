<?php
include('vue/nav.php');
$dossier = new dossier();
$partage = new partage();
$limite = 100000;
$percent = 0;

$zip_folder="./zip/";
$listefichiers = scandir($zip_folder);
$taille = 0;
foreach($listefichiers as $fichier){
  if($fichier != '.' && $fichier != '..' && $fichier != '.placeholder'){
    $temp = floor(filesize($data.'../zip/'.$fichier) / 1048576);
    $taille = $taille + $temp;
  }
}

$percent=100 / $limite;
$percent = $percent * $taille;

$npstat = $partage->comptenp();

//nombre de clics sur télécharger dans les dernieres 24h
$clics = $partage->clic_24h();

//les partages introuvables

$introuvable = $partage->introuvables($data);

include('vue/stats.php');
