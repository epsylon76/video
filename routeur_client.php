<?php

if(isset($uri[1]) && $uri[1] == ''){
  // renvoie vers une page oopsss
}
else{
  // il y a un hash

  if(isset($uri[2])){
    // il y a un id

    if(isset($uri[3]) && $uri[3] == 'dl'){
      // action de téléchargement des photos
      include('ctrl/actions/dl_photos.php');
    }
    else{
      $getPartage = $partage->get_type_partage($uri[2]);

      if($getPartage == "video"){
        include('ctrl/video.php');
      }
      elseif($getPartage == "photos"){
        include('ctrl/photos.php');
      }
      elseif($getPartage == "dossier"){
        // include('./ctrl/dossier_zip.php');
      }
    }
  }
  else{
    // on affiche la liste des partages 
    include('ctrl/partage.php');
  }

}

?>
