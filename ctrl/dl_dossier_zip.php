<?php
ini_set('max_execution_time', 1000);
ini_set('memory_limit', '20000000M'); //à modifier

//il faudra lui donner le nom de l'id de la BDD
$zip_name=$_GET['dl_dossier']."_test.zip";

$folder = $partage->get_partage($_GET['dl_dossier']);

$folder = $folder['chemin'];


if(file_exists('./zip/'.$zip_name) == "1"){

  header("Location: ./zip/".$zip_name);
}else{
  //on retire le dernier slash de data
  $data=rtrim($data, '/');
  //on echappe les espaces de $folder
  $folder=str_replace(' ', '\ ', $folder);
  $folder=str_replace('(', '\(', $folder);
  $folder=str_replace(')', '\)', $folder);
  $commande='nice zip -r -j -0 '.$data.'/../zip/'.$zip_name.' '.$data.$folder;

  $commande = shell_exec($commande);
  //echo $commande; //debug
  header("Location: ./zip/".$zip_name);
}
