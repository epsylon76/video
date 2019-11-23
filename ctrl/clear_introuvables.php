<?php

$partage = new partage();
$historique = new historique();

$introuvable = $partage->introuvables($data);

$historique->clear_introuvables($_SESSION['login']);
foreach($introuvable as $one){
  $partage->unset_partage($one['id']); //défaire le partage
}

header('Location: ./?page=introuvables');
