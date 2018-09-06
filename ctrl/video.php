<?php
if(!isset($_GET['email'])){
  $chemin='/data'.$_GET['video'];
}elseif(isset($_GET['email']) && isset($_GET['id'])){
  //retrouver le chemin via l'id
  $chemin = $partage->get_partage($_GET['id']);
  $chemin = '/data'.$chemin['chemin'];
}

include('vue/head.php');


//fin ops
include('vue/video.php');
