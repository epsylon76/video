<?php

$partage = new partage();

if(isset($_GET['email']) && isset($_GET['cle'])){ //s'il y a la clé dans l'url on affiche la liste
  if($partage->check_cle_email($_GET['cle'],$_GET['email'])){
    echo "oui";
  }
}

//liste des partages avec l'email en question
include('vue/nav.php');
include('vue/partage.php');
