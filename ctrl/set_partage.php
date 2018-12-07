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
//vérifions si on doit envoyer l'email_sujet
//si le dernier partage a été fait il y a moins de 6h

//liste des partages de cet email (clé)
$liste_partage = $partage->liste_partages($cle);



//envoi du mail
include('ctrl/sendemail.php');


header('Location: ./?page=dossiers&chemin='.$chemin_retour);
