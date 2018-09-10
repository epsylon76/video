<?php
session_start();
#le controlleur principal contient
#la connexion à la DB
#le chargement du controlleur

include_once('./config/config.php');
include_once('mdl/admin.php');
include_once('mdl/dossier.php');
include_once('mdl/partage.php');
include_once('vue/head.php');


if(isset($_GET['action']) && $_GET['action']=="deco"){
    include('./ctrl/deconnecter.php');
  }



if (isset($_SESSION['login'])){
  include('./ctrl/admin.php');

  switch ($_GET['page']){
    case "video" :
    include('./ctrl/video.php');
    break;

    case "photos" :
    include('./ctrl/photos.php');
    break;

    case "dl_photos":
    include('./ctrl/dl_photos.php');
    break;

    case "liste":
    include('./ctrl/liste.php');
    break;
  }
}else{ //pas de variable de session"login" = pas admin
  if(isset($_GET['email']) && isset($_GET['cle'])) {
    $partage = new partage();
    if($partage->check_cle_email($_GET['cle'],$_GET['email'])){

      if(isset($_GET['id']))
      {  //on accède à un partage en particulier
        //on détermine si ce sont des photos ou une vidéo

        if($partage->get_type_partage($_GET['id']) == "video"){
          include('./ctrl/video.php');
        }elseif($partage->get_type_partage($_GET['id']) == "photos"){
          include('./ctrl/photos.php');
        }

      }else { // on accède à la liste des partages

        include('./ctrl/partage.php');
      }
    }else{//check cle email failed
      include('./ctrl/accueil.php');
    }
  }else{ // pas d'url avec email
    include('./ctrl/accueil.php');
  }
}
