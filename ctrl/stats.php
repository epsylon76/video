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
$octetstogigaoctets = (1024*1024*1024);

include('vue/nav.php');
$dossier = new dossier();
$partage = new partage();
$freedisk = disk_free_space(".");
$limite = floor($freedisk / $octetstogigaoctets);
$percent = 0;

$zip_folder="./zip/";
$listefichiers = scandir($zip_folder);
$taille = 0;

foreach($listefichiers as $fichier){
  if($fichier != '.' && $fichier != '..' && $fichier != '.placeholder'){
    $temp = filesize($data.'../zip/'.$fichier);
    $taille = $taille + $temp;
  }
}
$taille = floor($taille / 1000000000);

$free = HumanSize($freedisk);

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

$annee = date('Y');
$anneeB = $annee-1;


//nombre de clics sur télécharger dans les dernieres 24h
$clics = $partage->clic_24h();
$clics_total = $partage->clic_total();

//les partages introuvables

$introuvable = $partage->introuvables($data);

include('vue/stats.php');
