<?php
session_start();
#le controlleur principal contient
#la connexion à la DB
#le chargement du controlleur
require('vendor/autoload.php');

include_once('./config/config.php');
include_once('./mdl/admin.php');
include_once('./mdl/dossier.php');
include_once('./mdl/partage.php');
if(!isset($_GET['dl_photos'])){
  include_once('./vue/head.php'); //ne pas afficher sur dl_photos car casse le stream
}



if(isset($_GET['action']) && $_GET['action']=="deco"){
  include('./ctrl/deconnecter.php');
}


if (isset($_SESSION['login'])){

  include('./ctrl/admin.php');
  //mode admin

}else{ //pas de variable de session"login" = pas admin
  if(isset($_GET['cle'])) {
    $partage = new partage();

    if(isset($_GET['id']))
    {  //on accède à un partage en particulier
      //on détermine si ce sont des photos ou une vidéo

      if($partage->get_type_partage($_GET['id']) == "video"){
        include('./ctrl/video.php');
      }elseif($partage->get_type_partage($_GET['id']) == "photos"){
        include('./ctrl/photos.php');
      }

    }elseif(isset($_GET['dl_photos'])){//on lance le téléchargement du zip photos
      include('./ctrl/dl_photos.php');
    }else{ // on accède à la liste des partages
      include('./ctrl/partage.php');
    }

  }else{ // pas d'url avec cle
    include('./ctrl/accueil.php');
  }
}
