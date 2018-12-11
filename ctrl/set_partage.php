<?php

$partage = new partage();
$historique = new historique();

$hours = $partage->last_partage($_POST['email']);//heures depuis le dernier partage

if(!isset($_POST['email']) && !isset($_POST['chemin'])){
  //rejeter
}else{
  $email=$_POST['email'];
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
  $type_partage = $_POST['type_partage'];
}

$retour = $partage->set_partage($chemin,$email,$type_partage,$_SESSION['login']);
$cle=$retour['cle'];
//ajout à l'historique ($id_admin,$id_partage,$action)
$historique->set_partage($_SESSION['login'],$chemin,$email);

//si le dernier partage a été fait il y a moins de 6h
if($hours >= 6){
  //envoi du mail si la différence est de un jour
  include('ctrl/sendemail.php');
}else{
  //on envoie pas de mail
}

header('Location: ./?page=dossiers&chemin='.$chemin_retour);
