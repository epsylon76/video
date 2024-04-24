<?php

$hours = $partage->last_partage($_POST['email']); //heures depuis le dernier partage

if (!isset($_POST['email']) && !isset($_POST['chemin'])) {
  //rejeter
} else {
  $email = $_POST['email'];
  $mailto = $email;//poursendemail
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
  $type_partage = $_POST['type_partage'];
  $email_type = $_POST['email_type'];

  $retour = $partage->set_partage($chemin, $email, $type_partage, $_SESSION['login'], $email_type);
  $cle = $retour['cle'];
  //ajout à l'historique ($id_admin,$id_partage,$action)
  $historique->set_partage($_SESSION['login'], $chemin, $email);

  //si le dernier partage a été fait il y a moins de 6h
  if ($hours >= 6) {
    //envoi du mail si la différence est de un jour
    include('ctrl/actions/sendemail.php');
  }

  if(false){ //DEBUG
    include('ctrl/actions/sendemail.php');
  }
}
if($chemin_retour == '/'){
  $chemin_retour = '';
}
//header('Location:/admin/dossiers/' . $chemin_retour);
