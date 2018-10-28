<?php

$partage = new partage();

if(!isset($_POST['email']) && !isset($_POST['chemin'])){
  //rejeter
}else{
  $email=$_POST['email'];
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
}

$cle = $partage->set_partage($chemin,$email);

//envoi du mail
include('ctrl/sendemail.php');


header('Location: /?page=dossiers&chemin='.$chemin_retour);
