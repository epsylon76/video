<?php

$partage = new partage();
$historique = new historique();
$id=$_GET['id'];
$infos = $partage->get_partage($id); //récupérer les infos avant l'effacement pour pouvoir les inscrire dans l'historique

$historique->unset_partage($_SESSION['login'],$infos['chemin'],$infos['email']);

$partage->unset_partage($id); //défaire le partage


if(isset($_GET['retour']) && $_GET['retour'] == 'stats'){
  header('Location: ./?page=stats');
}else{
  header('Location: ./?page=liste');
}
