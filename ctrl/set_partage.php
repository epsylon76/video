<?php

$partage = new partage();
$historique = new historique();

//date du dernier partage pour comparer et savoir si on envoie l'email
$max_partage = $partage->last_partage($_POST['email']);
//

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



$now = new DateTime();
$max_partage = new DateTime($max_partage[0]);
$interval = $max_partage->diff($now);
if($interval->format('%a') >= 1){
  //envoi du mail si la différence est de un jour
  include('ctrl/sendemail.php');
}else{
  //on envoie pas de mail
}

header('Location: ./?page=dossiers&chemin='.$chemin_retour);
