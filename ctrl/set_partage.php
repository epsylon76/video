<?php

$partage = new partage();

if(!isset($_POST['email']) && !isset($_POST['chemin'])){
  //rejeter
}else{
  $email=$_POST['email'];
  $chemin = $_POST['chemin'];
  $chemin_retour = $_POST['chemin_retour'];
}

$cle = rand(1,4545454545);
$cle = sha1($cle);

$partage->set_partage($chemin,$email,$cle);
echo $chemin;
header('Location: /?page=dossiers&chemin='.$chemin_retour);
