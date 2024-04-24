<?php

// $id=$_GET['id'];
$infos = $partage->get_partage($uri[3]); //récupérer les infos avant l'effacement pour pouvoir les inscrire dans l'historique

$historique->unset_partage($_SESSION['login'],$infos['chemin'],$infos['email']);

$partage->unset_partage($uri[3]); //défaire le partage

header('Location: /admin/partage/');
