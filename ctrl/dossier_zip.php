<?php

if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($_GET['id']);
  $chemin = $infos['chemin'];
  $email = $infos['email'];
}

//fin ops
include('vue/dossier_zip.php');

//ajout du script DL si user
if(isset($_GET['id'])){
  $action = 'dl_dossier';
  include('./scripts/script_button_dl.php');
}
