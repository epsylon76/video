<?php

//si valeurs post on teste le login
if(isset($_POST['login']) && isset($_POST['pass'])){
  $login = new admin();
  if($login->check_login($_POST['login'],$_POST['pass'])){

    $_SESSION['login'] = $_POST['login'];
    $_SESSION['pass'] = sha1($_POST['pass']);

    header('Location: ?page=dossiers');
  }
}


include('vue/accueil.php');
?>
