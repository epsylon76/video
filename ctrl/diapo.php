<?php

$chemin = $_GET['photos'];
$mode = "admin";

$dossier = new dossier($data,$chemin);
$listefichiers = $dossier->contenu_dossier($chemin,$data);
$diaporama = $dossier->diapo_photos($listefichiers);
$taille = 0;
$date ='';
$nb = 0;
foreach ($listefichiers as $item) {
  $date = filectime($data.$chemin.$item);
  $taille = ($taille + filesize($data.$chemin.$item));
  $nb++;
}

//fin ops
include('vue/diapo.php');
