<?php

if(isset($uri[2]) && $partage->check_partage($uri[1], $uri[2])){ // Mode client
  $id_partage = $uri[2];
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($id_partage);
  $chemin = chemin_relatif_normalise($infos['chemin']);
  chemin_data_ou_404($data, $chemin);
  $email = $infos['email'];
  $mode = 'client';
}
else{ //mode admin
  $chemin = chemin_depuis_segments_url(array_slice($uri, 2));
  chemin_data_ou_404($data, $chemin);
  $mode = "admin";
}


//calcul de la taille

$listefichiers = $dossier->contenu_dossier($chemin,$data);
$taille = 0;
$nb = 0;
foreach ($listefichiers as $item) {
  

  if($item != '.' && $item != '..' && $item != 'Thumbs.db'){
    $taille = ($taille + filesize(chemin_data_ou_404($data, $chemin . '/' . $item)));
    $nb++;
  }
}

//fin ops
include('vue/photos.php');

//ajout du script DL si user qui track le nombre de clic
if(isset($uri[2])){
  ?>
    <script type="text/javascript" src="/includes/js/video_photos.js"></script>
<?php
}
?>
