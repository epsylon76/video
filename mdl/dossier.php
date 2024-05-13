<?php

class dossier
{

  function contenu_dossier($chemin, $data)
  {
    $listefichiers = preg_grep('/^([^.])/', scandir($data . $chemin)); //exclut les fichiers commençant par un point
    $listefichiers = array_diff($listefichiers, ['Thumbs.db']); //retirer Thumbs.db
    natsort($listefichiers);
    return $listefichiers;
  }

  function infos_fichier($data, $chemin, $fichier)
  {
    $type_fichier[0] = filetype($data . $chemin . $fichier);

    #si ce n'est pas un dossier on donne son extension
    if ($type_fichier[0] == 'file') {
      $extension = pathinfo($data . $chemin . $fichier);
      $type_fichier[1] = $extension['extension'];
    }

    return $type_fichier;
  }


  function detect_photos($sousdossier)
  {
    $liste = scandir($sousdossier);
    $nb = 0;
    foreach ($liste as $item) {
      if ($item != '.' && $item != '..') {
        $type = filetype($sousdossier . '/' . $item);
        if ($type == 'file') {
          $ext = pathinfo($sousdossier . '/' . $item);
          if ($ext['extension'] == "jpg" || $ext['extension'] == "JPG") {
            $nb++;
          }
        }
      }
    }
    return $nb;
  }

  function nb_sous_dossiers($sousdossier)
  {
    $nb_sous_dossiers = 0;
    $sous_dossiers = scandir($sousdossier);
    foreach ($sous_dossiers as $sous) {
      if ($sous != "." && $sous != "..") {
        $type = filetype($sousdossier . '/' . $sous);
        if ($type == 'dir') {
          $nb_sous_dossiers++;
        }
      }
    }
    return $nb_sous_dossiers;
  }


