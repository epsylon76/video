<?php

class dossier {

  function contenu_dossier($chemin,$data){
    $liste ='';
    $listefichiers = scandir($data.$chemin);
    return $listefichiers;
  }

  function infos_fichier($data,$chemin,$fichier){
    $type_fichier[0] = filetype($data.$chemin.$fichier);

    #si ce n'est pas un dossier on donne son extension
    if($type_fichier[0] == 'file'){
      $extension = pathinfo($data.$chemin.$fichier);
      $type_fichier[1] = $extension['extension'];
    }

    return $type_fichier;
  }

  function folderSize ($dir)
  {
    $size = 0;
    foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
      $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
  }


  function affiche_contenu($listefichiers){

    global $data;
    global $chemin;
    $retour='';
    $compteur_images=0;
    $items = '';
    #en cas de retour à la racine on retire le trailing slash
    if($chemin == '//'){
      $chemin='/';
    }

    foreach($listefichiers as $ligne){

      global $partages;

      $type = $this->infos_fichier($data,$chemin,$ligne);

      //TYPE DOSSIER
      if($type[0] == 'dir' || $type[0] == 'link'){
        #différentes conditions pour le type $dossier
        switch ($ligne){
          case '..':
          //rien
          break;

          case '.':
          //rien
          break;

          default :
          //CALCUL TAILLE Dossier
          $nom_chemin_linux=str_replace(' ','\ ',$data.$chemin.$ligne);
          $nom_chemin_linux=str_replace('(','\(',$nom_chemin_linux);
          $nom_chemin_linux=str_replace(')','\)',$nom_chemin_linux);
          $commande = 'du -s --block-size=1G '.$nom_chemin_linux;
          $taille = shell_exec($commande);
          $taillebits = explode('	',$taille); //RUSE ! içi l'output ne sortait pas un espace mais un caractère blanc bien spécifique qu'il a fallu copier coller depuis la sortie d'un echo pour pouvoir le définir correctement
          $taille = $taillebits[0];
        


          $items .= '<li class="list-group-item">';
          $items .= '<div class="row">';//ligne
          $items .= '<div class="col-md-6">';//colonne 4
          $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="?page=dossiers&chemin='.$chemin.$ligne.'/">'.$ligne.'</a>';
          if($partages->nb_partages($chemin.$ligne) >= 1){$badge_color = "badge-success";}else{$badge_color="badge-warning";}
          $items .= '</div>';//fin colonne gauche

          if($taille <= 2 && $taille != 0){

            $items .= '<div class="col-md-4 offset-md-2">';//colonne droite
            $items .= '<form method="post" action="?page=set_partage" class="form-inline">';
            $items .= '<div class="form-group">';
            $items .= '<input type="hidden" name="chemin" value="'.$chemin.$ligne.'">';
            $items .= '<input type="hidden" name="chemin_retour" value="'.$chemin.'">';
            $items .= '<input type="hidden" name="type_partage" value="dossier">';
            $items .= '&nbsp;<input type="email" class="form-control form-control-sm" id="email" name="email" required>';
            $items .= '</div>';
            $items .= '&nbsp;<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-share-alt"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge '.$badge_color.'">'.$partages->nb_partages($chemin.$ligne).'</span></button>';
            $items .= '</form>';
            $items .= '</div>';
          }

          $items .= '</li>';
          break;
        }

      }
      else{
        #conditions d'affichage
        #si vidéo
        if($type[1] == 'mp4' || $type[1] == 'MP4' || $type[1] == 'mkv' || $type[1] == 'MKV'){

          //CALCUL TAILLE Fichier
          $nom_chemin_linux=str_replace(' ','\ ',$data.$chemin.$ligne);
          $nom_chemin_linux=str_replace('(','\(',$nom_chemin_linux);
          $nom_chemin_linux=str_replace(')','\)',$nom_chemin_linux);

          $commande = 'du -s --block-size=1G '.$nom_chemin_linux;
          $taille = shell_exec($commande);
          $taillebits = explode('	',$taille); //RUSE ! içi l'output ne sortait pas un espace mais un caractère blanc bien spécifique qu'il a fallu copier coller depuis la sortie d'un echo pour pouvoir le définir correctement
          $taille = $taillebits[0];


          $items .= '<li class="list-group-item">';

          $items .= '<div class="row">';//ligne

          $items .= '<div class="col-md-6">';//colonne 4
          $items .= '<i class="fas fa-video"></i>&nbsp;<a href="?page=video&video='.$chemin.$ligne.'">'.$ligne.'</a>';
          if($partages->nb_partages($chemin.$ligne) >= 1){$badge_color = "badge-success";}else{$badge_color="badge-warning";}
          $items .= '</div>';

          $items .= '<div class="col-md-4 offset-md-2">';
          $items .= '<form method="post" action="?page=set_partage" class="form-inline">';
          $items .= '<div class="form-group">';
          $items .= '<input type="hidden" name="chemin" value="'.$chemin.$ligne.'">';
          $items .= '<input type="hidden" name="chemin_retour" value="'.$chemin.'">';
          $items .= '<input type="hidden" name="type_partage" value="video">';
          $items .= '&nbsp;<input type="email" class="form-control form-control-sm" id="email" name="email" required>';
          $items .= '</div>';
          $items .= '&nbsp;<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-share-alt"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge '.$badge_color.'">'.$partages->nb_partages($chemin.$ligne).'</span></button>';
          $items .= '</form>';
          $items .= '</div>';

          $items .= '</li>';

        }
        #si image
        if($type[1] == 'jpg' || $type[1] == 'JPG'){
          $compteur_images++;

        }

      }

    }
    if($compteur_images > 1){//mode dossier photos
      $retour .= '<h1> Dossier de photos </h1>';
      $retour .= '<p><strong>Notice : </strong>s\'il y a autre chose que des photos dans ce dossier, ces fichiers n\'apparaitront pas</p>';
      $retour .= '<form method="post" action="?page=set_partage" class="form-inline">';
      $retour .= '<input type="hidden" name="chemin" value="'.$chemin.'">';
      $retour .= '<input type="hidden" name="chemin_retour" value="'.$chemin.'">';
      $items .= '<input type="hidden" name="type_partage" value="photos">';
      $retour .= 'Il y a <strong>'.$compteur_images.'</strong> photos dans ce dossier <a class="btn btn-sm btn-primary" href="?page=photos&photos='.$chemin.'"><i class="fas fa-eye"></i>&nbsp;voir</a>';
      if($partages->nb_partages($chemin) >= 1){$badge_color = "badge-success";}else{$badge_color="badge-warning";}
      $retour .= '&nbsp;<input type="email" class="form-control form-control-sm" id="email" name="email" required>';
      $retour .= '&nbsp;<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-share-alt"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge '.$badge_color.'">'.$partages->nb_partages($chemin).'</span></button>';
      $retour .= '</form>';
    }

    //rendu de la liste
    $retour .= '<ul class="list-group list-group-flush">';
    $retour .= $items;
    $retour .='</ul>';
    return $retour;
  }//fin affiche contenu


