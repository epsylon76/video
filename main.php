<?php
session_start();

require('vendor/autoload.php');

include_once('./config/config.php');
//parametres titre, email....
$params = get_params();
$data = $params['dossier_data'];

include_once('./mdl/admin.php');
include_once('./mdl/dossier.php');
include_once('./mdl/partage.php');
include_once('./mdl/historique.php');


if(!isset($_GET['dl_photos']) && !isset($_GET['dl_dossier']) ){
  include_once('./vue/head.php'); //ne pas afficher sur dl_photos car casse le stream
}



if(isset($_GET['action']) && $_GET['action']=="deco"){
  include('./ctrl/deconnecter.php');
}

//accès via clé detruit la session avant toutes
if(isset($_GET['cle'])) {unset($_SESSION['login']);session_destroy();}
//



if (isset($_SESSION['login'])){//MODE ADMIN
  include('./ctrl/admin.php');

}else{ //MODE CLIENT
  if(isset($_GET['cle'])) {

    $partage = new partage();

    if(isset($_GET['id']))
    {  //on accède à un partage en particulier
      //on détermine si ce sont des photos ou une vidéo

      if($partage->get_type_partage($_GET['id']) == "video"){
        include('./ctrl/video.php');
      }elseif($partage->get_type_partage($_GET['id']) == "photos"){
        include('./ctrl/photos.php');
      }elseif($partage->get_type_partage($_GET['id']) == "dossier"){
        include('./ctrl/dossier_zip.php');//on lance le téléchargement du zip dossier --> passer par une page explicative
      }

    }elseif(isset($_GET['dl_photos'])){//on lance le téléchargement du zip photos
      include('./ctrl/dl_photos.php');
    }elseif(isset($_GET['dl_dossier'])){//on lance le téléchargement du zip dossier
        include('./ctrl/dl_dossier_zip.php');
    }else{ // on accède à la liste des partages
      include('./ctrl/partage.php');
    }

  }else{ // pas d'url avec cle
    include('./ctrl/accueil.php');
  }
}
