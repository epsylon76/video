<?php

if(isset($uri[2]) && $partage->check_partage($uri[1], $uri[2])){ //mode utilisateur
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($uri[2]);
  $chemin = '/data'.$infos['chemin'];
  $email = $infos['email'];
  $mode = "user";
  $taille_fichier = $dossier->HumanSize(filesize($data.$infos['chemin'])); //diff
}else{ //mode admin
  $slices = array_slice($uri, 2);
  $chemin = '';
  foreach($slices as $u){
    $chemin .= $u.'/';
  }
  $chemin = rtrim('/data'.$chemin, '/');
  $chemin = urldecode($chemin);
  $mode = "admin";
  $filePathSystem = $data.ltrim($chemin, '/data/');
  $taille_fichier = $dossier->HumanSize(filesize($filePathSystem)); //diff
}

$nom_fichier = explode("/", $chemin);
$nom_fichier = array_reverse($nom_fichier);
$nom_fichier = $nom_fichier[0];



include('./vue/video.php');

//ajout du script DL si user
if($mode == "user"){
  $action = 'dl_video';
  include('/scripts/script_button_dl.php');
}
