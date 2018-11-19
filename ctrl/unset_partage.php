<?php

$partage = new partage();
$historique = new historique();

  $id=$_GET['id'];
  $cle = $_GET['cle'];

$partage->unset_partage($id,$cle);


header('Location: ./?page=liste');
