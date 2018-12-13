<?php

class dossier {

  function contenu_dossier($chemin,$data){
    $listefichiers = scandir($data.$chemin);
    natsort($listefichiers);
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


  function affiche_contenu($listefichiers){

    global $data;
    global $chemin;
    global $params;
    $retour='';
    $compteur_images=0;
    $items = '';
    $nb_sous_dossiers = 0;
    #en cas de retour à la racine on retire le trailing slash
    if($chemin == '//'){$chemin='/';}

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

          //calcul du nombre de sous dossiers
          $sous_dossiers = scandir($data.$chemin.$ligne);
          foreach($sous_dossiers as $sous){
            if($sous != "." && $sous != ".."){
              $type = $this->infos_fichier($data,$chemin,$ligne.'/'.$sous);
              if($type[0] == 'dir'){
                $nb_sous_dossiers ++;
              }
            }
          }
          //

          $items .= '<li class="list-group-item">';
          $items .= '<div class=" row justify-content-between">';//ligne
          $items .= '<div class="col-md-6">';//colonne 4
          $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="?page=dossiers&chemin='.$chemin.$ligne.'/">'.$ligne.'</a>';
          if($partages->nb_partages($chemin.$ligne) >= 1){$badge_color = "badge-success";}else{$badge_color="badge-warning";}
          $items .= '</div>';//fin colonne gauche

          if($nb_sous_dossiers <= 2 && $params['partage_dossier']==true){
            $items .= '<div class="col-md-5">';//colonne droite
            $items .= '<form method="post" action="?page=set_partage" class="form-inline">';
            $items .= '<div class="form-group">';
            $items .= '<input type="hidden" name="chemin" value="'.$chemin.$ligne.'">';
            $items .= '<input type="hidden" name="chemin_retour" value="'.$chemin.'">';
            $items .= '<input type="hidden" name="type_partage" value="dossier">';
            $items .= '&nbsp;<input type="email" class="form-control form-control-sm" id="email" name="email" required size="30">';
            $items .= '&nbsp;<button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-folder-plus"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge '.$badge_color.'">'.$partages->nb_partages($chemin.$ligne).'</span></button>';
            $items .= '</form>';
            $items .= '</div>';
            $items .= '</div>';
          }

          $items .= '</li>';
          break;
        }

      }
      elseif($type[1] == 'mp4' || $type[1] == 'MP4' || $type[1] == 'mkv' || $type[1] == 'MKV' || $type[1] == 'avi' || $type[1] == 'AVI'){

          //si vidéo on affiche le partage
          $items .= '<li class="list-group-item">';
          $items .= '<div class="row justify-content-between">';//ligne
          $items .= '<div class="col-md-6">';//colonne 4
          $items .= '<i class="fas fa-video"></i>&nbsp;<a href="?page=video&video='.$chemin.$ligne.'">'.$ligne.'</a>';
          if($partages->nb_partages($chemin.$ligne) >= 1){$badge_color = "badge-success";}else{$badge_color="badge-warning";}
          $items .= '</div>';
          $items .= '<div class="col-md-5">';
          $items .= '<form method="post" action="?page=set_partage" class="form-inline">';
          $items .= '<div class="form-group">';
          $items .= '<input type="hidden" name="chemin" value="'.$chemin.$ligne.'">';
          $items .= '<input type="hidden" name="chemin_retour" value="'.$chemin.'">';
          $items .= '<input type="hidden" name="type_partage" value="video">';
          $items .= '&nbsp;<input type="email" class="form-control form-control-sm" id="email" name="email" required size="30">';
          $items .= '&nbsp;<button type="submit" class="btn btn-sm btn-info"><i class="fas fa-video"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge '.$badge_color.'">'.$partages->nb_partages($chemin.$ligne).'</span></button>';
          $items .= '</form>';
          $items .= '</div>';
          $items .= '</div>';
          $items .= '</li>';

        }elseif($type[1] == 'jpg' || $type[1] == 'JPG'){
          $compteur_images++; //si photo on compte mais on affiche pas
        }elseif($ligne != '.DS_Store'){
          //autre fichier
          $items .= '<li class="list-group-item">';
          $items .= '<div class="row justify-content-between">';//ligne
          $items .= '<div class="col-md-6">';//colonne 4
          $items .= '<i class="fas fa-file"></i>&nbsp;'.$ligne;
          $items .= '</div>';
          $items .= '</div>';
          $items .= '</li>';
        }

    }// for each (on a fini d'itérer les fichiers contenu dans le chemin en cours)


    if($compteur_images > 2 && $nb_sous_dossiers == 0){//mode dossier photos
      $retour .= '<h1> Photos </h1>';
      $retour .= '<p><strong>Note : </strong>s\'il y a autre chose que des photos dans ce dossier, ces fichiers n\'apparaitront pas</p>';
      $retour .= '<form method="post" action="?page=set_partage" class="form-inline">';
      $retour .= '<input type="hidden" name="chemin" value="'.$chemin.'">';
      $retour .= '<input type="hidden" name="chemin_retour" value="'.$chemin.'">';
      $retour .= '<input type="hidden" name="type_partage" value="photos">';
      $retour .= 'Il y a <strong>&nbsp;'.$compteur_images.'</strong>&nbsp;photos dans ce dossier&nbsp;<a class="btn btn-sm btn-primary" href="?page=photos&photos='.$chemin.'"><i class="fas fa-eye"></i>&nbsp;voir</a>';
      if($partages->nb_partages($chemin) >= 1){$badge_color = "badge-success";}else{$badge_color="badge-warning";}
      $retour .= '&nbsp;<input type="email" class="form-control form-control-sm" id="email" name="email" required size="30">';
      $retour .= '&nbsp;<button type="submit" class="btn btn-sm btn-info"><i class="fas fa-camera"></i>&nbsp;Partager&nbsp;&nbsp;<span class="badge '.$badge_color.'">'.$partages->nb_partages($chemin).'</span></button>';
      $retour .= '</form>';
    }

    //rendu de la liste
    $retour .= '<ul class="list-group list-group-flush">';
    $retour .= $items;
    $retour .= '</ul>';
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




}
