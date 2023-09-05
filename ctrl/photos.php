<?php

if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){ // Mode client
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($_GET['id']);
  $chemin = $infos['chemin'];
  $email = $infos['email'];
}
else{ //mode admin
  $chemin = $_GET['photos'];
  $mode = "admin";
}


//calcul de la taille
$dossier = new dossier($data,$chemin);
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
if(isset($_GET['id'])){
  $action = 'dl_photos';
  include('./scripts/script_button_dl.php');
}
