<?php

if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($_GET['id']);
  $chemin = $infos['chemin'];
  $email = $infos['email'];
}
else{ //mode admin
  $chemin = $_GET['photos'];
  $mode = "admin";
}



$diapo = new dossier();
$liste_photos = $diapo->contenu_dossier($chemin,$data);
$diaporama = $diapo->diapo_photos($liste_photos);


//fin ops
include('vue/photos.php');

//ajout du script DL si user
if(isset($_GET['id'])){
  $action = 'dl_photos';
  include('./scripts/script_button_dl.php');
}
