<?php

$partage = new partage();
$historique = new historique();
$id=$_GET['id'];
$infos = $partage->get_partage($id); //récupérer les infos avant l'effacement pour pouvoir les inscrire dans l'historique

$historique->unset_partage($_SESSION['login'],$infos['chemin'],$infos['email']);

$partage->unset_partage($id); //défaire le partage



header('Location: ./?page=liste');
