<?php

if (isset($uri[2]) && $partage->check_partage($uri[1], $uri[2])) { //mode utilisateur
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($uri[2]);
  $chemin = '/data/' . $infos['chemin'];
  $chemin = str_replace('//', '/', $chemin); //prends en compte tout les cas
  $email = $infos['email'];
  $mode = "user";
  $taille_fichier = filesize($data . $infos['chemin']); //diff
} else { //mode admin
  $slices = array_slice($uri, 2);
  $chemin = '';
  foreach ($slices as $u) {
    $chemin .= $u . '/';
  }
  $chemin = str_replace('//', '/', $chemin); //prends en compte tout les cas
  $chemin = urldecode($chemin);
  $chemin = '/data/'.$chemin;
  $chemin = rtrim($chemin, '/');
  $mode = "admin";
  $filePathSystem = $data . ltrim($chemin, '/data/');
  $taille_fichier = filesize($filePathSystem); //diff
}

$nom_fichier = explode("/", $chemin);
$nom_fichier = array_reverse($nom_fichier);
$nom_fichier = $nom_fichier[0];



include('./vue/video.php');

//ajout du script DL si user
if (isset($uri[2])) { //mode user
?>
  <script type="text/javascript" src="/includes/js/video_photos.js"></script>

  <!-- 
  APPELER FICHIER PHP COMME DANS video_photos.js
   -->
  <script>
  // $(document).ready(function(){
  //   var video = document.getElementById("id-video");
  //   var source = document.getElementById("id-source");
  //   var chemin = source.src;

  //   $(video).on('play', function() {
  //       $.ajax({
  //           type: 'HEAD',
  //           url: chemin,
  //           success: function(data, textStatus, jqXHR){
              
  //           }
  //       });
  //   });
  // });
  </script>

<?php
}