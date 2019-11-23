<?php


function HumanSize($Bytes)
{
  $Type=array("", "Ko", "Ko", "Go", "To", "Po");
  $Index=0;
  while($Bytes>=1024)
  {
    $Bytes/=1024;
    $Index++;
  }
  return("".floor($Bytes)." ".$Type[$Index]);
}


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

$free = disk_free_space(".");
$free = HumanSize($free);

$dirs = scandir('data/');
$i=0;
foreach($dirs as $dir){
  if($dir != '.' && $dir != '..'){
  $freedata[$i]['nom'] =  $dir;
  $calc = disk_free_space('data/'.$dir);
  $freedata[$i]['free'] = HumanSize($calc);
  $i++;
}
}

$percent=100 / $limite;
$percent = $percent * $taille;

$npstat = $partage->comptenp();

//nombre de clics sur télécharger dans les dernieres 24h
$clics = $partage->clic_24h();
$clics_total = $partage->clic_total();

//les partages introuvables

$introuvable = $partage->introuvables($data);

include('vue/stats.php');
