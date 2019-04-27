<?php
if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){ //mode utilisateur
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($_GET['id']);
  $chemin = './data'.$infos['chemin'];
  $email = $infos['email'];
  $mode = "user";

}else{ //mode admin

  $chemin='./data'.$_GET['video'];

  $mode = "admin";
}

$nom_fichier = explode("/", $chemin);
$nom_fichier = array_reverse($nom_fichier);
$nom_fichier = $nom_fichier[0];

$dossier = new dossier();
$taille_fichier = $dossier->HumanSize(filesize($chemin));


include('./vue/video.php');

//ajout du script DL si user
if(isset($_GET['id'])){
  $action = 'dl_video';
  include('./scripts/script_button_dl.php');
}
