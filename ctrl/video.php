<?php
if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){
  //retrouver le chemin via l'id
  $chemin = $partage->get_partage($_GET['id']);
  $chemin = '/data'.$chemin['chemin'];


//fin ops
include('vue/video.php');

}
