<?php

$login = new admin();

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {

  if ($login->check_login_crypt($_SESSION['login'], $_SESSION['pass'])) {

    if (!isset($_GET['page'])) {
      $_GET['page'] = "dossiers";
    }

    switch ($_GET['page']) {

        //dossiers
      case "dossiers":
        if (!isset($_GET['chemin'])) {
          $chemin = "/";
        } else {
          $chemin = $_GET['chemin'];
        }
        $partages = new partage();
        $dossier = new dossier();

        $listefichiers = $dossier->contenu_dossier($chemin, $data);
        $breadcrumb = $dossier->breadcrumb($chemin);

        include('vue/nav.php');
        include('vue/admin.php');
        break;

      case "video":
        include('ctrl/video.php');
        break;

      case "photos":
        include('ctrl/photos.php');
        break;


      case "preview":
        include('ctrl/preview.php');
        break;

      case "dl_photos":
        include('ctrl/dl_photos.php');
        break;

      case "liste":
        include('ctrl/liste.php');
        break;

      case "historique":
        include('./ctrl/historique.php');
        break;

        //set partage
      case "set_partage":
        include('ctrl/set_partage.php');
        break;

        //unset partage
      case "unset_partage":
        include('ctrl/unset_partage.php');
        break;

      case 'clear_introuvables':
        include('ctrl/clear_introuvables.php');
        break;

        //renvoi mail
      case "renvoi_mail":
        include('ctrl/renvoi_mail.php');
        break;

        //renvoi date
      case "renvoi_date":
        include('ctrl/renvoi_date.php');
        break;


      case "parametres":
        include('ctrl/parametres.php');
        break;

      case "admin_dl_photos": //inclut le dl
        include('ctrl/admin_dl_photos.php');
        break;

      case "stats":
        include('ctrl/stats.php');
        break;

      case "users":
        include('ctrl/users.php');
        break;

      case 'introuvables':
        include('ctrl/introuvables.php');
        break;

      case "change_psw":
        include 'ctrl/change_psw.php';
        break;

      case "suppr_zip":
        include 'ctrl/suppr_zip.php';
        break;
    }



    //fin affichage admin
  } else {
    echo "check pass deja crypt";
    session_destroy();
    header('Location: ./');
  }
} else {
  echo "pas de pass et login pass en session";
  session_destroy();
  header('Location ./');
}
