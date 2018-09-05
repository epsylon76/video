<?php

$chemin=$_GET['photos'];

include('vue/head.php');
//ops

$diapo = new dossier();
$liste_photos = $diapo->contenu_dossier($chemin,$data);
$diaporama = $diapo->diapo_photos($liste_photos);



//fin ops
include('vue/photos.php');
