<?php

if(isset($uri[2]) && $partage->check_partage($uri[1], $uri[2])){ // Mode client
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($uri[2]);
  $chemin = $infos['chemin'];
  $email = $infos['email'];
}
else{ //mode admin
  $slices = array_slice($uri, 2);
  $chemin = '';
  foreach($slices as $u){
    $chemin .= $u.'/';
  }
  $chemin = rtrim('/data'.$chemin, '/');
  $chemin = urldecode($chemin);
  $mode = "admin";
}


//calcul de la taille

$listefichiers = $dossier->contenu_dossier($chemin,$data);
$taille = 0;
$date ='';
$nb = 0;
foreach ($listefichiers as $item) {
  if($item != '.' && $item != '..' && $item != 'Thumbs.db'){
    $date = filectime($data.$chemin.'/'.$item);
    $taille = ($taille + filesize($data.$chemin.'/'.$item));
    $nb++;
  }
}

//fin ops
include('vue/photos.php');

//ajout du script DL si user qui track le nombre de clic
if(isset($uri[2])){
  $action = 'dl_photos';
  include('./scripts/script_button_dl.php');
}
