<?php

// $id=$_GET['id'];
$infos = $partage->get_partage($uri[2]); //récupérer les infos avant l'effacement pour pouvoir les inscrire dans l'historique

$file_attente->remove_partage($uri[2]);
$partage->unset_partage($uri[2]); //défaire le partage

$historique->unset_partage($_SESSION['login'],$infos['chemin'],$infos['email']);



header('Location: /admin/partage/');