  function affiche_contenu($listefichiers)
  {

    global $data;
    global $chemin;
    global $params;
    global $uri;
    global $dossier;

    $retour = '';
    $compteur_images = 0;
    $items = '';
    $nb_sous_dossiers = 0;
    #en cas de retour à la racine on retire le trailing slash
    if ($chemin == '//') {
      $chemin = '/';
    }

    foreach ($listefichiers as $ligne) {

      global $partage;

      $type = $this->infos_fichier($data, $chemin, $ligne);

      //
      //TYPE DOSSIER
      //

      if ($type[0] == 'dir' || $type[0] == 'link') {
        #différentes conditions pour le type $dossier
        if($ligne != '..' && $ligne != '.'){
             //calcul du nombre de sous dossiers
            $nb_sous_dossiers = $this->nb_sous_dossiers($data . $chemin . $ligne);
            //calcul du nombre de Photos
            $nb_photos = $this->detect_photos($data . $chemin . $ligne);

            $cle = $partage->get_cle_with_chemin('/' . $chemin . $ligne);

            if ($nb_photos >= 2) { //dossier de photos

              $items .= '<li class="list-group-item">';
              $items .= '<div class="d-flex justify-content-between">'; //ligne justifiée

              $items .= '<div  class="col-6">'; //une div pour la justification
              $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="/admin/dossiers/' . $chemin . $ligne . '/">' . $ligne . '</a>';
              $items .= '<input id="input_tag" data-nom_dossier="' . $chemin . $ligne . '" data-type="fichier" type="text" class="form-control" style="display:inline-block;">';
              $items .= '</div>';


              if ($partage->nb_partages($chemin . $ligne) >= 1) {
                $badge_color = "badge-success";
              } else {
                $badge_color = "badge-warning";
              }

              //bouton de partage des photos

              $items .= '<button type="button" class="btn btn-success btn-sm clickpartage" data-typepartage="photos" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-toggle="modal" data-target="#partageModal" >
                <i class="fas fa-camera"></i>
                &nbsp;Partager&nbsp;&nbsp;
                <span class="badge ' . $badge_color . '">' . $partage->nb_partages($chemin . $ligne) . '</span>
                </button>';


            } else { //juste un dossier

              $items .= '<li class="list-group-item">';
              $items .= '<div class="d-flex justify-content-between">'; //ligne justifiée

              $items .= '<div>'; //une div pour la justification
              $items .= '<i class="fas fa-folder"></i>&nbsp;<a href="/admin/dossiers/' . $chemin . $ligne . '/">' . $ligne . '</a>';
              $items .= '</div>';
              $items .= '<div>'; //une div pour la justification
              $items .= '<input id="input_tag" data-nom_dossier="' . $chemin . $ligne . '" data-type="dossier" type="text" class="form-control" >';
              $items .= '</div>';

              if ($partage->nb_partages($chemin . $ligne) >= 1) {
                $badge_color = "badge-success";
              } else {
                $badge_color = "badge-warning";
              }

              //bouton de partage des dossiers zip
              if ($nb_sous_dossiers <= 4 && $params['partage_dossier'] == true) {
                $items .= '<button type="button" class="btn btn-danger btn-sm  clickpartage"  data-typepartage="dossier" data-chemin="' . $chemin . $ligne . '" data-retour="' . $chemin . '" data-toggle="modal" data-target="#partageModal">
                <i class="fas fa-folder-plus"></i>
                  &nbsp;Partager&nbsp;&nbsp;
                  <span class="badge ' . $badge_color . '">' . $partage->nb_partages($chemin . $ligne) . '</span>
                  </button>';
              } else {
                $items .= '<div>'; //une div pour remplacer le vide
                $items .= '</div>';
              }
            }

            $items .= '</div>'; //row
            $items .= '</li>' ;
        } //fin if $ligne != '..' && $ligne != '.'

      } //fin type dossier
      elseif ($type[1] == 'mp4' || $type[1] == 'MP4' || $type[1] == 'mkv' || $type[1] == 'MKV' || $type[1] == 'avi' || $type[1] == 'AVI') {

        //
        //type VIDEO
        //



        //echo $chemin.$ligne.'<br>';
        //si partage vidéo
        $items .= '<li class="list-group-item">';
        $items .= '<div class="d-flex justify-content-between">'; //ligne

        $items .= '<div>';
        $items .= '<i class="fas fa-video"></i>&nbsp;<a href="/admin/video/' . $chemin . $ligne . '">' . $ligne . '</a>';
        $items .= '&nbsp;<input id="input_tag" data-nom_dossier="' . $chemin . $ligne . '" data-type="fichier" type="text" style="background: transparent;border:1px solid grey;border-radius:5px;">';
        $items .= '</div>';



        if ($partage->nb_partages($chemin . $ligne) >= 1) {
          $badge_color = "badge-success";
        } else {
          $badge_color = "badge-warning";
        }


        $items .= '<button type="button" class="btn btn-primary btn-sm  clickpartage"
            data-typepartage="video"
            data-chemin="' . $chemin . $ligne . '"
            data-retour="' . $chemin . '"
            data-toggle="modal"
            data-target="#partageModal">
            <i class="fas fa-video"></i>
            &nbsp;Partager&nbsp;&nbsp;
            <span class="badge ' . $badge_color . '">' . $partage->nb_partages($chemin . $ligne) . '</span>
            </button>';

        $items .= '</li>';
      } elseif ($type[1] == 'jpg' || $type[1] == 'JPG') {
        $compteur_images++; //si photo on compte mais on affiche pas
      } elseif ($ligne != '.DS_Store' && $ligne != '._.DS_Store' && $ligne != 'Thumbs.db') {
        //autre fichier
        $items .= '<li class="list-group-item">';
        $items .= '<div class="row justify-content-between">'; //ligne
        $items .= '<div class="col-md-6">'; //colonne droite
        $items .= '<i class="fas fa-file"></i>&nbsp;' . $ligne;
        $items .= '&nbsp;<a href="./data' . $chemin . $ligne . '">‌‌<i class="fas fa-file-download"></i></a>';
        $items .= '</div>';
        $items .= '</div>';
        $items .= '</li>';
      }
    }
    // 
    // FIN DU  "for each" (on a fini d'itérer les fichiers contenu dans le chemin en cours)
    //

    if ($compteur_images > 2 && $nb_sous_dossiers == 0) {
      //mode dossier photos, on va afficher le bouton de téléchargement et le diaporama
      include('ctrl/photos.php');
    }


    //rendu de la liste
    $retour .= '<ul class="list-group list-group-flush">';
    $retour .= $items;
    $retour .= '</ul>';
    return $retour;
  } //fin affiche contenu


}
