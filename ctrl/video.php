<?php
if(isset($_GET['id']) && $partage->check_partage($_GET['cle'], $_GET['id'])){ //mode utilisateur
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($_GET['id']);
  $chemin = './data'.$infos['chemin'];
  $email = $infos['email'];
  $mode = "user";

}else{ //mode admin
  $chemin='./data'.$_GET['video'];
  $mode = "admin";
}

//condition selon le format de la vidéo
$extension = pathinfo($data.$chemin);
$ext =  $extension['extension'];
if($ext == "mp4" || $ext == "MP4"){
  include('./vue/video.php');
}else{
  include('./vue/video_dl.php');
}

//ajout du script DL si user
if(isset($_GET['id'])){
  include('./scripts/script_button_dl.php');
}