  function diapo_photos($liste){

    global $data;
    global $chemin;
    $retour='';
    $compteur_images=0;
    #en cas de retour à la racine on retire le trailing slash

    foreach($liste as $ligne){

      $type = $this->infos_fichier($data,$chemin,$ligne);

      if($type[0] != 'dir' && $type[0] != 'link'){
        #conditions d'affichage
        #si image
        if($type[1] == 'jpg' || $type[1] == 'JPG'){
          $retour .= '<div><img data-lazy="/data'.$chemin.$ligne.'" style="max-width: 100%;"></img></div>';
          $compteur_images++;
        }

      }
    }
    if($compteur_images > 1){$retour .= 'Il y a '.$compteur_images.' photos';}
    return $retour;
  }

  function breadcrumb($chemin){
    $lien = '';
    $retour = '<nav aria-label="breadcrumb">
    <ol class="breadcrumb">';

    $bread = trim($chemin, '/');
    $bread = explode('/', $bread);

    $retour .= '<li class="breadcrumb-item"><a href="?page=dossiers&chemin=/">Racine</a></li>';

    foreach($bread as $ligne){
      $lien  .= '/'.$ligne;
      $retour .= '<li class="breadcrumb-item"><a href="?page=dossiers&chemin='.$lien.'/">'.$ligne.'</a></li>';
    }

    $retour .= '</ol></nav>';
    return $retour;
  }

  function formatBytes($size, $precision = 2)
  {
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
  }




}
