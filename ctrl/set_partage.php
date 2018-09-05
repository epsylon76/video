<?php

$partage = new partage();

if(!isset($_POST['email']) && !isset($_POST['chemin'])){
  //rejeter
}else{
  $email=$_POST['email'];
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
}

$partage->set_partage($chemin,$email);
//echo $chemin;
header('Location: /?page=dossiers&chemin='.$chemin_retour);
