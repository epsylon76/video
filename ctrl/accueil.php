<?php

//si valeurs post on teste le login
if(isset($_POST['login']) && isset($_POST['pass'])){
  $login = new admin();
  $historique = new historique();
  if($login->check_login($_POST['login'],$_POST['pass'])){

    $_SESSION['login'] = $_POST['login'];
    $_SESSION['pass'] = sha1($_POST['pass']);
    $id_admin = $login->get_id_admin($_SESSION['login']);
    $_SESSION['id_admin'] = $id_admin;
    $historique->admin_login($_SESSION['login']);
    header('Location: ?page=dossiers');
  }
}


include('vue/accueil.php');
?>
