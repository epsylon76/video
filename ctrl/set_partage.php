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
$historique->admin_partage($_SESSION['id_admin'],$retour['id'],'set_partage');
//envoi du mail
include('ctrl/sendemail.php');


header('Location: '.$domain_url.'?page=dossiers&chemin='.$chemin_retour);
