<?php

$partage = new partage();
$historique = new historique();

if(!isset($_POST['email']) && !isset($_POST['chemin'])){
  //rejeter
}else{
  $email=$_POST['email'];
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
  $type_partage = $_POST['type_partage'];
}

$retour = $partage->set_partage($chemin,$email,$type_partage);
$cle=$retour['cle'];
//ajout à l'historique ($id_admin,$id_partage,$action)
$historique->set_partage($_SESSION['login'],$chemin,$email);
//envoi du mail
include('ctrl/sendemail.php');


header('Location: ./?page=dossiers&chemin='.$chemin_retour);
