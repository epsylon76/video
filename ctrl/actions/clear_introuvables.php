<?php

$introuvable = $partage->introuvables($data);

$historique->clear_introuvables($_SESSION['login']);
if ($introuvable) {
  foreach($introuvable as $one){
    $partage->unset_partage($one['id']); //défaire le partage
  }
}

header('Location: /admin/stats/introuvables/');
