<?php

$partage = new partage();
$historique = new historique();

  $id=$_GET['id'];
  $cle = $_GET['cle'];
$infos = $partage->get_partage($id); //récupérer les infos avant l'effacement pour pouvoir les inscrire dans l'historique

$historique->unset_partage($_SESSION['login'],$infos['chemin'],$infos['email']);

$partage->unset_partage($id,$cle); //défaire le partage



header('Location: ./?page=liste');
