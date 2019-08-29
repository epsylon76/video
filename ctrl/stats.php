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

$vol = $dossier->espace_disque($data);

$npstat = $partage->comptenp();

//les partages introuvables

$requete="SELECT * from `partage`";
$query=$DB_con->prepare($requete);
$query->execute();
$results = $query->fetchAll();
$i=0;
$introuvable=false;
foreach($results as $ligne){
  $date= new DateTime($ligne['date']);
  $date_aff = $date->format('d/m/Y H:i');

if (file_exists($data.$ligne['chemin'])) {$exist = true;}else{
  $introuvable[$i]['id'] = $ligne['id'];
  $introuvable[$i]['chemin'] = $ligne['chemin'];
  $i++;
}

}

include('vue/stats.php');
