<?php

if(isset($uri[2]) && $partage->check_partage($uri[1], $uri[2])){ // Mode client
  $id_partage = $uri[2];
  //retrouver le chemin via l'id
  $infos = $partage->get_partage($id_partage);
  $chemin = $infos['chemin'];
  $email = $infos['email'];
  $mode = 'client';
}
else{ //mode admin
  $slices = array_slice($uri, 2);
  $chemin = '';
  foreach($slices as $u){
    $chemin .= $u.'/';
  }
  // $chemin = rtrim('/data'.$chemin, '/');
  $chemin = rtrim($chemin, '/');
  $chemin = urldecode($chemin);
  $mode = "admin";
}


//calcul de la taille

$listefichiers = $dossier->contenu_dossier($chemin,$data);
$taille = 0;
$nb = 0;
foreach ($listefichiers as $item) {
  

  if($item != '.' && $item != '..' && $item != 'Thumbs.db'){
    $taille = ($taille + filesize($data.$chemin.'/'.$item));
    $nb++;
  }
}

// foreach ($listefichiers as $item) {
//   $tmp1 = strrchr($item, '(');
//   $res1 = substr($tmp1, 1, strpos($tmp1, ')') -1);
//   pr ($res1);

//   if(strpos($items, $res1)){
//     echo filesize($data.$chemin.'/'.$item);
//   }
// }


//fin ops
include('vue/photos.php');

//ajout du script DL si user qui track le nombre de clic
if(isset($uri[2])){
  ?>
    <script type="text/javascript" src="/includes/js/video_photos.js"></script>
<?php
}
