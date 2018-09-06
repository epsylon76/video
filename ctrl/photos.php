<?php


if(!isset($_GET['email'])){
  $chemin=$_GET['photos'];
}elseif(isset($_GET['email']) && isset($_GET['id'])){
  //retrouver le chemin via l'id
  $chemin = $partage->get_partage($_GET['id']);
  $chemin = $chemin['chemin'];
}

include('vue/head.php');
//ops

$diapo = new dossier();
$liste_photos = $diapo->contenu_dossier($chemin,$data);
$diaporama = $diapo->diapo_photos($liste_photos);



//fin ops
include('vue/photos.php');
