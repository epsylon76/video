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

//fin ops
include('vue/photos.php');

//ajout du script DL si user qui track le nombre de clic
if(isset($uri[2])){
  ?>
  <script>
    $("#bouton-dl").click(function() {
      console.log('eventdl');
      $.ajax({
        url: '/ajax/clic_dl.php',
        type: 'GET',
        data: 'chemin=<?php echo $chemin; ?>&email=<?php echo $email ?>&action=dl_photos',
        dataType: 'html'
      });

    });
  </script>
<?php
}
