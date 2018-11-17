<?php

$partage = new partage();

  $id=$_GET['id'];
  $cle = $_GET['cle'];

$partage->unset_partage($id,$cle);

header('Location: ./?page=liste');
