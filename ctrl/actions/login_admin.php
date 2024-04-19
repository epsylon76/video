<?php

//si valeurs post on teste le login
if(isset($_POST['login']) && isset($_POST['pass'])){
  //$historique = new historique();
  if($admin->check_login($_POST['login'],$_POST['pass'])){

    $_SESSION['login'] = $_POST['login'];
    $_SESSION['pass'] = sha1($_POST['pass']);
    $id_admin = $admin->get_id_admin($_SESSION['login']);
    $_SESSION['id_admin'] = $id_admin;
    $admin->update_last_login($id_admin);
  //  $historique->admin_login($_SESSION['login']);
    header('Location: /admin/');
  }
}