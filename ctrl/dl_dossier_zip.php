<?php
ini_set('max_execution_time', 1000);
ini_set('memory_limit', '20000000M'); //à modifier


$zip_name=$_GET['dl_dossier']."_dossier.zip";

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
  $commande='cd '.$data.$folder.' && nice zip -r -0 '.$data.'/../zip/'.$zip_name.' ./*';
  //echo $commande;
  $commande = shell_exec($commande);
  //echo $commande; //debug
  header("Location: ./zip/".$zip_name);
}
