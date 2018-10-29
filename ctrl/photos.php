<?php


if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){
  //retrouver le chemin via l'id
  $chemin = $partage->get_partage($_GET['id']);
  $chemin = $chemin['chemin'];




$diapo = new dossier();
$liste_photos = $diapo->contenu_dossier($chemin,$data);
$diaporama = $diapo->diapo_photos($liste_photos);



//fin ops
include('vue/photos.php');

}else{
  header('Location: /');
}
