<?php

$login = new admin();

if(isset($_SESSION['login']) && isset($_SESSION['pass'])){

  if($login->check_login_crypt($_SESSION['login'],$_SESSION['pass'])){

    if(!isset($_GET['page'])){$_GET['page'] = "dossiers";}

    switch($_GET['page']){

      case "dossiers":
      if (!isset($_GET['chemin'])){
        $chemin="/";
      }else{
        $chemin = $_GET['chemin'];
      }
      $partages = new partage();
      $dossier = new dossier($data,$chemin);

      $listefichiers = $dossier->contenu_dossier($chemin,$data);

      $breadcrumb = $dossier->breadcrumb($chemin);

      include('vue/nav.php');
      include('vue/admin.php');
      break;

      case "set_partage":
      include('ctrl/set_partage.php');
      break;
    }



    //fin affichage admin
  }else{
    echo"check pass deja crypt";
    session_destroy();
    header('Location: ./');
  }

}else{
  echo"pas de pass et login pass en session";
  session_destroy();
  header('Location ./');
}
