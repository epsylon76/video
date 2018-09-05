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


if(isset($_GET['action'])){
  if($_GET['action']=="deco"){
    include('./ctrl/deconnecter.php');
  }
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
  }
}else{ //pas de variable de session"login" = pas admin
  if(isset($_GET['email'])){
    include('./ctrl/partage.php');
  }else{
    include('./ctrl/accueil.php');
  }
}
