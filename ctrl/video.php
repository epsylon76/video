<?php

if (isset($uri[2]) && $partage->check_partage($uri[1], $uri[2])) { //mode utilisateur
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($uri[2]);
  $chemin_relatif = chemin_relatif_normalise($infos['chemin']);
  $chemin_resolu = chemin_data_ou_404($data, $chemin_relatif);
  $chemin = '/data/' . chemin_pour_url($chemin_relatif);
  $email = $infos['email'];
  $mode = "user";
  $taille_fichier = filesize($chemin_resolu); //diff
} else { //mode admin
  $chemin_relatif = chemin_depuis_segments_url(array_slice($uri, 2));
  $chemin_resolu = chemin_data_ou_404($data, $chemin_relatif);
  $chemin = '/data/' . chemin_pour_url($chemin_relatif);
  $mode = "admin";
  $taille_fichier = filesize($chemin_resolu); //diff
}

$nom_fichier = basename($chemin_relatif);



include('./vue/video.php');

//ajout du script DL si user
if (isset($uri[2])) { //mode user
?>
  <script type="text/javascript" src="/includes/js/video_photos.js"></script>
<?php
}
